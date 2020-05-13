<?php
declare(strict_types=1);

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    public function test_login_and_get_api_token()
    {
        $user = factory(User::class)->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'api_token' => $user->api_token,
        ]);
    }

    public function test_failed_login()
    {
        $user = factory(User::class)->create();

        $response = $this->postJson('/api/login', [
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Invalid credentials',
        ]);
    }
}
