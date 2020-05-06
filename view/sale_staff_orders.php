<?php
if ($_COOKIE['UserRole'] == 3) {


    //require Admin COntroller
    require_once '../controller/SaleStaffController.php';
    //create an object of connection
    $hiep = new SaleStaffController();
    $UserId = $_COOKIE["UserId"];


    /* control the $_GET and $_POST */
    if (!empty($_POST['theOrderId'])) {
        $OrderId = $_POST['theOrderId'];
        $orders = $hiep->viewOrders($OrderId, "isOrderId");
    } else {
        $orders = $hiep->viewOrders($UserId, "isUserId");
    }
    /* control the $_GET and $_POST */

    //get result: all categories from DB
    ?>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Recorded Orders</h1>
        </div>

        <!-- /.col-lg-12 -->
    </div>




    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Orders
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Customer Id</th>
                                <th>Date Of Order</th>
                                <th>Total Amount</th>
                                <th>User Id</th>
                                <th>View Order Details</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            while ($row = mysqli_fetch_assoc($orders)) {
                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $row['OrderId'] ?></td>
                                    <td><?php echo $row['CustomerId'] ?></td>
                                    <td><?php echo $row['DateOfOrder'] ?></td>
                                    <td>$ <?php echo $row['TotalAmount'] ?></td>
                                    <td><?php echo $row['UserId'] ?></td>
                                    <td><form class="frminline" action="./sale_staff_index.php?area=orderdetails" method="post">
                                            <!--get value of category Id for $_POST['updateCategory']-->
                                            <input type="hidden" name="IdOfOrder" value="<?php echo $row['OrderId'] ?>"/>
                                            <input type="submit" value="View Details"/>
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
}else{
    header("Location: ./login.php");
}
?>