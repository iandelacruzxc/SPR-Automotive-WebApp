    <!-- Modal -->
    <div id="createModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-4 rounded-lg shadow-lg max-w-5xl w-full">
            <h3 id="modalTitle" class="text-lg font-bold mb-4">Add New Transaction</h3>
            <form id="createTransactionForm">
                <div id="modalBody" class="h-[28rem] pl-4 overflow-y-scroll">
                    <input type="hidden" id="transactionId" name="transactionId">
                    <!-- Form fields as you have defined -->
                    <div class="font-semibold mb-4">Client Information</div>
                    <div class="grid grid-cols-2 gap-2 mb-8">
                        <div class="col-span-2">
                            <label for="client_name" class="block text-sm text-gray-700">Client
                                Name</label>
                            <input type="text" id="client_name" name="client_name"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                        </div>
                        <div class="col-span-2">
                            <label for="unit" class="block text-sm text-gray-700">Unit/Year
                                Model</label>
                            <input type="text" id="unit" name="unit"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                        </div>
                        <div>
                            <label for="plate_no" class="block text-sm text-gray-700">Plate No.</label>
                            <input type="text" id="plate_no" name="plate_no"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                        </div>
                        <div>
                            <label for="color" class="block text-sm text-gray-700">Color</label>
                            <input type="text" id="color" name="color"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                        </div>
                        <div class="col-span-2">
                            <label for="address" class="block text-sm text-gray-700">Address</label>
                            <textarea id="address" name="address" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required></textarea>
                        </div>
                        <div>
                            <label for="contact" class="block text-sm text-gray-700">Contact No.</label>
                            <input type="text" id="contact" name="contact"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm text-gray-700">Email</label>
                            <input type="text" id="email" name="email"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                        </div>
                    </div>

                    <div class="font-semibold mb-4">Transaction Details</div>
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        {{-- <div class="col-span-2">
                            <label for="code" class="block text-sm text-gray-700">Transaction Code</label>
                            <input type="text" id="code" name="code"
                                class="mt-1 block w-full read-only:border-gray-300 rounded-md shadow-sm sm:text-sm" readonly>
                        </div>
                        <div class="">
                            <label for="mechanic_id" class="block text-sm text-gray-700">Mechanic</label>
                            <select id="mechanic_id" name="mechanic_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                                <option value="" selected>--</option>
                            </select>
                        </div>
                        <div class="">
                            <label for="downpayment" class="block text-sm text-gray-700">Downpayment</label>
                            <input type="number" id="downpayment" name="downpayment"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                        </div> --}}
                        <div class="">
                            <label for="date_in" class="block text-sm text-gray-700">Date In</label>
                            <input type="datetime-local" id="date_in" name="date_in"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                        </div>
                        {{-- <div class="">
                            <label for="date_out" class="block text-sm text-gray-700">Date Out</label>
                            <input type="datetime-local" id="date_out" name="date_out"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                        </div> --}}
                        <div class="">
                            <label for="status" class="block text-sm text-gray-700">Status</label>
                            <select id="status" name="status"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                                <option value="Pending" selected>Pending</option>
                                <option value="Processing">Processing</option>
                                <option value="Done">Done</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end border-t-1 pt-2">
                    <button type="button" id="closeModal"
                        class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-4 rounded-lg shadow-lg max-w-5xl w-full">
            <h3 id="editModalTitle" class="text-lg font-bold mb-4">Edit Transaction</h3>
            <form id="editTransactionForm">
                <div id="editModalBody" class="h-[28rem] pl-4 overflow-y-scroll">
                    <input type="hidden" id="editTransactionId" name="transactionId">
                    <!-- Form fields (same as the create modal, but with different IDs for the inputs) -->
                    <div class="font-semibold mb-4">Client Information</div>
                    <div class="grid grid-cols-2 gap-2 mb-8">
                        <div class="col-span-2">
                            <label for="edit_client_name" class="block text-sm text-gray-700">Client
                                Name</label>
                            <input type="text" id="edit_client_name" name="client_name"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                        </div>
                        <div class="col-span-2">
                            <label for="edit_unit" class="block text-sm text-gray-700">Unit/Year
                                Model</label>
                            <input type="text" id="edit_unit" name="unit"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                        </div>
                        <div>
                            <label for="edit_plate_no" class="block text-sm text-gray-700">Plate No.</label>
                            <input type="text" id="edit_plate_no" name="plate_no"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                        </div>
                        <div>
                            <label for="edit_color" class="block text-sm text-gray-700">Color</label>
                            <input type="text" id="edit_color" name="color"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                        </div>
                        <div class="col-span-2">
                            <label for="edit_address" class="block text-sm text-gray-700">Address</label>
                            <textarea id="edit_address" name="address" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required></textarea>
                        </div>
                        <div>
                            <label for="edit_contact" class="block text-sm text-gray-700">Contact No.</label>
                            <input type="text" id="edit_contact" name="contact"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                        </div>
                        <div>
                            <label for="edit_email" class="block text-sm text-gray-700">Email</label>
                            <input type="text" id="edit_email" name="email"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                        </div>
                    </div>

                    <div class="font-semibold mb-4">Transaction Details</div>
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <div class="">
                            <label for="edit_date_in" class="block text-sm text-gray-700">Date In</label>
                            <input type="datetime-local" id="edit_date_in" name="date_in"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                        </div>
                        <div class="">
                            <label for="edit_status" class="block text-sm text-gray-700">Status</label>
                            <select id="edit_status" name="status"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                                <option value="Pending">Pending</option>
                                <option value="Processing">Processing</option>
                                <option value="Done">Done</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end border-t-1 pt-2">
                    <button type="button" id="closeEditModal"
                        class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div id="addProductModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-4 rounded-lg shadow-lg max-w-lg w-full">
            <h3 id="addProductModalTitle" class="text-lg font-bold mb-4">Add Product</h3>
            <form id="addTransactionProductForm">
                <div id="addProductModalBody" class="pl-4 overflow-y-scroll">
                    <div class="mb-2">
                        <label for="product_id" class="block text-sm text-gray-700">Product</label>
                        <select id="product_id" name="product_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                            <option value="">--</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="p_price" class="block text-sm text-gray-700">Price</label>
                        <input type="number" id="p_price" name="p_price"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" readonly
                            required>
                    </div>
                    <div class="mb-2">
                        <label for="quantity" class="block text-sm text-gray-700">Quantity</label>
                        <input type="number" id="quantity" name="quantity"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                    </div>
                </div>
                <div class="flex justify-end border-t-1 pt-2">
                    <button type="button" id="closeAddProductModal"
                        class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Service Modal -->
    <div id="addServiceModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-4 rounded-lg shadow-lg max-w-lg w-full">
            <h3 id="addServiceModalTitle" class="text-lg font-bold mb-4">Add Service</h3>
            <form id="addTransactionServiceForm">
                <div id="addServiceModalBody" class="pl-4 overflow-y-scroll">
                    <div class="mb-2">
                        <label for="service_id" class="block text-sm text-gray-700">Service</label>
                        <select id="service_id" name="service_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                            <option value="">--</option>
                        </select>
                    </div>
                    <div class="">
                        <label for="price" class="block text-sm text-gray-700">Price</label>
                        <input type="number" id="price" name="price"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" readonly
                            required>
                    </div>
                </div>
                <div class="flex justify-end border-t-1 pt-2">
                    <button type="button" id="closeAddServiceModal"
                        class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Submit</button>
                </div>
            </form>
        </div>
    </div>
