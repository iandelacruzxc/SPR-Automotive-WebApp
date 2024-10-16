<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    @vite('resources/css/app.css')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Styles -->
    <style>
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

        @include('users.nav')
        <div class="bg-gray-100 dark:bg-gray-800 py-8">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <section class="my-8 relative group">
                    <h1 class="text-2xl font-bold mb-4">Shopping Cart</h1>
                    @if(session()->has('cart') && count(session('cart')) > 0)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        @foreach(session('cart') as $item)
                        <div class="flex flex-col md:flex-row -mx-4 p-4 border-b">
                            <!-- Image Section -->
                            <div class="md:flex-1 px-4 mb-4 md:mb-0">
                                <div class="h-[460px] rounded-lg bg-gray-300 dark:bg-gray-700">
                                    <img class="w-full h-full object-cover rounded-lg" src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                                </div>
                            </div>

                            <!-- Product Details Section -->
                            <div class="md:flex-1 px-4">
                                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">{{ $item['name'] }}</h2>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">
                                    Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed ante justo.
                                </p>
                                <!-- Inside the Product Details Section -->
                                <div class="flex mb-4">
                                    <div class="mr-4">
                                        <span class="font-bold text-gray-700 dark:text-gray-300">Price:</span>
                                        <span class="text-gray-600 dark:text-gray-300 total-price">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                    </div>
                                    <div>
                                        <span class="font-bold text-gray-700 dark:text-gray-300">Quantity:</span>
                                        <span class="text-gray-600 dark:text-gray-300">{{ $item['quantity'] }}</span>
                                    </div>
                                </div>


                                <!-- Quantity Controls -->
                                <div class="flex mb-4">
                                    @if(isset($item['id']))
                                    <button class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white py-2 px-4 rounded-full font-bold hover:bg-gray-300 dark:hover:bg-gray-600" onclick="updateQuantity('{{ $item['id'] }}', -1)">-</button>
                                    <span class="mx-2 text-lg">{{ $item['quantity'] }}</span>
                                    <button class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white py-2 px-4 rounded-full font-bold hover:bg-gray-300 dark:hover:bg-gray-600" onclick="updateQuantity('{{ $item['id'] }}', 1)">+</button>
                                    @else
                                    <p>Product ID is missing</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p>Your cart is empty.</p>
                    @endif
                </section>
            </div>
        </div>




    </main>

    @include('users.user-script')


</body>

</html>