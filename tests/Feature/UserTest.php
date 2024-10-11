<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_user()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
            'x-api-key' => env("API_KEY"),
        ])->patchJson('/api/user', [
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'first_name' => 'John',
                'last_name' => 'Doe',
            ]);
    }

    public function test_can_get_user_details()
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

    public function test_can_delete_user()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
            'x-api-key' => env("API_KEY"),
        ])->deleteJson('/api/user');

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'statusCode' => 200,
                'message' => 'User deleted successfully',
                'data' => [],
                'error' => null,
            ]);

        // Assert user is deleted from the database
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
