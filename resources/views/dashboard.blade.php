<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>




    <div class="py-12">
        <div class="max-w-7xl md:mx-0 mx-4 sm:px-6 lg:px-8">
            <!-- Dashboard Cards Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Users Card -->
                <div class="p-4 bg-white rounded shadow">
                    <div class="flex items-center  mb-4">
                        <!-- Badge with larger SVG -->
                        <div class="w-20 h-20 flex items-center justify-center rounded-lg bg-red-500 text-white mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </div>
                        <!-- Text beside SVG -->
                        <div class="flex flex-col justify-center">
                            <div class="font-bold text-xl text-gray-800 mb-1 text-center">Users</div>
                            <div class="text-gray-700 text-3xl font-bold mb-2">
                                {{ $totalUsers }} <!-- Display total services -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- service Card -->
                <div class="p-4 bg-white rounded shadow">
                    <div class="flex items-center mb-4">
                        <!-- Badge with larger SVG -->
                        <div class="w-20 h-20 flex items-center justify-center rounded-lg bg-blue-500 text-white mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-12 h-12">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                            </svg>
                        </div>
                        <!-- Text beside SVG -->
                        <div class="flex flex-col justify-center">
                            <div class="font-bold text-xl text-gray-800 mb-1 text-center">Services</div>
                            <div class="text-gray-700 text-3xl font-bold mb-2">
                                {{ $totalServices }} <!-- Display total services -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Products Card -->
                <div class="p-4 bg-white rounded shadow">
                    <div class="flex items-center mb-4">
                        <!-- Badge with larger SVG -->
                        <div
                            class="w-20 h-20 flex items-center justify-center rounded-lg bg-green-500 p-4 text-white mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path fill="#ffffff"
                                    d="M50.7 58.5L0 160l208 0 0-128L93.7 32C75.5 32 58.9 42.3 50.7 58.5zM240 160l208 0L397.3 58.5C389.1 42.3 372.5 32 354.3 32L240 32l0 128zm208 32L0 192 0 416c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-224z" />
                            </svg>
                        </div>
                        <!-- Text beside SVG -->
                        <div class="flex flex-col justify-center">
                            <div class="font-bold text-xl text-gray-800 mb-1 text-center">Products</div>
                            <div class="text-gray-700 text-3xl font-bold mb-2">
                                {{ $totalProducts }} <!-- Display total services -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Mechanics Card -->
                <div class="p-4 bg-white rounded shadow">
                    <div class="flex items-center mb-4">
                        <!-- Badge with larger SVG -->
                        <div
                            class="w-20 h-20 flex items-center justify-center rounded-lg bg-yellow-500 p-4 text-white mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 640 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path fill="#ffffff"
                                    d="M144 160A80 80 0 1 0 144 0a80 80 0 1 0 0 160zm368 0A80 80 0 1 0 512 0a80 80 0 1 0 0 160zM0 298.7C0 310.4 9.6 320 21.3 320l213.3 0c.2 0 .4 0 .7 0c-26.6-23.5-43.3-57.8-43.3-96c0-7.6 .7-15 1.9-22.3c-13.6-6.3-28.7-9.7-44.6-9.7l-42.7 0C47.8 192 0 239.8 0 298.7zM320 320c24 0 45.9-8.8 62.7-23.3c2.5-3.7 5.2-7.3 8-10.7c2.7-3.3 5.7-6.1 9-8.3C410 262.3 416 243.9 416 224c0-53-43-96-96-96s-96 43-96 96s43 96 96 96zm65.4 60.2c-10.3-5.9-18.1-16.2-20.8-28.2l-103.2 0C187.7 352 128 411.7 128 485.3c0 14.7 11.9 26.7 26.7 26.7l300.6 0c-2.1-5.2-3.2-10.9-3.2-16.4l0-3c-1.3-.7-2.7-1.5-4-2.3l-2.6 1.5c-16.8 9.7-40.5 8-54.7-9.7c-4.5-5.6-8.6-11.5-12.4-17.6l-.1-.2-.1-.2-2.4-4.1-.1-.2-.1-.2c-3.4-6.2-6.4-12.6-9-19.3c-8.2-21.2 2.2-42.6 19-52.3l2.7-1.5c0-.8 0-1.5 0-2.3s0-1.5 0-2.3l-2.7-1.5zM533.3 192l-42.7 0c-15.9 0-31 3.5-44.6 9.7c1.3 7.2 1.9 14.7 1.9 22.3c0 17.4-3.5 33.9-9.7 49c2.5 .9 4.9 2 7.1 3.3l2.6 1.5c1.3-.8 2.6-1.6 4-2.3l0-3c0-19.4 13.3-39.1 35.8-42.6c7.9-1.2 16-1.9 24.2-1.9s16.3 .6 24.2 1.9c22.5 3.5 35.8 23.2 35.8 42.6l0 3c1.3 .7 2.7 1.5 4 2.3l2.6-1.5c16.8-9.7 40.5-8 54.7 9.7c2.3 2.8 4.5 5.8 6.6 8.7c-2.1-57.1-49-102.7-106.6-102.7zm91.3 163.9c6.3-3.6 9.5-11.1 6.8-18c-2.1-5.5-4.6-10.8-7.4-15.9l-2.3-4c-3.1-5.1-6.5-9.9-10.2-14.5c-4.6-5.7-12.7-6.7-19-3l-2.9 1.7c-9.2 5.3-20.4 4-29.6-1.3s-16.1-14.5-16.1-25.1l0-3.4c0-7.3-4.9-13.8-12.1-14.9c-6.5-1-13.1-1.5-19.9-1.5s-13.4 .5-19.9 1.5c-7.2 1.1-12.1 7.6-12.1 14.9l0 3.4c0 10.6-6.9 19.8-16.1 25.1s-20.4 6.6-29.6 1.3l-2.9-1.7c-6.3-3.6-14.4-2.6-19 3c-3.7 4.6-7.1 9.5-10.2 14.6l-2.3 3.9c-2.8 5.1-5.3 10.4-7.4 15.9c-2.6 6.8 .5 14.3 6.8 17.9l2.9 1.7c9.2 5.3 13.7 15.8 13.7 26.4s-4.5 21.1-13.7 26.4l-3 1.7c-6.3 3.6-9.5 11.1-6.8 17.9c2.1 5.5 4.6 10.7 7.4 15.8l2.4 4.1c3 5.1 6.4 9.9 10.1 14.5c4.6 5.7 12.7 6.7 19 3l2.9-1.7c9.2-5.3 20.4-4 29.6 1.3s16.1 14.5 16.1 25.1l0 3.4c0 7.3 4.9 13.8 12.1 14.9c6.5 1 13.1 1.5 19.9 1.5s13.4-.5 19.9-1.5c7.2-1.1 12.1-7.6 12.1-14.9l0-3.4c0-10.6 6.9-19.8 16.1-25.1s20.4-6.6 29.6-1.3l2.9 1.7c6.3 3.6 14.4 2.6 19-3c3.7-4.6 7.1-9.4 10.1-14.5l2.4-4.2c2.8-5.1 5.3-10.3 7.4-15.8c2.6-6.8-.5-14.3-6.8-17.9l-3-1.7c-9.2-5.3-13.7-15.8-13.7-26.4s4.5-21.1 13.7-26.4l3-1.7zM472 384a40 40 0 1 1 80 0 40 40 0 1 1 -80 0z" />
                            </svg>
                        </div>
                        <!-- Text beside SVG -->
                        <div class="flex flex-col justify-center">
                            <div class="font-bold text-xl text-gray-800 mb-1 text-center">Mechanics</div>
                            <div class="text-gray-700 text-3xl font-bold mb-2">
                                {{ $totalMechanics }} <!-- Display total services -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Transactions Card -->
                {{-- <div class="max-w-sm rounded overflow-hidden shadow-lg bg-white p-6">
                    <div class="flex items-center mb-4">
                        <!-- Badge with larger SVG -->
                        <div
                            class="w-20 h-20 flex items-center justify-center rounded-lg bg-orange-500 p-4 text-white mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 640 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path fill="#ffffff"
                                    d="M535 41c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l64 64c4.5 4.5 7 10.6 7 17s-2.5 12.5-7 17l-64 64c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l23-23L384 112c-13.3 0-24-10.7-24-24s10.7-24 24-24l174.1 0L535 41zM105 377l-23 23L256 400c13.3 0 24 10.7 24 24s-10.7 24-24 24L81.9 448l23 23c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L7 441c-4.5-4.5-7-10.6-7-17s2.5-12.5 7-17l64-64c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9zM96 64l241.9 0c-3.7 7.2-5.9 15.3-5.9 24c0 28.7 23.3 52 52 52l117.4 0c-4 17 .6 35.5 13.8 48.8c20.3 20.3 53.2 20.3 73.5 0L608 169.5 608 384c0 35.3-28.7 64-64 64l-241.9 0c3.7-7.2 5.9-15.3 5.9-24c0-28.7-23.3-52-52-52l-117.4 0c4-17-.6-35.5-13.8-48.8c-20.3-20.3-53.2-20.3-73.5 0L32 342.5 32 128c0-35.3 28.7-64 64-64zm64 64l-64 0 0 64c35.3 0 64-28.7 64-64zM544 320c-35.3 0-64 28.7-64 64l64 0 0-64zM320 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z" />
                            </svg>
                        </div>
                        <!-- Text beside SVG -->
                        <div class="flex flex-col justify-center">
                            <div class="font-bold text-xl text-gray-800 mb-1 text-center">Transactions</div>
                            <div class="text-gray-700 text-3xl font-bold mb-2">
                                {{ $totalTransactions }} <!-- Display total services -->
            </div>
        </div>
    </div>
    </div> --}}
    </div>
    <div class="mt-8 bg-white rounded shadow p-4">
        <div class="text-xl font-bold mb-4">Transactions</div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-2">
            <div class="flex justify-between items-center bg-red-100 p-4 rounded shadow">
                <div class="text-lg font-semibold text-red-700">Pending</div>
                <div class="text-lg font-bold text-white px-4 py-2 rounded-full bg-red-700">
                    {{ $totalPendingTransactions }}
                </div>
            </div>
            <div class="flex justify-between items-center bg-yellow-100 p-4 rounded shadow">
                <div class="text-lg font-semibold text-yellow-700">Processing</div>
                <div class="text-lg font-bold text-white px-4 py-2 rounded-full bg-yellow-700">
                    {{ $totalProcessingTransactions }}
                </div>
            </div>
            <div class="flex justify-between items-center bg-green-100 p-4 rounded shadow">
                <div class="text-lg font-semibold text-green-700">Done</div>
                <div class="text-lg font-bold text-white px-4 py-2 rounded-full bg-green-700">
                    {{ $totalDoneTransactions }}
                </div>
            </div>
            <div class="flex justify-between items-center bg-blue-100 p-4 rounded shadow">
                <div class="text-lg font-semibold text-blue-700">Total</div>
                <div class="text-lg font-bold text-white px-4 py-2 rounded-full bg-blue-700">
                    {{ $totalTransactions }}
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>


</x-app-layout>