<?php

namespace App\Http\Controllers;

use App\Models\AnalyticsEvent;
use App\Models\ChatHistory;
use App\Models\Prompt;
use App\Models\SavedPrompt;
use App\Models\SavedTool;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();
        return view('dashboard', [
            'savedTools' => $user->savedTools()->latest()->get(),
            'savedPrompts' => SavedPrompt::where('user_id', $user->id)->with('prompt')->latest()->get(),
            'promptCount' => $user->prompts()->count(),
            'conversationCount' => $user->chatHistories()->count(),
            'activityCount' => AnalyticsEvent::where('user_id', $user->id)->count(),
        ]);
    }

    public function prompts(Request $request)
    {
        $category = $request->string('category')->toString();
        $query = Prompt::query()->where('is_public', true)->latest();
        if ($category !== '') $query->where('category', $category);

        return view('prompts.index', [
            'prompts' => $query->paginate(18)->withQueryString(),
            'categories' => config('alphaai.prompt_categories'),
            'selectedCategory' => $category,
        ]);
    }

    public function storePrompt(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'body' => ['required', 'string', 'max:10000'],
            'category' => ['required', 'string', 'max:60'],
            'locale' => ['required', 'in:en,ar,ckb,badini'],
            'tool_key' => ['nullable', 'string', 'max:120'],
            'is_public' => ['sometimes', 'boolean'],
        ]);
        $data['user_id'] = $request->user()->id;
        $prompt = Prompt::create($data);
        return response()->json(['ok' => true, 'prompt' => $prompt], 201);
    }

    public function copyPrompt(Prompt $prompt): JsonResponse
    {
        abort_unless($prompt->is_public || Auth::id() === $prompt->user_id, 404);
        $prompt->increment('copy_count');
        return response()->json(['ok' => true, 'body' => $prompt->body]);
    }

    public function savePrompt(Request $request, Prompt $prompt): JsonResponse
    {
        abort_unless($prompt->is_public, 404);
        SavedPrompt::firstOrCreate(['user_id' => $request->user()->id, 'prompt_id' => $prompt->id]);
        return response()->json(['ok' => true]);
    }

    public function saveTool(Request $request): JsonResponse
    {
        $data = $request->validate([
            'tool_key' => ['required', 'string', 'max:120'],
            'tool_name' => ['required', 'string', 'max:160'],
            'category' => ['nullable', 'string', 'max:60'],
        ]);
        $saved = SavedTool::firstOrCreate(['user_id' => $request->user()->id, 'tool_key' => $data['tool_key']], $data);
        return response()->json(['ok' => true, 'saved' => $saved]);
    }

    public function assistant(Request $request)
    {
        $history = $request->user()->chatHistories()->latest('last_message_at')->get();
        return view('assistant.index', compact('history'));
    }

    public function askAssistant(Request $request): JsonResponse
    {
        $data = $request->validate(['message' => ['required', 'string', 'max:2000']]);
        $message = trim($data['message']);
        $lower = Str::lower($message);
        $reply = match (true) {
            Str::contains($lower, ['prompt', 'پرۆم'], true) => __('Start with the Prompt Library. Choose a category, copy a prompt, then adapt it to your goal.'),
            Str::contains($lower, ['learn', 'course', 'فێر', 'کۆرس'], true) => __('For a clear path, start with the beginner courses, then move into Python, machine learning, or generative AI.'),
            Str::contains($lower, ['kurd', 'کورد'], true) => __('Open the Kurdish AI Hub for Kurdish tools, terminology, prompts, and learning resources in Sorani and Badini.'),
            Str::contains($lower, ['tool', 'ئامراز'], true) => __('Tell me what you want to make: code, write, design, research, automate, or create media. I will point you to the right category.'),
            default => __('I can help you find an AI tool, prompt, course, or Kurdish resource. Tell me what you want to accomplish.'),
        };
        $history = $request->user()->chatHistories()->latest('last_message_at')->first();
        $messages = $history?->messages ?? [];
        $messages[] = ['role' => 'user', 'content' => $message];
        $messages[] = ['role' => 'assistant', 'content' => $reply];
        $history ??= new ChatHistory(['user_id' => $request->user()->id, 'title' => Str::limit($message, 60)]);
        $history->messages = array_slice($messages, -20);
        $history->last_message_at = now();
        $history->save();
        return response()->json(['ok' => true, 'reply' => $reply]);
    }

    public function track(Request $request): JsonResponse
    {
        $data = $request->validate([
            'event' => ['required', 'string', 'max:80', 'regex:/^[a-z0-9_.-]+$/'],
            'path' => ['nullable', 'string', 'max:500'],
            'entity_type' => ['nullable', 'string', 'max:60'],
            'entity_key' => ['nullable', 'string', 'max:160'],
            'metadata' => ['nullable', 'array'],
        ]);
        AnalyticsEvent::create(array_merge($data, [
            'user_id' => $request->user()?->id,
            'session_hash' => hash('sha256', (string) $request->session()->getId()),
        ]));
        return response()->json(['ok' => true], 202);
    }

    public function news()
    {
        $articles = $this->newsRecords();
        return view('news.index', compact('articles'));
    }

    public function newsShow(string $slug)
    {
        $article = collect($this->newsRecords())->firstWhere('slug', $slug);
        abort_unless($article, 404);
        return view('news.show', compact('article'));
    }

    private function newsRecords(): array
    {
        try {
            $raw = app('firebase.database')->getReference('news')->getValue();
        } catch (\Throwable $e) {
            report($e);
            $raw = [];
        }
        $locale = app()->getLocale();
        $records = [];
        foreach (is_array($raw) ? $raw : [] as $key => $node) {
            if (! is_array($node) || (($node['status'] ?? 'published') !== 'published')) continue;
            $title = is_array($node['title'] ?? null) ? ($node['title'][$locale] ?? $node['title']['en'] ?? 'AI News') : ($node['title'] ?? 'AI News');
            $excerpt = is_array($node['excerpt'] ?? null) ? ($node['excerpt'][$locale] ?? $node['excerpt']['en'] ?? '') : ($node['excerpt'] ?? '');
            $body = is_array($node['body'] ?? null) ? ($node['body'][$locale] ?? $node['body']['en'] ?? $excerpt) : ($node['body'] ?? $excerpt);
            $records[] = ['id' => (string) ($node['id'] ?? $key), 'slug' => (string) ($node['slug'] ?? Str::slug($title)), 'title' => $title, 'excerpt' => $excerpt, 'body' => $body, 'source' => $node['source'] ?? 'AlphaAi', 'category' => $node['category'] ?? 'AI', 'image_url' => $node['image_url'] ?? '', 'published_at' => $node['published_at'] ?? now()->toIso8601String()];
        }
        usort($records, fn ($a, $b) => strtotime($b['published_at']) <=> strtotime($a['published_at']));
        return $records;
    }

    public function robots(): \Illuminate\Http\Response
    {
        return response("User-agent: *\nAllow: /\nDisallow: /dashboard\nDisallow: /assistant\nDisallow: /api/\nSitemap: ".url('/sitemap.xml')."\n", 200, ['Content-Type' => 'text/plain']);
    }

    public function sitemap(): \Illuminate\Http\Response
    {
        $urls = ['/', '/tools', '/prompts', '/kurdish-ai', '/courses', '/news', '/about', '/universities', '/academic-guide'];
        $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($urls as $url) $xml .= '<url><loc>'.e(url($url)).'</loc><changefreq>weekly</changefreq></url>';
        foreach ($this->newsRecords() as $article) $xml .= '<url><loc>'.e(route('news.show', $article['slug'])).'</loc><changefreq>monthly</changefreq></url>';
        return response($xml.'</urlset>', 200, ['Content-Type' => 'application/xml']);
    }
}
