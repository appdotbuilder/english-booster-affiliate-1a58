<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommissionPayout>
 */
class CommissionPayoutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'affiliate_id' => User::factory(),
            'amount' => $this->faker->numberBetween(500000, 2000000),
            'status' => $this->faker->randomElement(['pending', 'processing', 'paid', 'cancelled']),
            'notes' => $this->faker->optional()->sentence(),
            'processed_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}