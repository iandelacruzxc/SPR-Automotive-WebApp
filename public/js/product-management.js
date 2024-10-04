$(document).ready(function() {
    var table = $('#example').DataTable({
        "paging": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/products",
            "type": "GET" // Use GET method for fetching data
        },
        "columnDefs": [
            { "className": "custom-align-left", "targets": [2,0] } // Apply custom alignment to the 'price' column (3rd column, zero-based index)
        ],
        "columns": [
            { 
                "data": null, // This column will be for the row number
                "render": function (data, type, row, meta) {
                    return meta.row + 1; // Returns the row number starting from 1
                }
            },
            { 
                "data": "image_path",
                "render": function (data) {
                    // Adjust this URL to match your application's URL structure
                    const imageUrl = `http://127.0.0.1:8000/storage/${data}`;
                    return `<img src="${imageUrl}" alt="Product Image" class="w-20 h-20 object-cover rounded-md">`;
                }
            },
            
            { "data": "name" },
            // { "data": "description" },
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
                        statusClass = 'bg-red-500 text-white border border-red-700'; // Updated Tailwind class for red background with a border
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


    

    // Handle action button clicks
    $('#example').on('click', 'button', function(e) {
        e.preventDefault();
        var action = $(this).attr('class');
        var rowData = table.row($(this).parents('tr')).data();
        console.log(rowData); // Check if data is retrieved correctly
        switch(true) {
            case action.includes('view'):
                if (rowData) {
                    $('#productDetails').html(`
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img src="http://127.0.0.1:8000/storage/${rowData.image_path}" alt="Product Image" class="w-20 h-20 object-cover rounded-md"> <!-- Fixed size -->
                            </div>
                            <div>
                                <p><strong>Name:</strong> ${rowData.name || 'N/A'}</p>
                                <p><strong>Description:</strong> ${rowData.description || 'N/A'}</p>
                                <p><strong>Price:</strong> ${rowData.price || 'N/A'}</p>
                                <p><strong>Status:</strong> ${rowData.status === 1 ? 'Active' : 'Inactive'}</p>
                            </div>
                        </div>
                    `);
                    
                    
                    
                    $('#viewModal').removeClass('hidden'); // Show the modal
                } else {
                    console.error("No row data found.");
                }
            break;
            case action.includes('edit'):
                $('#modalTitle').text('Edit Product'); // Set the modal title
                $('#productId').val(rowData.id); // Set the product ID
                $('#name').val(rowData.name); // Set the name
                $('#description').val(rowData.description); // Set the description
                $('#price').val(rowData.price); // Set the price
                $('#status').val(rowData.status); // Set the status
                $('#imagePreview').attr('src', `http://127.0.0.1:8000/storage/${rowData.image_path}`).removeClass('hidden'); // Show the current image
                $('#createModal').removeClass('hidden'); // Show the edit modal
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
                            url: '/products/' + rowData.id, // Adjust URL as needed
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire('Deleted!', 'The product has been deleted.', 'success');
                                table.ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire('Error!', 'There was an issue deleting the product.', 'error');
                            }
                        });
                    }
                });
                break;
        }
        $(this).closest('.action-menu').addClass('hidden');
    });

    // Close modal functionality
    $('#closeViewModal').on('click', function() {
        $('#viewModal').addClass('hidden');
    });

    $('#createProductForm').on('submit', function(e) {
        e.preventDefault();
        
        var productId = $('#productId').val();
        var url = productId ? '/products/' + productId : '/products'; // URL for update or create
        var method = productId ? 'POST' : 'POST'; // Using POST; _method will handle it
        
        var formData = new FormData(this); // Using FormData to include files
    
        if (productId) {
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
                    title: productId ? 'Updated!' : 'Created!',
                    text: productId ? 'The product has been updated successfully.' : 'The product has been created successfully.'
                }).then(() => {
                    // $('#createModal').addClass('hidden'); // Hide the modal
                
                    $('#createProductForm')[0].reset(); // Reset the form
                    $('#imagePreview').addClass('hidden'); // Hide the image preview
                    table.ajax.reload(); // Reload the DataTable with new data
                });
            },
            error: function(xhr) {
                var errorMessage = 'Error occurred while saving the product.';
                if (xhr.status === 422) { // Validation error from Laravel
                    var errors = xhr.responseJSON.errors;
                    errorMessage = 'Validation error(s):\n' + Object.values(errors).map(function(error) {
                        return error[0]; // Show the first validation error for each field
                    }).join('\n');
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMessage
                });
            }
        });
    });
    
    

    // Handle Create Button Click
    $('#createButton').on('click', function() {
        $('#createModal').removeClass('hidden');
        $('#modalTitle').text('Add New Product');
        $('#productId').val('');
        $('#createProductForm')[0].reset();
        $('#imagePreview').attr('src', '').addClass('hidden');
    });

    // Close modal button functionality
    $('#closeModal').on('click', function() {
        $('#createModal').addClass('hidden');
    });



});
