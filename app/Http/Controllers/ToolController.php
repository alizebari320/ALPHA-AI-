<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Kreait\Firebase\Database;
use Kreait\Firebase\Database\Transaction;
use Kreait\Firebase\Exception\Database\TransactionFailed;

class ToolController extends Controller
{
    /**
     * Firebase RTDB root holding the directory.
     */
    private const NODE = 'ai_tools';

    /**
     * Multilingual fields stored as { en, ar, ckb, badini } objects.
     */
    private const TRANSLATABLE = ['name', 'tagline', 'description'];

    protected function db(): Database
    {
        return app('firebase.database');
    }

    // ==========================================================
    // Public directory
    // ==========================================================

    /**
     * Display the AI Tools directory, already resolved to the active locale.
     */
    public function index(Request $request)
    {
        $locale = app()->getLocale();
        $error = null;
        $tools = [];

        try {
            $raw = $this->db()->getReference(self::NODE)->getValue();

            // An empty / missing RTDB path returns null — that is not an error.
            foreach (is_array($raw) ? $raw : [] as $key => $node) {
                if (! is_array($node)) {
                    continue;
                }

                $tool = $this->normalize((string) $key, $node, $locale);

                if ($tool['status'] === 'approved') {
                    $tools[] = $tool;
                }
            }
        } catch (\Throwable $e) {
            Log::error('AI tools fetch failed: '.$e->getMessage());
            $error = __('Could not load tools right now. Please try again later.');
        }

        // Most viewed first, then highest rated, then alphabetical.
        usort($tools, function (array $a, array $b): int {
            return [$b['views_count'], $b['rating_avg']] <=> [$a['views_count'], $a['rating_avg']]
                ?: strcasecmp($a['name'], $b['name']);
        });

        return view('tools.index', [
            'tools' => $tools,
            'error' => $error,
            'categories' => config('alphaai.tools.categories', []),
            'pricingTypes' => config('alphaai.tools.pricing_types', []),
        ]);
    }

    public function show(string $id)
    {
        try {
            $raw = $this->db()->getReference(self::NODE)->getValue();
        } catch (\Throwable $e) {
            report($e);
            abort(503, __('The tool directory is temporarily unavailable.'));
        }
        foreach (is_array($raw) ? $raw : [] as $key => $node) {
            if (! is_array($node)) continue;
            $tool = $this->normalize((string) $key, $node, app()->getLocale());
            if ($tool['status'] === 'approved' && ($key === $id || $tool['id'] === $id || $tool['slug'] === $id)) {
                return view('tools.show', ['tool' => $tool]);
            }
        }
        abort(404);
    }

    // ==========================================================
    // Submissions
    // ==========================================================

    /**
     * Accept a public tool submission.
     *
     * Submissions arrive in a single language; the other three are seeded from
     * that value so the directory never renders an empty card, and the record
     * is stored as `pending` for admin review.
     */
    public function submit(Request $request): JsonResponse
    {
        $locales = array_keys(config('alphaai.locales', []));

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'tagline' => ['nullable', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:2000'],
            'website_url' => ['required', 'url', 'max:2048'],
            'icon_url' => ['nullable', 'url', 'max:2048'],
            'category' => ['required', Rule::in(config('alphaai.tools.categories', []))],
            'pricing_type' => ['required', Rule::in(config('alphaai.tools.pricing_types', []))],
            'lang' => ['required', Rule::in($locales)],
        ]);

        $payload = [
            'slug' => Str::slug($validated['name']) ?: Str::random(10),
            'category' => $validated['category'],
            'pricing_type' => $validated['pricing_type'],
            'website_url' => $validated['website_url'],
            'icon_url' => $validated['icon_url'] ?? null,
            'rating_avg' => 0.0,
            'rating_count' => 0,
            'views_count' => 0,
            'status' => 'pending',
            'submitted_locale' => $validated['lang'],
            'created_at' => now()->toIso8601String(),
        ];

        // Mirror the submitted language across every locale as a fallback.
        foreach (self::TRANSLATABLE as $field) {
            $value = trim((string) ($validated[$field] ?? ''));
            $payload[$field] = array_fill_keys($locales, $value);
        }

        try {
            $ref = $this->db()->getReference(self::NODE)->push($payload);
        } catch (\Throwable $e) {
            Log::error('AI tool submission failed: '.$e->getMessage());

            return response()->json([
                'ok' => false,
                'message' => __('Something went wrong. Please try again.'),
            ], 500);
        }

