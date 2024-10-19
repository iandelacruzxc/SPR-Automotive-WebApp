<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Stock Details') }}
        </h2>
    </x-slot>

    @include('admin.inventory.style')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <a href="/inventory"
                        class="inline-flex items-center bg-gray-300 text-gray-800 py-2 px-4 rounded-md hover:bg-gray-400 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12H3m0 0l7-7m-7 7l7 7" />
                        </svg>
                        Back
                    </a>
                    <!-- <button id="addStocksButton" class="inline-block bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600">Add Stocks</button> -->
                    <!-- Create Button with Icon -->
                    <button id="createButton"
                        class="inline-block bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600"
                        data-product-id="{{ $product->id }}">
                        <i class="fas fa-plus mr-2"></i>
                        {{ __('Add Stocks') }}
                    </button>
                </div>
                <h3 class="text-lg font-semibold mb-4">Product Overview</h3>
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Product Overview Cards -->
                    <div class="flex-1">
                        <div class="bg-white border border-gray-200 rounded-lg shadow-md p-4 flex flex-col">
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                                class="w-full h-64 object-cover rounded-md mb-4"> <!-- Full width image -->
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Product Name:</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $product->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Description</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $product->description }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Price</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $product->price }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Stocks</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ optional($product->inventory)->quantity ?? '0' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Sold</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $product->price }}</td>
                                    </tr>
                                    <!-- Additional Stock Records can be added here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" id="product-id" value="{{ $product->id }}">
                    <!-- Stock Records Table -->
                    <div class="flex-1">
                        <div class="bg-white border border-gray-200 rounded-lg shadow-md p-4">
                            <h4 class="text-lg font-semibold mb-2">Stock-In Records</h4>
                            <table id="inventoryTable" class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Stock-In Date</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Quantity</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.inventory.modal')

    @push('scripts')
        <script src="{{ asset('js/inventory.js') }}"></script>
    @endpush
</x-app-layout>
