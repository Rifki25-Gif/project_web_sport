<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sportify') }}</title>

        <!-- SEO Meta Tags -->
        <meta name="description" content="Your one-stop shop for the best athletic footwear.">
        <meta name="keywords" content="sports shoes, athletic footwear, running shoes, basketball shoes, sneakers">
        <meta name="author" content="SportShoes">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col justify-between">
            <!-- Header with Logo -->
            <header class="bg-gradient-to-r from-blue-700 via-blue-600 to-blue-400 shadow-lg py-4">
                <div class="container mx-auto px-4 flex justify-center">
                    <a href="/" class="flex items-center">
                        <x-application-logo class="w-10 h-10 text-yellow-400 mr-3" />
                        <span class="text-2xl font-bold text-white">Sport<span class="text-yellow-400">Shoes</span></span>
                    </a>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-grow flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-900 dark:to-gray-800 py-8">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-gradient-to-r from-blue-800 via-blue-700 to-blue-600 text-white py-4">
                <div class="container mx-auto px-4 text-center">
                    <p>&copy; {{ date('Y') }} SportShoes. All rights reserved.</p>
                </div>
            </footer>
        </div>
    </body>
</html>
