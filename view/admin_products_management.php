<?php
if ($_COOKIE['UserRole'] == 1) {
    require_once '../controller/AdminController.php';
    //create an object:
    $hiep = new AdminController();
    
    /*DELETE PRODUCT*/
    if (!empty($_POST['deleleProductId'])) {
        $ProductId = $_POST['deleleProductId'];
        //delete image
        $theProduct= $hiep->viewAllProducts($ProductId);
        while ($row = mysqli_fetch_assoc($theProduct)) {
            $image=$row["Image"];
        }
        $path="../public/images/items/$image";
        unlink($path);
        //delete file
        $hiep->deleteProduct($ProductId);
        header("Location: ../view/admin_index.php?area=productsmanagement");
    }
    /*DELETE PRODUCT*/
    //get all product
    $result = $hiep->viewAllProducts("");
    ?>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Product Management</h1>
        </div>

        <!-- /.col-lg-12 -->
    </div>

    <form action="./admin_index.php?area=products_add_update" method="post" >
        <!--get value of category Id for $_POST['updateCategory']-->
        <input type="hidden" name="addProduct" value="yes"/>
        <input type="submit" value="Add A Product"/>
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
                                <th>Category Id</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Delete</th>
                                <th>Update</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $row['ProdId'] ?></td>
                                    <td><?php echo $row['ProdName'] ?></td>
                                    <td><?php echo $row['CategoryId'] ?></td>
                                    <td><?php echo $row['Price'] ?></td>
                                    <td><?php echo $row['Description'] ?></td>
                                    <td><img src="../public/images/items/<?php echo $row['Image'] ?>" style="width: 100%;"></td>                                    
                                    <td><form class="frminline" action="./admin_products_management.php" method="post" 
                                              onsubmit="return confirmDelete();">
                                            <!--get value of category Id for $_POST['deleleCategory']-->
                                            <input type="hidden" name="deleleProductId" value="<?php echo $row['ProdId'] ?>"/>
                                            <input type="submit" value="delete"/>
                                        </form></td>

                                    <td><form class="frminline" action="./admin_index.php?area=products_add_update" method="post">
                                            <!--get value of category Id for $_POST['updateCategory']-->
                                            <input type="hidden" name="updateProduct" value="<?php echo $row['ProdId'] ?>"/>
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