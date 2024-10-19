@php
    use Carbon\Carbon;
    // Parse the date and format it to 'F j, Y, g:i A'
    $formattedDateIn = Carbon::parse($transaction->date_in)->format('F j, Y, g:i A');
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaction Details') }}
        </h2>
    </x-slot>

    @include('admin.transaction.style')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <a href="/transactions"
                        class="inline-flex items-center bg-gray-200 text-gray-900 py-2 px-4 rounded-md hover:bg-gray-300 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12H3m0 0l7-7m-7 7l7 7" />
                        </svg>
                        Back
                    </a>
                </div>
                <div class="border rounded p-4 mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-lg font-bold">General Information</div>
                        <div>
                            <button id="transaction_edit_btn" data-transaction='@json($transaction)'
                                class="inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                                Edit
                            </button>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 items-start">
                        <div class="grid grid-cols-2 gap-y-1">
                            <div class="px-4 font-semibold text-gray-800">Transaction Code:</div>
                            <div class="px-4 text-gray-500" data-field="code">{{ $transaction->code }}
                            </div>
                            <div class="px-4 font-semibold text-gray-800">Name:</div>
                            <div class="px-4 text-gray-500" data-field="client_name">
                                {{ $transaction->client_name }}</div>
                            <div class="px-4 font-semibold text-gray-800">Unit/Model:</div>
                            <div class="px-4 text-gray-500" data-field="unit">{{ $transaction->unit }}
                            </div>
                            <div class="px-4 font-semibold text-gray-800">Color:</div>
                            <div class="px-4 text-gray-500" data-field="color">
                                {{ $transaction->color }}</div>
                            <div class="px-4 font-semibold text-gray-800">Plate No.:</div>
                            <div class="px-4 text-gray-500" data-field="plate_no">
                                {{ $transaction->plate_no }}</div>
                        </div>
                        <div class="grid grid-cols-2 gap-y-1">
                            <div class="px-4 font-semibold text-gray-800">Address:</div>
                            <div class="px-4 text-gray-500" data-field="address">
                                {{ $transaction->address }}</div>
                            <div class="px-4 font-semibold text-gray-800">Phone No.:</div>
                            <div class="px-4 text-gray-500" data-field="contact">
                                {{ $transaction->contact }}</div>
                            <div class="px-4 font-semibold text-gray-800">Email:</div>
                            <div class="px-4 text-gray-500" data-field="email">
                                {{ $transaction->email }}</div>
                            <div class="px-4 font-semibold text-gray-800">Date In:</div>
                            <div class="px-4 text-gray-500" data-field="date_in">
                                {{ $formattedDateIn }}</div>
                            <div class="px-4 font-semibold text-gray-800">Status:</div>
                            <div class="px-4 text-gray-500" data-field="status">
                                {{ $transaction->status }}</div>
                        </div>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-2">
                    <div class="border rounded p-4 mb-2">
                        <div class="flex justify-end mb-2">
                            <button id="createButton"
                                class="inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                                Add Service
                            </button>
                        </div>
                        <table class="table-auto w-full text-center">
                            <thead class="bg-gray-200">
                                <th class="text-gray-900">Name</th>
                                <th class="text-gray-900">Price</th>
                                <th class="text-gray-900">Action</th>
                            </thead>
                            <tbody class="divide-y divide-gray-200 text-gray-600">
                                <tr>
                                    <td>Repainting</td>
                                    <td>1500</td>
                                    <td><button class="text-red-500 hover:text-red-600" title="Delete"><i
                                                class="fa-solid fa-trash"></i></button></td>
                                </tr>
                                <tr>
                                    <td>Coating</td>
                                    <td>1500</td>
                                    <td><button class="text-red-500 hover:text-red-600" title="Delete"><i
                                                class="fa-solid fa-trash"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="border rounded p-4 mb-2">
                        <div class="flex justify-end mb-2">
                            <button id="createButton"
                                class="inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                                Add Product
                            </button>
                        </div>
                        <table class="table-auto w-full text-center">
                            <thead class="bg-gray-200">
                                <th class="text-gray-900">Name</th>
                                <th class="text-gray-900">Quantity</th>
                                <th class="text-gray-900">Price</th>
                                <th class="text-gray-900">Action</th>
                            </thead>
                            <tbody class="divide-y divide-gray-200 text-gray-600">
                                <tr>
                                    <td>Paint</td>
                                    <td>1</td>
                                    <td>1500</td>
                                    <td><button class="text-red-500 hover:text-red-600" title="Delete"><i
                                                class="fa-solid fa-trash"></i></button></td>
                                </tr>
                                <tr>
                                    <td>Paint</td>
                                    <td>2</td>
                                    <td>3000</td>
                                    <td><button class="text-red-500 hover:text-red-600" title="Delete"><i
                                                class="fa-solid fa-trash"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.transaction.modal')

    @push('scripts')
        <script src="{{ asset('js/transactions.js') }}"></script>
    @endpush
</x-app-layout>
