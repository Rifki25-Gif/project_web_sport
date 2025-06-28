<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get metrics for cards
        $totalSales = Order::where('status', 'completed')->sum('total');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('is_admin', false)->count();
        
        // Get recent orders
        $recentOrders = Order::with('user')
                            ->latest()
                            ->take(5)
                            ->get();
        
        // Get top selling products
        $topProducts = DB::table('order_items')
                        ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
                        ->groupBy('product_id')
                        ->orderBy('total_sold', 'desc')
                        ->take(5)
                        ->get();
                        
        $topProductsData = Product::whereIn('id', $topProducts->pluck('product_id'))
                                ->get()
                                ->map(function ($product) use ($topProducts) {
                                    $productSales = $topProducts->where('product_id', $product->id)->first();
                                    $product->total_sold = $productSales ? $productSales->total_sold : 0;
                                    return $product;
                                })
                                ->sortByDesc('total_sold');
        
        // Get monthly sales data for the chart
        $monthlySales = $this->getMonthlySalesData();
        
        // Get sales by category for the chart
        $salesByCategory = $this->getSalesByCategoryData();
        
        // Get pending reviews count
        $pendingReviewsCount = Review::where('is_approved', false)->count();
        
        return view('admin.dashboard', compact(
            'totalSales',
            'totalOrders',
            'totalProducts',
            'totalCustomers',
            'recentOrders',
            'topProductsData',
            'monthlySales',
            'salesByCategory',
            'pendingReviewsCount'
        ));
    }
    
    private function getMonthlySalesData()
    {
        $startDate = Carbon::now()->subMonths(11)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        $monthlySales = Order::where('status', 'completed')
                            ->where('created_at', '>=', $startDate)
                            ->where('created_at', '<=', $endDate)
                            ->select(
                                DB::raw('YEAR(created_at) as year'),
                                DB::raw('MONTH(created_at) as month'),
                                DB::raw('SUM(total) as total')
                            )
                            ->groupBy('year', 'month')
                            ->orderBy('year')
                            ->orderBy('month')
                            ->get();
        
        // Fill in missing months with zero sales
        $result = [];
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            $year = $currentDate->year;
            $month = $currentDate->month;
            $monthName = $currentDate->format('M');
            
            $monthlySale = $monthlySales->first(function ($sale) use ($year, $month) {
                return $sale->year == $year && $sale->month == $month;
            });
            
            $result[] = [
                'month' => $monthName,
                'year' => $year,
                'total' => $monthlySale ? round($monthlySale->total, 2) : 0
            ];
            
            $currentDate->addMonth();
        }
        
        return $result;
    }
    
    private function getSalesByCategoryData()
    {
        $categories = Category::all();
        $result = [];
        
        foreach ($categories as $category) {
            $total = DB::table('order_items')
                    ->join('products', 'order_items.product_id', '=', 'products.id')
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->where('orders.status', 'completed')
                    ->where('products.category_id', $category->id)
                    ->sum(DB::raw('order_items.price * order_items.quantity'));
            
            $result[] = [
                'category' => $category->name,
                'total' => round($total, 2)
            ];
        }
        
        return collect($result)->sortByDesc('total')->values()->all();
    }
} 