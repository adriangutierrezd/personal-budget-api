<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $date = $this->faker->randomElement([
            '2024-01-28',
            '2024-01-29',
            '2024-02-04'
        ]);

        $description = $this->faker->randomElement([
            null,
            $this->faker->words(20, true)
        ]);

        return [
            'user_id' => 1,
            'category_id' => Category::factory(),
            'amount' => $this->faker->numberBetween(1, 500),
            'name' => $this->faker->words(6, true),
            'description' => $description,
            'date' => $date,
            'week' => date('W', strtotime($date)),
            'month' => date('n', strtotime($date)),
            'year' => date('Y', strtotime($date))
        ];
    }
}
