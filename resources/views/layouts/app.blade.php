<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <!-- Navigation -->
        <nav class="bg-white shadow-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">E-Shop</a>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-blue-600">Products</a>
                        <a href="{{ route('categories.index') }}" class="text-gray-700 hover:text-blue-600">Categories</a>
                        
                        @auth
                            <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-blue-600">
                                Cart <span class="bg-red-500 text-white rounded-full w-6 h-6 inline-flex items-center justify-center text-sm">{{ Auth::user()->cart()->count() }}</span>
                            </a>
                            <a href="{{ route('orders.index') }}" class="text-gray-700 hover:text-blue-600">My Orders</a>
                            
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('products.create') }}" class="text-gray-700 hover:text-blue-600">Add Product</a>
                            @endif

                            <div class="relative group">
                                <button class="text-gray-700 hover:text-blue-600">{{ Auth::user()->name }}</button>
                                <div class="hidden group-hover:block absolute right-0 bg-white shadow-lg rounded-lg">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                        @endauth
                    </div>

                    <!-- Mobile Menu Toggle -->
                    <div class="md:hidden flex items-center">
                        <button id="mobile-menu-toggle" class="text-gray-700 hover:text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
                <a href="{{ route('products.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Products</a>
                <a href="{{ route('categories.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Categories</a>
                @auth
                    <a href="{{ route('cart.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Cart</a>
                    <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">My Orders</a>
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Login</a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Register</a>
                @endauth
            </div>
        </nav>

        <!-- Flash Messages -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-xl font-bold mb-4">E-Shop</h3>
                        <p class="text-gray-400">Your trusted online shopping destination</p>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="{{ route('products.index') }}" class="hover:text-white">Products</a></li>
                            <li><a href="{{ route('categories.index') }}" class="hover:text-white">Categories</a></li>
                            <li><a href="#" class="hover:text-white">About Us</a></li>
                            <li><a href="#" class="hover:text-white">Contact</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Account</h4>
                        <ul class="space-y-2 text-gray-400">
                            @auth
                                <li><a href="{{ route('profile.edit') }}" class="hover:text-white">My Profile</a></li>
                                <li><a href="{{ route('orders.index') }}" class="hover:text-white">My Orders</a></li>
                            @else
                                <li><a href="{{ route('login') }}" class="hover:text-white">Login</a></li>
                                <li><a href="{{ route('register') }}" class="hover:text-white">Register</a></li>
                            @endauth
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Contact Info</h4>
                        <p class="text-gray-400">Email: info@eshop.com</p>
                        <p class="text-gray-400">Phone: +1 (555) 123-4567</p>
                        <p class="text-gray-400">Address: 123 Main Street, City, State 12345</p>
                    </div>
                </div>
                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; 2024 E-Shop. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
