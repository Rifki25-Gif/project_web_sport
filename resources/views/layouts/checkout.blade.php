<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Checkout</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-center mb-8">Checkout</h1>

            <!-- Progress Bar -->
            <div class="w-full mb-8">
                <div class="flex items-center justify-center">
                    <div class="step-item {{ request()->routeIs('checkout.shipping') ? 'active' : '' }} {{ (request()->routeIs('checkout.payment') || request()->routeIs('checkout.success')) ? 'completed' : '' }}">
                        <div class="step-marker">1</div>
                        <div class="step-label">Shipping</div>
                    </div>
                    <div class="flex-auto border-t-2 transition duration-500 ease-in-out {{ (request()->routeIs('checkout.payment') || request()->routeIs('checkout.success')) ? 'border-blue-600' : 'border-gray-300' }}"></div>
                    <div class="step-item {{ request()->routeIs('checkout.payment') ? 'active' : '' }} {{ request()->routeIs('checkout.success') ? 'completed' : '' }}">
                        <div class="step-marker">2</div>
                        <div class="step-label">Payment</div>
                    </div>
                    <div class="flex-auto border-t-2 transition duration-500 ease-in-out {{ request()->routeIs('checkout.success') ? 'border-blue-600' : 'border-gray-300' }}"></div>
                    <div class="step-item {{ request()->routeIs('checkout.success') ? 'active' : '' }}">
                        <div class="step-marker">3</div>
                        <div class="step-label">Success</div>
                    </div>
                </div>
            </div>


            <main>
                @yield('slot')
            </main>
        </div>
    </div>
    <script src="{{ asset('js/checkout.js') }}"></script>
</body>
</html> 