<x-account-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <!-- Order Statistics -->
        <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                Order Statistics
            </h3>
            <div class="mt-4 grid grid-cols-1 gap-5 sm:grid-cols-3">
                <!-- Total Orders -->
                <div class="bg-white dark:bg-gray-700 overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <!-- Heroicon name: outline/shopping-bag -->
                                <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                        Total Orders
                                    </dt>
                                    <dd class="text-3xl font-semibold text-gray-900 dark:text-white">
                                        12
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Pending Orders -->
                <div class="bg-white dark:bg-gray-700 overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <!-- Heroicon name: outline/clock -->
                                <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                        Pending Orders
                                    </dt>
                                    <dd class="text-3xl font-semibold text-gray-900 dark:text-white">
                                        3
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Completed Orders -->
                <div class="bg-white dark:bg-gray-700 overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <!-- Heroicon name: outline/check-circle -->
                                <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                        Completed Orders
                                    </dt>
                                    <dd class="text-3xl font-semibold text-gray-900 dark:text-white">
                                        9
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Athletic-themed Cards -->
        <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100 mt-8">
                Explore Your Athletic Journey
            </h3>
            <div class="mt-4 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Training Plans -->
                <div class="bg-gray-800 text-white overflow-hidden shadow rounded-lg transform hover:scale-105 transition-transform duration-300">
                    <div class="p-5">
                        <h4 class="text-xl font-bold">Training Plans</h4>
                        <p class="mt-2 text-gray-300">Access personalized training schedules to meet your goals.</p>
                        <a href="#" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">View Plans</a>
                    </div>
                </div>
                <!-- Nutrition Guide -->
                <div class="bg-gray-800 text-white overflow-hidden shadow rounded-lg transform hover:scale-105 transition-transform duration-300">
                    <div class="p-5">
                        <h4 class="text-xl font-bold">Nutrition Guide</h4>
                        <p class="mt-2 text-gray-300">Fuel your performance with our expert nutrition advice.</p>
                        <a href="#" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Get Advice</a>
                    </div>
                </div>
                <!-- Community Forum -->
                <div class="bg-gray-800 text-white overflow-hidden shadow rounded-lg transform hover:scale-105 transition-transform duration-300">
                    <div class="p-5">
                        <h4 class="text-xl font-bold">Community Forum</h4>
                        <p class="mt-2 text-gray-300">Connect with fellow athletes and share your progress.</p>
                        <a href="#" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Join Community</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-account-layout> 