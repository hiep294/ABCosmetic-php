<?php
if ($_COOKIE['UserRole'] == 2) {
    //require Admin COntroller
    require_once '../controller/NationalManagerController.php';
    //create an object of connection
    $hiep = new NationalManagerController();

    $OrderDate1 = "";
    $OrderDate2 = "";
    $UserId = "";

    if (isset($_POST["DoFilter"])) {
        $OrderDate1 = $_POST["OrderDate1"];
        $OrderDate2 = $_POST["OrderDate2"];
        $UserId = $_POST["UserId"];
    }


    $ordersOrderDetails = $hiep->viewOrdersAndOrderDetail($OrderDate1, $OrderDate2, $UserId);
    $hiep->setRecordedQuantityAndTotalAmount($ordersOrderDetails);
    $recordedQuantity = $hiep->getTotalQuantity2();
    $recordedTotalAmount = $hiep->getTotalAmount2();
    $ordersOrderDetails = $hiep->viewOrdersAndOrderDetail($OrderDate1, $OrderDate2, $UserId);
    ?>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Report Order For Staff</h1>
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <form action="./national_manager_index.php?area=staff" method="post" >
        <input type="hidden" name="DoFilter" value="keepGoing" class="btn-circle"/>
        <div class="row">
            <div class="col-lg-12">
                <table width="100%" class="table table-striped table-bordered table-hover" style="padding: 0;">
                    <thead>
                        <tr>
                            <th>Recorded Quantity: <?php echo $recordedQuantity; ?>&emsp;|| &emsp;
                                Recorded Total Amount: $<?php echo $recordedTotalAmount; ?></th>
                        </tr>
                    </thead>
                </table>

                <table width="100%" class="table table-striped table-bordered table-hover">                    
                    <thead>
                        <tr>
                            <th><input type="date" class="form-control" value="<?php
                                if (isset($_POST["DoFilter"])) {
                                    echo $_POST["OrderDate1"];
                                } else {
                                    echo date('Y-m-d');
                                }
                                ?>" name="OrderDate1"></th>
                            <th><input type="date" class="form-control" value="<?php
                                if (isset($_POST["DoFilter"])) {
                                    echo $_POST["OrderDate2"];
                                } else {
                                    echo date('Y-m-d');
                                }
                                ?>" name="OrderDate2"></th>
                            <th>
                                <select name="UserId" class="form-control">
                                    <option value=''>All Sale Staffs</option>
                                    <?php
                                    $users = $hiep->viewAllSaleSaff(3);//view the sale staff
                                    while ($row = mysqli_fetch_array($users)) {
                                        $id = $row[0];
                                        $name = $row[1];
                                        if ($row[0] == $_POST["UserId"]) {
                                            $selected = "selected"; //to select the choosen UserId
                                        }else{
                                            $selected = "";
                                        }
                                        echo "<option value='$id' $selected>Sale Staff: $id. $name</option>";
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


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Purchases/Orders
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example44">
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Customer Id</th>
                                <th>Date Of Order</th>
                                <th>Total Amount</th>
                                <th>Sale Staff Id</th>
                                <th>Product Detail Id</th>
                                <th>Order Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $OrderIdNow = null;
                            while ($row = mysqli_fetch_assoc($ordersOrderDetails)) {
                                $OrderIdBefore = $OrderIdNow;
                                if ($OrderIdBefore != $row['OrderId'] && $OrderIdNow != null) {
                                    ?><tr class="odd gradeX">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr class="odd gradeX">
                                    <td>
                                        <?php
                                        if ($OrderIdBefore == $row['OrderId']) {
                                            
                                        } else {
                                            echo $row['OrderId'];
                                        }
                                        ?>
                                    </td>
                                    <td><?php
                                        if ($OrderIdBefore == $row['OrderId']) {
                                            
                                        } else {
                                            echo $row['CustomerId'];
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($OrderIdBefore == $row['OrderId']) {
                                            
                                        } else {
                                            echo $row['DateOfOrder'];
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($OrderIdBefore == $row['OrderId']) {
                                            
                                        } else {
                                            echo "$ ".$row['TotalAmount'];
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($OrderIdBefore == $row['OrderId']) {
                                            
                                        } else {
                                            echo $row['UserId'];
                                        }
                                        ?>
                                    </td> 
                                    <td><?php echo $row['ProductDetailId'] ?></td>
                                    <td><?php echo $row['OrderQuantity'] ?></td>
                                </tr>
                                <?php
                                $OrderIdNow = $row['OrderId'];
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
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