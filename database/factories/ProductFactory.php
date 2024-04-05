<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'description' => $this->faker->sentence,
            'short_description' => $this->faker->sentence,
            'price' => fake()->numberBetween(100,  1000),
            'quantity' => $this->faker->numberBetween(0 - 1000),
            'slug' => $this->faker->sentence,
            'category_id' => Category::all()->random()->id,
            'brand_id' => Brand::all()->random()->id,


        ];
    }
}
