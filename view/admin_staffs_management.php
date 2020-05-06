<?php
if ($_COOKIE['UserRole'] == 1) {
    require_once '../controller/AdminController.php';
    $hiep = new AdminController();
    //delete STAFF

    if (isset($_POST['deleleStaff'])) {
        $hiep->deleteStaff($_POST['deleleStaff']);
        header("Location: ./admin_index.php?area=staffsmanagement");
    }
    //all staffs
    $result = $hiep->viewAllStaffs("");
    ?>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Staff Management</h1>
        </div>

        <!-- /.col-lg-12 -->
    </div>

    <form action="./admin_index.php?area=staffs_add_update" method="post" >
        <!--get value of category Id for $_POST['updateCategory']-->
        <input type="hidden" name="addStaff" value="yes"/>
        <input type="submit" value="Add A Staff"/>
    </form>


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    DataTables Advanced Tables
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Store Id</th>
                                <th>Role</th>
                                <th>Delete</th>
                                <th>Update</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $row['UserId'] ?></td>
                                    <td><?php echo $row['UserName'] ?></td>
                                    <td><?php echo $row['UserPhone'] ?></td>
                                    <td><?php echo $row['UserEmail'] ?></td>
                                    <td><?php echo $row['StoreId'] ?></td>
                                    <td><?php
                                        if ($row['UserRole'] == 1) {
                                            echo "Admin";
                                        } elseif ($row['UserRole'] == 2) {
                                            echo "National Manager";
                                        } elseif ($row['UserRole'] == 3) {
                                            echo "Sale Staff";
                                        }
                                        ?></td>
                                    <td>
                                        <form class="frminline" action="./admin_staffs_management.php" method="post" 
                                              onsubmit="return confirmDelete();">
                                            <!--get value of category Id for $_POST['deleleCategory']-->
                                            <input type="hidden" name="deleleStaff" value="<?php echo $row['UserId'] ?>"/>
                                            <input type="submit" value="delete"/>
                                        </form>
                                    </td>
                                    <td><form class="frminline" action="./admin_index.php?area=staffs_add_update" method="post">
                                            <!--get value of category Id for $_POST['updateCategory']-->
                                            <input type="hidden" name="updateStaff" value="<?php echo $row['UserId'] ?>"/>
                                            <input type="submit" value="update"/>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        <script>
                            function confirmDelete() {
                                var r = confirm("Are you sure you would like to delete?");
                                if (r) {
                                    return true;
                                } else {
                                    return false;
                                }
                            }
                        </script>
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->

                </div>

                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.panel -->
    </div>

    <!-- /.col-lg-12 -->


    <?php
} else {
    header("Location: ./login.php");
}?>