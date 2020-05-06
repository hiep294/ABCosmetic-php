<?php
if ($_COOKIE['UserRole'] == 2) {
    //require Admin COntroller
    require_once '../controller/NationalManagerController.php';
    //create an object of connection
    $hiep = new NationalManagerController();

    $OrderDate1 = "";
    $OrderDate2 = "";
    $ProductId = "";

    if (isset($_POST["DoFilter"])) {
        $OrderDate1 = $_POST["OrderDate1"];
        $OrderDate2 = $_POST["OrderDate2"];
        $ProductId = $_POST["ProductId"];
    }


    $ordersOrderDetailsByProduct = $hiep->viewOrdersAndOrderDetailByProduct($OrderDate1, $OrderDate2, $ProductId);
    $hiep->setRecordedQuantityAndTotalAmount($ordersOrderDetailsByProduct);
    $recordedQuantity = $hiep->getTotalQuantity2();
    $ordersOrderDetailsByProduct = $hiep->viewOrdersAndOrderDetailByProduct($OrderDate1, $OrderDate2, $ProductId);
    $hiep->setRecordedTotalSpendingForProducts($ordersOrderDetailsByProduct);
    $recordedTotalAmount = $hiep->getTotalAmount2();
    $ordersOrderDetailsByProduct = $hiep->viewOrdersAndOrderDetailByProduct($OrderDate1, $OrderDate2, $ProductId);
    ?>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Report Order For Product</h1>
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <form action="./national_manager_index.php?area=product" method="post" >
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
                                <select name="ProductId" class="form-control">
                                    <option value=''>All Products</option>
                                    <?php 
                                    $products = $hiep->viewAllProducts("");//view the sale staff
                                    while ($row = mysqli_fetch_array($products)) {
                                        $id = $row[0];
                                        $name = $row[1];
                                        if ($row[0] == $_POST["ProductId"]) {
                                            $selected = "selected"; //to select the choosen UserId
                                        }else{
                                            $selected = "";
                                        }
                                        echo "<option value='$id' $selected>$id: $name</option>";
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
                                <th>Store Id</th>
                                <th>Date Of Order</th>
                                <th>Sale Staff Id</th>
                                <th>Product Id</th>
                                <th>Order Quantity</th>
                                <th>Total Spending</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $OrderIdNow = null;
                            while ($row = mysqli_fetch_assoc($ordersOrderDetailsByProduct)) {
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
                                            echo $row['StoreId'];
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
                                            echo $row['UserId'];
                                        }
                                        ?>
                                    </td> 
                                    <td>
                                        <?php
                                        if ($OrderIdBefore == $row['OrderId']) {
                                            
                                        } else {
                                            echo $row['ProdId'];
                                        }
                                        ?>
                                    </td>                                     
                                    <td><?php echo $row['OrderQuantity'] ?></td>
                                    <td>
                                        <?php
                                        if ($OrderIdBefore == $row['OrderId']) {
                                            
                                        } else {
                                            //find price follow product detail id
                                            $price = $hiep->findPriceOfProduct($row['ProductDetailId']);
                                            $totalSpending = $price*$row['OrderQuantity'];
                                            echo "$ ".$totalSpending;
                                        }
                                        ?>
                                    </td>
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