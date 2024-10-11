<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->withHeaders([
            'x-api-key' => env("API_KEY"),
        ])->postJson('/api/auth/register', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@gmail.com',
            'password' => 'password',
        ]);

        $response->assertStatus(201)
        ->assertJson([
            'status' => true,
            'statusCode' => 201,
            'message' => "User resgistered successfully",
            'data' => [],
            'error' => null
        ]);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'jane.doe@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->withHeaders([
            'x-api-key' => env("API_KEY"),
        ])->postJson('/api/auth/login', [
            'email' => 'jane.doe@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'statusCode',
                'message',
                'data' => [
                    'access_token',
                    'user' => [
                        'id',
                        'first_name',
                        'last_name',
                        'email',
                        'account_type',
                        'email_verified_at',
                        'ip_address',
                        'created_at',
                    ]
                ],
                'error'
            ]);
    }

    public function test_authenticated_user_can_access_protected_route()
    {
        $user = User::factory()->create();

        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
            'x-api-key' => env("API_KEY"),
        ])->getJson('/api/user');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'statusCode',
                'message',
                'data' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'account_type',
                    'email_verified_at',
                    'ip_address',
                    'created_at',
                ],
                'error'
            ]);
    }
}
