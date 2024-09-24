<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Service Management') }}
        </h2>
    </x-slot>

    @include('admin.product-management.style')
 

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <!-- Create Button with Icon -->
            <div class="flex justify-end mb-4">
                <button id="createButton" class="bg-blue-500 text-white px-4 py-2 rounded-md flex items-center hover:bg-blue-600">
                    <!-- Font Awesome Plus Icon -->
                    <i class="fas fa-plus mr-2"></i>
                    {{ __('Create') }}
                </button>
            </div>
            <!-- Table -->
            <div class="overflow-x-auto">
                <table id="example" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nam e</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
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

@include('admin.service-management.modal')

    @push('scripts')
       <script src="{{ asset('js/service-management.js') }}"></script>\
    @endpush
    
</x-app-layout>