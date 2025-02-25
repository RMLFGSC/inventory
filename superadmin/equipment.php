<?php
include("../includes/header.php");
include("../includes/navbar.php");


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

        <!-- ADD MODAL -->
        <div class="modal fade" id="GMCaddEquipment" tabindex="-1" role="dialog" aria-labelledby="ItemModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ItemModalLabel">Add Equipmet</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="create.php" method="POST">
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6 col-12">
                                    <label>Equipment</label>
                                    <input type="text" name="equip_name" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label for="category">Category</label>
                                    <select class="custom-select" id="cat_id" name="category" aria-label="Default select example" required>
                                        <option value="" selected disabled>Select Category</option>
                                        <option value="IT Equipment">IT Equipment</option>
                                        <option value="Engineering Equipment">Engineering Equipment</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="addEquipment" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end of add modal -->

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
                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#GMCaddEquipment">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Add Equipment
                </button>
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
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#editProductModal" class="btn btn-sm btn-success editproduct-btn"><i class="fa-solid fa-edit"></i></button>
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