<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $randProductNumber = rand(1, 1000);

        return [
            'id' => Str::uuid()->toString(),
            'category_id' => Category::factory()->createOne(),
            'name' => "Product {$randProductNumber} name",
            'price' => fake()->randomFloat(2, 0, 1000),
        ];
    }
}
