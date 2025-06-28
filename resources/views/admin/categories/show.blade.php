<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Category Details') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{ $category->name }}</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                Edit
                            </a>
                            <a href="{{ route('admin.categories.index') }}" class="inline-block bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                                Back to List
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-4">
                                <h4 class="text-lg font-medium text-gray-700 dark:text-gray-300">Details</h4>
                                <div class="mt-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="mb-2">
                                        <span class="font-semibold">Name:</span> 
                                        <span>{{ $category->name }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="font-semibold">Slug:</span> 
                                        <span>{{ $category->slug }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="font-semibold">Status:</span> 
                                        <span class="{{ $category->is_active ? 'text-green-500' : 'text-red-500' }}">
                                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="font-semibold">Created:</span> 
                                        <span>{{ $category->created_at->format('M d, Y H:i') }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="font-semibold">Last Updated:</span> 
                                        <span>{{ $category->updated_at->format('M d, Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h4 class="text-lg font-medium text-gray-700 dark:text-gray-300">Description</h4>
                                <div class="mt-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    {{ $category->description ?? 'No description available.' }}
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-lg font-medium text-gray-700 dark:text-gray-300">Image</h4>
                            <div class="mt-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-auto rounded-lg">
                                @else
                                    <div class="w-full h-48 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                        <span class="text-gray-500 dark:text-gray-400">No image available</span>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-4">
                                <h4 class="text-lg font-medium text-gray-700 dark:text-gray-300">Products</h4>
                                <div class="mt-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="text-sm">
                                        <span class="font-semibold">Total Products:</span> 
                                        <span>{{ $category->products->count() }}</span>
                                    </div>
                                    @if($category->products->count() > 0)
                                        <div class="mt-2">
                                            <a href="{{ route('admin.products.index', ['category' => $category->id]) }}" class="text-blue-500 hover:underline">
                                                View all products in this category
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 