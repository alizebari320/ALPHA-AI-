<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    private function adminEmail(): string
    {
        return config('alphaai.admin_emails')[0];
    }

    public function test_guest_is_redirected_away_from_admin_routes(): void
    {
        $this->post('/store-course', ['title' => 'Hacked'])
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_non_admin_is_forbidden(): void
    {
        $user = User::factory()->create(['email' => 'random@example.com']);

        $this->actingAs($user)
            ->post('/store-course', ['title' => 'Hacked'])
            ->assertForbidden();
    }

    public function test_admin_passes_the_gate(): void
    {
        $admin = User::factory()->create(['email' => $this->adminEmail()]);

        // Not 403/302-to-login: the gate let the request reach the controller.
        $response = $this->actingAs($admin)->get('/courses/1/edit');

        $this->assertNotSame(403, $response->getStatusCode());
        $this->assertFalse(
            $response->isRedirect(route('login')),
            'Admin should not be bounced to the login page.'
        );
    }

    public function test_admin_check_is_case_insensitive(): void
    {
        $admin = User::factory()->create([
            'email' => strtoupper($this->adminEmail()),
        ]);

        $this->actingAs($admin)
            ->post('/store-course', ['title' => 'x'])
            ->assertStatus(302); // passed the gate, handled by controller
    }

    public function test_every_mutating_admin_route_is_gated(): void
    {
        $user = User::factory()->create(['email' => 'random@example.com']);

        $routes = [
            ['post', '/store-course'],
            ['post', '/store-ai-tool'],
            ['post', '/store-academic-guide'],
            ['put', '/courses/1'],
            ['delete', '/courses/1'],
            ['put', '/ai-tools/1'],
            ['delete', '/ai-tools/1'],
            ['put', '/academic-guide/1'],
            ['delete', '/academic-guide/1'],
        ];

        foreach ($routes as [$verb, $uri]) {
            $this->actingAs($user)->{$verb}($uri)
                ->assertForbidden("Route {$verb} {$uri} is NOT admin-gated.");
        }
    }
}
