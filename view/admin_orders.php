<?php
if ($_COOKIE['UserRole'] == 1) {


    //require Admin COntroller
    require_once '../controller/AdminController.php';
    //create an object of connection
    $hiep = new AdminController();
    if (!empty($_POST['deleleOrder'])) {
        $OrderId = $_POST['deleleOrder'];
        //delete order:
        $hiep->deleteOrder($OrderId);
    }
    /* control the $_GET and $_POST */
    $orders = $hiep->viewOrders("", "");
    //get result: all order from DB
    //
    //view order from an orderdetail
    if (!empty($_POST['theOrderId'])) {
        $OrderId = $_POST['theOrderId'];
        $orders = $hiep->viewOrders($OrderId, "isOrderId");
    }
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
                                <th>Recorder Id</th>
                                <th>View Order Details</th>                                
                                <th>Update</th>
                                <th>Delete</th>
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
                                    <td><form class="frminline" action="./admin_index.php?area=orderdetailsmanagement" method="post">
                                            <!--get value of category Id for $_POST['updateCategory']-->
                                            <input type="hidden" name="IdOfOrder" value="<?php echo $row['OrderId'] ?>"/>
                                            <input type="submit" value="Order Details"/>
                                        </form>
                                    </td>
                                    <td><form class="frminline" action="./admin_index.php?area=order_update_delete" method="post">
                                            <!--get value of category Id for $_POST['deleleCategory']-->
                                            <input type="hidden" name="updateOrder" value="<?php echo $row['OrderId'] ?>"/>
                                            <input type="submit" value="Update/ Detail"/>
                                        </form>
                                    </td>
                                    <td><form class="frminline" action="./admin_index.php?area=ordersmanagement" method="post" 
                                              onsubmit="return confirmDelete();">
                                            <!--get value of category Id for $_POST['deleleCategory']-->
                                            <input type="hidden" name="deleleOrder" value="<?php echo $row['OrderId'] ?>"/>
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
}else{
    header("Location: ./login.php");
}
?>