        return response()->json([
            'ok' => true,
            'id' => $ref->getKey(),
            'message' => __('Thanks! Your tool was submitted for review.'),
        ], 201);
    }

    // ==========================================================
    // Ratings & views
    // ==========================================================

    /**
     * Record a 1–5 star rating and recompute the running average.
     *
     * Runs inside an RTDB transaction so concurrent votes cannot clobber
     * each other's counts.
     */
    public function upvote(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        $path = self::NODE.'/'.$id;

        if ($this->db()->getReference($path)->getSnapshot()->getValue() === null) {
            return response()->json(['ok' => false, 'message' => 'not_found'], 404);
        }

        try {
            $value = $this->transact($path, function (array $node) use ($validated): array {
                $count = (int) ($node['rating_count'] ?? 0);
                $avg = (float) ($node['rating_avg'] ?? 0);

                $newCount = $count + 1;

                $node['rating_count'] = $newCount;
                $node['rating_avg'] = round((($avg * $count) + $validated['rating']) / $newCount, 2);

                return $node;
            });
        } catch (\Throwable $e) {
            Log::error("AI tool rating failed for {$id}: ".$e->getMessage());

            return response()->json([
                'ok' => false,
                'message' => __('Something went wrong. Please try again.'),
            ], 500);
        }

        return response()->json([
            'ok' => true,
            'rating_avg' => round((float) ($value['rating_avg'] ?? 0), 2),
            'rating_count' => (int) ($value['rating_count'] ?? 0),
            'message' => __('Thanks for rating!'),
        ]);
    }

    /**
     * Increment the view counter when a tool's detail modal is opened.
     */
    public function view(string $id): JsonResponse
    {
        try {
            $value = $this->transact(self::NODE.'/'.$id, function (array $node): array {
                $node['views_count'] = (int) ($node['views_count'] ?? 0) + 1;

                return $node;
            });

            return response()->json([
                'ok' => true,
                'views_count' => (int) ($value['views_count'] ?? 0),
            ]);
        } catch (\Throwable $e) {
            Log::warning("AI tool view increment failed for {$id}: ".$e->getMessage());

            // A failed counter must never break the UI.
            return response()->json(['ok' => false], 200);
        }
    }

    /**
     * Read-modify-write a node under an ETag transaction.
     *
     * Kreait guards the write with the ETag captured at snapshot time, so a
     * concurrent update throws TransactionFailed; we simply re-read and retry.
     *
     * @param  callable(array<string, mixed>): array<string, mixed>  $mutator
     * @return array<string, mixed>
     */
    private function transact(string $path, callable $mutator, int $attempts = 3): array
    {
        $db = $this->db();

        for ($attempt = 1; ; $attempt++) {
            try {
                return $db->runTransaction(function (Transaction $tx) use ($db, $path, $mutator): array {
                    $ref = $db->getReference($path);

                    $current = $tx->snapshot($ref)->getValue();
                    $current = is_array($current) ? $current : [];

                    $next = $mutator($current);

                    $tx->set($ref, $next);

                    return $next;
                });
            } catch (TransactionFailed $e) {
                if ($attempt >= $attempts) {
                    throw $e;
                }

                usleep(120_000 * $attempt);
            }
        }
    }

    // ==========================================================
    // Normalisation
    // ==========================================================

    /**
     * Flatten one RTDB node into a view-ready array for the active locale.
     *
     * Handles both the documented multilingual schema and the older
     * title_so / title_ba / desc_so / desc_ba / tool_url records already
     * present in the database, so legacy entries keep rendering.
     *
     * @param  array<string, mixed>  $node
     * @return array<string, mixed>
     */
    private function normalize(string $key, array $node, string $locale): array
    {
        $legacy = [
            'name' => [
                'ckb' => $node['title_so'] ?? null,
                'badini' => $node['title_ba'] ?? null,
            ],
            'tagline' => [],
            'description' => [
                'ckb' => $node['desc_so'] ?? null,
                'badini' => $node['desc_ba'] ?? null,
            ],
        ];

        $resolved = [];

        foreach (self::TRANSLATABLE as $field) {
            $bag = $node[$field] ?? null;

            // Some rows store a plain string instead of a per-locale object.
            if (is_string($bag)) {
                $bag = [$locale => $bag];
            }

            $bag = is_array($bag) ? $bag : [];
            $bag += array_filter(
                $legacy[$field] ?? [],
                fn ($v) => $v !== null && trim((string) $v) !== ''
            );

            $resolved[$field] = $this->pick($bag, $locale);
        }

        $categories = config('alphaai.tools.categories', []);
        $category = (string) ($node['category'] ?? '');

        // Legacy free-text categories are not in the enum — bucket them.
        if (! in_array($category, $categories, true)) {
            $category = 'kurdish_ai';
        }

        $pricingTypes = config('alphaai.tools.pricing_types', []);
        $pricing = (string) ($node['pricing_type'] ?? 'free');

        if (! in_array($pricing, $pricingTypes, true)) {
            $pricing = 'free';
        }

        // Legacy records predate `status`; treat them as already approved.
        $status = (string) ($node['status'] ?? 'approved');

        return [
            'id' => (string) ($node['id'] ?? $key),
            'key' => $key,
            'slug' => (string) ($node['slug'] ?? Str::slug($resolved['name']) ?: $key),
            'name' => $resolved['name'] !== '' ? $resolved['name'] : __('AI Tools'),
            'tagline' => $resolved['tagline'],
            'description' => $resolved['description'],
            'category' => $category,
            'pricing_type' => $pricing,
            'website_url' => (string) ($node['website_url'] ?? $node['tool_url'] ?? ''),
            'icon_url' => (string) ($node['icon_url'] ?? $node['image_url'] ?? ''),
            'rating_avg' => round((float) ($node['rating_avg'] ?? 0), 2),
            'rating_count' => (int) ($node['rating_count'] ?? 0),
            'views_count' => (int) ($node['views_count'] ?? 0),
            'status' => in_array($status, config('alphaai.tools.statuses', []), true) ? $status : 'pending',
            'prompts' => array_values(array_filter(
                (array) ($node['example_prompts'] ?? []),
                fn ($p) => is_string($p) && trim($p) !== ''
            )),
            'languages' => array_values(array_intersect(
                ['en', 'ckb', 'badini', 'ar'],
                array_values((array) ($node['supported_languages'] ?? ['en', 'ckb', 'badini', 'ar']))
            )),
        ];
    }

    /**
     * Pick the best available translation for the active locale.
     *
     * @param  array<string, mixed>  $bag
     */
    private function pick(array $bag, string $locale): string
    {
        $chain = config("alphaai.locales.{$locale}.fallback", [$locale]);

        foreach ($chain as $candidate) {
            $value = trim((string) ($bag[$candidate] ?? ''));

            if ($value !== '') {
                return $value;
            }
        }

        // Last resort: any non-empty translation at all.
        foreach ($bag as $value) {
            $value = trim((string) $value);

            if ($value !== '') {
                return $value;
            }
        }

        return '';
    }
}
