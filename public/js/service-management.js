$(document).ready(function() {
    var table = $('#example').DataTable({
        "paging": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/services/data",
            "type": "GET" // Use GET method for fetching data
        },
        "columnDefs": [
            { "className": "custom-align-left", "targets": 2 } // Apply custom alignment to the 'price' column (3rd column, zero-based index)
        ],
        "columns": [
            { "data": "name" },
            { "data": "description" },
            { "data": "price" },
            { 
                "data": "status", 
                "render": function (data) {
                    var statusText = '';
                    var statusClass = '';
            
                    if (data == 1) {
                        statusText = 'Active';
                        statusClass = 'bg-green-500 text-white border border-green-700'; // Tailwind class for green background with a border
                    } else if (data == 2) {
                        statusText = 'Inactive';
                        statusClass = 'bg-red-500 text-white border border-red-700'; // Tailwind class for red background with a border
                    }
            
                    return `<span class="inline-block px-3 py-1 rounded-full text-xs font-semibold ${statusClass}">${statusText}</span>`;
                }
            },
            
            
            { "data": null, 
                "defaultContent": `
                    <div class="flex space-x-2">
                        <button class="view text-gray-500 hover:text-gray-700 mr-2" title="View">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="edit text-green-500 hover:text-gray-700 mr-2" title="Edit">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button class="delete text-red-600 hover:text-red-800" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                `
            }
        ], 
        "pageLength": 10, // Set default page length
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ] // Page length options
    });

    // Handle Form Submission
    $('#createServiceForm').on('submit', function(e) {
        e.preventDefault();
    
        // var formData = $(this).serialize();
        // var serviceId = $('#serviceId').val();
        // var url = serviceId ? '/services/update/' + serviceId : '/services';
        // var method = serviceId ? 'PUT' : 'POST';
    
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });

        var serviceId = $('#serviceId').val();
        var url = serviceId ? '/services/' + serviceId : '/services'; // URL for update or create
        var method = serviceId ? 'POST' : 'POST'; // Using POST; _method will handle it
        
        var formData = new FormData(this); // Using FormData to include files
    
        if (serviceId) {
            formData.append('_method', 'PUT'); // Laravel requires this for PUT requests
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    

        $.ajax({
            url: url,
            method: method, // Change this to method
            data: formData,
            contentType: false, // Prevent jQuery from setting the content-type header
            processData: false, // Prevent jQuery from processing the data
            success: function(response) {
                $('#createModal').addClass('hidden');
                Swal.fire({
                    icon: 'success',
                    title: serviceId ? 'Updated!' : 'Added!',
                    text: serviceId ? 'The service has been updated successfully.' : 'The service has been added successfully.'
                }).then(() => {
                    // $('#createModal').addClass('hidden');
                    $('#createServiceForm')[0].reset();
                    table.ajax.reload(); // Reload the DataTable with new data
                });

            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Error occurred while saving the service. ' + xhr.responseText
                });
            }
        });
    });
    

    // Handle Create Button Click
    $('#createButton').on('click', function() {
        $('#createModal').removeClass('hidden');
        $('#modalTitle').text('Create Service');
        $('#serviceId').val(''); // Clear ID for new service
        $('#createServiceForm')[0].reset(); // Reset form fields
    });

    // Handle Close Modal Click
    $('#closeModal').on('click', function() {
        $('#createModal').addClass('hidden');
    });

    // Handle view button click
    // $('#example').on('click', '.view', function() {
    //     var rowData = table.row($(this).parents('tr')).data();
       
    //     // Populate the modal with data
    //     $('#serviceDetails').html(`
    //         <p><strong>Name:</strong> ${rowData.name}</p>
    //         <p><strong>Description:</strong> ${rowData.description}</p>
    //         <p><strong>Price:</strong> ${rowData.price}</p>
    //         <p><strong>Status:</strong> ${rowData.status ? 'Active' : 'Inactive'}</p>
    //     `);
       
    //     // Show the modal
    //     $('#viewModal').removeClass('hidden');
    // });

    // Close the view modal
    $('#closeViewModal').on('click', function() {
        $('#viewModal').addClass('hidden');
    });

    // Click outside to close open menus and modals
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.view, .action-button').length) {
            $('.action-menu').addClass('hidden');
            $('#viewModal').addClass('hidden');
        }
    });

    // Handle action button clicks
    $('#example').on('click', 'button', function(e) {
        e.preventDefault();
        var action = $(this).attr('class');
        var rowData = table.row($(this).parents('tr')).data();

        switch(true) {
            case action.includes('view'):
                $('#serviceDetails').html(`
                    <p><strong>Name:</strong> ${rowData.name}</p>
                    <p><strong>Description:</strong> ${rowData.description}</p>
                    <p><strong>Price:</strong> ${rowData.price}</p>
                    <p><strong>Status:</strong> ${rowData.status ? 'Active' : 'Inactive'}</p>
                `);
                $('#viewModal').removeClass('hidden');
                break;
            case action.includes('edit'):
                $('#modalTitle').text('Edit Service');
                $('#serviceId').val(rowData.id);
                $('#name').val(rowData.name);
                $('#description').val(rowData.description);
                $('#price').val(rowData.price);
                $('#status').val(rowData.status);
                $('#createModal').removeClass('hidden');
                break;
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
                            url: '/services/' + rowData.id, // Adjust URL as needed
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    'The service has been deleted.',
                                    'success'
                                );
                                table.ajax.reload(); // Reload DataTable
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'There was an issue deleting the service.',
                                    'error'
                                );
                            }
                        });
                    }
                });
                break;
        }
        $(this).closest('.action-menu').addClass('hidden');
    });

});
