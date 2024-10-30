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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/css/pikaday.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/pikaday.js"></script>


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

        #status-label {
            color: red;
            margin-top: 10px;
            /* Space between date picker and label */
        }

        .is-disabled {
            color: #ccc !important;
            /* Gray text color */
            background-color: red !important;
            /* Light gray background */
            cursor: not-allowed;
            /* Change cursor to indicate not selectable */
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
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <img src="{{ asset('images/logo2.png') }}" alt="Logo" style="width: 150px; height: auto;">
                    </a>
                </div>
                <!-- Hamburger Menu Button -->
                <div class="block lg:hidden">
                    <button id="hamburgerButton" class="text-white focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
                <!-- Navigation Tabs -->
                <div id="navMenu" class="hidden lg:flex space-x-4">
                    {{-- <a href="/" class="hover:text-gray-400">Home</a>
                    <a href="/about" class="hover:text-gray-400">About</a>
                    <a href="/services" class="hover:text-gray-400">Services</a>
                    <a href="/contact" class="hover:text-gray-400">Contact</a> --}}
                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/dashboard') }}" class="hover:text-gray-400">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="hover:text-gray-400">Log in</a>
                    @endauth
                    @endif
                </div>
                <!-- Mobile Menu -->
                <div id="mobileMenu" class="lg:hidden fixed inset-0 bg-gray-800 bg-opacity-75 z-50 hidden">
                    <div class="flex flex-col items-center mt-10 space-y-6">
                        {{-- <a href="/" class="text-white text-lg hover:text-gray-400">Home</a>
                        <a href="/about" class="text-white text-lg hover:text-gray-400">About</a>
                        <a href="/services" class="text-white text-lg hover:text-gray-400">Services</a>
                        <a href="/contact" class="text-white text-lg hover:text-gray-400">Contact</a> --}}
                        @if (Route::has('login'))
                        @auth
                        <a href="{{ url('/dashboard') }}"
                            class="text-white text-lg hover:text-gray-400">Dashboard</a>
                        @else
                        <a href="{{ route('login') }}" class="text-white text-lg hover:text-gray-400">Log in</a>
                        @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>
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
                <div class=" mb-4">
                    <h2 class="text-2xl font-bold">Featured Products</h2> <!-- Change text accordingly -->
                </div>
                <div class="carousel-wrapper relative overflow-hidden">
                    <div class="carousel-track flex transition-transform duration-500 ease-in-out">
                        <!-- Carousel Items -->
                        @foreach($products as $product)
                        <div class="carousel-item flex-shrink-0 w-64 h-40 bg-gray-200 mx-2 rounded-lg shadow-lg">
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover rounded-lg">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                                <p class="text-sm mt-2">Description for {{ $product->name }}.</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>


                <!-- Carousel Controls -->
                <button
                    class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                    id="prevBtn">&#10094;</button>
                <button
                    class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                    id="nextBtn">&#10095;</button>
                <!-- Indicators (dynamic dots will be inserted here) -->
                <div class="flex justify-center mt-4 indicator-container">
                    <!-- Dynamic dots will be generated by JavaScript -->
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
            <!-- End About Us Section -->
            <section class="bg-gray-100 py-12">
                <!-- Contact Us Section -->
                <div class="max-w-4xl mx-auto p-8 bg-white rounded-md shadow-lg">
                    <!-- Section Heading -->
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800">Contact Us</h2>
                        <p class="text-gray-600 mt-2">Have any questions? Please fill out the form below to get in touch with us.</p>
                    </div>

                    <!-- Notice for Occupied Dates -->
                    <div id="notice-message" class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 flex items-center">
                        <i class="fas fa-exclamation-triangle text-2xl ml-3"></i> <!-- Notice icon on the right -->
                        <div class="flex-grow text-center"> <!-- Center text -->
                            <p class="font-semibold text-lg">Notice:</p>
                            <p>If there are already 5 occupied dates, you cannot book an appointment.</p>
                        </div>

                    </div>

                    <!-- Form Section -->
                    <form id="appointmentForm">
                        <div class="my-6 flex flex-col gap-4">

                            <!-- Service Selection -->
                            <div class="my-3" id="a">
                                <label for="service" class="block text-sm font-semibold text-gray-700 mb-1">Select Service *</label>
                                <select name="service" id="service"
                                    class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2 placeholder-slate-400 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500"
                                    required>
                                    <option value="" disabled selected>Select a service</option>
                                    @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option> <!-- Populate options from the services -->
                                    @endforeach
                                </select>
                            </div>

                            <!-- Email Input -->
                            <div class="my-3" id="b">
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email *</label>
                                <input type="email" name="email" id="email"
                                    class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2 placeholder-slate-400 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500"
                                    placeholder="Enter your email" required />
                            </div>

                            <!-- Date Picker -->
                            <div id="datepicker-container">
                                <label for="appointment_datetime" class="block text-sm font-semibold text-gray-700 mb-1">Select Date *</label>
                                <input type="text" id="datepicker" name="appointment_datetime"
                                    class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2 placeholder-slate-400 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 sm:text-sm" placeholder="Select a date" required />
                                <label id="status-label" class="block text-sm font-semibold text-red-600 mt-1">Red = Occupied</label> <!-- Enhanced Status label -->
                            </div>

                            <div id="occupied-dates-container">
                                <h2 class="text-lg font-semibold mb-2">Occupied Dates</h2>
                                <table class="min-w-full bg-white border border-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="border-b px-4 py-2 text-left">Date</th>
                                            <th class="border-b px-4 py-2 text-left">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="occupied-dates-body">
                                        <!-- Occupied dates will be populated here -->
                                    </tbody>
                                </table>
                                <p id="occupied-count" class="text-sm text-gray-500 mt-2"></p>
                            </div>



                            <!-- Message Textarea -->
                            <div class="my-3" id="c">
                                <label for="message" class="block text-sm font-semibold text-gray-700 mb-1">Message *</label>
                                <textarea name="message" id="message" cols="30" rows="10"
                                    class="mb-10 h-40 w-full resize-none rounded-md border border-slate-300 bg-white p-5 font-semibold text-gray-500 placeholder-slate-400 focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500"
                                    placeholder="Type your message here..." required></textarea>
                            </div>

                            <!-- Book Appointment Button -->
                            <div class="text-center" id="d">
                                <button type="submit" class="rounded-lg bg-blue-700 px-8 py-5 text-sm font-semibold text-white hover:bg-blue-800">
                                    Book Appointment
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </section>



        </div>
    </main>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            let currentIndex = 0;
            const itemsPerView = 4; // Number of visible cards at a time
            const totalItems = $('.carousel-item').length;
            const totalPages = Math.ceil(totalItems / itemsPerView);

            // Dynamically create dots based on total pages
            for (let i = 0; i < totalPages; i++) {
                $('.indicator-container').append(
                    `<span class="dot w-3 h-3 bg-gray-400 rounded-full mx-1 cursor-pointer" data-slide="${i}"></span>`
                );
            }

            // Update carousel function
            function updateCarousel() {
                const offset = -(currentIndex * 100) / itemsPerView;
                $('.carousel-track').css('transform', `translateX(${offset}%)`);

                // Update dots
                $('.dot').removeClass('active');
                const activeIndex = Math.floor(currentIndex / itemsPerView);
                $('.dot').eq(activeIndex).addClass('active');
            }

            // Next Button
            $('#nextBtn').click(function() {
                if (currentIndex >= totalItems - itemsPerView) {
                    currentIndex = 0; // Reset to first card when last card is reached
                } else {
                    currentIndex++;
                }
                updateCarousel();
            });

            // Previous Button
            $('#prevBtn').click(function() {
                if (currentIndex <= 0) {
                    currentIndex = totalItems - itemsPerView; // Jump to the last card from the first
                } else {
                    currentIndex--;
                }
                updateCarousel();
            });

            // Dots click event
            $('.dot').click(function() {
                const slideIndex = $(this).data('slide') * itemsPerView;
                currentIndex = slideIndex;
                updateCarousel();
            });

            // Initial setup for indicators
            $('.dot').eq(0).addClass('active');

            document.getElementById('hamburgerButton').addEventListener('click', function() {
                const mobileMenu = document.getElementById('mobileMenu');
                mobileMenu.classList.toggle('hidden');
            });



            // Set the minimum date and time to the current date and time
            function setMinDateTime() {
                const now = new Date();
                // Format the date and time to YYYY-MM-DDTHH:mm
                const formattedDate = now.toISOString().slice(0, 16);
                $('#appointment_datetime').attr('min', formattedDate);
            }

            setMinDateTime(); // Set the minimum date and time on page load

            $('#appointmentForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Get the selected date and time
                const appointmentDateTime = new Date($('#appointment_datetime').val());
                const now = new Date();

                // Check if the selected date and time are in the past
                if (appointmentDateTime < now) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Date and Time',
                        text: 'Please select a date and time that is in the future.',
                        confirmButtonText: 'OK'
                    });
                    return; // Stop form submission
                }


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Get form data
                var formData = $(this).serialize();

                $.ajax({
                    url: '/guest/appointment', // This is the correct route for storing appointments
                    type: 'POST',
                    data: formData,
                    beforeSend: function() {
                        // Show the loading SweetAlert
                        Swal.fire({
                            title: 'Saving...',
                            text: 'Please wait while we process your request.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading(); // Display loading spinner
                            }
                        });
                    },
                    success: function(response) {
                        // Close loading alert
                        Swal.close();

                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Appointment Booked',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });

                        // Clear the form fields
                        $('#appointment_datetime').val('');
                        $('#message').val('');
                        $('#service').val('');

                        window.location.reload();
                    },
                    error: function(xhr) {
                        // Close loading alert
                        Swal.close();

                        // Show error message
                        var errorMessage = xhr.responseJSON?.message || 'An unknown error occurred.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Error Booking Appointment',
                            text: errorMessage,
                            confirmButtonText: 'OK'
                        });
                    }
                });

            });


        });
        // Get the appointment dates passed from the Laravel controller
        const appointments = @json($appointments); // Convert PHP array to JavaScript

        // Convert appointments to Date objects
        const disabledDates = appointments.map(date => moment(date).toDate());

        // Populate the occupied dates table
        const occupiedCountElement = document.getElementById('occupied-count');
        const occupiedDatesBody = document.getElementById('occupied-dates-body');
        const datePickerContainer = document.getElementById('datepicker-container');
        const a = document.getElementById('a');
        const b = document.getElementById('b');
        const c = document.getElementById('c');
        const d = document.getElementById('d');

        // Populate the table with occupied dates
        appointments.forEach(date => {
            const row = document.createElement('tr');
            row.innerHTML = `
        <td class="border-b px-4 py-2 text-sm text-gray-700">${date}</td>
        <td class="border-b px-4 py-2 text-sm text-gray-700">Occupied</td>
    `;
            occupiedDatesBody.appendChild(row);
        });

        // Update the occupied count
        const occupiedCount = appointments.length;
        occupiedCountElement.textContent = `${occupiedCount} occupied date(s)`;

        // Disable all dates if the number of occupied dates exceeds the threshold (5)
        const disableAllDates = occupiedCount >= 5;

        if (occupiedCount >= 5) {
            datePickerContainer.style.display = 'none'; // Hide the date picker if 5 or more
            a.style.display = 'none';
            b.style.display = 'none';
            c.style.display = 'none';
            d.style.display = 'none';
        } else {
            datePickerContainer.style.display = 'block'; // Show the date picker if less than 5
            a.style.display = 'block';
            b.style.display = 'block';
            c.style.display = 'block';
            d.style.display = 'block';
        }

        const picker = new Pikaday({
            field: document.getElementById('datepicker'),
            // Disable occupied dates
            disableDayFn: function(date) {
                // Return true if disabling all dates

                return disabledDates.some(disabledDate =>
                    date.getFullYear() === disabledDate.getFullYear() &&
                    date.getMonth() === disabledDate.getMonth() &&
                    date.getDate() === disabledDate.getDate()
                );
            },
            format: 'YYYY-MM-DD',
            onDraw: function() {
                const days = document.querySelectorAll('.pika-day'); // Select all day elements
                days.forEach(day => {
                    const dayNumber = parseInt(day.textContent, 10); // Get the day number
                    const date = new Date(this.currentYear, this.currentMonth, dayNumber); // Create a date object

                    // Check for occupied dates
                    if (disabledDates.some(disabledDate =>
                            date.getFullYear() === disabledDate.getFullYear() &&
                            date.getMonth() === disabledDate.getMonth() &&
                            date.getDate() === disabledDate.getDate()
                        )) {
                        console.log(`Occupied Date Found: ${date.toLocaleDateString()}`); // Debug log
                        day.classList.add('is-occupied'); // Add red styling for occupied dates
                    }

                });
            }
        });
    </script>
    <footer class="bg-white text-black py-6">
        <div class="mt-6 text-center text-gray-400 text-sm">
            &copy; 2024 MyCompany. All rights reserved.
        </div>
    </footer>

    @vite('resources/js/app.js')

</body>

</html>