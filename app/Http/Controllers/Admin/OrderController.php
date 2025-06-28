<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.orders.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // In a real application, we would fetch the order from the database
        // For now, we'll use dummy data that matches our view's expected format
        
        $dummyOrders = [
            '12345' => [
                'id' => '#12345',
                'customer' => 'John Doe',
                'customer_email' => 'john@example.com',
                'date' => '2024-07-30',
                'total' => '150.00',
                'status' => 'Shipped',
                'status_class' => 'bg-green-100 text-green-800',
                'payment' => 'Credit Card',
                'payment_class' => 'bg-blue-100 text-blue-800',
                'items' => [
                    ['name' => 'Running Shoes', 'qty' => 1, 'price' => '100.00', 'image' => 'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg'],
                    ['name' => 'Sports Socks', 'qty' => 2, 'price' => '25.00', 'image' => 'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-02.jpg']
                ],
                'shipping_address' => [
                    'name' => 'John Doe',
                    'street' => '123 Main St',
                    'city' => 'Sportsville',
                    'state' => 'CA',
                    'zip' => '12345',
                    'country' => 'USA'
                ],
                'billing_address' => [
                    'name' => 'John Doe',
                    'street' => '123 Main St',
                    'city' => 'Sportsville',
                    'state' => 'CA',
                    'zip' => '12345',
                    'country' => 'USA'
                ],
                'payment_details' => [
                    'method' => 'Credit Card',
                    'last4' => '1234',
                    'expiration' => '12/25'
                ],
                'tracking' => [
                    ['status' => 'Order Placed', 'date' => 'July 26, 2024', 'description' => 'Order has been received'],
                    ['status' => 'Processing', 'date' => 'July 27, 2024', 'description' => 'Order is being processed'],
                    ['status' => 'Shipped', 'date' => 'July 28, 2024', 'description' => 'Order has been shipped', 'tracking_number' => '123456789']
                ]
            ]
        ];
        
        // Check if the order exists
        if (!isset($dummyOrders[$id])) {
            abort(404);
        }
        
        $order = $dummyOrders[$id];
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
