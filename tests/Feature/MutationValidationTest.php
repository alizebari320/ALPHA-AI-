<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MutationValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_course_mutation_requires_a_valid_title(): void
    {
        $admin = User::factory()->create(['email' => config('alphaai.admin_emails')[0]]);

        $this->actingAs($admin)
            ->post('/store-course', ['video_url' => 'not-a-url'])
            ->assertSessionHasErrors(['title', 'video_url']);
    }

    public function test_prompt_category_must_be_configured(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson('/prompts', [
                'title' => 'Test',
                'body' => 'Body',
                'category' => 'not-a-category',
                'locale' => 'en',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['category']);
    }
}
