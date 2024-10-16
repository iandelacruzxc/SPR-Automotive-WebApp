@include('users.nav')

<div class="container mx-auto p-4">
    <!-- Container for the Appointment History Table -->
    <div class="mx-14 mt-10 bg-white rounded-lg shadow-lg p-6"> <!-- Added padding to the card -->
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Appointment History</h2> <!-- Added margin-bottom to the title -->

        <table id="appointmentsTable" class="min-w-full bg-white rounded-lg shadow-lg border border-gray-200"> <!-- Added border for better visibility -->
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">Name</th>
                <th class="py-3 px-6 text-left">Services</th>
                    <th class="py-3 px-6 text-left">Message</th>
                    <th class="py-3 px-6 text-left">Appointment Date</th>
                    <th class="py-3 px-6 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
          
            </tbody>
        </table>
    </div>
</div>
</main>

@include('users.user-script')


</body>

</html>