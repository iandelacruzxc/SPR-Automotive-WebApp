@include('users.nav')


<div class="container mx-auto p-4">
    <!-- Container for the Appointment Form -->
    <div class="mx-14 mt-10 bg-white rounded-lg shadow-lg">
        <!-- Contact Us Title -->
        <!-- Make an Appointment Title -->
        <div class="mt-3 text-center text-4xl font-bold">Make an Appointment</div>


        <!-- Form Section -->
        <div class="p-8">
            <form id="appointmentForm"> <!-- Added form ID here -->
                <!-- Notice for Occupied Dates -->
                <div id="notice-message" class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 flex items-center">
                    <i class="fas fa-exclamation-triangle text-2xl ml-3"></i> <!-- Notice icon on the right -->
                    <div class="flex-grow text-center"> <!-- Center text -->
                        <p class="font-semibold text-lg">Notice:</p>
                        <p>If there are already 5 occupied dates, you cannot book an appointment.</p>
                    </div>
                    <!-- <i class="fas fa-exclamation-triangle text-2xl ml-3"></i> Notice icon on the right -->
                </div>

                <div id="form-container" class="my-6 flex flex-col gap-4"> <!-- Wrap the form fields -->
                    <div class="my-6">
                        <label for="service" class="block text-sm font-semibold text-gray-700 mb-1">Select Service *</label>
                        <select name="service" id="service"
                            class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2 placeholder-slate-400 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500"
                            required>
                            <option value="" disabled selected>Select a service</option>
                            <!-- Dynamic options will be appended here -->
                        </select>
                    </div>
                    <!-- Date Picker -->
                    <div id="datepicker-container">
                        <label for="appointment_datetime" class="block text-sm font-semibold text-gray-700 mb-1">Select Date *</label>
                        <input type="text" id="datepicker" name="appointment_datetime"
                            class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2 placeholder-slate-400 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 sm:text-sm" placeholder="Select a date" required />
                        <label id="status-label" class="block text-sm font-semibold text-red-600 mt-1">Red = Occupied</label> <!-- Enhanced Status label -->
                    </div>

                    <div class="my-6">
                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-1">Message *</label>
                        <textarea name="message" id="message" cols="30" rows="10"
                            class="mb-10 h-40 w-full resize-none rounded-md border border-slate-300 p-5 font-semibold text-gray-500 placeholder-slate-400 focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500"
                            placeholder="Type your message here..." required></textarea>
                    </div>

                    <!-- Book Appointment Button -->
                    <div class="text-center">
                        <button type="submit" class="rounded-lg bg-blue-700 px-8 py-5 text-sm font-semibold text-white hover:bg-blue-800">Book Appointment</button>
                    </div>
                </div>
            </form>

        </div>

    </div>
</div>
</div>

</main>

@include('users.user-script')


</body>

</html>