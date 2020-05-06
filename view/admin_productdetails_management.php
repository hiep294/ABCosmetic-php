<?php
if ($_COOKIE['UserRole'] == 1) {
    require_once '../controller/AdminController.php';
    $hiep = new AdminController();

    //delete product detail:
    if (isset($_POST['deleleProductDetail'])) {
        $hiep->deleteProductDetail($_POST['deleleProductDetail']);
        header("Location: ./admin_index.php?area=productdetailsmanagement");
    }

    //get result: all categories from DB
    $condition = "";
    if (isset($_POST['searchProdId'])) {
        if ($_POST['searchProdId'] != "allProducts" && $_POST['searchStoreId'] == "allStores") {
            $id1 = $_POST['searchProdId'];
            $condition = "ProdId='$id1'";
        } elseif ($_POST['searchStoreId'] != "allStores" && $_POST['searchProdId'] == "allProducts") {
            $id2 = $_POST['searchStoreId'];
            $condition = "StoreId='$id2'";
        } elseif ($_POST['searchStoreId'] != "allStores" && $_POST['searchProdId'] != "allProducts") {
            $id1 = $_POST['searchProdId'];
            $id2 = $_POST['searchStoreId'];
            $condition = "StoreId='$id2' AND ProdId='$id1'";
//        if ($_POST['searchProdId']=="allProducts" && $_POST['searchStoreId'] == "allStores") {
//            $condition = "";
//        }
        }
    }


    $result = $hiep->viewAllProductDetailsCond($condition);
    ?>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><a href="./admin_index.php?area=productdetailsmanagement">Store Quantity</a></h1>
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <form action="./admin_index.php?area=productdetails_add_update" method="post" >
            <div class="col-lg-12">
                <table width="100%" class="table table-striped table-bordered table-hover">                    
                    <thead>
                        <tr>
                            <th><input type="hidden" name="assignQuantity" value="yes"/>
                                <!--//yTHE action-->
                                <select name="storeId" class="form-control" required="">
                                    <?php
                                    $allStores = $hiep->viewAllStores("");
                                    while ($row = mysqli_fetch_array($allStores)) {
                                        $id = $row[0];
                                        $addess = $row[1];
                                        echo "<option value='$id'>Store: $id. $addess</option>";
                                    }
                                    ?>
                                </select></th>
                            <th><input type="submit" value="Create A New Record" class="btn-danger"/></th>
                        </tr>
                    </thead>
                </table>
            </div>            
        </form>
    </div>

    <div class="row">
        <form action="./admin_index.php?area=productdetailsmanagement" method="post" >
            <div class="col-lg-12">
                <!--get value of category Id for $_POST['updateCategory']-->
                <!--<input type="number" name="searchProdId" placeholder="Product Id"/>-->
                <table width="100%" class="table table-striped table-bordered table-hover">                    
                    <thead>
                        <tr>
                            <th>
                                <select name="searchProdId" class="form-control">
                                    <option value='allProducts'>All products</option>
                                    <?php
                                    $allProducts = $hiep->viewAllProducts("");
                                    while ($row11 = mysqli_fetch_array($allProducts)) {

                                        $id1 = $row11[0];
                                        $name = $row11[1];
                                        if ($row11[0] == $_POST['searchProdId']) {
                                            $select = "selected";
                                        } else {
                                            $select = "";
                                        }
                                        echo "<option value='$id1' $select>$id1. $name</option>";
                                    }
                                    ?>
                                </select>
                            </th>
                            <th>
                                <select name="searchStoreId" class="form-control">
                                    <option value='allStores'>All Stores</option>
                                    <?php
                                    $allStores2 = $hiep->viewAllStores("");
                                    while ($row = mysqli_fetch_array($allStores2)) {
                                        $id = $row[0];
                                        $addess = $row[1];
                                        if ($row[0] == $_POST['searchStoreId']) {
                                            $select2 = "selected";
                                        } else {
                                            $select2 = "";
                                        }
                                        echo "<option value='$id' $select2>$id. $addess</option>";
                                    }
                                    ?>
                                </select>
                            </th>

                            <th style="width: 50%"><input type="submit" value="Find" class="btn-circle"/></th>

                        </tr>
                    </thead>
                </table>

                <!--            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                <input type="number" name="searchStoreId" placeholder="Store Id"/>
                                <div style="font-size: 10px;"><input type="submit" value="Find" class="btn-circle"/></div>-->
            </div>
        </form>





        <div class="row">
            <div class="col-lg-12">
            </div>
        </div>





    </div>
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
                                <th>Product Detail Id</th>
                                <th>Product Id</th>
                                <th>Store Id</th>
                                <th>Offer Quantity</th>
                                <th>Delete</th>
                                <th>Update/Detail</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $row['ProductDetailId'] ?></td>
                                    <td><?php echo $row['ProdId'] ?></td>
                                    <td><?php echo $row['StoreId'] ?></td>
                                    <td><?php echo $row['StoreQuantity'] ?></td>
                                    <td><form class="frminline" action="./admin_productdetails_management.php" method="post" 
                                              onsubmit="return confirmDelete();">
                                            <!--get value of category Id for $_POST['deleleCategory']-->
                                            <input type="hidden" name="deleleProductDetail" value="<?php echo $row['ProductDetailId'] ?>"/>
                                            <input type="submit" value="delete"/>
                                        </form></td>

                                    <td><form class="frminline" action="./admin_index.php?area=productdetails_add_update" method="post">
                                            <!--get value of category Id for $_POST['updateCategory']-->
                                            <input type="hidden" name="updateProductDetail" value="<?php echo $row['ProductDetailId'] ?>"/>
                                            <input type="submit" value="update/detail"/>
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
} else {
    header("Location: ./login.php");
}
?>