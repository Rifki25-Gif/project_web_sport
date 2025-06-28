<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Running Shoes',
                'description' => 'High-performance footwear designed for runners of all levels. Featuring advanced cushioning, responsive soles, and breathable materials for optimal comfort during your runs.',
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=2070&auto=format&fit=crop',
            ],
            [
                'name' => 'Lifestyle Sneakers',
                'description' => 'Stylish and comfortable sneakers for everyday wear. Combining fashion-forward designs with all-day comfort for your urban adventures.',
                'image' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?q=80&w=1887&auto=format&fit=crop',
            ],
            [
                'name' => 'Training & Gym',
                'description' => 'Versatile footwear designed for cross-training, weightlifting, and gym workouts. Featuring stable platforms, durable construction, and flexible support.',
                'image' => 'https://images.unsplash.com/photo-1560769629-975ec94e6a86?q=80&w=1964&auto=format&fit=crop',
            ],
            [
                'name' => 'Basketball',
                'description' => 'Performance basketball shoes engineered for explosive movements, superior court grip, and ankle support. Designed for both indoor and outdoor play.',
                'image' => 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?q=80&w=1964&auto=format&fit=crop',
            ],
            [
                'name' => 'Soccer',
                'description' => 'Specialized footwear for the beautiful game, featuring cleats for optimal traction, touch-enhancing materials, and lightweight construction for speed.',
                'image' => 'https://images.unsplash.com/photo-1605235186583-a8272b61f9fe?q=80&w=2070&auto=format&fit=crop',
            ],
            [
                'name' => 'Tennis',
                'description' => 'Court-specific shoes designed for lateral movements, durability, and stability during tennis matches and practice sessions.',
                'image' => 'https://images.unsplash.com/photo-1606226804390-8a6e9bf8e2b6?q=80&w=2070&auto=format&fit=crop',
            ],
            [
                'name' => 'Hiking & Outdoor',
                'description' => 'Rugged footwear built for the trails, featuring waterproof materials, superior traction, and durable construction for all your outdoor adventures.',
                'image' => 'https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?q=80&w=2012&auto=format&fit=crop',
            ],
            [
                'name' => 'Volleyball',
                'description' => 'Specialized shoes designed for the unique movements of volleyball, featuring excellent cushioning for jumps and quick lateral support.',
                'image' => 'https://images.unsplash.com/photo-1562552052-c72ceddf93dc?q=80&w=2070&auto=format&fit=crop',
            ]
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'image' => $category['image'],
            ]);
        }
    }
} 