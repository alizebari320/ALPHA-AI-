<?php

namespace Tests\Feature;

use App\Models\Prompt;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_product_pages_render(): void
    {
        $this->get('/prompts')->assertOk();
        $this->get('/kurdish-ai')->assertOk();
        $this->get('/news')->assertOk();
        $this->get('/sitemap.xml')->assertOk();
        $this->get('/robots.txt')->assertOk();
    }

    public function test_public_prompt_can_be_copied_without_login(): void
    {
        $prompt = Prompt::create([
            'title' => 'Test prompt',
            'body' => 'Explain this clearly.',
            'category' => 'study',
            'locale' => 'en',
            'is_public' => true,
        ]);

        $this->postJson("/prompts/{$prompt->id}/copy")
            ->assertOk()
            ->assertJsonPath('body', 'Explain this clearly.');
        $this->assertSame(1, $prompt->fresh()->copy_count);
    }

    public function test_assistant_requires_authentication(): void
    {
        $this->get('/assistant')->assertRedirect('/login');
        $this->actingAs(User::factory()->create(['email_verified_at' => now()]))
            ->postJson('/assistant/ask', ['message' => 'find me a tool'])
            ->assertOk()
            ->assertJsonPath('ok', true);
    }
}
