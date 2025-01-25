<?php

namespace Database\Factories;

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
            'user_id'=>1,
            'category_id'=>10,
            'name'=>$this->faker->name,
            'price'=>$this->faker->numberBetween(100,1000),
            'unit'=>$this->faker->numberBetween(1,10),
            'img_url'=>$this->faker->imageUrl
        ];
    }
}
