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
                    <input type="hidden" id="transactionId" name="transactionId" value="{{ $transaction->id }}">
                    <div class="grid md:grid-cols-2 md:items-start w-full">
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
                <div class="grid md:grid-cols-2 md:gap-2 w-full">
                    <div class="border rounded p-4 mb-2 overflow-auto">
                        <div class="flex justify-between items-center mb-2">
                            <div class="text-lg font-bold">Services</div>
                            <button id="addServiceButton"
                                class="inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                                Add Service
                            </button>
                        </div>
                        <table id="serviceTable" class="table-auto w-full text-center">
                            <thead class="bg-gray-200">
                                <th class="text-gray-900">Name</th>
                                <th class="text-gray-900">Price</th>
                                <th class="text-gray-900">Action</th>
                            </thead>
                            <tbody class="divide-y divide-gray-200 text-gray-600">
                            </tbody>
                        </table>
                    </div>
                    <div class="border rounded p-4 mb-2 overflow-auto">
                        <div class="flex justify-between items-center mb-2">
                            <div class="text-lg font-bold">Products</div>
                            <button id="addProductButton"
                                class="inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                                Add Product
                            </button>
                        </div>
                        <table id="productTable" class="table-auto w-full text-center">
                            <thead class="bg-gray-200">
                                <th class="text-gray-900">Name</th>
                                <th class="text-gray-900">Price</th>
                                <th class="text-gray-900">Quantity</th>
                                <th class="text-gray-900">Total</th>
                                <th class="text-gray-900">Action</th>
                            </thead>
                            <tbody class="divide-y divide-gray-200 text-gray-600">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-4">
                    <input type="hidden" id="initMechanicId" name="initMechanicId"
                        value="{{ $transaction->mechanic_id }}">
                    <form id="submitTransactionForm">
                        <input type="hidden" id="submitTransactionId" name="submitTransactionId"
                            value="{{ $transaction->id }}">
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div class="">
                                <label for="mechanic_id" class="block text-sm font-bold text-gray-700">Assigned
                                    Mechanic</label>
                                <select id="mechanic_id" name="mechanic_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                                    <option value="" selected>--</option>
                                </select>
                            </div>
                            <div class="">
                                <label for="date_out" class="block text-sm text-gray-700">Date Out</label>
                                <input type="datetime-local" id="date_out" name="date_out"
                                    value="{{ $transaction->date_out }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                            </div>
                            <div>
                                <label for="downpayment"
                                    class="block text-sm font-bold text-gray-700">Downpayment</label>
                                <input type="number" id="downpayment" name="downpayment"
                                    value="{{ $transaction->downpayment }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm"
                                    min="0" max="{{ $transaction->amount }}" required>
                            </div>
                            <div>
                                <label for="amount" class="block text-sm font-bold text-gray-700">Total</label>
                                <input type="number" id="amount" name="amount"
                                    value="{{ $transaction->amount }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" readonly>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('admin.transaction.modal')

    @push('scripts')
        <script src="{{ asset('js/transactions.js') }}"></script>
        <script src="{{ asset('js/transaction-services.js') }}"></script>
        <script src="{{ asset('js/transaction-products.js') }}"></script>
    @endpush
</x-app-layout>
