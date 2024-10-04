    <!-- Modal -->
    <div id="createModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-xl w-full">
            <h3 id="modalTitle" class="text-lg font-semibold mb-4">Add New Service</h3>
            <form id="createStocksForm">
                <input type="hidden" id="stockId" name="id">
                <input type="hidden" id="productId" name="productId">
                <!-- Form fields as you have defined -->
                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                </div>
                <div class="mb-4">
                    <label for="stockDate" class="block text-sm font-medium text-gray-700">Stock Date</label>
                    <input type="date" id="stockDate" name="stockDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                </div>

                <div class="flex justify-end">
                    <button type="button" id="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal -->
    <div id="viewModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <h3 class="text-lg font-semibold mb-4">Service Details</h3>
            <div id="serviceDetails">
                <!-- Details will be dynamically added here -->
            </div>
            <div class="flex justify-end">
                <button type="button" id="closeViewModal" class="bg-gray-500 text-white px-4 py-2 rounded-md">Close</button>
            </div>
        </div>
    </div>