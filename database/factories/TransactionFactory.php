<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), 
            'bill_type' => $this->faker->randomElement(['Electricity', 'Water', 'Internet']),
            'amount_due' => $this->faker->randomFloat(2, 50, 500),
            'amount_paid' => $this->faker->randomFloat(2, 10, 500),
            'description' => $this->faker->sentence,
            'payment_method' => $this->faker->randomElement(['Credit Card', 'Bank Transfer', 'PayPal']),
            'transaction_reference' => $this->faker->unique()->bothify('REF######'),
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'due_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
        ];
    }
}
