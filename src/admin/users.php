<?php include "./pages/header.php" ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Users</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>UserName</th>
                                            <th>Password</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Full Name</th>
                                            <th>Location</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include "../func/database.php";
                                        $rs = users();
                                        $row = $rs->fetch_all();
                                        foreach ($row as $user) {
                                                echo "<tr>
                                                        <td>{$user[1]}</td>
                                                        <td>{$user[2]}</td>
                                                        <td>{$user[3]}</td>
                                                        <td>{$user[4]}</td>
                                                        <td>{$user[5]}</td>
                                                        <td>{$user[6]}</td>
                                                        <td>
                                                            <a href='../profile.php?user={$user[1]}' class='btn btn-primary'>Edit</a>
                                                            <a href='delete.php?id={$user[0]}' class='btn btn-danger'>Delete</a>
                                                        </td>   
                                                    </tr>";
                                        }
                                        ?>  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <?php include "./pages/footer.php" ?>