<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_menu' => fake()->name(),
            'price' => fake()->numberBetween(5, 300),
            'description' => fake()->paragraph(2),
            'category_id' => Category::all()->random()->id,
        ];
    }
}
