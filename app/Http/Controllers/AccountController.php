<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class AccountController extends Controller
{
    public function dashboard()
    {
        return view('account.dashboard');
    }

    public function orders()
    {
        return view('account.orders');
    }

    public function orderDetails($id)
    {
        // In a real application, we would fetch the order from the database
        // For now, we'll use dummy data that matches our view's expected format
        
        $orders = [
            'WU88191111' => [
                'id' => 'WU88191111',
                'date' => 'January 22, 2021',
                'datetime' => '2021-01-22',
                'status' => 'Completed',
                'total' => '120.00',
                'products' => [
                    ['id' => 1, 'name' => 'Running Shoes', 'href' => '#', 'price' => '75.00', 'quantity' => 1, 'imageSrc' => 'https://tailwindui.com/img/ecommerce-images/order-history-page-02-product-01.jpg', 'imageAlt' => 'Gray canvas low-top sneakers with white laces and rubber sole.'],
                    ['id' => 2, 'name' => 'Athletic Shorts', 'href' => '#', 'price' => '45.00', 'quantity' => 1, 'imageSrc' => 'https://tailwindui.com/img/ecommerce-images/order-history-page-02-product-02.jpg', 'imageAlt' => 'Black athletic shorts with white drawstring.'],
                ],
                'shipping_address' => [
                    'name' => 'John Doe',
                    'street' => '123 Main St',
                    'city' => 'Sportsville',
                    'state' => 'CA',
                    'zip' => '12345',
                    'country' => 'USA'
                ],
                'payment_method' => 'Credit Card',
                'tracking' => [
                    ['status' => 'Order Placed', 'date' => 'January 18, 2021', 'description' => 'Your order has been received'],
                    ['status' => 'Processing', 'date' => 'January 19, 2021', 'description' => 'Your order is being processed'],
                    ['status' => 'Shipped', 'date' => 'January 20, 2021', 'description' => 'Your order has been shipped', 'tracking_number' => 'TRK12345678'],
                    ['status' => 'Delivered', 'date' => 'January 22, 2021', 'description' => 'Your order has been delivered']
                ]
            ],
            'WU88191112' => [
                'id' => 'WU88191112',
                'date' => 'February 5, 2022',
                'datetime' => '2022-02-05',
                'status' => 'Processing',
                'total' => '90.00',
                'products' => [
                    ['id' => 1, 'name' => 'Performance T-Shirt', 'href' => '#', 'price' => '35.00', 'quantity' => 1, 'imageSrc' => 'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg', 'imageAlt' => 'Front of men\'s Basic Tee in black.'],
                    ['id' => 2, 'name' => 'Sports Water Bottle', 'href' => '#', 'price' => '15.00', 'quantity' => 1, 'imageSrc' => 'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-01.jpg', 'imageAlt' => 'Tall slender porcelain bottle with natural clay textured body and cork stopper.'],
                    ['id' => 3, 'name' => 'Yoga Mat', 'href' => '#', 'price' => '40.00', 'quantity' => 1, 'imageSrc' => 'https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-02.jpg', 'imageAlt' => 'Olive drab green insulated bottle with flared screw lid and flat top.'],
                ],
                'shipping_address' => [
                    'name' => 'John Doe',
                    'street' => '123 Main St',
                    'city' => 'Sportsville',
                    'state' => 'CA',
                    'zip' => '12345',
                    'country' => 'USA'
                ],
                'payment_method' => 'PayPal',
                'tracking' => [
                    ['status' => 'Order Placed', 'date' => 'February 1, 2022', 'description' => 'Your order has been received'],
                    ['status' => 'Processing', 'date' => 'February 3, 2022', 'description' => 'Your order is being processed']
                ]
            ],
        ];
        
        // Check if order exists in our dummy data
        if (!isset($orders[$id])) {
            abort(404);
        }
        
        $order = $orders[$id];
        
        return view('account.order-detail', compact('order'));
    }

    public function wishlist()
    {
        $wishlistItems = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('account.wishlist', [
            'wishlistItems' => $wishlistItems
        ]);
    }

    public function profile()
    {
        return view('account.profile');
    }

    public function addresses()
    {
        return view('account.addresses');
    }
    
    public function removeFromWishlist($wishlistId)
    {
        $wishlist = Wishlist::where('id', $wishlistId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        $wishlist->delete();
        
        return back()->with('success', 'Product has been removed from your wishlist.');
    }
}
