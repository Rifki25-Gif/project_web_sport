<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Shoe Products</h2>
                        <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Add New Shoe</a>
                    </div>
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                    
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search by name, brand..." class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </div>
                            
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select name="category" id="category" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    <option value="">All Categories</option>
                                    @foreach($categories ?? [] as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            
                            <div class="flex gap-2">
                                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">Filter</button>
                                <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Reset</a>
                            </div>
                        </form>
                    </div>
                    
                    <form action="{{ route('admin.products.bulkActions') }}" method="POST" id="bulk-actions-form">
                        @csrf
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                                <thead class="bg-gray-100 text-gray-700">
                                    <tr>
                                        <th class="w-10 py-3 px-4 text-left">
                                            <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                        </th>
                                        <th class="py-3 px-4 text-left">Image</th>
                                        <th class="py-3 px-4 text-left">Name</th>
                                        <th class="py-3 px-4 text-left">Brand</th>
                                        <th class="py-3 px-4 text-left">Category</th>
                                        <th class="py-3 px-4 text-left">Price</th>
                                        <th class="py-3 px-4 text-left">Stock</th>
                                        <th class="py-3 px-4 text-left">Status</th>
                                        <th class="py-3 px-4 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($products as $product)
                                        <tr>
                                            <td class="py-3 px-4">
                                                <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" class="product-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                            </td>
                                            <td class="py-3 px-4">
                                                <div class="w-16 h-16 overflow-hidden rounded-md">
                                                    @if($product->featured_image)
                                                        <img src="{{ asset('storage/' . $product->featured_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                                    @elseif($product->images && count(json_decode($product->images)) > 0)
                                                        <img src="{{ asset('storage/' . json_decode($product->images)[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                            No Image
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="py-3 px-4">
                                                <div class="font-medium text-gray-900">{{ $product->name }}</div>
                                                <div class="text-sm text-gray-500">SKU: {{ $product->sku }}</div>
                                            </td>
                                            <td class="py-3 px-4">
                                                {{ $product->brand }}
                                            </td>
                                            <td class="py-3 px-4">
                                                {{ $product->category->name ?? 'Uncategorized' }}
                                            </td>
                                            <td class="py-3 px-4">
                                                @if($product->sale_price)
                                                    <div class="text-sm">
                                                        <span class="line-through text-gray-500">${{ number_format($product->price, 2) }}</span>
                                                        <span class="font-medium text-red-600">${{ number_format($product->sale_price, 2) }}</span>
                                                    </div>
                                                    <div class="text-xs text-green-600">{{ $product->discountPercentage() }}% off</div>
                                                @else
                                                    <span class="font-medium">${{ number_format($product->price, 2) }}</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4">
                                                @if($product->stock_quantity > 10)
                                                    <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">{{ $product->stock_quantity }}</span>
                                                @elseif($product->stock_quantity > 0)
                                                    <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">{{ $product->stock_quantity }}</span>
                                                @else
                                                    <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">Out of stock</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4">
                                                @if($product->is_active)
                                                    <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Active</span>
                                                @else
                                                    <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="py-6 text-center text-gray-500">No products found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        @if(count($products) > 0)
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <select name="action" id="bulk-action" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                        <option value="">Bulk Actions</option>
                                        <option value="delete">Delete Selected</option>
                                        <option value="activate">Mark as Active</option>
                                        <option value="deactivate">Mark as Inactive</option>
                                    </select>
                                    <button type="submit" id="apply-bulk-action" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700" disabled>Apply</button>
                                </div>
                                
                                <div>
                                    {{ $products->links() }}
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select-all');
            const productCheckboxes = document.querySelectorAll('.product-checkbox');
            const bulkActionSelect = document.getElementById('bulk-action');
            const applyBulkActionButton = document.getElementById('apply-bulk-action');
            
            // Handle "Select All" checkbox
            selectAllCheckbox.addEventListener('change', function() {
                productCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateBulkActionButton();
            });
            
            // Handle individual checkboxes
            productCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectAllCheckbox();
                    updateBulkActionButton();
                });
            });
            
            // Handle bulk action select
            bulkActionSelect.addEventListener('change', function() {
                updateBulkActionButton();
            });
            
            function updateSelectAllCheckbox() {
                const allChecked = Array.from(productCheckboxes).every(checkbox => checkbox.checked);
                const someChecked = Array.from(productCheckboxes).some(checkbox => checkbox.checked);
                
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = someChecked && !allChecked;
            }
            
            function updateBulkActionButton() {
                const someChecked = Array.from(productCheckboxes).some(checkbox => checkbox.checked);
                const actionSelected = bulkActionSelect.value !== '';
                
                applyBulkActionButton.disabled = !(someChecked && actionSelected);
            }
            
            // Confirm bulk delete action
            document.getElementById('bulk-actions-form').addEventListener('submit', function(event) {
                if (bulkActionSelect.value === 'delete') {
                    if (!confirm('Are you sure you want to delete the selected products?')) {
                        event.preventDefault();
                    }
                }
            });
        });
    </script>
</x-app-layout> 