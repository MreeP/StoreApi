<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use RefreshDatabase;

    public function test_login_endpoint()
    {
        $user = User::factory()->createOne();
        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'invalid_password',
        ]);

        $response->assertStatus(401)
            ->assertJson(['error' => 'Invalid credentials.']);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonMissing(['error' => 'Invalid credentials.']);

        $this->assertDatabaseHas('api_tokens', [
            'user_id' => $user->id,
            'token' => $response['token'],
        ]);
    }

    public function test_logout_endpoint()
    {
        $user = User::factory()->createOne();

        $token = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ])['token'];

        // Since everything affects one session (and we are testing api tokens) we have to perform manual logout.
        auth()->logout();
        $this->assertFalse(auth()->check());

        $response = $this->post('/api/logout', ['token' => 'fake_token_123']);
        $response->assertStatus(403)
            ->assertJson(['message' => 'unauthenticated']);

        $response = $this->post('/api/logout', ['token' => $token]);
        $response->assertStatus(200)
            ->assertJson(['message' => 'Logged out successfully.']);
    }
}
