$(document).ready(function () {
    var table = $("#example").DataTable({
        paging: true,
        processing: true,
        serverSide: true,
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
                defaultContent: `
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
              `,
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
            models: ["products", "mechanics"],
        },
        success: function (response) {
            console.log(response);
            // response.products will contain the products data
            // response.mechanics will contain the mechanics data

            var mechanicId = $("#mechanic_id");
            var mechanicOptions = response.mechanics.map(function (item) {
                return $("<option></option>")
                    .attr("value", item.id)
                    .text(item.fullname);
            });
            mechanicId.append(mechanicOptions); // Append all options at once
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

    // Handle Form Submission
    $("#createTransactionForm").on("submit", function (e) {
        e.preventDefault();

        var transactionId = $("#transactionId").val();
        var url = transactionId
            ? "/transactions/" + transactionId
            : "/transactions"; // URL for update or create
        var method = transactionId ? "POST" : "POST"; // Using POST; _method will handle it

        var formData = new FormData(this); // Using FormData to include files

        if (transactionId) {
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
                    title: transactionId ? "Updated!" : "Added!",
                    text: transactionId
                        ? "The transaction has been updated successfully."
                        : "The transaction has been added successfully.",
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

    // Close the view modal
    $("#closeViewModal").on("click", function () {
        $("#viewModal").addClass("hidden");
    });

    // Click outside to close open menus and modals
    $(document).on("click", function (e) {
        if (!$(e.target).closest(".view, .action-button").length) {
            $(".action-menu").addClass("hidden");
            $("#viewModal").addClass("hidden");
        }
    });

    // Handle action button clicks
    $("#example").on("click", "button", function (e) {
        e.preventDefault();
        var action = $(this).attr("class");
        var rowData = table.row($(this).parents("tr")).data();

        switch (true) {
            case action.includes("view"):
                $("#transactionDetails").html(`
                  <p><strong>Client Name:</strong> ${rowData.client_name}</p>
                  <p><strong>Unit:</strong> ${rowData.unit}</p>
                  <p><strong>Plate No.:</strong> ${rowData.plate_no}</p>
                  <p><strong>Color:</strong> ${rowData.color}</p>
                  <p><strong>Contact:</strong> ${rowData.contact}</p>
                  <p><strong>Email:</strong> ${rowData.email}</p>
                  <p><strong>Address:</strong> ${rowData.address}</p>
                  <p><strong>Code:</strong> ${rowData.code}</p>
                  <p><strong>Processed By:</strong> ${rowData.processed_by}</p>
                  <p><strong>Mechanic:</strong> ${rowData.mechanic}</p>
                  <p><strong>Downpayment:</strong> ${rowData.downpayment}</p>
                  <p><strong>Balance:</strong> ${rowData.balance}</p>
                  <p><strong>Amount:</strong> ${rowData.amount}</p>
                  <p><strong>Date In:</strong> ${rowData.date_in}</p>
                  <p><strong>Date Out:</strong> ${
                      rowData.date_out ? rowData.date_out : "--"
                  }</p>
                  <p><strong>Status:</strong> ${rowData.status}</p>
              `);
                $("#viewModal").removeClass("hidden");
                break;
            case action.includes("edit"):
                $("#modalTitle").text("Edit Transaction");
                $("#transactionId").val(rowData.id);
                $("#client_name").val(rowData.client_name);
                $("#unit").val(rowData.unit);
                $("#color").val(rowData.color);
                $("#plate_no").val(rowData.plate_no);
                $("#contact").val(rowData.contact);
                $("#email").val(rowData.email);
                $("#address").val(rowData.address);

                // $("#code").val(rowData.code);
                $("#mechanic_id").val(rowData.mechanic_id);
                $("#downpayment").val(rowData.downpayment);
                $("#date_in").val(rowData.date_in);
                $("#date_out").val(rowData.date_out);
                $("#status").val(rowData.status);
                $("#createModal").removeClass("hidden");
                break;
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
});
