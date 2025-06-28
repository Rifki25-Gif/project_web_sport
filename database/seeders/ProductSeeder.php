<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        
        // Running Shoes
        $runningCategory = $categories->where('name', 'Running Shoes')->first();
        if ($runningCategory) {
            $runningProducts = [
                [
                    'name' => 'Aero Boost 2.0',
                    'description' => 'Ultimate responsive running shoe for marathon runners. Features a lightweight design with superior cushioning for long-distance comfort.',
                    'price' => 179.99,
                    'sale_price' => 159.99,
                    'stock_quantity' => 45,
                    'sku' => 'RUN-AB2-001',
                    'brand' => 'Nike',
                    'surface_type' => 'Road',
                    'performance_rating' => 'Professional',
                    'sizes' => ['7', '8', '9', '10', '11', '12'],
                    'color' => 'Black/Red, Blue/White, Gray/Orange',
                    'featured_image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff',
                    'is_featured' => true,
                ],
                [
                    'name' => 'Trail Blazer Pro',
                    'description' => 'Rugged trail running shoe with aggressive tread pattern for optimal grip on uneven terrain. Water-resistant upper keeps feet dry in wet conditions.',
                    'price' => 149.99,
                    'sale_price' => null,
                    'stock_quantity' => 32,
                    'sku' => 'RUN-TBP-002',
                    'brand' => 'Adidas',
                    'surface_type' => 'Trail',
                    'performance_rating' => 'Advanced',
                    'sizes' => ['7', '8', '9', '10', '11', '12'],
                    'color' => 'Green/Black, Brown/Orange, Gray/Blue',
                    'featured_image' => 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa',
                    'is_featured' => false,
                ],
                [
                    'name' => 'Velocity Elite',
                    'description' => 'Lightweight racing shoe designed for speed. Features a carbon fiber plate for maximum energy return and propulsion.',
                    'price' => 199.99,
                    'sale_price' => 179.99,
                    'stock_quantity' => 20,
                    'sku' => 'RUN-VE-003',
                    'brand' => 'Nike',
                    'surface_type' => 'Track',
                    'performance_rating' => 'Elite',
                    'sizes' => ['7', '8', '9', '10', '11'],
                    'color' => 'Neon Yellow/Black, White/Red, Blue/Silver',
                    'featured_image' => 'https://images.unsplash.com/photo-1595341888016-a392ef81b7de',
                    'is_featured' => true,
                ],
            ];
            
            foreach ($runningProducts as $product) {
                Product::create([
                    'name' => $product['name'],
                    'slug' => Str::slug($product['name']),
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'sale_price' => $product['sale_price'],
                    'stock_quantity' => $product['stock_quantity'],
                    'sku' => $product['sku'],
                    'category_id' => $runningCategory->id,
                    'brand' => $product['brand'],
                    'surface_type' => $product['surface_type'],
                    'performance_rating' => $product['performance_rating'],
                    'sizes' => json_encode($product['sizes']),
                    'color' => $product['color'],
                    'featured_image' => $product['featured_image'],
                    'is_featured' => $product['is_featured'],
                    'is_active' => true,
                    'rating' => rand(35, 50) / 10,
                ]);
            }
        }
        
        // Basketball Shoes
        $basketballCategory = $categories->where('name', 'Basketball')->first();
        if ($basketballCategory) {
            $basketballProducts = [
                [
                    'name' => 'Court Dominator X',
                    'description' => 'High-top basketball shoe with exceptional ankle support and cushioning. Designed for explosive movements and quick direction changes.',
                    'price' => 189.99,
                    'sale_price' => null,
                    'stock_quantity' => 28,
                    'sku' => 'BBL-CDX-001',
                    'brand' => 'Nike',
                    'surface_type' => 'Indoor',
                    'performance_rating' => 'Professional',
                    'sizes' => ['8', '9', '10', '11', '12', '13'],
                    'color' => 'Black/Gold, Red/White, Blue/Silver',
                    'featured_image' => 'https://images.unsplash.com/photo-1607522370275-f14206abe5d3',
                    'is_featured' => true,
                ],
                [
                    'name' => 'Air Elevate Pro',
                    'description' => 'Mid-top basketball shoe with responsive cushioning for all-day comfort. Features a durable rubber outsole for excellent traction.',
                    'price' => 159.99,
                    'sale_price' => 139.99,
                    'stock_quantity' => 35,
                    'sku' => 'BBL-AEP-002',
                    'brand' => 'Adidas',
                    'surface_type' => 'All-Court',
                    'performance_rating' => 'Advanced',
                    'sizes' => ['7', '8', '9', '10', '11', '12'],
                    'color' => 'White/Blue, Black/Red, Gray/Green',
                    'featured_image' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5',
                    'is_featured' => false,
                ],
            ];
            
            foreach ($basketballProducts as $product) {
                Product::create([
                    'name' => $product['name'],
                    'slug' => Str::slug($product['name']),
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'sale_price' => $product['sale_price'],
                    'stock_quantity' => $product['stock_quantity'],
                    'sku' => $product['sku'],
                    'category_id' => $basketballCategory->id,
                    'brand' => $product['brand'],
                    'surface_type' => $product['surface_type'],
                    'performance_rating' => $product['performance_rating'],
                    'sizes' => json_encode($product['sizes']),
                    'color' => $product['color'],
                    'featured_image' => $product['featured_image'],
                    'is_featured' => $product['is_featured'],
                    'is_active' => true,
                    'rating' => rand(35, 50) / 10,
                ]);
            }
        }
        
        // Soccer Shoes
        $soccerCategory = $categories->where('name', 'Soccer')->first();
        if ($soccerCategory) {
            $soccerProducts = [
                [
                    'name' => 'Mercurial Vapor 15',
                    'description' => 'Lightweight soccer cleats designed for speed. Features a textured upper for superior ball control and precision passing.',
                    'price' => 229.99,
                    'sale_price' => 199.99,
                    'stock_quantity' => 25,
                    'sku' => 'SOC-MV15-001',
                    'brand' => 'Nike',
                    'surface_type' => 'Firm Ground',
                    'performance_rating' => 'Elite',
                    'sizes' => ['7', '8', '9', '10', '11', '12'],
                    'color' => 'Crimson/Black, Blue/Yellow, White/Gold',
                    'featured_image' => 'https://images.unsplash.com/photo-1511886929837-354d827aae26',
                    'is_featured' => true,
                ],
                [
                    'name' => 'Predator Elite',
                    'description' => 'Soccer cleats designed for powerful shots and precise passes. Features a textured upper for enhanced ball control in all weather conditions.',
                    'price' => 199.99,
                    'sale_price' => null,
                    'stock_quantity' => 30,
                    'sku' => 'SOC-PE-002',
                    'brand' => 'Adidas',
                    'surface_type' => 'Firm Ground',
                    'performance_rating' => 'Professional',
                    'sizes' => ['7', '8', '9', '10', '11', '12'],
                    'color' => 'Black/Red, Blue/White, Green/Black',
                    'featured_image' => 'https://images.unsplash.com/photo-1628351509551-f47d72ec6c3e',
                    'is_featured' => false,
                ],
                [
                    'name' => 'Future Z 1.1',
                    'description' => 'Innovative soccer cleats with a unique lacing system for a customized fit. Designed for agile players who rely on quick movements and creativity.',
                    'price' => 189.99,
                    'sale_price' => 169.99,
                    'stock_quantity' => 22,
                    'sku' => 'SOC-FZ-003',
                    'brand' => 'Puma',
                    'surface_type' => 'Firm Ground',
                    'performance_rating' => 'Advanced',
                    'sizes' => ['7', '8', '9', '10', '11'],
                    'color' => 'Yellow/Black, Blue/Green, White/Red',
                    'featured_image' => 'https://images.unsplash.com/photo-1535131749006-b7d58b247c8b',
                    'is_featured' => true,
                ],
            ];
            
            foreach ($soccerProducts as $product) {
                Product::create([
                    'name' => $product['name'],
                    'slug' => Str::slug($product['name']),
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'sale_price' => $product['sale_price'],
                    'stock_quantity' => $product['stock_quantity'],
                    'sku' => $product['sku'],
                    'category_id' => $soccerCategory->id,
                    'brand' => $product['brand'],
                    'surface_type' => $product['surface_type'],
                    'performance_rating' => $product['performance_rating'],
                    'sizes' => json_encode($product['sizes']),
                    'color' => $product['color'],
                    'featured_image' => $product['featured_image'],
                    'is_featured' => $product['is_featured'],
                    'is_active' => true,
                    'rating' => rand(35, 50) / 10,
                ]);
            }
        }
    }
} 