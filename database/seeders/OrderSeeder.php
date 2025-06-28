<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 sample users
        $users = User::factory()->count(10)->create();

        // Create a few orders for each user
        $users->each(function (User $user) {
            // Create 1 to 3 orders per user
            for ($i = 0; $i < rand(1, 3); $i++) {
                $order = Order::create([
                    'user_id' => $user->id,
                    'total_price' => 0, // Will be updated after adding items
                    'status' => $this->getRandomStatus(),
                    'shipping_address' => $this->generateAddress(),
                    'billing_address' => $this->generateAddress(),
                ]);

                // Add 2 to 5 items to each order
                $totalPrice = 0;
                $products = Product::inRandomOrder()->limit(rand(2, 5))->get();

                foreach ($products as $product) {
                    $quantity = rand(1, 3);
                    $price = $product->sale_price ?? $product->price;
                    $itemPrice = $price * $quantity;
                    $sizes = json_decode($product->sizes);

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                        'size' => $sizes[array_rand($sizes)] ?? null,
                    ]);

                    $totalPrice += $itemPrice;
                }

                // Update the total price of the order
                $order->update(['total_price' => $totalPrice]);
            }
        });
    }

    /**
     * Get a random order status.
     *
     * @return string
     */
    private function getRandomStatus(): string
    {
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        return $statuses[array_rand($statuses)];
    }

    /**
     * Generate a random address.
     *
     * @return string
     */
    private function generateAddress(): string
    {
        return fake()->streetAddress() . ', ' . fake()->city() . ', ' . fake()->stateAbbr() . ' ' . fake()->postcode();
    }
}
