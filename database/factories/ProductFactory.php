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
        $name = $this->faker->unique()->words(rand(2, 4), true);
        $slug = Str::slug($name);
        $price = $this->faker->randomFloat(2, 50, 300);
        $sale_price = $this->faker->boolean(30) ? $price * 0.8 : null; // 30% chance of having a sale price
        
        // Shoe sizes
        $sizes = [];
        for ($i = 0; $i < rand(5, 10); $i++) {
            $sizes[] = (string)rand(38, 45); // EU sizes from 38 to 45
        }
        
        // Generate multiple images
        $images = [];
        for ($i = 1; $i <= rand(3, 5); $i++) {
            $images[] = 'https://picsum.photos/seed/' . $this->faker->uuid() . '/800/600';
        }
        
        // Surface types for football shoes
        $surfaceTypes = ['Firm Ground', 'Soft Ground', 'Artificial Grass', 'Indoor', 'Turf'];
        
        // Brands
        $brands = ['Nike', 'Adidas', 'Puma', 'New Balance', 'Umbro', 'Mizuno'];
        
        // Colors
        $colors = ['Black', 'White', 'Red', 'Blue', 'Green', 'Yellow', 'Orange', 'Purple'];
        
        // Performance ratings
        $performanceRatings = ['Professional', 'Elite', 'Amateur', 'Casual'];
        
        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory()->create()->id,
            'name' => ucwords($name),
            'slug' => $slug,
            'description' => $this->faker->paragraphs(rand(3, 5), true),
            'price' => $price,
            'sale_price' => $sale_price,
            'sku' => strtoupper($this->faker->unique()->bothify('??###??')),
            'stock_quantity' => $this->faker->numberBetween(0, 100),
            'brand' => $this->faker->randomElement($brands),
            'material' => $this->faker->randomElement(['Leather', 'Synthetic', 'Mesh', 'Knit']),
            'color' => $this->faker->randomElement($colors),
            'sizes' => json_encode($sizes),
            'images' => json_encode($images),
            'featured_image' => 'https://picsum.photos/seed/' . $this->faker->uuid() . '/800/600',
            'surface_type' => $this->faker->randomElement($surfaceTypes),
            'performance_rating' => $this->faker->randomElement($performanceRatings),
            'is_featured' => $this->faker->boolean(20), // 20% chance of being featured
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }
}
