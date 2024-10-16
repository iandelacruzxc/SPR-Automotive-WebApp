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
        <div class="container mx-auto p-4">
            <!-- Main Banner -->
            <section class="relative bg-cover bg-center custom-banner-height"
                style="background-image: url('{{ asset('images/main-banner.png') }}'); background-size: cover; background-position: center;">
                <div class="absolute inset-0  opacity-50"></div>
                <div class="relative container mx-auto h-full px-5">
                    <!-- Button on the left side -->
                    <div class="absolute left-5 top-1/2 transform -translate-y-1/2 text-white">
                    </div>
                    <!-- Centered content -->
                    <div class="flex items-center justify-center h-full">
                        <!-- Add any additional content here -->
                    </div>
                </div>
            </section>
            <!-- End Main Banner -->
            <!-- Carousel for product 1 -->
            <section class="my-8 relative group">
                <div class="mb-4">
                    <h2 class="text-2xl font-bold">Featured Products</h2>
                </div>
                <div class="carousel-wrapper relative overflow-hidden">
                    <div class="carousel-track flex transition-transform duration-500 ease-in-out">
                        <!-- Carousel Items -->
                        @foreach($products as $product)
                        <div class="carousel-item flex-shrink-0 w-64 h-40 bg-gray-200 mx-2 rounded-lg shadow-lg">
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-lg">
                            <p class="text-xs text-center text-red-500">{{ asset($product->image_path) }}</p> <!-- Debugging line -->
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- Carousel Controls -->
                <button class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300" id="prevBtn">&#10094;</button>
                <button class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300" id="nextBtn">&#10095;</button>
                <!-- Indicators -->
                <div class="flex justify-center mt-4 indicator-container">
                    <!-- Dynamic dots can be generated here if needed -->
                </div>
            </section>

            <!-- About Us Section -->
            <section class="my-12 relative">
                <div class="flex flex-col md:flex-row items-center relative">
                    <!-- Left Side: Image -->
                    <div class="w-full md:w-1/2 mb-8 md:mb-0 relative">
                        <img src="{{ asset('images/about-us.png') }}" alt="Company Image"
                            class="w-full h-auto rounded-lg shadow-lg object-cover mb-2">

                        <!-- Floating Container -->
                        <div
                            class="relative md:absolute top-1/4 right-0 transform md:translate-x-[95%] bg-white bg-opacity-90 p-8 rounded-lg shadow-xl shadow-black h-[500px] flex flex-col justify-center">
                            <h2 class="text-3xl font-bold mb-4">About Our Company</h2>
                            <p class="text-lg mb-6">
                                We are a leading company in the industry, dedicated to providing top-notch services and
                                innovative solutions to our customers.
                            </p>
                            <p class="text-lg mb-6">
                                With years of experience and a commitment to excellence, we have established ourselves
                                as a trusted name in the market.
                            </p>
                            <p class="text-lg">
                                Our vision is to continue growing and evolving with the times, always keeping our
                                customers at the heart of everything we do.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End About Us Section -->
        </div>
    </main>
    @include('users.user-script')
    @include('users.footer')