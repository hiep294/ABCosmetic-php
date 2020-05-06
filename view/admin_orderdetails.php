<?php
if ($_COOKIE['UserRole'] == 1) {


    //require Admin COntroller
    require_once '../controller/AdminController.php';
    //create an object of connection
    $hiep = new AdminController();

    //DO DELETE
     if (!empty($_POST['delOrderDetail_OrderId'])) {
        $deletedOrderId = $_POST['delOrderDetail_OrderId'];
        $deletedProductDetailId = $_POST['delOrderDetail_ProductDetailId'];
        //action:
        $hiep->deleteOrderDetailManager($deletedOrderId, $deletedProductDetailId);
    }

    ////
    if (!empty($_POST['IdOfOrder'])) {
        $orderdetails = $hiep->viewOrderDetails($_POST['IdOfOrder']);
    } elseif (!empty($_POST['delOrderDetail_OrderId'])) {
        $orderdetails = $hiep->viewOrderDetails($_POST['delOrderDetail_OrderId']);
    } elseif (!empty($_COOKIE['ordersDetailUpdate_to_orderDetails'])){
        $orderdetails = $hiep->viewOrderDetails($_COOKIE['ordersDetailUpdate_to_orderDetails']);
    }else{
        $orderdetails = $hiep->viewOrderDetails("");
    }




//INTERFACE
    //get result: all categories from DB
    ?>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Recorded Order In DETAILS</h1>
        </div>

        <!-- /.col-lg-12 -->
    </div>




    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Order Details
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Product Detail Id</th>
                                <th>Order Quantity</th>
                                <th>View Order</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            while ($row = mysqli_fetch_assoc($orderdetails)) {
                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $row['OrderId'] ?></td>
                                    <td><?php echo $row['ProductDetailId'] ?></td>
                                    <td><?php echo $row['OrderQuantity'] ?></td>
                                    <td><form class="frminline" action="./admin_index.php?area=ordersmanagement" method="post">
                                            <!--get value of category Id for $_POST['updateCategory']-->
                                            <input type="hidden" name="theOrderId" value="<?php echo $row['OrderId'] ?>"/>
                                            <input type="submit" value="View Order"/>
                                        </form>
                                    </td>
                                    <td><form class="frminline" action="./admin_index.php?area=order_update_delete" method="post">
                                            <!--get value of category Id for $_POST['deleleCategory']-->
                                            <input type="hidden" name="updateOrderDetail_OrderId" value="<?php echo $row['OrderId'] ?>"/>
                                            <input type="hidden" name="updateOrderDetail_ProductDetailId" value="<?php echo $row['ProductDetailId'] ?>"/>
                                            <input type="hidden" name="updateOrderDetail" value="keepGoing"/>
                                            <input type="submit" value="Update/ Detail"/>
                                        </form>
                                    </td>
                                    <td><form class="frminline" action="./admin_index.php?area=orderdetailsmanagement" method="post" 
                                              onsubmit="return confirmDelete();">
                                            <!--get value of category Id for $_POST['deleleCategory']-->
                                            <input type="hidden" name="delOrderDetail_OrderId" value="<?php echo $row['OrderId'] ?>"/>
                                            <input type="hidden" name="delOrderDetail_ProductDetailId" value="<?php echo $row['ProductDetailId'] ?>"/>
                                            <input type="submit" value="Delete"/>
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
     if (!empty($_COOKIE['ordersDetailUpdate_to_orderDetails'])) {
        $hiep->DBConnection->unsetCookie('ordersDetailUpdate_to_orderDetails');;
    }
//    $hiep->DBConnection->unsetCookie("ordersDetailUpdate_to_orderDetails");
}else{
    header("Location: ./login.php");
}

//reset cookie: ordersDetailUpdate_to_orderDetails

?>