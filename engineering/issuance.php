<?php
include("../includes/header.php");

//query
$query = "SELECT request.*, users.fullname AS requester_name, users.department, stock_in.item
          FROM request 
          JOIN users ON request.user_id = users.user_id
          JOIN stock_in ON request.stockin_id = stock_in.stockin_id
          WHERE req_id IN (SELECT MIN(req_id) FROM request GROUP BY req_number) 
          AND stock_in.category = 'Engineering Equipment' 
          ORDER BY status ASC, req_number DESC";
$result = mysqli_query($conn, $query);
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- topbar -->
        <?php
        include("../includes/topbar_eng.php");
        ?>



        <div class="modal fade" id="viewRequestModal" tabindex="-1" role="dialog"
            aria-labelledby="viewRequestModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewStockinModalLabel">Requisition Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Requested By</label>
                                <input type="text" id="requestedBy" name="fullname" class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label>Department</label>
                                <input type="text" id="department" name="department" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Requisition #</label>
                                <input type="text" id="requisitionNumber" name="req_number" class="form-control"
                                    readonly>
                            </div>
                            <div class="col-md-6">
                                <label>Date</label>
                                <input type="text" id="date" name="date" class="form-control" readonly>
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
                                    <button type="button" class="btn btn-sm btn-success print-btn"
                                        id="saveRequest">Save</button>
                                </div>
                            </div>
                            <div class="ml-auto">
                                <button type="button" class="btn btn-sm btn-secondary"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End of view modal-->

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
                <div class="ml-auto">
                    <a href="issuance.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-file-signature fa-sm text-white-50"></i> Issuance</a>
                    <a href="reports.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-chart-bar fa-sm text-white-50"></i> Reports</a>
                </div>
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
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?php echo $row['req_number']; ?></td>
                                        <td><?php echo $row['requester_name']; ?></td>
                                        <td><?php echo $row['department']; ?></td>
                                        <td><?php echo $row['item']; ?></td>
                                        <td><?php echo $row['qty']; ?></td>
                                        <td><?php echo $row['date']; ?></td>
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
                                                    data-req_number="<?php echo $row['req_number']; ?>">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                            <?php else: ?>
                                                <button type="button" data-toggle="modal" data-target="#viewRequestModal"
                                                    class="btn btn-sm btn-success viewrequest-btn"
                                                    data-id="<?php echo $row['req_id']; ?>"
                                                    data-req_number="<?php echo $row['req_number']; ?>">
                                                    <i class="fa-solid fa-circle-check"></i>
                                                </button>
                                                <button type="button" data-toggle="modal" data-target="#confirmDeclineModal"
                                                    class="btn btn-sm btn-danger viewrequest-btn"
                                                    data-id="<?php echo $row['req_id']; ?>">
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
                const reqId = $(this).data('id'); 

                // Store the request ID inside the modal (so Save button can access it later)
                $('#viewRequestModal').data('id', reqId);

                // Fetch request items via AJAX
                $.ajax({
                    url: 'fetch_request_items.php',
                    type: 'POST',
                    data: { req_number: reqno },
                    success: function (data) {
                        $('#view_request_items').html(data);
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching request items: ", error);
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
                        data: { id: requestId, status: 2 },
                        success: function (response) {

                            location.reload();
                        }
                    });
                    $('#confirmDeclineModal').modal('hide');
                });
            });

            // Save button functionality (Update Status to Served)
            $('#saveRequest').on('click', function () {
                const requestId = $('#viewRequestModal').data('id'); // Get stored ID

                if (!requestId) {
                    console.error("No request ID found!");
                    return;
                }

                $.ajax({
                    url: 'update_status.php',
                    type: 'POST',
                    data: { id: requestId, status: 1 }, // 1 for served
                    success: function (response) {
                        console.log("Status updated successfully: ", response);
                        location.reload(); 
                    },
                    error: function (xhr, status, error) {
                        console.error("Error updating status: ", error);
                    }
                });
            });
        });
    </script>