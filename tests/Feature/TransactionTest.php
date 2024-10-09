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
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/transactions', [
            'user_id' => $user->id,
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
            ->assertJsonStructure(['message', 'transaction']);
    }

    public function test_can_get_transaction()
    {
        $user = User::factory()->create();
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
        ]);
        Sanctum::actingAs($user);

        $response = $this->getJson("/api/transactions/{$transaction->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['id', 'user_id', 'amount_due']);
    }

    public function test_can_update_transaction()
    {
        $user = User::factory()->create();
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
        ]);
        Sanctum::actingAs($user);

        $response = $this->putJson("/api/transactions/{$transaction->id}", [
            'amount_paid' => 75.00,
            'status' => 'completed',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'amount_paid' => 75.00,
                'status' => 'completed',
            ]);
    }
}
