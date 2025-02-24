<?php
include("../includes/header.php");
include("../includes/navbar.php");
?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- topbar -->
        <?php
        include("../includes/topbar.php");

        // query
        $query = "SELECT * FROM users";
        $result = mysqli_query($conn, $query);
        ?>


        <!-- ADD MODAL-->
        <div class="modal fade" id="GMCadduser" tabindex="-1" role="dialog" aria-labelledby="ItemModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ItemModalLabel">Add New User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="create.php" method="POST">
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Full Name</label>
                                    <input type="text" name="fullname" class="form-control" required>
                                </div>
                               
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Password</label>
                                    <input type="password" name="pword" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email Address</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Phone Number</label>
                                    <input type="text" name="number" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Department</label>
                                    <input type="text" name="department" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select name="role" id="roleSelect" required class="form-control" onchange="toggleBranchField(this)">
                                    <option value="">Select Role</option>
                                    <option value="superadmin">Superadmin</option>
                                    <option value="admin">Admin</option>
                                    <option value="superuser">Superuser</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="adduser" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end of add modal -->


        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Users</h1>
                <button type="button" class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#GMCadduser">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Add
                </button>
            </div>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="card-datatable table-responsive pt-0">
                        <table class="datatables-basic table" id="dataTable" width="100%">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>User Role</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?php echo $row['fullname']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['department']; ?></td>
                                        <td>
                                            <?php
                                            switch ($row['role']) {
                                                case 'superadmin':
                                                    echo 'Superadmin';
                                                    break;
                                                case 'admin':
                                                    echo 'Admin';
                                                    break;
                                                case 'superuser':
                                                    echo 'Superuser';
                                                    break;
                                                case 'user':
                                                    echo 'User';
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#editProductModal" class="btn btn-sm btn-success editproduct-btn"><i class="fa-solid fa-edit"></i></button>
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#viewProductModal" class="btn btn-sm btn-warning viewproduct-btn"><i class="fa-solid fa-eye text-white"></i></button>
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
    ?>