<?php
include("../includes/header.php");
include("../includes/navbar_mmo.php");

if (!isset($_SESSION['auth_user']['user_id'])) {
    die("Error: User is not logged in. Please log in first.");
}

// Query to fetch both pending and served issuance requests
$query = "SELECT request.*, users.fullname AS requester_name, users.department
          FROM request 
          JOIN users ON request.user_id = users.user_id
          WHERE request.status IN (0, 1)  -- Include both pending (0) and served (1) requests
          AND req_id IN (SELECT MIN(req_id) FROM request GROUP BY req_number) 
          ORDER BY req_number ASC";

$result = mysqli_query($conn, $query);

// Check for query errors
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <?php
        include("../includes/topbar.php");
        ?>

        <!-- View Request Modal -->
        <div class="modal fade" id="viewRequestModal" tabindex="-1" role="dialog"
            aria-labelledby="viewRequestModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewRequestModalLabel">Requisition Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Requested By</label>
                                <input type="text" id="requestedBy" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label>Department</label>
                                <input type="text" id="department" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Requisition #</label>
                                <input type="text" id="requisitionNumber" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label>Date</label>
                                <input type="text" id="date" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Items</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody id="view_request_items">
                                    <!-- Rows will be populated dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex w-100">
                            <div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-sm btn-info approve-btn mr-2">Print</button>
                                    <button type="button" class="btn btn-sm btn-success print-btn" id="saveRequest">Save</button>
                                </div>
                            </div>
                            <div class="ml-auto">
                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of View Request Modal -->

        <!-- Decline Confirmation Modal -->
        <div class="modal fade" id="confirmDeclineModal" tabindex="-1" role="dialog"
            aria-labelledby="confirmDeclineModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeclineModalLabel">Confirm Decline</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to decline this request?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-sm btn-danger" id="confirmDecline">Decline</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Decline Confirmation Modal -->

        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Issuance</h1>
            </div>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="card-datatable pt-0">
                        <table class="datatables-basic table" id="dataTable" width="100%">
                            <thead>
                                <tr>
                                    <th>Req Number</th>
                                    <th>Requester</th>
                                    <th>Department</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['req_number']); ?></td>
                                        <td><?php echo htmlspecialchars($row['requester_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['department']); ?></td>
                                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                                        <td>
                                            <?php
                                            if ($row['status'] == 0) {
                                                echo '<span class="badge badge-warning">Pending</span>';
                                            } elseif ($row['status'] == 1) {
                                                echo '<span class="badge badge-success">Served</span>';
                                            } elseif ($row['status'] == 2) {
                                                echo '<span class="badge badge-danger">Declined</span>';
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            <?php if ($row['status'] == 2 || $row['status'] == 1): // If Declined (2) or Served (1) ?>
                                                <button type="button" data-toggle="modal" data-target="#viewRequestModal"
                                                    class="btn btn-sm btn-warning viewrequest-btn"
                                                    data-req_number="<?php echo htmlspecialchars($row['req_number']); ?>">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                            <?php else: ?>
                                                <button type="button" data-toggle="modal" data-target="#viewRequestModal"
                                                    class="btn btn-sm btn-success viewrequest-btn"
                                                    data-id="<?php echo htmlspecialchars($row['req_id']); ?>"
                                                    data-req_number="<?php echo htmlspecialchars($row['req_number']); ?>">
                                                    <i class="fa-solid fa-circle-check"></i>
                                                </button>
                                                <button type="button" data-toggle="modal" data-target="#confirmDeclineModal"
                                                    class="btn btn-sm btn-danger viewrequest-btn"
                                                    data-id="<?php echo htmlspecialchars($row['req_id']); ?>">
                                                    <i class="fa-solid fa-circle-xmark"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php
    include("../includes/scripts.php");
    include("../includes/footer.php");
    include("../includes/datatables.php");
    ?>

    <script>
        $(document).ready(function () {
            // View request modal functionality
            $('.viewrequest-btn').on('click', function () {
                const reqno = $(this).data('req_number');
                const requestId = $(this).data('id'); // Get the request ID if available

                // Fetch request items via AJAX
                $.ajax({
                    url: 'fetch_requisition_details.php', // Update to the correct PHP file
                    type: 'POST',
                    data: { req_number: reqno },
                    dataType: 'json', // Expect JSON response
                    success: function (data) {
                        if (data) {
                            $('#requestedBy').val(data.requester_name); // Set requester name
                            $('#department').val(data.department); // Set department
                            $('#requisitionNumber').val(data.req_number); // Set requisition number
                            $('#date').val(data.date); // Set date

                            // Populate the items in the table
                            let itemsHtml = '';
                            data.items.forEach(item => {
                                itemsHtml += `<tr>
                                                <td>${item.item}</td>
                                                <td>${item.qty}</td>
                                              </tr>`;
                            });
                            $('#view_request_items').html(itemsHtml); // Set items in the table
                            $('#viewRequestModal').data('id', requestId); // Store the request ID in the modal
                        } else {
                            console.error("No data returned from the server.");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching request items: ", error);
                    }
                });
            });

            // Save button functionality (Update Status to Served)
            $('#saveRequest').on('click', function () {
                const requestId = $('#viewRequestModal').data('id'); // Get stored ID

                if (!requestId) {
                    console.error("No request ID found!");
                    return;
                }

                // Set the status to 1 for "Served"
                const status = 1; // Change this to 2 if you want to mark as "Declined"

                $.ajax({
                    url: 'update_status.php', // Ensure this is the correct path
                    type: 'POST',
                    data: { id: requestId, status: status }, // Send the request ID and status
                    success: function (response) {
                        const result = JSON.parse(response); // Parse the JSON response
                        if (result.success) {
                            console.log("Status updated successfully: ", result);
                            location.reload(); // Reload the page to see the updated status
                        } else {
                            console.error("Error updating status: ", result.error);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error updating status: ", error);
                    }
                });
            });

            // Decline button functionality
            $('.btn-danger.viewrequest-btn').on('click', function () {
                $('#confirmDeclineModal').modal('show');

                const requestId = $(this).data('id');

                // Handle confirmation
                $('#confirmDecline').off('click').on('click', function () {
                    $.ajax({
                        url: 'update_status.php',
                        type: 'POST',
                        data: { id: requestId, status: 2 }, // 2 for declined
                        success: function (response) {
                            const result = JSON.parse(response);
                            if (result.success) {
                                console.log("Request declined successfully: ", result);
                                location.reload(); // Reload the page to see the updated status
                            } else {
                                console.error("Error declining request: ", result.error);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error("Error declining request: ", error);
                        }
                    });
                    $('#confirmDeclineModal').modal('hide');
                });
            });

            // Print button functionality
            $('.approve-btn').on('click', function () {
                const printContents = document.getElementById('view_request_items').innerHTML; // Get the items to print
                const printWindow = window.open('', '', 'height=600,width=800');

                printWindow.document.write('<html><head><title>Print</title>');
                printWindow.document.write('<style>');
                printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
                printWindow.document.write('h1, h2, h3, h4, h5, h6 { color: #333; text-align: center; }');
                printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
                printWindow.document.write('th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
                printWindow.document.write('th { background-color: #f2f2f2; }');
                printWindow.document.write('p { margin: 5px 0; text-align: center; }');
                printWindow.document.write('</style>');
                printWindow.document.write('</head><body>');
                printWindow.document.write('<h1>Requisition Details</h1>');
                printWindow.document.write(printContents);
                printWindow.document.write('</body></html>');

                printWindow.document.close();
                printWindow.print();
                printWindow.close();
            });
        });
    </script>  