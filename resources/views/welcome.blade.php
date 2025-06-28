@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-gray-900">
        <div class="mx-auto max-w-7xl">
            <div class="relative z-10 pt-14 lg:w-full lg:max-w-2xl">
                <div class="relative px-6 py-32 sm:py-40 lg:px-8 lg:py-56 lg:pr-0">
                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-xl">
                        <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">Step into Performance</h1>
                        <p class="mt-6 text-lg leading-8 text-gray-300">Discover the perfect athletic shoes for your sport. From running to basketball, we've got your feet covered with top brands and performance-driven designs.</p>
                        <div class="mt-10 flex items-center gap-x-6">
                            <a href="{{ route('products.index') }}" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Shop Now</a>
                            <a href="{{ route('size-guide') }}" class="text-sm font-semibold leading-6 text-white">Size Guide <span aria-hidden="true">→</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="aspect-[3/2] object-cover lg:aspect-auto lg:h-full lg:w-full" src="https://images.unsplash.com/photo-1562183241-b937e95585b6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1965&q=80" alt="Athletic shoes">
        </div>
    </div>
    
    <!-- Categories Section -->
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-base font-semibold leading-7 text-indigo-600">Shop by Category</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Find your perfect fit</p>
                <p class="mt-6 text-lg leading-8 text-gray-600">Explore our wide range of athletic footwear designed for every sport and activity.</p>
            </div>
            
            <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                    @foreach($categories->take(3) as $category)
                        <div class="flex flex-col">
                            <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                                <div class="h-5 w-5 flex-none text-indigo-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                {{ $category->name }}
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                                <p class="flex-auto">{{ $category->products_count }} products available</p>
                                <p class="mt-6">
                                    <a href="{{ route('categories.show', $category->slug) }}" class="text-sm font-semibold leading-6 text-indigo-600">
                                        Browse category <span aria-hidden="true">→</span>
                                    </a>
                                </p>
                            </dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        </div>
    </div>
    
    <!-- Featured Products -->
    <x-product-recommendations title="Featured Products" :products="$featuredProducts" />
    
    <!-- New Arrivals -->
    <x-product-recommendations title="New Arrivals" :products="$newArrivals" />
    
    <!-- Best Sellers -->
    <x-product-recommendations title="Best Sellers" :products="$bestSellers" />
    
    <!-- Personalized Recommendations -->
    @auth
        <x-product-recommendations title="Recommended For You" :products="$personalizedRecommendations" />
    @endauth
    
    <!-- Call to Action -->
    <div class="bg-white">
        <div class="mx-auto max-w-7xl py-24 sm:px-6 sm:py-32 lg:px-8">
            <div class="relative isolate overflow-hidden bg-gray-900 px-6 pt-16 shadow-2xl sm:rounded-3xl sm:px-16 md:pt-24 lg:flex lg:gap-x-20 lg:px-24 lg:pt-0">
                <svg viewBox="0 0 1024 1024" class="absolute left-1/2 top-1/2 -z-10 h-[64rem] w-[64rem] -translate-y-1/2 [mask-image:radial-gradient(closest-side,white,transparent)] sm:left-full sm:-ml-80 lg:left-1/2 lg:ml-0 lg:-translate-x-1/2 lg:translate-y-0" aria-hidden="true">
                    <circle cx="512" cy="512" r="512" fill="url(#759c1415-0410-454c-8f7c-9a820de03641)" fill-opacity="0.7" />
                    <defs>
                        <radialGradient id="759c1415-0410-454c-8f7c-9a820de03641">
                            <stop stop-color="#7775D6" />
                            <stop offset="1" stop-color="#E935C1" />
                        </radialGradient>
                    </defs>
                </svg>
                <div class="mx-auto max-w-md text-center lg:mx-0 lg:flex-auto lg:py-32 lg:text-left">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Boost your athletic performance.<br>Start shopping today.</h2>
                    <p class="mt-6 text-lg leading-8 text-gray-300">Join thousands of athletes who trust our shoes for their best performance. Find your perfect pair today.</p>
                    <div class="mt-10 flex items-center justify-center gap-x-6 lg:justify-start">
                        <a href="{{ route('products.index') }}" class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Browse Collection</a>
                        <a href="{{ route('size-guide') }}" class="text-sm font-semibold leading-6 text-white">Size Guide <span aria-hidden="true">→</span></a>
                    </div>
                </div>
                <div class="relative mt-16 h-80 lg:mt-8">
                    <img class="absolute left-0 top-0 w-[57rem] max-w-none rounded-md bg-white/5 ring-1 ring-white/10" src="https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1450&q=80" alt="App screenshot" width="1824" height="1080">
                </div>
            </div>
        </div>
    </div>
@endsection 
