    
<!-- Modal -->
<div id="createModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-xl w-full">
        <h3 id="modalTitle" class="text-lg font-semibold mb-4">Add New Service</h3>
        <form id="createServiceForm">
            <input type="hidden" id="serviceId" name="id">
            <!-- Form fields as you have defined -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required></textarea>
            </div>
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" id="price" name="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
            </div>
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                </select>
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
