<?php
include("../includes/header.php");
include("../includes/navbar_eng.php");


//query
$query = "SELECT * FROM equipment ORDER BY equipment_id ASC";
$result = mysqli_query($conn, $query);

?>

<style>
    .modal-body {
        padding: 20px;
    }

    .table {
        font-size: 14px;
    }
</style>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- topbar -->
        <?php
        include("../includes/topbar.php");

        ?>


        <!-- View Product Modal -->
        <div class="modal fade" id="viewStockinModal" tabindex="-1" role="dialog" aria-labelledby="viewStockinModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewStockinModalLabel">Stock-in Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Equipment</th>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="stockinDetailsBody">
                                    <!-- Dynamic content will be inserted here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--End of view modal-->

        <script>
                // Update view modal functionality
                $('.viewstockin-btn').on('click', function() {
                    const equipment_id = $(this).data('equipment_id');

                    $.ajax({
                        url: 'fetch_stockin_details.php',
                        type: 'POST',
                        data: {
                            equipment_id: equipment_id
                        },
                        success: function(data) {
                            $('#stockinDetailsBody').html(data);
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching stock-in details: ", error);
                        }
                    });
                });
        </script>

        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Equipments</h1>
            </div>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="card-datatable pt-0">
                        <table class="datatables-basic table" id="dataTable" width="100%">
                            <thead>
                                <tr>
                                    <th>Equipment</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php

                                while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?php echo $row['equip_name']; ?></td>
                                        <td><?php echo $row['category']; ?></td>
                                        <td>
                                            <button type="button" data-toggle="modal" data-target="#viewStockinModal" class="btn btn-sm btn-warning viewstockin-btn">
                                                <i class="fa-solid fa-eye text-white"></i>
                                            </button>
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