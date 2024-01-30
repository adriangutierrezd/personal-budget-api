<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recurring>
 */
class RecurringFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $description = $this->faker->randomElement([
            null,
            $this->faker->words(20, true)
        ]);

        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'amount' => $this->faker->numberBetween(1, 500),
            'name' => $this->faker->words(6, true),
            'description' => $description
        ];
    }
}
