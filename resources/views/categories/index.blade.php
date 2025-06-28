<x-app-layout>
    <div class="bg-gray-100 py-8">
        <div class="container mx-auto px-4">
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('welcome') }}" class="text-gray-700 hover:text-blue-600">
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-gray-500 md:ml-2">All Categories</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Page Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">Browse All Categories</h1>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Explore our wide range of sports equipment categories and find the perfect gear for your sport.</p>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse ($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}" class="group">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden transform transition-transform duration-300 group-hover:scale-105">
                            <div class="relative">
                                @if (Str::startsWith($category->image, ['http://', 'https://']))
                                    <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-full h-64 object-cover">
                                @elseif ($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-64 object-cover">
                                @else
                                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-500">No image</span>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-80 group-hover:opacity-70 transition-opacity"></div>
                                <div class="absolute bottom-0 left-0 p-6">
                                    <h2 class="text-2xl font-bold text-white mb-1">{{ $category->name }}</h2>
                                    <p class="text-white/80 text-sm line-clamp-2">{{ $category->description }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12">
                        <h2 class="text-2xl font-bold text-gray-600">No categories found</h2>
                        <p class="text-gray-500 mt-2">Check back later for new categories.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout> 