@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('products.show', $product->slug) }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Product
            </a>
        </div>
        
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h2 class="text-lg leading-6 font-medium text-gray-900">Write a Review for {{ $product->name }}</h2>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Share your thoughts with other customers</p>
            </div>
            
            <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                <div class="flex items-center mb-6">
                    <img src="{{ $product->getFirstImage() }}" alt="{{ $product->name }}" class="h-20 w-20 object-cover rounded">
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $product->brand }}</p>
                    </div>
                </div>
                
                @if ($hasPurchased)
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">
                                    You've purchased this product. Your review will be marked as a verified purchase.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <form action="{{ route('products.reviews.store', $product->slug) }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <!-- Rating -->
                        <div>
                            <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                            <div class="mt-1">
                                <div class="flex items-center" x-data="{ rating: 0 }">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button type="button" 
                                                @click="rating = {{ $i }}; document.getElementById('rating').value = {{ $i }}" 
                                                class="focus:outline-none">
                                            <svg :class="{'text-yellow-400': rating >= {{ $i }}, 'text-gray-300': rating < {{ $i }}}" 
                                                 class="h-8 w-8 cursor-pointer" 
                                                 xmlns="http://www.w3.org/2000/svg" 
                                                 viewBox="0 0 20 20" 
                                                 fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </button>
                                    @endfor
                                    <input type="hidden" id="rating" name="rating" value="0">
                                </div>
                                @error('rating')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Review Title</label>
                            <div class="mt-1">
                                <input type="text" name="title" id="title" value="{{ old('title') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Summarize your review">
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Comment -->
                        <div>
                            <label for="comment" class="block text-sm font-medium text-gray-700">Review</label>
                            <div class="mt-1">
                                <textarea id="comment" name="comment" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="What did you like or dislike? What did you use this product for?">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div>
                            <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Submit Review
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
@endpush
@endsection 