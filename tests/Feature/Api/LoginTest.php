<?php

namespace Tests\Feature\Api;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testLoginAndGetApiToken()
    {
        $user = factory(User::class)->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'api_token' => $user->api_token,
        ]);
    }

    public function testFailedLogin()
    {
        $user = factory(User::class)->create();

        $response = $this->postJson('/api/login', [
            'email' => $this->faker->email,
            'password' => $this->faker->password
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            "message" => "Invalid credentials"
        ]);
    }
}
