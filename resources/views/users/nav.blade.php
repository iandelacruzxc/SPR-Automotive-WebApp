<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>
    @vite('resources/css/app.css')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="{{ asset('css/Datatables/datatables.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/css/pikaday.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/pikaday.js"></script>

    <!-- Styles -->
    <style>
        .is-disabled {
            color: #ccc !important;
            /* Gray text color */
            background-color: red !important;
            /* Light gray background */
            cursor: not-allowed;
            /* Change cursor to indicate not selectable */
        }

        .carousel-wrapper {
            width: 100%;
            overflow: hidden;
        }

        .carousel-track {
            display: flex;
            transition: transform 0.5s ease;
        }

        .carousel-item {
            flex: 0 0 auto;
            width: 25%;
            /* Show 4 cards at a time */
        }

        /* Indicator dots */
        .dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            margin: 0 5px;
            background-color: #bbb;
            border-radius: 50%;
            transition: background-color 0.3s;
        }

        .dot.active {
            background-color: #717171;
        }

        /* Button hover styling */
        .group:hover .carousel-btn {
            opacity: 1;
        }

        .custom-banner-height {
            height: 700px;
            /* Adjust this value as needed */
        }
    </style>

</head>

<body class="font-sans antialiased bg-gray-200">
    <header>
        <h1>@yield('header')</h1>
    </header>
    <main>
        <nav class="bg-white text-black p-4">
            <div class="container mx-auto flex items-center justify-between">
                <!-- Logo Section -->
                <div class="flex items-center">
                    <a href="#">
                        <img src="{{ asset('images/logo2.png') }}" alt="Logo" class="block h-9 w-auto">
                    </a>
                </div>
                <!-- Hamburger Menu Button -->
                <div class="block lg:hidden">
                    <button id="hamburgerButton" class="text-black focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
                <!-- Navigation Tabs -->
                <div id="navMenu" class="hidden lg:flex items-center space-x-4">
                    <a href="{{ url('/user/dashboard') }}" class="hover:text-gray-400">Home</a>
                    <a href="{{ url('/user/services') }}" class="hover:text-gray-400">Services</a>
                    <a href="{{ url('/user/products') }}" class="hover:text-gray-400">Products</a>
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="hover:text-gray-400 focus:outline-none">
                            Appointment
                        </button>
                        <!-- Dropdown Menu -->
                        <div
                            x-show="open"
                            @click.away="open = false"
                            class="absolute mt-2 w-48 bg-white shadow-lg rounded-md py-2 z-10"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95">
                            <a href="{{ route('appointment.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Book Now</a>
                            <a href="{{ url('/user/appointment-history') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Appointment History</a>
                        </div>
                    </div>
                    <!-- Logout and Cart -->

                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="hover:text-gray-400 focus:outline-none">
                            @if(auth()->check())
                            Welcome, {{ auth()->user()->name }} <!-- Display user name -->
                            @else
                            Please log in
                            @endif
                        </button>

                        <!-- Dropdown Menu -->
                        <div
                            x-show="open"
                            @click.away="open = false"
                            class="absolute mt-2 w-48 bg-white shadow-lg rounded-md py-2 z-10"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95">
                            <div class="border-t border-gray-200"></div> <!-- Divider -->
                            <div class="py=1">
                                <a href="{{ url('/user/profile-management') }}" class="w-full text-left block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                            </div>
                            <div class="py-1">
                                <form action="{{ route('logout') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>






                    <!-- <a href="{{ url('/cart') }}" class="flex items-center hover:text-gray-400 relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l1 4h13l1-4h2M3 3h2l1 4h13l1-4h2m-1 16a2 2 0 100-4 2 2 0 000 4zm-11 0a2 2 0 100-4 2 2 0 000 4zm11-4H7m4 0l1-3m3 0H9m7 0l1-3H9m7 0H9"></path>
                        </svg>
                        <span class="bg-red-500 text-white rounded-full px-2 py-1 text-xs">
                            {{ session()->has('cart') ? count(session('cart')) : 0 }}
                        </span>
                    </a> -->
                </div>

                <!-- Mobile Menu -->
                <div id="mobileMenu" class="lg:hidden fixed inset-0 bg-gray-800 bg-opacity-75 z-50 hidden">
                    <div class="flex flex-col items-center mt-10 space-y-6">
                        <a href="{{ url('/dashboard') }}" class="text-white text-lg hover:text-gray-400">Dashboard</a>
                        <a href="{{ route('login') }}" class="text-white text-lg hover:text-gray-400">Log in</a>
                    </div>
                </div>
            </div>
        </nav>