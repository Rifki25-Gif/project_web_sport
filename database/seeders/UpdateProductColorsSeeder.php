<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class UpdateProductColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all products
        $products = Product::all();
        
        foreach ($products as $product) {
            // Make sure we have a color value
            if ($product->color) {
                // Extract color options from the string
                $colorString = $product->color;
                $colorOptions = [];
                
                // If the color contains commas, it's likely multiple colors
                if (strpos($colorString, ',') !== false) {
                    $parts = explode(',', $colorString);
                    foreach ($parts as $part) {
                        // Extract the first color in case of 'Color/Color' format
                        $colorPart = explode('/', trim($part))[0];
                        $colorOptions[] = trim($colorPart);
                    }
                } else {
                    // Single color or possibly a 'Color/Color' format
                    $parts = explode('/', $colorString);
                    foreach ($parts as $part) {
                        $colorOptions[] = trim($part);
                    }
                }
                
                // Make sure color options is unique and not empty
                $colorOptions = array_unique(array_filter($colorOptions));
                
                // If we have color options, update the colors field
                if (!empty($colorOptions)) {
                    // Update the colors field directly in the database to avoid any model casting issues
                    DB::table('products')
                        ->where('id', $product->id)
                        ->update(['colors' => json_encode($colorOptions)]);
                }
            }
        }
    }
}
