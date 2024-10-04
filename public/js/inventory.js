$(document).ready(function () {


    var table = $('#example').DataTable({
        "paging": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/inventory",
            "type": "GET" // Use GET method for fetching data
        },
        "columnDefs": [
            { "className": "custom-align-left", "targets": [2, 0] } // Apply custom alignment to specific columns
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
            { "data": "quantity" },
            { "data": "quantity" },
            {
                "data": null, 
                "render": function(data, type, row) {
                    return `
                        <div class="flex justify-center space-x-2">
                            <button class="view text-gray-500 hover:text-gray-700 mr-2" data-id="${row.id}" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ], 
        "pageLength": 10, // Set default page length
        
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ] // Page length options
    });
    
    $(document).on('click', '.view', function() {
        var productId = $(this).data('id');
        // Redirect to the show page for the selected product
        window.location.href = '/inventory/' + productId;
    });

    var productId = document.getElementById('product-id').value;
    console.log(productId)
    // Use this productId in your DataTable initialization
    var table = $('#inventoryTable').DataTable({
        "paging": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/inventory/" + productId,
            "type": "GET"
        },
        "columns": [
            { "data": "stock_date" },
            { "data": "quantity" }
        ],
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });

      // ADD AND EDIT 
      $('#createStocksForm').on('submit', function(e) {
        e.preventDefault();
        
        var stockId = $('#stockId').val();
        var productId = $('#productId').val();
        var url = stockId ? '/inventory/' + stockId : '/inventory'; // URL for update or create
        
        var method = stockId ? 'POST' : 'POST'; // Using POST; _method will handle it
        
        var formData = new FormData(this); // Using FormData to include files
    
        if (stockId) {
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
                    title: stockId ? 'Updated!' : 'Created!',
                    text: stockId ? 'The stocks has been updated successfully.' : 'The stocks has been created successfully.'
                }).then(() => {
                    // $('#createModal').addClass('hidden'); // Hide the modal
                
                    $('#createStocksForm')[0].reset(); // Reset the form
                    $('#imagePreview').addClass('hidden'); // Hide the image preview
                    table.ajax.reload(); // Reload the DataTable with new data
                });
            },
            error: function(xhr) {
                var errorMessage = 'Error occurred while saving the stocks.';
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
    $('#createButton').on('click', function () {
        $('#createModal').removeClass('hidden');
        $('#modalTitle').text('Add Stocks');
        $('#stockId').val('');
        $('#createStocksForm')[0].reset();
    });

    // Close modal button functionality
    $('#closeModal').on('click', function () {
        $('#createModal').addClass('hidden');
    });


    $('#createButton').on('click', function() {
        var productId = $(this).data('product-id'); // Get the product ID from the button
        $('#productId').val(productId); // Set the product ID in the hidden input in the modal
        $('#createModal').removeClass('hidden'); // Show the modal
    });


  
    
    
   
    
    

});
