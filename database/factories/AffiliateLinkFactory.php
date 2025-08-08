<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AffiliateLink>
 */
class AffiliateLinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $trackingCode = 'EB' . strtoupper(Str::random(8));
        
        return [
            'user_id' => User::factory(),
            'program_id' => Program::factory(),
            'tracking_code' => $trackingCode,
            'link_url' => url('/affiliate/' . $trackingCode . '/program/' . $this->faker->numberBetween(1, 100)),
            'clicks' => $this->faker->numberBetween(0, 500),
        ];
    }
}