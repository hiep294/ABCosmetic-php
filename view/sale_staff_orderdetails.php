<?php
if ($_COOKIE['UserRole'] == 3) {
    $orderId = null;
    if (!empty($_POST['IdOfOrder'])) {
        $orderId = $_POST['IdOfOrder'];
    }
    if (!empty($_COOKIE['fromAddorderDetail'])) {
        $orderId = $_COOKIE['fromAddorderDetail'];
    }


    if ($orderId != null) {



        //require Admin COntroller
        require_once '../controller/SaleStaffController.php';
        //create an object of connection
        $hiep = new SaleStaffController();
        $orderdetails = $hiep->viewOrderDetails($orderId);



        //get result: all categories from DB
        ?>

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Order Id: <?php echo $orderId;?> in Detail</h1>
            </div>

            <!-- /.col-lg-12 -->
        </div>



        <form class="frminline" action="./sale_staff_index.php?area=addrecord" method="post">
            <!--get value of category Id for $_POST['updateCategory']-->
            <input type="hidden" name="theOrderId" value="<?php echo $orderId ?>"/>
            <input type="submit" value="Add New Order Detail"/>
        </form>
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
                                        <td><form class="frminline" action="./sale_staff_index.php?area=orders" method="post">
                                                <!--get value of category Id for $_POST['updateCategory']-->
                                                <input type="hidden" name="theOrderId" value="<?php echo $row['OrderId'] ?>"/>
                                                <input type="submit" value="View Order"/>
                                            </form>
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

        <!-- /.col-lg-12 -->


        <?php
    }
    if (!empty($_COOKIE['fromAddorderDetail'])) {
        $hiep->DBConnection->unsetCookie('fromAddorderDetail');;
    }
}else{
    header("Location: ./login.php");
}
?>