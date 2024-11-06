<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mechanics Management') }}
        </h2>
    </x-slot>

    <!-- Add this to your Blade template or HTML file -->
    <style>
        /* Ensure DataTable styles are applied correctly */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 0.375rem;
            margin: 0 0.125rem;
            cursor: pointer;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #3182ce;
            color: white;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #2b6cb0;
            color: white;
        }

        .custom-align-left {
            text-align: left !important;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <!-- Create Button with Icon -->
                @if(Auth::user()->hasRole('staff'))
                <!-- Hide the Actions header if the user is a staff -->
                @else
                <div class="flex justify-end mb-4">
                    <button id="createButton" class="bg-blue-500 text-white px-4 py-2 rounded-md flex items-center hover:bg-blue-600">
                        <!-- Font Awesome Plus Icon -->
                        <i class="fas fa-plus mr-2"></i>
                        {{ __('Create') }}
                    </button>
                </div>
                @endif
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table id="mechanicsTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Firstname</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Middlename</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Lastname</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Position</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rate</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Table rows -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="createModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-xl w-full">
            <h3 id="modalTitle" class="text-lg font-semibold mb-4">Add New Mechanic</h3>
            <form id="createMechanicForm">
                <input type="hidden" id="mechanicId" name="id">
                <!-- Form fields as you have defined -->
                <div class="mb-4">
                    <label for="firstname" class="block text-sm font-medium text-gray-700">Firstname</label>
                    <input type="text" id="firstname" name="firstname"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="middlename" class="block text-sm font-medium text-gray-700">Middlename</label>
                    <input type="text" id="middlename" name="middlename"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="lastname" class="block text-sm font-medium text-gray-700">Lastname</label>
                    <input type="text" id="lastname" name="lastname"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                    <input type="text" id="position" name="position"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="rate" class="block text-sm font-medium text-gray-700">Rate</label>
                    <input type="number" id="rate" name="rate"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                        <option value="1">Working</option>
                        <option value="2" selected>Stand-by</option>
                    </select>
                </div>
                {{-- <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                    </select>
                </div> --}}
                <div class="flex justify-end">
                    <button type="button" id="closeModal"
                        class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div id="viewModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <h3 class="text-lg font-semibold mb-4">Mechanic Details</h3>
            <div id="mechanicDetails">
                <!-- Details will be dynamically added here -->
            </div>
            <div class="flex justify-end">
                <button type="button" id="closeViewModal"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md">Close</button>
            </div>
        </div>
    </div>
    <script>
        window.userRole = "{{ Auth::user()->getRoleNames()->first() }}";
    </script>
    @push('scripts')
    <script src="{{ asset('js/mechanics.js') }}"></script>\
    @endpush
</x-app-layout>