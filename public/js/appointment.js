$(document).ready(function () {

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
    var table = $('#example').DataTable({
        "paging": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "admin-appointment",
            "type": "GET" // Use GET method for fetching data
        },
        "columns": [
            { "data": "user.name" },
            { "data": "service.name" },
            { "data": "message" },
            {
                data: 'appointment_date',
                name: 'appointment_date',
                render: function (data) {
                    return formatDate(data); // Formats the date
                }
            },
            {
                data: 'status',
                name: 'status',
                render: function (data) {
                    // Create a badge for the status
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

                    // Return the badge for the status
                    return `<span class="${badgeColor} px-2 py-1 rounded-full text-xs font-semibold">${badgeText}</span>`;
                }
            },
            {
                data: 'status',
                name: 'status',
                render: function (data, type, row) {
                    // Create the status dropdown for changing status
                    let statusDropdown = `
                        <div>
                            <select class="status-dropdown" data-id="${row.id}">
                                <option value="" disabled ${row.status ? '' : 'selected'}>Select Status</option>
                                <option value="pending" ${row.status === 'pending' ? 'selected' : ''}>Pending</option>
                                <option value="confirmed" ${row.status === 'confirmed' ? 'selected' : ''}>Confirmed</option>
                                <option value="completed" ${row.status === 'completed' ? 'selected' : ''}>Completed</option>
                                <option value="canceled" ${row.status === 'canceled' ? 'selected' : ''}>Canceled</option>
                            </select>
                        </div>
                    `;
                    return statusDropdown; // Return only the dropdown
                }
            },


        ],
        "pageLength": 10, // Set default page length
        "info": false, // Disable the information display
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]] // Page length options
    });


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('change', '.status-dropdown', function () {
        var appointmentId = $(this).data('id');
        var newStatus = $(this).val();
        var $dropdown = $(this); // Store reference to dropdown for later

        // Use SweetAlert for confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to change the status to " + newStatus + ".",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed the change, send AJAX request
                $.ajax({
                    url: '/admin-appointment/' + appointmentId, // Use resource route
                    method: 'PUT', // Since it's a resource route, use PUT for updates
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        status: newStatus
                    },
                    success: function (response) {
                        Swal.fire(
                            'Updated!',
                            'The status has been changed to ' + newStatus + '.',
                            'success'
                        );
                        $('#example').DataTable().ajax.reload(); // Reload the DataTable to reflect the changes
                    },
                    error: function (xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'There was an issue updating the status. Please try again.',
                            'error'
                        );
                        // Revert dropdown to original value if error occurs
                        $dropdown.val($dropdown.data('original-status'));
                    }
                });
            } else {
                // User canceled, revert the dropdown to the original value
                $dropdown.val($dropdown.data('original-status'));
            }
        });
    });

    // Store original status value when dropdown is focused (before change)
    $(document).on('focus', '.status-dropdown', function () {
        $(this).data('original-status', $(this).val());
    });


});
