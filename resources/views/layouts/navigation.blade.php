<nav x-data="{ open: false, searchOpen: false }" class="bg-gradient-to-r from-blue-700 via-blue-600 to-blue-400 dark:from-gray-900 dark:via-gray-800 dark:to-gray-700 shadow-lg border-b-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-12">
        <div class="flex justify-between items-center h-20">
            <!-- Navigation Links -->
            <div class="flex gap-8 items-center">
                <div class="hidden sm:flex gap-2 lg:gap-6">
                    <x-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
                        <span class="text-lg font-bold tracking-wide px-3 py-2 rounded-lg transition-all duration-200 group hover:bg-blue-800/30 hover:text-yellow-300 focus:bg-blue-900/40 focus:text-yellow-400 {{ request()->routeIs('welcome') ? 'text-yellow-300 underline underline-offset-8' : 'text-white' }}">{{ __('Home') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
                        <span class="text-lg font-bold tracking-wide px-3 py-2 rounded-lg transition-all duration-200 group hover:bg-blue-800/30 hover:text-yellow-300 focus:bg-blue-900/40 focus:text-yellow-400 {{ request()->routeIs('products.index') ? 'text-yellow-300 underline underline-offset-8' : 'text-white' }}">{{ __('Products') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('categories.show', ['category' => 'all'])" :active="request()->routeIs('categories.show')">
                        <span class="text-lg font-bold tracking-wide px-3 py-2 rounded-lg transition-all duration-200 group hover:bg-blue-800/30 hover:text-yellow-300 focus:bg-blue-900/40 focus:text-yellow-400 {{ request()->routeIs('categories.show') ? 'text-yellow-300 underline underline-offset-8' : 'text-white' }}">{{ __('Categories') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('size-guide')" :active="request()->routeIs('size-guide')">
                        <span class="text-lg font-bold tracking-wide px-3 py-2 rounded-lg transition-all duration-200 group hover:bg-blue-800/30 hover:text-yellow-300 focus:bg-blue-900/40 focus:text-yellow-400 {{ request()->routeIs('size-guide') ? 'text-yellow-300 underline underline-offset-8' : 'text-white' }}">{{ __('Size Guide') }}</span>
                    </x-nav-link>
                </div>
            </div>
            <!-- Search Bar -->
            <div class="hidden sm:flex items-center flex-1 justify-center px-4">
                <div class="relative w-full max-w-xs">
                    <input type="text" id="search" name="search" placeholder="Search for products..." class="block w-full px-5 py-2 text-base text-gray-700 bg-white border border-gray-200 rounded-full shadow focus:border-yellow-400 focus:ring-2 focus:ring-yellow-300 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 dark:focus:border-yellow-400 transition-all duration-300" />
                    <div id="search-results" class="absolute z-50 w-full bg-white rounded-md shadow-lg mt-1" style="display: none;"></div>
                </div>
            </div>
            <!-- Icons & Auth -->
            <div class="flex items-center gap-4">
                <!-- Wishlist Icon -->
                <a href="{{ route('wishlist.index') }}" class="relative p-2 rounded-full text-white hover:text-yellow-300 dark:text-blue-200 dark:hover:text-yellow-400 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </a>
                <!-- Cart Icon -->
                <div class="relative">
                    <livewire:cart-icon />
                </div>
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-5 py-2 border border-transparent text-base font-bold rounded-full text-blue-900 bg-yellow-400 hover:bg-yellow-300 focus:outline-none transition ease-in-out duration-150 shadow">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-2">
                                <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-base font-bold text-blue-900 bg-yellow-400 hover:bg-yellow-300 px-5 py-2 rounded-full shadow transition-colors duration-200">Log in</a>
                    <a href="{{ route('register') }}" class="ml-2 text-base font-bold text-yellow-400 border-2 border-yellow-400 hover:bg-yellow-400 hover:text-blue-900 px-5 py-2 rounded-full shadow transition-colors duration-200">Register</a>
                @endauth
            </div>
            <!-- Mobile Hamburger & Search -->
            <div class="flex items-center sm:hidden gap-2 ms-2">
                <button @click="searchOpen = !searchOpen" class="inline-flex items-center justify-center p-2 rounded-full text-white hover:bg-yellow-300 hover:text-blue-700 focus:outline-none transition duration-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-full text-white hover:bg-yellow-300 hover:text-blue-700 focus:outline-none transition duration-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gradient-to-r from-blue-700 via-blue-600 to-blue-400 dark:from-gray-900 dark:via-gray-800 dark:to-gray-700 shadow-lg">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
                {{ __('Products') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('categories.show', ['category' => 'all'])" :active="request()->routeIs('categories.show')">
                {{ __('Categories') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('size-guide')" :active="request()->routeIs('size-guide')">
                {{ __('Size Guide') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('wishlist.index')" :active="request()->routeIs('wishlist.index')">
                {{ __('Wishlist') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                {{ __('Cart') }} <livewire:cart-icon />
            </x-responsive-nav-link>
        </div>
        @auth
        <div class="pt-4 pb-1 border-t border-blue-200 dark:border-blue-700">
            <div class="px-4">
                <div class="font-medium text-base text-white dark:text-blue-300">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-blue-100">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
    <!-- Mobile Search Bar -->
    <div x-show="searchOpen" class="p-4 sm:hidden">
        <div class="relative">
            <input type="text" id="mobile-search" name="search" placeholder="Search for products..." class="block w-full px-4 py-2 text-base text-gray-700 bg-white border border-gray-200 rounded-full shadow focus:border-yellow-400 focus:ring-2 focus:ring-yellow-300 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 dark:focus:border-yellow-400 transition-all duration-300">
            <div id="mobile-search-results" class="absolute z-50 w-full bg-white rounded-md shadow-lg mt-1" style="display: none;"></div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const setupSearch = (searchInputId, searchResultsId) => {
            const searchInput = document.getElementById(searchInputId);
            const searchResults = document.getElementById(searchResultsId);

            searchInput.addEventListener('keyup', function () {
                const query = searchInput.value;

                if (query.length < 2) {
                    searchResults.style.display = 'none';
                    return;
                }

                // Show loading state
                searchResults.innerHTML = '<div class="p-4 text-center">Loading...</div>';
                searchResults.style.display = 'block';

                fetch(`/search?query=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        let resultsHtml = '';
                        if (data.length > 0) {
                            data.forEach(product => {
                                resultsHtml += `<a href="/products/${product.slug}" class="block p-4 hover:bg-gray-100">${product.name}</a>`;
                            });
                        } else {
                            resultsHtml = '<div class="p-4 text-center">No results found</div>';
                        }
                        searchResults.innerHTML = resultsHtml;
                    })
                    .catch(error => {
                        console.error('Error fetching search results:', error);
                        searchResults.innerHTML = '<div class="p-4 text-center text-red-500">Error loading results.</div>';
                    });
            });

             // Hide results when clicking outside
            document.addEventListener('click', function (event) {
                if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
                    searchResults.style.display = 'none';
                }
            });
        };

        setupSearch('search', 'search-results');
        setupSearch('mobile-search', 'mobile-search-results');
    });
</script>
