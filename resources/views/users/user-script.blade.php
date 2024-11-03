<script src="{{ asset('js/jquery.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/Datatables/datatables.js') }}"></script>


<script>
    $(document).ready(function() {
        let currentIndex = 0;
        const itemsPerView = 4; // Number of visible cards at a time
        const totalItems = $('.carousel-item').length;
        const totalPages = Math.ceil(totalItems / itemsPerView);

        // Dynamically create dots based on total pages
        for (let i = 0; i < totalPages; i++) {
            $('.indicator-container').append(
                `<span class="dot w-3 h-3 bg-gray-400 rounded-full mx-1 cursor-pointer" data-slide="${i}"></span>`
            );
        }

        // Update carousel function
        function updateCarousel() {
            const offset = -(currentIndex * 100) / itemsPerView;
            $('.carousel-track').css('transform', `translateX(${offset}%)`);

            // Update dots
            $('.dot').removeClass('active');
            const activeIndex = Math.floor(currentIndex / itemsPerView);
            $('.dot').eq(activeIndex).addClass('active');
        }

        // Next Button
        $('#nextBtn').click(function() {
            if (currentIndex >= totalItems - itemsPerView) {
                currentIndex = 0; // Reset to first card when last card is reached
            } else {
                currentIndex++;
            }
            updateCarousel();
        });

        // Previous Button
        $('#prevBtn').click(function() {
            if (currentIndex <= 0) {
                currentIndex = totalItems - itemsPerView; // Jump to the last card from the first
            } else {
                currentIndex--;
            }
            updateCarousel();
        });

        // Dots click event
        $('.dot').click(function() {
            const slideIndex = $(this).data('slide') * itemsPerView;
            currentIndex = slideIndex;
            updateCarousel();
        });

        // Initial setup for indicators
        $('.dot').eq(0).addClass('active');

        document.getElementById('hamburgerButton').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('hidden');
        });
    });

    function updateQuantity(id, change) {
        if (!id) {
            console.error("Product ID is missing!");
            return;
        }

        // Send AJAX request to update the quantity
        fetch(`/user/cart/update/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    change: change
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Reload the cart or update the displayed cart items dynamically
                location.reload(); // Reload the page to reflect the changes
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    }


    // Set the minimum date and time to the current date and time
    function setMinDateTime() {
        const now = new Date();
        // Format the date and time to YYYY-MM-DDTHH:mm
        const formattedDate = now.toISOString().slice(0, 16);
        $('#appointment_datetime').attr('min', formattedDate);
    }

    setMinDateTime(); // Set the minimum date and time on page load

    $('#appointmentForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Get the selected date and time
        const appointmentDateTime = new Date($('#appointment_datetime').val());
        const now = new Date();

        // Check if the selected date and time are in the past
        if (appointmentDateTime < now) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Date and Time',
                text: 'Please select a date and time that is in the future.',
                confirmButtonText: 'OK'
            });
            return; // Stop form submission
        }


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Get form data
        var formData = $(this).serialize();

        $.ajax({
            url: '/user/appointment', // This is the correct route for storing appointments
            type: 'POST',
            data: formData,
            beforeSend: function() {
                // Show the loading SweetAlert
                Swal.fire({
                    title: 'Saving...',
                    text: 'Please wait while we process your request.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading(); // Display loading spinner
                    }
                });
            },
            success: function(response) {
                // Close loading alert
                Swal.close();

                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Appointment Booked',
                    text: response.message,
                    confirmButtonText: 'OK'
                });

                // Clear the form fields
                $('#appointment_datetime').val('');
                $('#message').val('');
                $('#service').val('');
            },
            error: function(xhr) {
                // Close loading alert
                Swal.close();

                // Show error message
                var errorMessage = xhr.responseJSON?.message || 'An unknown error occurred.';
                Swal.fire({
                    icon: 'error',
                    title: 'Error Booking Appointment',
                    text: errorMessage,
                    confirmButtonText: 'OK'
                });
            }
        });

    });



    function formatDate(dateString) {
        const options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            hour12: true
        };
        const date = new Date(dateString);
        return date.toLocaleString('en-US', options);
    }

    $(document).ready(function() {
        $('#appointmentsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('/user/appointment-history') }}", // Your new route
                type: 'GET'
            },
            columns: [{
                    data: 'user.name',
                    name: 'user.name'
                },
                {
                    data: 'service.name',
                    name: 'service.name'
                },
                {
                    data: 'message',
                    name: 'message'
                },
                {
                    data: 'appointment_date',
                    name: 'appointment_date',
                    render: function(data) {
                        return formatDate(data); // Formats the date
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data) {
                        let badgeColor;
                        let badgeText;

                        switch (data) {
                            case 'pending':
                                badgeColor = 'bg-orange-200 text-orange-800';
                                badgeText = 'Pending';
                                break;
                            case 'confirmed':
                                badgeColor = 'bg-blue-200 text-blue-800';
                                badgeText = 'Confirmed';
                                break;
                            case 'completed':
                                badgeColor = 'bg-green-200 text-green-800';
                                badgeText = 'Completed';
                                break;
                            case 'canceled':
                                badgeColor = 'bg-red-200 text-red-800';
                                badgeText = 'Canceled';
                                break;
                            default:
                                badgeColor = 'bg-gray-200 text-gray-800';
                                badgeText = 'Unknown';
                                break;
                        }

                        return `<span class="${badgeColor} px-2 py-1 rounded-full text-xs font-semibold">${badgeText}</span>`;
                    }
                }
            ],
            "info": false, // Disable the information display
            "order": [
                [2, 'desc'] // Order by the appointment date (third column)
            ]
        });



    });

    document.addEventListener('DOMContentLoaded', function() {
        // Fetch services when the page loads
        fetch('/options?models[]=services')
            .then(response => response.json())
            .then(data => {
                const serviceSelect = document.getElementById('service');
                if (data.services) {
                    data.services.forEach(service => {
                        const option = document.createElement('option');
                        option.value = service.id;
                        option.textContent = service.name;
                        serviceSelect.appendChild(option);
                    });

                    // Auto-select the service based on the query parameter
                    const urlParams = new URLSearchParams(window.location.search);
                    const serviceId = urlParams.get('service_id'); // Get service_id from URL

                    if (serviceId) {
                        serviceSelect.value = serviceId; // Set the dropdown to the selected service
                    }
                } else {
                    console.error('No services found.');
                }
            })
            .catch(error => {
                console.error('Error fetching services:', error);
            });
    });


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