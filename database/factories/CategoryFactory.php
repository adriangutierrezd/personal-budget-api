<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $colors = array(
            "#FF0000", // Rojo
            "#00FF00", // Verde
            "#0000FF", // Azul
            "#FFFF00", // Amarillo
            "#FF00FF", // Magenta
            "#00FFFF", // Cian
            "#800080", // Púrpura
            "#FFA500", // Naranja
            "#008000", // Verde oscuro
            "#000000"  // Negro
        );

        return [
            'user_id' => User::factory(),
            'name' => $this->faker->words(4, true),
            'color' => $colors[array_rand($colors)]
        ];
    }
}
