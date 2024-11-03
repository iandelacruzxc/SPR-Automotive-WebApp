$(document).ready(function () {
    var transactionId = document.getElementById("transactionId").value;
    var productTable = $("#productTable").DataTable({
        paging: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "/transaction-products/" + transactionId,
            type: "GET", // Use GET method for fetching data
        },
        columns: [
            { data: "name" },
            { data: "price", orderable: false },
            { data: "quantity", orderable: false },
            { data: "total", orderable: false },
            {
                data: null,
                orderable: false,
                defaultContent: `
                <div class="flex space-x-2">
                    <button class="delete text-red-600 hover:text-red-800" title="Delete">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            `,
            },
        ],
        pageLength: 10, // Set default page length
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"],
        ], // Page length options
    });

    // Handle action button clicks
    $("#productTable").on("click", "button", function (e) {
        e.preventDefault();
        var action = $(this).attr("class");
        var rowData = productTable.row($(this).parents("tr")).data();
        switch (true) {
            case action.includes("delete"):
                // SweetAlert2 confirmation
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, remove it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with the delete operation
                        $.ajax({
                            url: "/transaction-products/" + rowData.id, // Adjust URL as needed
                            type: "DELETE",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    "content"
                                ),
                            },
                            success: function (response) {
                                const downpayment = $("#downpayment");
                                Swal.fire(
                                    "Deleted!",
                                    "The product has been removed.",
                                    "success"
                                );
                                $("#amount").text(response.amount);
                                downpayment.attr({
                                    min: response.downpayment,
                                    max: response.amount,
                                });
                                downpayment.val(response.downpayment);

                                productTable.ajax.reload();
                            },
                            error: function (xhr) {
                                Swal.fire(
                                    "Error!",
                                    "There was an issue removing the product.",
                                    "error"
                                );
                            },
                        });
                    }
                });
                break;
        }
        $(this).closest(".action-menu").addClass("hidden");
    });

    // Close modal functionality
    $("#closeViewModal").on("click", function () {
        $("#viewModal").addClass("hidden");
    });

    $("#addTransactionProductForm").on("submit", function (e) {
        e.preventDefault();

        var formData = new FormData(this); // Using FormData to include files
        formData.append("transaction_id", transactionId);

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url: "/transaction-products",
            method: "POST", // Change this to method
            data: formData,
            contentType: false, // Prevent jQuery from setting the content-type header
            processData: false, // Prevent jQuery from processing the data
            success: function (response) {
                $("#createModal").addClass("hidden");
                Swal.fire({
                    icon: "success",
                    title: "Added",
                    text: "Product added successfully.",
                }).then(() => {
                    // $('#createModal').addClass('hidden'); // Hide the modal
                    const downpayment = $("#downpayment");
                    $("#addTransactionProductForm")[0].reset();
                    $("#amount").text(response.amount);

                    downpayment.attr({
                        min: response.downpayment,
                        max: response.amount,
                    });
                    downpayment.val(response.downpayment);
                    // Reset the form
                    productTable.ajax.reload(); // Reload the DataTable with new data
                });
            },
            error: function (xhr) {
                var errorMessage = "Error occurred while saving the product.";
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
    $("#addProductButton").on("click", function () {
        $("#addProductModal").removeClass("hidden");
        $("#addProductModalTitle").text("Add Product");
        $("#productId").val("");
        $("#addTransactionProductForm")[0].reset();
    });

    // Close modal button functionality
    $("#closeAddProductModal").on("click", function () {
        $("#addProductModal").addClass("hidden");
    });
});
