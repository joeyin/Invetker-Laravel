<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $qty = fake()->numberBetween(1, 1000);
        $price = fake()->numberBetween(1, 230);
        $fee = fake()->numberBetween(0, 2) / 100;
        return [
            'datetime' => fake()->dateTimeThisMonth(),
            'quantity' => $qty,
            'price' => $price,
            'fee' => $qty * $price * $fee,
        ];
    }
}
