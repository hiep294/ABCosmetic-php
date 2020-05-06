<?php
if ($_COOKIE['UserRole'] == 1) {
    require_once '../controller/AdminController.php';
    $hiep = new AdminController();
 
//DO UPDATE ORDER DETAIL
    if (!empty($_POST['doUpdateOrderDetail'])) {
        $currentOrderId = $_POST['currentOrderId'];
        $currentProductDetailId = $_POST['currentProductDetailId'];
        $updatedProductDetailId = $_POST['chosenProductDetail'];
        $updatedOrderQuantity = $_POST['orderQuantity'];
        //do delete order detail
        $hiep->deleteOrderDetailManager($currentOrderId, $currentProductDetailId);
        // do add order detail in current OrderId, handle in sale staff controller
        $hiep->addOrderDetailManagement($currentOrderId, $updatedProductDetailId, $updatedOrderQuantity);
        //set cookie
        $hiep->DBConnection->setCookie("ordersDetailUpdate_to_orderDetails",$currentOrderId);
        //without load pages:
        $witoutLoadPage= $hiep->DBConnection->getcookie('ordersDetailUpdate_to_orderDetails');
        header("Location: ../view/admin_index.php?area=orderdetailsmanagement");
    }
    /* DO UPDATE ORDER */
    if (!empty($_POST['doUpdateOrder'])) {
        $theOrderId = $_POST['orderId'];
        $theCustomerId = $_POST['customerId'];
        if (isset($_POST['chosenCustomer'])) {
            $theCustomerId = $_POST['chosenCustomer'];
        }
        $theOrderDate = $_POST['orderDate'];
        $hiep->updateOrder($theOrderId, $theCustomerId, $theOrderDate);
        header("Location: ../view/admin_index.php?area=ordersmanagement");
    }


//INTERFACE: ORDER
    if (!empty($_POST['updateOrder'])) {
        $orderId = $_POST['updateOrder'];
        $order = $hiep->viewOrders($orderId, "isOrderId");
        while ($row = mysqli_fetch_assoc($order)) {
            $customerId = $row['CustomerId'];
            $orderDate = $row['DateOfOrder'];
            $totalAmount = $row['TotalAmount'];
            $userId = $row['UserId'];
        }
        //customer
        $customers = $hiep->ViewAllCustomers("");
        ?>
<div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Update Order</h1>
        </div>

        <!-- /.col-lg-12 -->
</div><div class="row">
        <form action="./admin_orders_update.php" method="post">
            <div div class="col-lg-4">
                <input type="hidden" name="doUpdateOrder" value="keepGoing">
                <div class="form-group">
                    <label for="name">Order Id:</label>
                    <input type="number" class="form-control" name="orderId" value="<?php echo $orderId; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="text">Customer Id:</label>
                    <input type="text" class="form-control" name="customerId" value="<?php echo $customerId; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="text">Total Amount:</label>
                    <input type="number" class="form-control" name="totalAmount" value="<?php echo $totalAmount; ?>" readonly>
                </div>   
                <div class="form-group">
                    <label for="text">Date Of Order:</label>
                    <input type="date" class="form-control" name="orderDate" value="<?php echo $orderDate; ?>" required="">
                </div>
                <div class="form-group">
                    <label for="text">User Id:</label>
                    <input type="text" class="form-control" name="userId" value="<?php echo $userId; ?>" readonly>
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </div>  



            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span style="font-weight: bold;">For Update Customer:</span>
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
                                    <th>Choose</th>
        <!--                                        <th>Choose</th>-->
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                while ($row = mysqli_fetch_assoc($customers)) {
                                    ?>

                                    <tr class="odd gradeX">
                                        <td><?php echo $row['CustomerId'] ?></td>
                                        <td><?php echo $row['CustomerName'] ?></td>
                                        <td><?php echo $row['CustomerPhone'] ?></td>
                                        <td><?php echo $row['CustomerEmail'] ?></td>
                                        <td><input type="radio" name="chosenCustomer" value="<?php echo $row['CustomerId'] ?>"/></td>

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

        </form>
    </div>
        <?php
    }

//OTHER INTERFACE: for order detail 
    if (!empty($_POST['updateOrderDetail'])) {
        $OrderId = $_POST['updateOrderDetail_OrderId'];
        $ProductDetailId = $_POST['updateOrderDetail_ProductDetailId'];
        $orderdetail = $hiep->viewTheOrderDetail($OrderId, $ProductDetailId);
        while ($row = mysqli_fetch_assoc($orderdetail)) {
            $OrderQuantity = $row['OrderQuantity'];
        }


        //print product details in where the staff works
        $ProductDetailsOfTheStore = $hiep->findProductDetailsOfTheStoreFromOrderIdManagement($OrderId);
        //current product detail
        while ($row0 = mysqli_fetch_assoc($ProductDetailsOfTheStore)) {
            if ($row0["ProductDetailId"] == $ProductDetailId) {
                $currentProdId = $row0["ProdId"];
                $currentProdName = $row0["ProdName"];
                $currentImage = $row0["Image"];
                $currentPrice = $row0["Price"];
                $currentStoreId = $row0["StoreId"];
                $currentStoreQuantity = $row0["StoreQuantity"];
            }
        }
        //reload $ProductDetailsOfTheStore
        $ProductDetailsOfTheStore = $hiep->findProductDetailsOfTheStoreFromOrderIdManagement($OrderId);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Update Order Detail</h1>
            </div></div>
        <form action="./admin_orders_update.php" method="post">
            <div div class="col-lg-4">
                <input type="hidden" name="doUpdateOrderDetail" value="keepGoing">
                <div class="form-group">
                    <label for="name">Order Id:</label>
                    <input type="text" class="form-control" name="currentOrderId" value="<?php echo $OrderId; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="text">Product Detail Id:</label>
                    <input type="text" class="form-control" name="currentProductDetailId" value="<?php echo $ProductDetailId; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="text">Order Quantity:</label>
                    <input type="number" class="form-control" name="orderQuantity" value="<?php echo $OrderQuantity; ?>" required="">
                </div>               
                <button type="submit" class="btn btn-default">UPDATE ORDER DETAIL</button>
            </div>  



            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span style="font-weight: bold;">THE CURRENT PRODUCT DETAIL</span>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Product Detail Id</th>
                                    <th>Product Id</th>
                                    <th>Product Name</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Store Id</th>
                                    <th>Store Quantity</th>
                                    <th>Choose</th>
        <!--                                        <th>Choose</th>-->
                                </tr>
                            </thead>
                            <tbody>



                                <tr class="odd gradeX">
                                    <td><?php echo $ProductDetailId ?></td>
                                    <td><?php echo $currentProdId ?></td>
                                    <td><?php echo $currentProdName ?></td>
                                    <td><img src="../public/images/items/<?php echo $currentImage ?>" style="width: 100%;"></td>
                                    <td>$ <?php echo $currentPrice ?></td>
                                    <td><?php echo $currentStoreId ?></td>
                                    <td><?php echo $currentStoreQuantity ?></td>
                                    <td><?php if ($currentStoreQuantity == 0) {
            ?><input type="text" name="" placeholder="" value="OutOfStock" readonly=""/><?php
                                        } else {
                                            ?> <input type="radio" name="chosenProductDetail" value="<?php echo $ProductDetailId ?>" checked=""/><?php
                                        }
                                        ?>
                                    </td>

                                </tr>


                            </tbody>
                        </table>
                        <!-- /.table-responsive -->

                    </div>

                    <!-- /.panel-body -->
                </div>
            </div>
            <!-- /.panel -->



            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span style="font-weight: bold;">PRODUCTS OF STORE WHICH THE SALE STAFF WORKS</span>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example2">
                                <thead>
                                    <tr>
                                        <th>Product Detail Id</th>
                                        <th>Product Id</th>
                                        <th>Product Name</th>
                                        <th>Image</th>
                                        <th>Price</th>
                                        <th>Store Id</th>
                                        <th>Store Quantity</th>
                                        <th>Choose</th>
        <!--                                        <th>Choose</th>-->
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    while ($row = mysqli_fetch_assoc($ProductDetailsOfTheStore)) {
                                        ?>

                                        <tr class="odd gradeX">
                                            <td><?php echo $row['ProductDetailId'] ?></td>
                                            <td><?php echo $row['ProdId'] ?></td>
                                            <td><?php echo $row['ProdName'] ?></td>
                                            <td><img src="../public/images/items/<?php echo $row['Image'] ?>" style="width: 100%;"></td>
                                            <td>$ <?php echo $row['Price'] ?></td>
                                            <td><?php echo $row['StoreId'] ?></td>
                                            <td><?php echo $row['StoreQuantity'] ?></td>
                                            <td><?php if ($row['StoreQuantity'] == 0) {
                                            ?><input type="text" name="" placeholder="" value="OutOfStock" readonly=""/><?php
                                                } else {
                                                    ?> <input type="radio" name="chosenProductDetail" value="<?php echo $row['ProductDetailId'] ?>"/><?php
                                                }
                                                ?>
                                            </td>

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

            <!-- /.panel -->

        </form>
        <?php
    }
}else{
    header("Location: ./login.php");
}
    