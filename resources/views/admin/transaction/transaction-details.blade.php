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
                    @if(Auth::user()->hasRole('staff'))
                    <!-- Hide the Actions header if the user is a staff -->
                    @else
                    <button onclick="window.open('/invoice/{{ $transaction->id }}', '_blank')"
                        class="inline-flex items-center bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 10v6a2 2 0 01-2 2H7a2 2 0 01-2-2v-6M5 10h14l1.88 6.63A2 2 0 0119 20H5a2 2 0 01-1.88-3.37L5 10zm14 0V7a5 5 0 00-5-5h-4a5 5 0 00-5 5v3" />
                        </svg>
                        Print Invoice
                    </button>
                    @endif
                </div>

                <div class="border rounded p-4 mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-lg font-bold">General Information</div>
                        @if(Auth::user()->hasRole('staff'))
                        <!-- Hide the Actions header if the user is a staff -->
                        @else
                        <div>
                            <button id="transaction_edit_btn" data-transaction='@json($transaction)'
                                class="inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                                Edit
                            </button>
                        </div>
                        @endif

                    </div>
                    <input type="hidden" id="transactionId" name="transactionId" value="{{ $transaction->id }}">
                    <div class="grid md:grid-cols-2 md:items-start w-full">
                        <div class="grid grid-cols-2 gap-y-1">
                            <div class="px-4 font-semibold text-gray-800">Transaction Code:</div>
                            <div class="px-4 text-gray-500" data-field="code">{{ $transaction->code }}
                            </div>
                            <div class="px-4 font-semibold text-gray-800">Name:</div>
                            <div class="px-4 text-gray-500" data-field="client_name">
                                {{ $transaction->client_name }}
                            </div>
                            <div class="px-4 font-semibold text-gray-800">Unit/Model:</div>
                            <div class="px-4 text-gray-500" data-field="unit">{{ $transaction->unit }}
                            </div>
                            <div class="px-4 font-semibold text-gray-800">Color:</div>
                            <div class="px-4 text-gray-500" data-field="color">
                                {{ $transaction->color }}
                            </div>
                            <div class="px-4 font-semibold text-gray-800">Plate No.:</div>
                            <div class="px-4 text-gray-500" data-field="plate_no">
                                {{ $transaction->plate_no }}
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-y-1">
                            <div class="px-4 font-semibold text-gray-800">Address:</div>
                            <div class="px-4 text-gray-500" data-field="address">
                                {{ $transaction->address }}
                            </div>
                            <div class="px-4 font-semibold text-gray-800">Phone No.:</div>
                            <div class="px-4 text-gray-500" data-field="contact">
                                {{ $transaction->contact }}
                            </div>
                            <div class="px-4 font-semibold text-gray-800">Email:</div>
                            <div class="px-4 text-gray-500" data-field="email">
                                {{ $transaction->email }}
                            </div>
                            <div class="px-4 font-semibold text-gray-800">Date In:</div>
                            <div class="px-4 text-gray-500" data-field="date_in">
                                {{ $formattedDateIn }}
                            </div>
                            <div class="px-4 font-semibold text-gray-800">Status:</div>
                            <div class="px-4 text-gray-500" data-field="status">
                                {{ $transaction->status }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-2 w-full">
                    <div class="border rounded p-4 mb-2 overflow-auto">
                        <div class="flex justify-between items-center mb-2">
                            <div class="text-lg font-bold">Services</div>

                            @if(Auth::user()->hasRole('staff'))
                            <!-- Hide the Actions header if the user is a staff -->
                            @else
                            <button id="addServiceButton"
                                class="inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                                Add Service
                            </button>
                            @endif
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

                            @if(Auth::user()->hasRole('staff'))
                            <!-- Hide the Actions header if the user is a staff -->
                            @else
                            <button id="addProductButton"
                                class="inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                                Add Product
                            </button>
                            @endif
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
                <div class="flex items-end justify-between border-b-2 mt-4 border-gray-900">
                    <div class="text-lg font-bold text-gray-900">Total Payable Amount <span
                            class="text-sm italic text-gray-700">(Services and Products)</span></div>
                    <div id="amount" class="text-lg font-bold text-gray-900">{{ $transaction->amount }}</div>
                </div>

                @if(Auth::user()->hasRole('staff'))
                <div class="mt-8 border rounded p-4">
                    <input type="hidden" id="initMechanicId" name="initMechanicId" value="{{ $transaction->mechanic_id }}">
                    <div class="text-lg font-bold mb-4">Transaction Details</div>
                    <form id="submitTransactionForm">
                        <input type="hidden" id="submitTransactionId" name="submitTransactionId" value="{{ $transaction->id }}">
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div class="">
                                <label for="mechanic_id" class="block text-sm font-bold text-gray-700">Assigned Mechanic <span class="text-red-700">*</span></label>
                                <select id="mechanic_id" name="mechanic_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required disabled>
                                    <option value="{{ $transaction->mechanic_id }}" selected>{{ $transaction->mechanic->name ?? '--' }}</option>
                                </select>
                            </div>
                            <div class="">
                                <label for="estimated_completion_date" class="block text-sm text-gray-700">Estimated Completion Date <span class="text-red-700">*</span></label>
                                <input type="datetime-local" id="estimated_completion_date" name="estimated_completion_date" value="{{ $transaction->estimated_completion_date }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" readonly>
                            </div>
                            <div>
                                <label for="downpayment" class="block text-sm font-bold text-gray-700">Downpayment <span class="text-red-700 text-xs italic">(Atleast 20% of Total Payable Amount) *</span></label>
                                <input type="number" step="0.1" id="downpayment" name="downpayment" value="{{ $transaction->downpayment }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" min="{{ $transaction->amount * 0.2 }}" max="{{ $transaction->amount }}" required readonly>
                            </div>
                            <div class="">
                                <label for="payment_status" class="block text-sm font-bold text-gray-700">Payment Status <span class="text-red-700">*</span></label>
                                <select id="payment_status" name="payment_status" data-selected="{{ $transaction->payment_status }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required disabled>
                                    <option value="Unpaid" {{ $transaction->payment_status == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="Partially Paid" {{ $transaction->payment_status == 'Partially Paid' ? 'selected' : '' }}>Partially Paid</option>
                                    <option value="Paid" {{ $transaction->payment_status == 'Paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="Refunded" {{ $transaction->payment_status == 'Refunded' ? 'selected' : '' }}>Refunded</option>
                                    <option value="Cancelled" {{ $transaction->payment_status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <div class="">
                                <label for="date_out" class="block text-sm text-gray-700">Date Out</label>
                                <input type="datetime-local" id="date_out" name="date_out" value="{{ $transaction->date_out }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" readonly>
                            </div>

                            <div class="">
                                <label for="status" class="block text-sm text-gray-700">Status <span class="text-red-700">*</span></label>
                                <select id="status" name="status" data-selected="{{ $transaction->status }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required disabled>
                                    <option value="Pending" {{ $transaction->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Processing" {{ $transaction->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="Done" {{ $transaction->status == 'Done' ? 'selected' : '' }}>Done</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                @else
                <div class="mt-8 border rounded p-4">
                    <input type="hidden" id="initMechanicId" name="initMechanicId" value="{{ $transaction->mechanic_id }}">
                    <div class="text-lg font-bold mb-4">Transaction Details</div>
                    <form id="submitTransactionForm">
                        <input type="hidden" id="submitTransactionId" name="submitTransactionId" value="{{ $transaction->id }}">
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div class="">
                                <label for="mechanic_id" class="block text-sm font-bold text-gray-700">Assigned Mechanic <span class="text-red-700">*</span></label>
                                <select id="mechanic_id" name="mechanic_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                                    <option value="" selected>--</option>
                                </select>
                            </div>
                            <div class="">
                                <label for="estimated_completion_date" class="block text-sm text-gray-700">Estimated Completion Date <span class="text-red-700">*</span></label>
                                <input type="datetime-local" id="estimated_completion_date" name="estimated_completion_date" value="{{ $transaction->estimated_completion_date }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                            </div>
                            <div>
                                <label for="downpayment" class="block text-sm font-bold text-gray-700">Downpayment <span class="text-red-700 text-xs italic">(Atleast 20% of Total Payable Amount) *</span></label>
                                <input type="number" step="0.1" id="downpayment" name="downpayment" value="{{ $transaction->downpayment }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" min="{{ $transaction->amount * 0.2 }}" max="{{ $transaction->amount }}" required>
                            </div>
                            <div class="">
                                <label for="payment_status" class="block text-sm font-bold text-gray-700">Payment Status <span class="text-red-700">*</span></label>
                                <select id="payment_status" name="payment_status" data-selected="{{ $transaction->payment_status }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                                    <option value="Unpaid" {{ $transaction->payment_status == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="Partially Paid" {{ $transaction->payment_status == 'Partially Paid' ? 'selected' : '' }}>Partially Paid</option>
                                    <option value="Paid" {{ $transaction->payment_status == 'Paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="Refunded" {{ $transaction->payment_status == 'Refunded' ? 'selected' : '' }}>Refunded</option>
                                    <option value="Cancelled" {{ $transaction->payment_status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <div class="">
                                <label for="date_out" class="block text-sm text-gray-700">Date Out</label>
                                <input type="datetime-local" id="date_out" name="date_out" value="{{ $transaction->date_out }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                            </div>

                            <div class="">
                                <label for="status" class="block text-sm text-gray-700">Status <span class="text-red-700">*</span></label>
                                <select id="status" name="status" data-selected="{{ $transaction->status }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                                    <option value="Pending" {{ $transaction->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Processing" {{ $transaction->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="Done" {{ $transaction->status == 'Done' ? 'selected' : '' }}>Done</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
                @endif

            </div>
        </div>
    </div>
    <script>
        window.userRole = "{{ Auth::user()->getRoleNames()->first() }}";
    </script>
    @include('admin.transaction.modal')

    @push('scripts')
    <script src="{{ asset('js/transactions.js') }}"></script>
    <script src="{{ asset('js/transaction-services.js') }}"></script>
    <script src="{{ asset('js/transaction-products.js') }}"></script>
    @endpush
</x-app-layout>