<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $randCategoryNumber = rand(1, 1000);

        return [
            'id' => Str::uuid()->toString(),
            'name' => "Category {$randCategoryNumber}",
            'description' => "Category {$randCategoryNumber} description",
        ];
    }
}
