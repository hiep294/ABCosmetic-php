<?php
if ($_COOKIE['UserRole'] == 2) {
    //require Admin COntroller
    require_once '../controller/NationalManagerController.php';
    //create an object of connection
    $hiep = new NationalManagerController();

    $OrderDate1 = "";
    $OrderDate2 = "";
    $StoreId = "";

    if (isset($_POST["DoFilter"])) {
        $OrderDate1 = $_POST["OrderDate1"];
        $OrderDate2 = $_POST["OrderDate2"];
        $StoreId = $_POST["StoreId"];
    }


    $ordersOrderDetailsByStore = $hiep->viewOrdersAndOrderDetailByStore($OrderDate1, $OrderDate2, $StoreId);
    $hiep->setRecordedQuantityAndTotalAmount($ordersOrderDetailsByStore);
    $recordedQuantity = $hiep->getTotalQuantity2();
    $recordedTotalAmount = $hiep->getTotalAmount2();
    $ordersOrderDetailsByStore = $hiep->viewOrdersAndOrderDetailByStore($OrderDate1, $OrderDate2, $StoreId);
    ?>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Report Order For Store</h1>
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <form action="./national_manager_index.php?area=store" method="post" >
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
                                <select name="StoreId" class="form-control">
                                    <option value=''>All Stores</option>
                                    <?php 
                                    $stores = $hiep->viewAllStores("");//view the sale staff
                                    while ($row = mysqli_fetch_array($stores)) {
                                        $id = $row[0];
                                        $address = $row[1];
                                        if ($row[0] == $_POST["StoreId"]) {
                                            $selected = "selected"; //to select the choosen UserId
                                        }else{
                                            $selected = "";
                                        }
                                        echo "<option value='$id' $selected>Store $id: $address</option>";
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
                                <th>Store Id</th>
                                <th>Product Detail Id</th>
                                <th>Order Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $OrderIdNow = null;
                            while ($row = mysqli_fetch_assoc($ordersOrderDetailsByStore)) {
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
                                    <td>
                                        <?php
                                        if ($OrderIdBefore == $row['OrderId']) {
                                            
                                        } else {
                                            echo $row['StoreId'];
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