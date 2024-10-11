<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_transaction()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
            'x-api-key' => env("API_KEY"),
        ])->postJson('/api/transaction', [
            'bill_type' => 'Electricity',
            'amount_due' => 100.50,
            'amount_paid' => 50.00,
            'description' => 'Electricity bill for September',
            'payment_method' => 'Credit Card',
            'transaction_reference' => 'REF123456789',
            'status' => 'pending',
            'due_date' => now()->addDays(7),
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'statusCode',
                'message',
                'data' => [
                    'id',
                    'user_id',
                    'bill_type',
                    'amount_due',
                    'amount_paid',
                    'description',
                    'payment_method',
                    'transaction_reference',
                    'status',
                    'due_date',
                    'created_at',
                ],
                'error'
            ]);
    }

    public function test_can_get_transaction()
    {
        $user = User::factory()->create();
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
        ]);
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
            'x-api-key' => env("API_KEY"),
        ])->getJson("/api/transaction/{$transaction->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'statusCode',
                'message',
                'data' => [
                    'id',
                    'user_id',
                    'bill_type',
                    'amount_due',
                    'amount_paid',
                    'description',
                    'payment_method',
                    'transaction_reference',
                    'status',
                    'due_date',
                    'created_at',
                ],
                'error'
            ]);
    }

    public function test_can_update_transaction()
    {
        $user = User::factory()->create();
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
        ]);
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
            'x-api-key' => env("API_KEY"),
        ])->patchJson("/api/transaction/{$transaction->id}", [
            'amount_paid' => 75.00,
            'status' => 'completed',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'amount_paid' => 75.00,
                'status' => 'completed',
            ]);
    }

    public function test_can_delete_transaction()
    {
        $user = User::factory()->create();
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
        ]);
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
            'x-api-key' => env("API_KEY"),
        ])->deleteJson("/api/transaction/{$transaction->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'statusCode' => 200,
                'message' => 'Transaction deleted successfully',
                'data' => [],
                'error' => null,
            ]);

        $this->assertDatabaseMissing('transactions', ['id' => $transaction->id]);
    }
}
