<!-- Modal -->
<div id="createModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-2xl w-full relative">
        <h3 id="modalTitle" class="text-lg font-semibold mb-4">Add New Product</h3>
    <form id="createProductForm" class="flex flex-col md:flex-row pb-20" enctype="multipart/form-data">
        <div class="w-full md:w-2/3 pr-4">
            <input type="hidden" id="productId" name="id">
            <!-- Form fields -->
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
                    <option value="" disabled selected>Select status</option>
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                </select>
            </div>
            
        </div>

        <!-- Image Upload Section on the Right -->
        <div class="w-full md:w-1/3 flex flex-col items-center">
            <div class="mb-4 w-full">
                <label for="image" class="block text-sm font-medium text-gray-700">Upload Image</label>
                <input type="file" id="imageUpload" name="image" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" accept="image/*" onchange="previewImage(event)">
            </div>

            <!-- Image Preview -->
            <div class="mb-4 w-full h-40 bg-gray-100 flex items-center justify-center border border-gray-300 rounded-md shadow-sm">
                <img id="imagePreview" src="" alt="Image Preview" class="max-h-full max-w-full object-cover hidden">
            </div>
        </div>


            <!-- Footer with buttons -->
        <div class="absolute bottom-0 left-0 right-0 bg-gray-100 p-4 flex justify-end">
            <button type="button" id="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">Cancel</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save</button>
        </div>
        </form>

    </div>
</div>

<!-- Modal -->
<div id="viewModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-xl w-full"> <!-- This is where you change the size -->
        <h3 class="text-lg font-semibold mb-4">Product Details</h3>
        <div id="productDetails"></div>
        <div class="flex justify-end">
            <button type="button" id="closeViewModal" class="bg-gray-500 text-white px-4 py-2 rounded-md">Close</button>
        </div>
    </div>
</div>




