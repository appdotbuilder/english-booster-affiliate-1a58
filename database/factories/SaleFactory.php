<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $saleAmount = $this->faker->numberBetween(1000000, 5000000);
        $commissionRate = $this->faker->numberBetween(10, 25);
        $commissionAmount = ($saleAmount * $commissionRate) / 100;
        
        return [
            'affiliate_id' => User::factory(),
            'program_id' => Program::factory(),
            'tracking_code' => 'EB' . strtoupper(Str::random(8)),
            'customer_name' => $this->faker->name(),
            'customer_email' => $this->faker->unique()->safeEmail(),
            'customer_phone' => '08' . $this->faker->numerify('##########'),
            'sale_amount' => $saleAmount,
            'commission_rate' => $commissionRate,
            'commission_amount' => $commissionAmount,
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
            'sale_date' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}