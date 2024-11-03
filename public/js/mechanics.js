$(document).ready(function () {
    var table = $("#mechanicsTable").DataTable({
        paging: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "/mechanics/data",
            type: "GET", // Use GET method for fetching data
        },
        columnDefs: [
            { className: "custom-align-left", targets: 2 }, // Apply custom alignment to the 'price' column (3rd column, zero-based index)
        ],
        columns: [
            { data: "firstname" },
            { data: "middlename" },
            { data: "lastname" },
            { data: "position" },
            { data: "rate" },
            {
                data: "status",
                render: function (data) {
                    var statusText = "";
                    var statusClass = "";
                    if (data == 1) {
                        statusText = "Working";
                        statusClass =
                            "bg-green-500 text-white border border-green-700"; // Tailwind class for green background with a border
                    } else if (data == 2) {
                        statusText = "Stand-by";
                        statusClass =
                            "bg-red-500 text-white border border-red-700"; // Tailwind class for red background with a border
                    }
                    return `<span class="inline-block px-3 py-1 rounded-full text-xs font-semibold ${statusClass}">${statusText}</span>`;
                },
            },
            {
                data: null,
                defaultContent: `
                    <div class="flex space-x-2">
                        <button class="view text-blue-500 hover:text-blue-700 mr-2" title="View">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="edit text-green-500 hover:text-red-700 mr-2" title="Edit">
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

    // Handle Form Submission
    $("#createMechanicForm").on("submit", function (e) {
        e.preventDefault();

        var formData = $(this).serialize();
        var mechanicId = $("#mechanicId").val();
        var url = mechanicId
            ? "/mechanics/update/" + mechanicId
            : "/mechanics/create";
        var method = mechanicId ? "PUT" : "POST";

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: mechanicId ? "Updated!" : "Added!",
                    text: mechanicId
                        ? "The mechanics has been updated successfully."
                        : "The mechanics has been added successfully.",
                }).then(() => {
                    $("#createModal").addClass("hidden");
                    $("#createMechanicForm")[0].reset();
                    table.ajax.reload(); // Reload the DataTable with new data
                });
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text:
                        "Error occurred while saving the mechanics. " +
                        xhr.responseText,
                });
            },
        });
    });

    // Handle Create Button Click
    $("#createButton").on("click", function () {
        $("#createModal").removeClass("hidden");
        $("#modalTitle").text("Create Mechanic");
        $("#mechanicId").val(""); // Clear ID for new mechanics
        $("#createMechanicForm")[0].reset(); // Reset form fields
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
    $("#mechanicsTable").on("click", "button", function (e) {
        e.preventDefault();
        var action = $(this).attr("class");
        var rowData = table.row($(this).parents("tr")).data();

        switch (true) {
            case action.includes("view"):
                $("#mechanicDetails").html(`
                    <p><strong>Firstname:</strong> ${rowData.firstname}</p>
                    <p><strong>Middlename:</strong> ${rowData.middlename}</p>
                    <p><strong>Lastname:</strong> ${rowData.lastname}</p>
                    <p><strong>Position:</strong> ${rowData.position}</p>
                    <p><strong>Rate:</strong> ${rowData.rate}</p>
                    <p><strong>Status:</strong> ${
                        rowData.status === 1 ? "Working" : "Stand-By"
                    }</p>
                `);
                $("#viewModal").removeClass("hidden");
                break;
            case action.includes("edit"):
                $("#modalTitle").text("Edit Mechanic");
                $("#mechanicId").val(rowData.id);
                $("#firstname").val(rowData.firstname);
                $("#middlename").val(rowData.middlename);
                $("#lastname").val(rowData.lastname);
                $("#position").val(rowData.position);
                $("#rate").val(rowData.rate);
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
                            url: "/mechanics/delete/" + rowData.id, // Adjust URL as needed
                            type: "DELETE",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    "content"
                                ),
                            },
                            success: function (response) {
                                Swal.fire(
                                    "Deleted!",
                                    "The mechanics has been deleted.",
                                    "success"
                                );
                                table.ajax.reload(); // Reload DataTable
                            },
                            error: function (xhr) {
                                Swal.fire(
                                    "Error!",
                                    "There was an issue deleting the mechanics.",
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
