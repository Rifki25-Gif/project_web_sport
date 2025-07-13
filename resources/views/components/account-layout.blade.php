<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Account') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="md:flex">
                    <!-- Sidebar -->
                    <div class="w-full md:w-1/4 bg-gray-50 dark:bg-gray-700 p-6">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-4">Account Menu</h3>
                        <nav class="space-y-2">
                            <a href="{{ route('account.dashboard') }}" class="block text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('account.dashboard') ? 'bg-gray-200 dark:bg-gray-600' : '' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('account.orders') }}" class="block text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('account.orders') ? 'bg-gray-200 dark:bg-gray-600' : '' }}">
                                My Orders
                            </a>
                            <a href="{{ route('account.profile') }}" class="block text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('account.profile') ? 'bg-gray-200 dark:bg-gray-600' : '' }}">
                                Profile Settings
                            </a>
                            <a href="{{ route('account.addresses') }}" class="block text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('account.addresses') ? 'bg-gray-200 dark:bg-gray-600' : '' }}">
                                Address Book
                            </a>
                        </nav>
                    </div>

                    <!-- Page Content -->
                    <div class="w-full md:w-3/4 p-6">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>