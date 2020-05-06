<?php
if ($_COOKIE['UserRole'] == 2) {
    require_once '../controller/NationalManagerController.php';
    $hiep = new NationalManagerController();

    //WORKING
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
                <h1 class="page-header">Product Detail Id: <?php echo $productdetailId; ?></h1>
            </div></div>
        <div class="row">
            <div class="col-lg-12">
            <!--<p>Please choose a store and a product below, before creating</p>-->
                <table width="60%" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Store Quantity:</th>
                            <th  style="width: 80%"><input type="number" name="quantity" value="<?php echo $quantity; ?>" class="form-control" readonly=""/></th>
                        </tr>
                    </thead>
                </table>
            </div></div>
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
        <?php
    }
} else {
    header("Location: ./login.php");
}
?>

