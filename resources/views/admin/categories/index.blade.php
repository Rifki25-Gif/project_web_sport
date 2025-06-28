<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Category Management') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Categories</h3>
                        <a href="{{ route('admin.categories.create') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                            Create Category
                        </a>
                    </div>

                    <form id="bulk-action-form" action="{{ route('admin.categories.bulkActions') }}" method="POST">
                        @csrf
                        <div class="mb-4 flex items-center">
                            <select name="action" id="bulk-action" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white mr-2">
                                <option value="">Bulk Actions</option>
                                <option value="delete">Delete</option>
                                <option value="activate">Activate</option>
                                <option value="deactivate">Deactivate</option>
                            </select>
                            <button type="submit" id="bulk-apply" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded" disabled>
                                Apply
                            </button>
                        </div>

                        <table id="categories-table" class="min-w-full bg-white dark:bg-gray-700">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200">
                                    <th class="py-2 px-4 text-left w-10">
                                        <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </th>
                                    <th class="py-2 px-4 text-left">Name</th>
                                    <th class="py-2 px-4 text-left">Image</th>
                                    <th class="py-2 px-4 text-left">Status</th>
                                    <th class="py-2 px-4 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr class="border-b dark:border-gray-600">
                                        <td class="py-2 px-4">
                                            <input type="checkbox" name="ids[]" value="{{ $category->id }}" class="category-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        </td>
                                        <td class="py-2 px-4">
                                            <a href="{{ route('admin.categories.show', $category) }}" class="text-blue-500 hover:underline">
                                                {{ $category->name }}
                                            </a>
                                        </td>
                                        <td class="py-2 px-4">
                                            @if($category->image)
                                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="h-12">
                                            @else
                                                <span class="text-gray-400">No image</span>
                                            @endif
                                        </td>
                                        <td class="py-2 px-4">
                                            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="name" value="{{ $category->name }}">
                                                <input type="hidden" name="description" value="{{ $category->description }}">
                                                <input type="hidden" name="is_active" value="{{ $category->is_active ? '0' : '1' }}">
                                                <button type="submit" class="relative inline-flex items-center cursor-pointer">
                                                    <div class="w-11 h-6 {{ $category->is_active ? 'bg-blue-600' : 'bg-gray-200 dark:bg-gray-700' }} rounded-full peer">
                                                        <span class="absolute left-1 top-1 {{ $category->is_active ? 'translate-x-5' : '' }} bg-white border rounded-full h-4 w-4 transition-all"></span>
                                                    </div>
                                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $category->is_active ? 'Active' : 'Inactive' }}</span>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="py-2 px-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 px-4 text-center">No categories found. <a href="{{ route('admin.categories.create') }}" class="text-blue-500">Create one</a>.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('select-all');
            const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
            const bulkActionSelect = document.getElementById('bulk-action');
            const bulkApplyButton = document.getElementById('bulk-apply');
            const bulkActionForm = document.getElementById('bulk-action-form');

            // Select all functionality
            selectAll.addEventListener('change', function() {
                categoryCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAll.checked;
                });
                updateBulkApplyButton();
            });

            // Individual checkbox change
            categoryCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectAllCheckbox();
                    updateBulkApplyButton();
                });
            });

            // Bulk action select change
            bulkActionSelect.addEventListener('change', updateBulkApplyButton);

            // Form submission confirmation
            bulkActionForm.addEventListener('submit', function(e) {
                const action = bulkActionSelect.value;
                if (action === 'delete') {
                    if (!confirm('Are you sure you want to delete the selected categories? This action cannot be undone.')) {
                        e.preventDefault();
                    }
                }
            });

            // Helper functions
            function updateSelectAllCheckbox() {
                const allChecked = Array.from(categoryCheckboxes).every(checkbox => checkbox.checked);
                const someChecked = Array.from(categoryCheckboxes).some(checkbox => checkbox.checked);
                
                selectAll.checked = allChecked;
                selectAll.indeterminate = someChecked && !allChecked;
            }

            function updateBulkApplyButton() {
                const anyChecked = Array.from(categoryCheckboxes).some(checkbox => checkbox.checked);
                const actionSelected = bulkActionSelect.value !== '';
                
                bulkApplyButton.disabled = !(anyChecked && actionSelected);
            }
        });
    </script>
    @endpush
</x-admin-layout> 