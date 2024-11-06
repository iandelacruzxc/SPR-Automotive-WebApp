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
<script>
    // Get the appointment dates passed from the Laravel controller
    const appointments = @json($appointments); // Convert PHP array to JavaScript

    // Convert appointments to Date objects
    const disabledDates = appointments.map(date => moment(date).toDate());

    // Populate the occupied dates table
    const occupiedCountElement = document.getElementById('occupied-count');
    const occupiedDatesBody = document.getElementById('occupied-dates-body');
    const datePickerContainer = document.getElementById('datepicker-container');



    // Update the occupied count
    const occupiedCount = appointments.length;
    // occupiedCountElement.textContent = `${occupiedCount} occupied date(s)`;

    // Disable all dates if the number of occupied dates exceeds the threshold (5)
    const disableAllDates = occupiedCount >= 5;

    if (occupiedCount >= 5) {
        // Hide the form fields but keep the notice visible
        document.getElementById('form-container').style.display = 'none'; // Hide form fields
    } else {
        document.getElementById('form-container').style.display = 'flex'; // Show form fields
    }


    const picker = new Pikaday({
        field: document.getElementById('datepicker'),
        // Disable occupied dates
        disableDayFn: function(date) {
            // Return true if disabling all dates

            return disabledDates.some(disabledDate =>
                date.getFullYear() === disabledDate.getFullYear() &&
                date.getMonth() === disabledDate.getMonth() &&
                date.getDate() === disabledDate.getDate()
            );
        },
        format: 'YYYY-MM-DD',
        onDraw: function() {
            const days = document.querySelectorAll('.pika-day'); // Select all day elements
            days.forEach(day => {
                const dayNumber = parseInt(day.textContent, 10); // Get the day number
                const date = new Date(this.currentYear, this.currentMonth, dayNumber); // Create a date object

                // Check for occupied dates
                if (disabledDates.some(disabledDate =>
                        date.getFullYear() === disabledDate.getFullYear() &&
                        date.getMonth() === disabledDate.getMonth() &&
                        date.getDate() === disabledDate.getDate()
                    )) {
                    console.log(`Occupied Date Found: ${date.toLocaleDateString()}`); // Debug log
                    day.classList.add('is-occupied'); // Add red styling for occupied dates
                }

            });
        }
    });
</script>
@include('users.user-script')



</body>

</html>