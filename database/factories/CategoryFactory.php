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
        $name = $this->faker->unique()->words(rand(1, 2), true);
        $slug = Str::slug($name);
        
        return [
            'name' => ucwords($name),
            'slug' => $slug,
            'description' => $this->faker->paragraph(),
            'image' => 'categories/category-' . rand(1, 5) . '.jpg',
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }
}
