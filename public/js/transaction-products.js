$(document).ready(function () {
    var table = $("#example").DataTable({
        paging: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "/transaction-products",
            type: "GET", // Use GET method for fetching data
        },
        columns: [
            { data: "name" },
            { data: "quantity" },
            { data: "price" },
            {
                data: null,
                render: function (data, type, row) {
                    return `
                        <div class="flex justify-center space-x-2">
                            <button class="delete text-gray-500 hover:text-gray-700 mr-2" data-id="${row.id}" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                },
            },
        ],
        pageLength: 10, // Set default page length
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
        ], // Page length options
    });

    var transactionId = document.getElementById("transaction-id").value;
    console.log(transactionId);
    // Use this productId in your DataTable initialization
    var table = $("#inventoryTable").DataTable({
        paging: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "/inventory/" + transactionId,
            type: "GET",
        },
        columns: [{ data: "stock_date" }, { data: "quantity" }],
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
        ],
    });

    // ADD AND EDIT
    $("#createStocksForm").on("submit", function (e) {
        e.preventDefault();

        var stockId = $("#stockId").val();
        var productId = $("#productId").val();
        var url = stockId ? "/inventory/" + stockId : "/inventory"; // URL for update or create

        var method = stockId ? "POST" : "POST"; // Using POST; _method will handle it

        var formData = new FormData(this); // Using FormData to include files

        if (stockId) {
            formData.append("_method", "PUT"); // Laravel requires this for PUT requests
        }

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url: url,
            method: method, // Change this to method
            data: formData,
            contentType: false, // Prevent jQuery from setting the content-type header
            processData: false, // Prevent jQuery from processing the data
            success: function (response) {
                $("#createModal").addClass("hidden");
                Swal.fire({
                    icon: "success",
                    title: stockId ? "Updated!" : "Created!",
                    text: stockId
                        ? "The stocks has been updated successfully."
                        : "The stocks has been created successfully.",
                }).then(() => {
                    // $('#createModal').addClass('hidden'); // Hide the modal

                    $("#createStocksForm")[0].reset(); // Reset the form
                    $("#imagePreview").addClass("hidden"); // Hide the image preview
                    table.ajax.reload(); // Reload the DataTable with new data
                });
            },
            error: function (xhr) {
                var errorMessage = "Error occurred while saving the stocks.";
                if (xhr.status === 422) {
                    // Validation error from Laravel
                    var errors = xhr.responseJSON.errors;
                    errorMessage =
                        "Validation error(s):\n" +
                        Object.values(errors)
                            .map(function (error) {
                                return error[0]; // Show the first validation error for each field
                            })
                            .join("\n");
                }
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: errorMessage,
                });
            },
        });
    });

    // Handle Create Button Click
    $("#createButton").on("click", function () {
        $("#createModal").removeClass("hidden");
        $("#modalTitle").text("Add Stocks");
        $("#stockId").val("");
        $("#createStocksForm")[0].reset();
    });

    // Close modal button functionality
    $("#closeModal").on("click", function () {
        $("#createModal").addClass("hidden");
    });

    $("#createButton").on("click", function () {
        var productId = $(this).data("product-id"); // Get the product ID from the button
        $("#productId").val(productId); // Set the product ID in the hidden input in the modal
        $("#createModal").removeClass("hidden"); // Show the modal
    });
});
