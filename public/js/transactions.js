$(document).ready(function () {
    var table = $("#example").DataTable({
        paging: true,
        processing: true,
        serverSide: true,
        order: [[6, "desc"]],
        ajax: {
            url: "/transactions",
            type: "GET", // Use GET method for fetching data
        },
        columnDefs: [
            { className: "custom-align-left", targets: 2 }, // Apply custom alignment to the 'price' column (3rd column, zero-based index)
        ],
        columns: [
            { data: "code" },
            { data: "client_name" },
            { data: "unit_color" },
            { data: "plate_no" },
            // { data: "downpayment" },
            { data: "balance" },
            { data: "amount" },
            { data: "date_in" },
            { data: "date_out" },
            {
                data: "status",
                render: function (data) {
                    var statusText = "";
                    var statusClass = "";

                    if (data == "Pending") {
                        statusText = "Pending";
                        statusClass = "bg-red-500 text-white";
                    } else if (data == "Processing") {
                        statusText = "Processing";
                        statusClass = "bg-yellow-500 text-white";
                    } else if (data == "Done") {
                        statusText = "Done";
                        statusClass = "bg-green-500 text-white";
                    }
                    return `<span class="inline-block px-3 py-1 rounded-full text-xs font-semibold ${statusClass}">${statusText}</span>`;
                },
            },
            {
                data: null,
                render: function (data, type, row) {
                    return `
                      <div class="flex justify-center space-x-2">
                          <button class="view bg-blue-500 text-white hover:bg-blue-600 px-2 py-1 rounded-md" data-id="${row.id}" title="View">
                              <i class="fas fa-eye"></i>
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

    $.ajax({
        url: "/options", // Assuming this is the route to the controller method
        method: "GET",
        data: {
            models: ["products", "mechanics", "services"],
        },
        success: function (response) {
            console.log(response);

            var mechanicId = $("#mechanic_id");
            var mechanicOptions = response.mechanics.map(function (item) {
                // Create a new option element
                var option = $("<option></option>")
                    .attr("value", item.id)
                    .data("status", item.status);

                // Check the status and disable the option if status is 1
                if (item.status === 1) {
                    option
                        .attr("disabled", "disabled")
                        .text(
                            `Unavailable - ${item.fullname}(${item.position})`
                        );
                } else if (item.status === 2) {
                    option.text(`${item.fullname}(${item.position})`);
                }

                return option;
            });
            mechanicId.append(mechanicOptions);
            mechanicId.val($('#initMechanicId').val());

            var serviceId = $("#service_id");
            var serviceOptions = response.services.map(function (item) {
                return $("<option></option>")
                    .attr("value", item.id)
                    .data("price", item.price)
                    .text(`${item.name}`);
            });
            serviceId.append(serviceOptions);

            var productId = $("#product_id");
            var productOptions = response.products.map(function (item) {
                return $("<option></option>")
                    .attr("value", item.id)
                    .data("price", item.price)
                    .text(`${item.name}`);
            });
            productId.append(productOptions); // Append all options at once
        },
        error: function (error) {
            console.log("Error:", error.responseJSON);
        },
    });

    $("#downpayment").on("blur", function () {
        var downpaymentValue = parseFloat($(this).val());

        if (!isNaN(downpaymentValue)) {
            $(this).val(downpaymentValue.toFixed(2));
        }
    });

    $(document).on("click", ".view", function () {
        var transactionId = $(this).data("id");
        // Redirect to the show page for the selected product
        window.location.href = "/transactions/" + transactionId;
    });

    // Handle Form Submission
    $("#createTransactionForm").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this); // Using FormData to include files
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url: "/transactions",
            method: "POST", // Change this to method
            data: formData,
            contentType: false, // Prevent jQuery from setting the content-type header
            processData: false, // Prevent jQuery from processing the data
            success: function (response) {
                $("#createModal").addClass("hidden");
                Swal.fire({
                    icon: "success",
                    title: "Added!",
                    text: "The transaction has been added successfully.",
                }).then(() => {
                    // $('#createModal').addClass('hidden');
                    $("#createTransactionForm")[0].reset();
                    table.ajax.reload(); // Reload the DataTable with new data
                });
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text:
                        "Error occurred while saving the transaction. " +
                        xhr.responseText,
                });
            },
        });
    });

    // Handle Create Button Click
    $("#createButton").on("click", function () {
        $("#createModal").removeClass("hidden");
        $("#modalTitle").text("Create Transaction");
        $("#transactionId").val(""); // Clear ID for new transaction
        $("#createTransactionForm")[0].reset(); // Reset form fields
    });

    // Handle Close Modal Click
    $("#closeModal").on("click", function () {
        $("#createModal").addClass("hidden");
    });

    // Handle action button clicks
    $("#example").on("click", "button", function (e) {
        e.preventDefault();
        var action = $(this).attr("class");
        var rowData = table.row($(this).parents("tr")).data();

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
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with the delete operation
                        $.ajax({
                            url: "/transactions/" + rowData.id, // Adjust URL as needed
                            type: "DELETE",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    "content"
                                ),
                            },
                            success: function (response) {
                                Swal.fire(
                                    "Deleted!",
                                    "The transaction has been deleted.",
                                    "success"
                                );
                                table.ajax.reload(); // Reload DataTable
                            },
                            error: function (xhr) {
                                Swal.fire(
                                    "Error!",
                                    "There was an issue deleting the transaction.",
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

    // Edit button click handler
    $("#transaction_edit_btn").on("click", function () {
        // Fetch the transaction details from the Laravel blade
        const transaction = $("#transaction_edit_btn").data("transaction");

        // Populate the modal fields
        $("#editTransactionId").val(transaction.id);
        $("#edit_client_name").val(transaction.client_name);
        $("#edit_unit").val(transaction.unit);
        $("#edit_plate_no").val(transaction.plate_no);
        $("#edit_color").val(transaction.color);
        $("#edit_address").val(transaction.address);
        $("#edit_contact").val(transaction.contact);
        $("#edit_email").val(transaction.email);
        $("#edit_date_in").val(transaction.date_in);
        $("#edit_status").val(transaction.status);

        // Show the modal
        $("#editModal").removeClass("hidden");
    });

    // Close modal handler
    $("#closeEditModal").on("click", function () {
        $("#editModal").addClass("hidden");
    });

    // Function to update the transaction view with new data
    function updateTransactionView(transaction) {
        // Iterate over each field and update its content
        for (const [key, value] of Object.entries(transaction)) {
            // Select the element based on the data-field attribute
            const element = document.querySelector(`[data-field="${key}"]`);
            if (element) {
                element.textContent = value; // Update the text content
            }
        }
    }
    // Handle form submission with AJAX
    $("#editTransactionForm").on("submit", function (e) {
        e.preventDefault();

        const transactionId = $("#editTransactionId").val();
        const formData = $(this).serialize();

        // Show loading alert
        Swal.fire({
            title: 'Updating...',
            text: 'Please wait while we update the status.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url: `/transactions/${transactionId}`,
            type: "PUT",
            data: formData,
            success: function (response) {
                // Close the loading alert
                Swal.close();
                $("#editModal").addClass("hidden");
                Swal.fire({
                    icon: "success",
                    title: "Updated!",
                    text: "The transaction has been updated successfully.",
                }).then(() => {
                    $("#editModal").addClass("hidden");
                    updateTransactionView(response.transaction); // Call the update function
                    $("#editTransactionForm")[0].reset();
                    // table.ajax.reload(); // Reload the DataTable with new data
                });
            },
            error: function (xhr) {
                // Close the loading alert
                Swal.close();
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "Error occurred while saving the transaction. " + xhr.responseText,
                });
            },
        });
    });




    $("#submitTransactionForm").on("submit", function (e) {
        e.preventDefault();

        const submitTransactionId = $("#submitTransactionId").val();
        let formData = $(this).serialize(); // Serialize the form

        // Append additional data manually
        formData += '&submittal=true'; // Add submittal field

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url: `/transactions/${submitTransactionId}`,
            type: "PUT", // Ensure you are using the correct HTTP method
            data: formData,
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Submitted!",
                    text: "The transaction has been submitted successfully.",
                });
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text:
                        "Error occurred while saving the transaction. " +
                        xhr.responseText,
                });
            },
        });
    });

});
