<?php
if ($_COOKIE['UserRole'] == 1) {
    require_once '../controller/AdminController.php';
    $hiep = new AdminController();

    //WORKING
    if (!empty($_POST['doUpdateProductDetailDB'])) {
        $productdetailId = $_POST['productdetailId'];
        $prodId = $_POST['ProdId'];
        $storeId = $_POST['StoreId'];
        $storeQuantity = $_POST['quantity'];
        $hiep->updateProductDetail($productdetailId, $prodId, $storeId, $storeQuantity);
        header("Location: ./admin_index.php?area=productdetailsmanagement");
    }

    if (!empty($_POST['doAddProductDetailDB'])) {
        $storeQuantity = $_POST['quantity'];
        $prodId = $_POST['chosenProduct'];
        $storeId = $_POST['chosenStore'];
        $hiep->addProductDetail($prodId, $storeId, $storeQuantity);
        header("Location: ./admin_index.php?area=productdetailsmanagement");
    }


    //INTERFACE:
    if (!empty($_POST['updateProductDetail'])) {
        $productdetailId = $_POST['updateProductDetail'];
        $rs0 = $hiep->viewAProductDetail($productdetailId);
        while ($row = mysqli_fetch_assoc($rs0)) {
            $prodId = $row['ProdId'];
            $storeId = $row['StoreId'];
            $quantity = $row['StoreQuantity'];
        }
        //get info of product and store
        $rs1 = $hiep->viewAllProducts($prodId);
        $rs2 = $hiep->viewAllStores($storeId);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Update Product Quantity</h1>
            </div></div>
        <br>
        <form action="./admin_productdetails_add_update.php" method="post" >
            <!--<p>Please choose a store and a product below, before creating</p>-->
            <input type="hidden" name="doUpdateProductDetailDB" value="keepGoing">
            Quantity: <input type="number" name="quantity" value="<?php echo $quantity; ?>" required=""/>
            <input type="hidden" name="productdetailId" value="<?php echo $productdetailId; ?>"/>
            <input type="submit" value="Update"/>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span style="font-weight: bold;">Store Info</span>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Store Id</th>
                                        <th>Address</th>
                                        <th>Phone</th>
        <!--                                        <th>Choose</th>-->
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    while ($row = mysqli_fetch_assoc($rs2)) {
                                        ?>

                                        <tr class="odd gradeX">
                                            <td><?php echo $row['StoreId'] ?><input type="hidden" name="StoreId" value="<?php echo $row['StoreId'] ?>"></td>
                                            <td><?php echo $row['StoreAddress'] ?></td>
                                            <td><?php echo $row['StorePhone'] ?></td>

                                        </tr>
                                        <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                            <!-- /.table-responsive -->

                        </div>

                        <!-- /.panel-body -->
                    </div>
                </div>
                <!-- /.panel -->
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span style="font-weight: bold;">Product Info</span>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Category Id</th>
                                        <th>Price</th>
                                        <th>Description</th>
                                        <th>Image</th>
        <!--                                        <th>Choose</th>-->
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    while ($row = mysqli_fetch_assoc($rs1)) {
                                        ?>

                                        <tr class="odd gradeX">
                                            <td><?php echo $row['ProdId'] ?><input type="hidden" name="ProdId" value="<?php echo $row['ProdId'] ?>"></td>
                                            <td><?php echo $row['ProdName'] ?></td>
                                            <td><?php echo $row['CategoryId'] ?></td>
                                            <td>$ <?php echo $row['Price'] ?></td>
                                            <td><?php echo $row['Description'] ?></td>
                                            <td><img src="../public/images/items/<?php echo $row['Image'] ?>" style="width: 100%;"></td>    
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->

                        </div>

                        <!-- /.panel-body -->
                    </div>
                </div>
                <!-- /.panel -->
            </div>
        </form>
        <?php
    }

    if (!empty($_POST['assignQuantity'])) {
        $rs1 = $hiep->viewAllProductsWhichHaveNotAssignedByAStore($_POST["storeId"]);
        $rs2 = $hiep->viewAllStores($_POST["storeId"]);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Assign Product Quantity</h1>
            </div></div>
        <br>
        <form action="./admin_productdetails_add_update.php" method="post" >
            <p>Please choose a store and a product below, before creating</p>
            <input type="hidden" name="doAddProductDetailDB" value="keepGoing">
            <input type="number" name="quantity" placeholder="Quantity" required=""/>
            <input type="submit" value="Create"/>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span style="font-weight: bold;">The Store</span>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Store Id</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Choose</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    while ($row = mysqli_fetch_assoc($rs2)) {
                                        ?>

                                        <tr class="odd gradeX">
                                            <td><?php echo $row['StoreId'] ?></td>
                                            <td><?php echo $row['StoreAddress'] ?></td>
                                            <td><?php echo $row['StorePhone'] ?></td>
                                            <td><input type="radio" name="chosenStore" value="<?php echo $row['StoreId'] ?>" checked=""/></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                            <!-- /.table-responsive -->

                        </div>

                        <!-- /.panel-body -->
                    </div>
                </div>
                <!-- /.panel -->
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span style="font-weight: bold;">List of Products Which have not been sold by this Store</span>
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
                                        <th>Choose</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    while ($row = mysqli_fetch_assoc($rs1)) {
                                        ?>

                                        <tr class="odd gradeX">
                                            <td><?php echo $row['ProdId'] ?></td>
                                            <td><?php echo $row['ProdName'] ?></td>
                                            <td><?php echo $row['CategoryId'] ?></td>
                                            <td><?php echo $row['Price'] ?></td>
                                            <td><?php echo $row['Description'] ?></td>
                                            <td><img src="../public/images/items/<?php echo $row['Image'] ?>" style="width: 100%;"></td>                                    


                                            <td><input type="radio" name="chosenProduct" value="<?php echo $row['ProdId'] ?>" required=""/></td>


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
        </form>
        <?php
    }
}else{
    header("Location: ./login.php");
}
?>

