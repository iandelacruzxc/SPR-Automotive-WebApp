$(document).ready(function () {


    var table = $("#example").DataTable({
        paging: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "/customer-profile",
            type: "GET", // Use GET method for fetching data
        },
        columnDefs: [
            { className: "custom-align-left", targets: [2, 0] }, // Apply custom alignment to specific columns
        ],
        columns: [
            {
                data: null, // This column will be for the row number
                render: function (data, type, row, meta) {
                    return meta.row + 1; // Returns the row number starting from 1
                },
            },

            { data: "name" },
            { data: "email" },
            {
                "data": null,
                "render": function (data, type, row) {
                    if (window.userRole !== 'staff') {
                        return `
                    <div class="flex space-x-2">
                        <button class="delete text-red-600 hover:text-red-800" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                `;
                    } else {
                        return '';  // Return empty content if role is 'staff'
                    }
                }
            }

        ],
        pageLength: 10, // Set default page length

        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
        ], // Page length options
    });



    // Handle action button clicks
    $('#example').on('click', 'button', function (e) {
        e.preventDefault();
        var action = $(this).attr('class');
        var rowData = table.row($(this).parents('tr')).data();
        console.log(rowData); // Check if data is retrieved correctly
        switch (true) {

            case action.includes('delete'):
                // SweetAlert2 confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with the delete operation
                        $.ajax({
                            url: '/customer-profile/' + rowData.id, // Adjust URL as needed
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                Swal.fire('Deleted!', 'The product has been deleted.', 'success');
                                table.ajax.reload();
                            },
                            error: function (xhr) {
                                Swal.fire('Error!', 'There was an issue deleting the product.', 'error');
                            }
                        });
                    }
                });
                break;
        }
        $(this).closest('.action-menu').addClass('hidden');
    });



});
