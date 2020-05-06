<?php
if ($_COOKIE['UserRole'] == 2) {
    require_once '../controller/NationalManagerController.php';
    $hiep = new NationalManagerController();

    //delete product detail:
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


    $productDetails = $hiep->viewAllProductDetailsCond($condition);
    $hiep->setQuantity($productDetails);
    $StoreQuantity = $hiep->getTotalQuantity2();
    $productDetails = $hiep->viewAllProductDetailsCond($condition);
    ?>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><a href="./national_manager_index.php?area=productdetail">Remained Product</a></h1>
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form action="./national_manager_index.php?area=productdetail" method="post" >
                <input type="hidden" name="DoFilter" value="keepGoing" class="btn-circle"/>
                <div class="row">
                    <div class="col-lg-12">
                        

                        <table width="100%" class="table table-striped table-bordered table-hover">                    
                            <thead>
                                <tr>
                                    <th>Number Of Remained Products: <?php echo $StoreQuantity; ?></th>
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
                                                echo "<option value='$id1' $select>$id1.$name</option>";
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
                                                echo "<option value='$id' $select2>$id.$addess</option>";
                                            }
                                            ?>
                                        </select>
                                    </th>

                                    <th><input type="submit" value="Find" class="btn-circle"/></th>

                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </form>
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
                                <th>Remained Quantity</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            while ($row = mysqli_fetch_assoc($productDetails)) {
                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $row['ProductDetailId'] ?></td>
                                    <td><?php echo $row['ProdId'] ?></td>
                                    <td><?php echo $row['StoreId'] ?></td>
                                    <td><?php echo $row['StoreQuantity'] ?></td>
                                    <td><form class="frminline" action="./national_manager_index.php?area=storage_info" method="post">
                                            <!--get value of category Id for $_POST['updateCategory']-->
                                            <input type="hidden" name="updateProductDetail" value="<?php echo $row['ProductDetailId'] ?>"/>
                                            <input type="submit" value="detail"/>
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