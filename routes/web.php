<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Livewire\ProductCatalog;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

// Using Livewire component for the homepage
// Route::get('/', action: [HomeController::class, 'index'])->name('welcome');

Route::get('/', function () {
    return 'Tes Koneksi Berhasil!';
});
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{product:slug}/reviews', [ReviewController::class, 'index'])->name('products.reviews');
Route::middleware(['auth'])->group(function () {
    Route::get('/products/{product:slug}/review/create', [ReviewController::class, 'create'])->name('products.reviews.create');
    Route::post('/products/{product:slug}/review', [ReviewController::class, 'store'])->name('products.reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});
  Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
  Route::get('/categories/all', [CategoryController::class, 'index'])->name('categories.all');
  Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/search', [ProductController::class, 'search'])->name('search');
Route::get('/size-guide', function() {
    return view('size-guide');
})->name('size-guide');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Alias route for kategory/all
Route::get('/kategory/all', function() {
    return redirect()->route('categories.index');
});

Route::get('/product-detail', function () {
    return view('product-detail');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('dashboard', [AccountController::class, 'dashboard'])->name('dashboard');
    Route::get('orders', [AccountController::class, 'orders'])->name('orders');
    Route::get('orders/{id}', [AccountController::class, 'orderDetails'])->name('orders.show');
    Route::get('profile', [AccountController::class, 'profile'])->name('profile');
    Route::get('addresses', [AccountController::class, 'addresses'])->name('addresses');
});

// Wishlist Routes
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/shipping', [CheckoutController::class, 'shipping'])->name('shipping');
    Route::post('/shipping', [CheckoutController::class, 'processShipping']);
    Route::get('/payment', [CheckoutController::class, 'payment'])->name('payment');
    Route::post('/payment', [CheckoutController::class, 'processPayment']);
    Route::get('/success', [CheckoutController::class, 'success'])->name('success');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::post('products/bulk-actions', [AdminProductController::class, 'bulkActions'])->name('products.bulkActions');
    Route::resource('orders', OrderController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::post('categories/bulk-actions', [AdminCategoryController::class, 'bulkActions'])->name('categories.bulkActions');
    Route::resource('users', UserController::class);
    
    // Reviews management
    Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::get('reviews/{review}', [AdminReviewController::class, 'show'])->name('reviews.show');
    Route::post('reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('reviews/{review}/reject', [AdminReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('reviews/bulk-actions', [AdminReviewController::class, 'bulkActions'])->name('reviews.bulkActions');
});

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');

// Checkout routes
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout/shipping', [CheckoutController::class, 'shipping'])->name('checkout.shipping');
    Route::post('/checkout/shipping', [CheckoutController::class, 'processShipping']);
    Route::get('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/checkout/payment', [CheckoutController::class, 'processPayment']);
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
});

require __DIR__.'/auth.php';
