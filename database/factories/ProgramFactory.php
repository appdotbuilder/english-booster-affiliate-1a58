<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class ProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['online', 'offline_pare', 'group', 'branch'];
        $category = $this->faker->randomElement($categories);
        
        return [
            'name' => $this->faker->words(3, true) . ' Program',
            'description' => $this->faker->sentence(),
            'category' => $category,
            'location' => $category === 'branch' ? $this->faker->city() : null,
            'price' => $this->faker->numberBetween(1000000, 5000000),
            'commission_percentage' => $this->faker->numberBetween(10, 25),
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }
}