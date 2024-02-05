<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_restaurant' => fake()->name(),
            'location' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->email(),
            'description' => fake()->paragraph(),
            'user_id' => User::all()->random()->id
        ];
    }
}
