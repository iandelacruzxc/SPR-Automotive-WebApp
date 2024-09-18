<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}      
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          
                <!-- Dashboard Cards Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    

     <!-- Users Card -->
     <div class="max-w-sm rounded overflow-hidden shadow-lg bg-white p-6">
        <div class="flex items-center mb-4">
            <!-- Badge with larger SVG -->
            <div class="w-20 h-20 flex items-center justify-center rounded-lg bg-blue-500 text-white mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-12 h-12">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                </svg>
            </div>
            <!-- Text beside SVG -->
            <div class="flex flex-col justify-center">
                <div class="font-bold text-xl text-gray-800 mb-1 text-center">Service List</div>
                <div class="text-gray-700 text-3xl font-bold mb-2">
                    {{ $totalServices }} <!-- Display total services -->
                </div>
          
            </div>
        </div>
    </div>

<!-- Users Card -->
<div class="max-w-sm rounded overflow-hidden shadow-lg bg-white p-6">
    <div class="flex items-center mb-4">
        <!-- Badge with larger SVG -->
        <div class="w-20 h-20 flex items-center justify-center rounded-lg bg-pink-500 text-white mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
            </svg>
        </div>
        <!-- Text beside SVG -->
        <div class="flex flex-col justify-center">
            <div class="font-bold text-xl text-gray-800 mb-1 text-center">User List</div>
            <div class="text-gray-700 text-3xl font-bold mb-2">
                {{ $totalUsers }} <!-- Display total services -->
            </div>
        </div>
    </div>
</div>


                    
                
                  
    
                </div>
          
        </div>
    </div>
    
</x-app-layout>
