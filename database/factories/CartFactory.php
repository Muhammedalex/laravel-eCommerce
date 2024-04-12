<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity'=>fake()->numberBetween(1-10),
             'color'=>fake()->word(),
             'size'=>fake()->word(),
             'total_price'=>fake()->numberBetween(300,500),
             'user_id'=>User::all()->random()->id,
             'product_id'=>Product::all()->random()->id
        ];
    }
}
