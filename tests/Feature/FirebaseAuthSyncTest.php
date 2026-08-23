<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class FirebaseAuthSyncTest extends TestCase
{
    use RefreshDatabase;

    public function test_unverified_firebase_identity_is_rejected(): void
    {
        $this->mockFirebaseToken([
            'sub' => 'firebase-user-1',
            'email' => 'user@example.com',
            'email_verified' => false,
        ]);

        $this->postJson('/api/firebase-auth-sync', ['id_token' => 'token'])
            ->assertForbidden()
            ->assertJsonPath('error', 'email_not_verified');
    }

    public function test_existing_email_requires_explicit_account_link(): void
    {
        User::factory()->create(['email' => 'user@example.com']);
        $this->mockFirebaseToken([
            'sub' => 'firebase-user-2',
            'email' => 'user@example.com',
            'email_verified' => true,
        ]);

        $this->postJson('/api/firebase-auth-sync', ['id_token' => 'token'])
            ->assertStatus(409)
            ->assertJsonPath('error', 'account_link_required');
    }

    public function test_verified_firebase_identity_is_bound_by_uid(): void
    {
        $this->mockFirebaseToken([
            'sub' => 'firebase-user-3',
            'email' => 'new@example.com',
            'email_verified' => true,
            'name' => 'New User',
        ]);

        $this->postJson('/api/firebase-auth-sync', ['id_token' => 'token'])
            ->assertOk()
            ->assertJsonPath('ok', true);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'new@example.com',
            'firebase_uid' => 'firebase-user-3',
        ]);
    }

    private function mockFirebaseToken(array $claims): void
    {
        $token = Mockery::mock();
        $token->shouldReceive('claims->all')->andReturn($claims);

        $auth = Mockery::mock();
        $auth->shouldReceive('verifyIdToken')->once()->with('token')->andReturn($token);

        $this->app->instance('firebase.auth', $auth);
    }
}
