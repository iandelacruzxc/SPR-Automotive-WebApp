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
                        <div class="col-span-2">
                            <label for="code" class="block text-sm text-gray-700">Transaction Code</label>
                            <input type="text" id="code" name="code"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
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
                        </div>
                        <div class="">
                            <label for="date_in" class="block text-sm text-gray-700">Date In</label>
                            <input type="datetime-local" id="date_in" name="date_in"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm" required>
                        </div>
                        <div class="">
                            <label for="date_out" class="block text-sm text-gray-700">Date Out</label>
                            <input type="datetime-local" id="date_out" name="date_out"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                        </div>
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

    <!-- Modal -->
    <div id="viewModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <h3 class="text-lg font-semibold mb-4">Transaction Details</h3>
            <div id="transactionDetails">
                <!-- Details will be dynamically added here -->
            </div>
            <div class="flex justify-end">
                <button type="button" id="closeViewModal"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md">Close</button>
            </div>
        </div>
    </div>
