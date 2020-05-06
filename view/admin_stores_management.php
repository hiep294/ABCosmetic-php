<?php
if ($_COOKIE['UserRole'] == 1) {
    require_once '../controller/AdminController.php';
    $hiep = new AdminController();
    //DO DELETE STORE
    if (isset($_POST['deleleStore'])) {
        $hiep->deleteStore($_POST['deleleStore']);
        header("Location: ./admin_index.php?area=storesmanagement");
    }
    //
    //get result: all categories from DB
    $result = $hiep->viewAllStores("");
    ?>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Store Management</h1>
        </div>

        <!-- /.col-lg-12 -->
    </div>

    <form action="./admin_index.php?area=stores_add_update" method="post" >
        <!--get value of category Id for $_POST['updateCategory']-->
        <input type="hidden" name="addStore" value="yes"/>
        <input type="submit" value="Add A Store"/>
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
                                <th>Store Id</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Delete</th>
                                <th>Update</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $row['StoreId'] ?></td>
                                    <td><?php echo $row['StoreAddress'] ?></td>
                                    <td><?php echo $row['StorePhone'] ?></td>
                                    <td><form class="frminline" action="./admin_index.php?area=storesmanagement" method="post" 
                                              onsubmit="return confirmDelete();">
                                            <!--get value of category Id for $_POST['deleleCategory']-->
                                            <input type="hidden" name="deleleStore" value="<?php echo $row['StoreId'] ?>"/>
                                            <input type="submit" value="delete"/>
                                        </form></td>

                                    <td><form class="frminline" action="./admin_index.php?area=stores_add_update" method="post">
                                            <!--get value of category Id for $_POST['updateCategory']-->
                                            <input type="hidden" name="updateStore" value="<?php echo $row['StoreId'] ?>"/>
                                            <input type="submit" value="update"/>
                                        </form></td>
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
}else{
    header("Location: ./login.php");
}?>