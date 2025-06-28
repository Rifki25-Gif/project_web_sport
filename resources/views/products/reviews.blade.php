@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('products.show', $product->slug) }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Product
            </a>
        </div>
        
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Product Info -->
            <div class="md:w-1/3">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-4">
                        <img src="{{ $product->getFirstImage() }}" alt="{{ $product->name }}" class="w-full h-64 object-cover object-center">
                        <h1 class="mt-4 text-xl font-bold text-gray-900">{{ $product->name }}</h1>
                        <div class="mt-2 flex items-center">
                            <div class="flex items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= round($product->rating))
                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @else
                                        <svg class="h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <p class="ml-2 text-sm text-gray-700">{{ $product->reviews()->approved()->count() }} reviews</p>
                        </div>
                        <p class="mt-2 text-gray-900">
                            @if ($product->sale_price)
                                <span class="text-lg font-bold">${{ number_format($product->sale_price, 2) }}</span>
                                <span class="text-sm line-through text-gray-500">${{ number_format($product->price, 2) }}</span>
                                <span class="ml-2 bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">{{ $product->discountPercentage() }}% OFF</span>
                            @else
                                <span class="text-lg font-bold">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </p>
                        
                        @auth
                            @if (!$product->reviews()->where('user_id', auth()->id())->exists())
                                <div class="mt-4">
                                    <a href="{{ route('products.reviews.create', $product->slug) }}" class="w-full bg-indigo-600 border border-transparent rounded-md py-2 px-4 flex items-center justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Write a Review
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="mt-4">
                                <a href="{{ route('login') }}" class="w-full bg-indigo-600 border border-transparent rounded-md py-2 px-4 flex items-center justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Login to Write a Review
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
            
            <!-- Reviews -->
            <div class="md:w-2/3">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Customer Reviews</h2>
                
                @if ($reviews->count() > 0)
                    <div class="space-y-8">
                        @foreach ($reviews as $review)
                            <div class="bg-white rounded-lg shadow overflow-hidden p-6">
                                <div class="flex items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-1">
                                            <div class="flex items-center">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review->rating)
                                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @else
                                                        <svg class="h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @endif
                                                @endfor
                                            </div>
                                            <h3 class="ml-2 text-lg font-medium text-gray-900">{{ $review->title }}</h3>
                                        </div>
                                        <p class="text-sm text-gray-500">
                                            By {{ $review->user->name }} on {{ $review->formatted_date }}
                                            @if ($review->is_verified_purchase)
                                                <span class="ml-2 bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Verified Purchase</span>
                                            @endif
                                        </p>
                                        <div class="mt-4 text-sm text-gray-700">
                                            {{ $review->comment }}
                                        </div>
                                        
                                        @if (auth()->check() && auth()->id() === $review->user_id)
                                            <div class="mt-4 flex space-x-4">
                                                <form action="{{ route('reviews.destroy', $review) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-sm text-red-600 hover:text-red-500" onclick="return confirm('Are you sure you want to delete this review?')">Delete</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-8">
                        {{ $reviews->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow overflow-hidden p-6 text-center">
                        <p class="text-gray-500">No reviews yet. Be the first to review this product!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 