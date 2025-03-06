<?php
include("../includes/header.php");
include("../includes/navbar_admin.php");

?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">

        <?php include("../includes/topbar.php"); ?>

        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Reports</h1>
            </div>

            <!-- Reports Container -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <!-- Report Type Selection and Date Filtering -->
                    <div class="form-group d-flex align-items-center">
                        <label for="reportType" class="mr-2">Select Report Type:</label>
                        <select class="form-control mr-3" id="reportType" style="width: 200px;">
                            <option value="requests">Requests Report</option>
                            <option value="issuance">Issuance Report</option>
                            <option value="stockin">Stock-In Report</option>
                            <option value="overview">Stock Overview</option>
                        </select>

                        <label for="startDate" class="mr-2">Start Date:</label>
                        <input type="date" class="form-control mr-3" id="startDate" style="width: 150px;">

                        <label for="endDate" class="mr-2">End Date:</label>
                        <input type="date" class="form-control" id="endDate" style="width: 150px;">
                    </div>

                    <div class="card-datatable pt-0">

                        <!-- REQUEST REPORT -->
                        <table class="table table-bordered report-table" id="requestsTable" width="100%">
                            <thead>
                                <tr>
                                    <th>Request #</th>
                                    <th>Requester</th>
                                    <th>Department</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM request";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>
                                            <td>{$row['req_number']}</td>
                                            <td>{$row['requester_name']}</td>
                                            <td>{$row['department']}</td>
                                            <td>{$row['date']}</td>
                                            <td>{$row['status']}</td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                        <!-- ISSUANCE REPORT -->
                        <table class="table table-bordered report-table" id="issuanceTable" width="100%" style="display:none;">
                            <thead>
                                <tr>
                                    <th>Issuance #</th>
                                    <th>Item Name</th>
                                    <th>Issued To</th>
                                    <th>Quantity</th>
                                    <th>Date Issued</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM request";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>
                                            <td>{$row['req_id']}</td>
                                            <td>{$row['stockin_id']}</td>
                                            <td>{$row['user_id']}</td>
                                            <td>{$row['qty']}</td>
                                            <td>{$row['date']}</td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                        <!-- STOCK-IN REPORT -->
                        <table class="table table-bordered report-table" id="stockinTable" width="100%" style="display:none;">
                            <thead>
                                <tr>
                                    <th>Stock-In #</th>
                                    <th>Item Name</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Date Received</th>
                                    <th>dop</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM stock_in";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>
                                            <td>{$row['stockin_id']}</td>
                                            <td>{$row['item']}</td>
                                            <td>{$row['category']}</td>
                                            <td>{$row['qty']}</td>
                                            <td>{$row['dr']}</td>
                                            <td>{$row['dop']}</td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                        <!-- STOCK OVERVIEW REPORT -->
                        <table class="table table-bordered report-table" id="overviewTable" width="100%" style="display:none;">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Category</th>
                                    <th>Total Stock</th>
                                    <th>In Use</th>
                                    <th>Available</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM stock_in";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>
                                            <td>{$row['item']}</td>
                                            <td>{$row['category']}</td>
                                            <td>{$row['total_stock']}</td>
                                            <td>{$row['in_use']}</td>
                                            <td>{$row['available']}</td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- JavaScript for Dropdown Selection -->
<script>
    document.getElementById("reportType").addEventListener("change", function() {
        var selectedReport = this.value;

        // Hide all tables
        document.querySelectorAll(".report-table").forEach(function(table) {
            table.style.display = "none";
        });

        // Show the selected table
        if (selectedReport === "requests") {
            document.getElementById("requestsTable").style.display = "table";
        } else if (selectedReport === "issuance") {
            document.getElementById("issuanceTable").style.display = "table";
        } else if (selectedReport === "stockin") {
            document.getElementById("stockinTable").style.display = "table";
            document.getElementById("overviewTable").style.display = "table"; // Show stock overview as well
        } else if (selectedReport === "overview") {
            document.getElementById("overviewTable").style.display = "table";
        }
    });
</script>

<?php
include("../includes/scripts.php");
include("../includes/footer.php");
?>
