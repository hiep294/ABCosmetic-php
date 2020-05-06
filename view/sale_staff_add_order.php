<?php
if ($_COOKIE['UserRole'] == 3) {
    //require Admin COntroller
    require_once '../controller/SaleStaffController.php';
    //create an object of connection
    $hiep = new SaleStaffController();


    /* BEGIN: DO MOTIFYCATION */
    if (!empty($_POST['doAddOrderDB'])) {
        //predict next OrderId for add to table tblOrderDetail:
        $TheNextOrderId = $hiep->predictTheNextId("tblOrder");
        //check whether user chooses a product or not
        $i = 0;
        foreach ($_POST as $prodDetailId => $orderQuantity) {//get proddetailId and quantity.
            if ($prodDetailId == "doAddOrderDB" ||
                    $prodDetailId == "chosenCustomer" || $prodDetailId == "DateOfOrder" || $orderQuantity == 0 || $orderQuantity == "OutOfStock" ||
                    $prodDetailId == "dataTables-example_length" || $prodDetailId == "dataTables-example2_length") {
                continue;
            }

            $i++;
        }//source: https://stackoverflow.com/questions/183914/how-do-i-get-the-key-values-from-post
        if ($i == 0) {
            header("Location: ../view/sale_staff_index.php?area=addrecord");
        } else {
            //add a record in tblOrder
            $CustomerId = $_POST['chosenCustomer'];
            $DateOfOrder = $_POST['DateOfOrder'];
            $TotalAmount = 0;
            $UserId = $_COOKIE["UserId"];
            $hiep->addOrder($CustomerId, $DateOfOrder, $TotalAmount, $UserId);

            //add to tblOrderDetail, update total amount
            foreach ($_POST as $prodDetailId => $orderQuantity) {//get proddetailId and quantity.
                if ($prodDetailId == "doAddOrderDB" ||
                        $prodDetailId == "chosenCustomer" || $prodDetailId == "DateOfOrder" || $orderQuantity == 0 || $orderQuantity == "OutOfStock" ||
                        $prodDetailId == "dataTables-example_length" || $prodDetailId == "dataTables-example2_length") {
                    continue;
                }
                /* add to product detail, /update Store quantity */
                $hiep->addOrderDetailManagement($TheNextOrderId, $prodDetailId, $orderQuantity);
            }//source: https://stackoverflow.com/questions/183914/how-do-i-get-the-key-values-from-post


            header("Location: ../view/sale_staff_index.php?area=addrecord");
        }
    }

    if (!empty($_POST['doAddOrderDetailDB'])) {
        //predict next OrderId for add to table tblOrderDetail:
        $theOrderId = $_POST['doAddOrderDetailDB'];
        $theProductDetailId = $_POST['theProductDetailId'];
        $theOrderQuantity = $_POST['theOrderQuantity'];

        //add to tblOrderDetail, update total amount

        /* add to product detail, /update Store quantity */
        $hiep->addOrderDetailManagement($theOrderId, $theProductDetailId, $theOrderQuantity);
        $hiep->DBConnection->setCookie("fromAddorderDetail", $theOrderId);
        $witoutLoadPage = $hiep->DBConnection->getcookie("fromAddorderDetail");
        header("Location: ../view/sale_staff_index.php?area=orderdetails");
    }


    /* END: DO MOTIFYCATION */
    ///
    ////INTERFACE
    //////
    /* BEGIN:INTERFACE */
    if (!empty($_POST['theOrderId'])) {//ADD order DETAIL I*******************************************************//
        //find all customers
//find all product detail of the store
        $storeId = $_COOKIE["StoreId"];
        $productdetails = $hiep->tblProductDetail_tblProduct($storeId);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Add An Order Detail to Order, Id (<?php echo $_POST['theOrderId'] ?>)</h1>
            </div>

            <!-- /.col-lg-12 -->
        </div>

        <!--check order quantity and store quantity-->
<!--        <script type="text/javascript">
            function checkForm(form)
            {
                var orderQuantity = parseInt(document.getElementById("OrderQuantity1").value);
                var storeQuantity = parseInt(document.getElementById("StoreQuantity1").value);
                if (orderQuantity > storeQuantity) {
                    return false;
                    alert("Error: check the order quantity must be smaller than store quantity!");
                } else {

                    //                    form.checkStoreQuantity.focus();
                    return true;
                }
            }
 onsubmit="return checkForm(this);"
        </script>-->


        <form action="./sale_staff_add_order.php" method="post">
            <input type="hidden" name="doAddOrderDetailDB" value="<?php echo $_POST['theOrderId'] ?>">

            <div class="row">
                <div class="col-lg-10">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span style="font-weight: bold;">Products of the store, Id: <?php echo "$storeId"; ?></span>
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
                                        <th>Store Quantity</th>
                                        <th>Order Quantity</th>
        <!--                                        <th>Choose</th>-->
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    while ($row = mysqli_fetch_assoc($productdetails)) {
                                        ?>

                                        <tr class="odd gradeX">
                                            <td><?php echo $row['ProductDetailId'] ?></td>
                                            <td><?php echo $row['ProdId'] ?></td>
                                            <td><?php echo $row['ProdName'] ?></td>
                                            <td><img src="../public/images/items/<?php echo $row['Image'] ?>" style="width: 100%;"></td>
                                            <td>$ <?php echo $row['Price'] ?></td>
                                            <td><?php echo $row['StoreQuantity'] ?>
                                                <input type="hidden" name="checkStoreQuantity" placeholder="" value="<?php echo $row['StoreQuantity'] ?>"/>
                                            </td>
                                            <td><?php if ($row['StoreQuantity'] == 0) {
                                            ?><input type="text" name="<?php echo $row['ProductDetailId'] ?>" placeholder="" min="0" value="OutOfStock" readonly=""/><?php
                                                } else {
                                                    ?>
                                                    <input type="radio" name="theProductDetailId" placeholder="" value="<?php echo $row['ProductDetailId'] ?>" required=""/>

                                                    <?php
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
                <div class="col-lg-2">
                    <input type="number" name="theOrderQuantity" placeholder="Order Quantity" required="" min="1" value="1">
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
                <!-- /.panel -->
            </div>

        </form>


        <?php
        /* END:INTERFACE */
    } else {//ADD order INTERFACE//**////*******************************************************//
        //find all customers
        $customers = $hiep->ViewAllCustomers("");
//find all product detail of the store
        $storeId = $_COOKIE["StoreId"];
        $productdetails = $hiep->tblProductDetail_tblProduct($storeId);
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Add An Order</h1>
            </div>

            <!--/.col-lg-12 echo date('Y-m-d')-->
        </div>
        <form action="./sale_staff_add_order.php" method="post">
            <input type="date" name="DateOfOrder" value="<?php echo date('Y-m-d'); ?>" required/>
            <input type="hidden" name="doAddOrderDB" value="keepGoing">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span style="font-weight: bold;">Customers:</span>
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
                                            <td><input type="radio" name="chosenCustomer" value="<?php echo $row['CustomerId'] ?>" required=""/></td>

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



            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span style="font-weight: bold;">Products of the store, Id: <?php echo "$storeId"; ?></span>
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
                                        <th>Store Quantity</th>
                                        <th>Order Quantity</th>
        <!--                                        <th>Choose</th>-->
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    while ($row = mysqli_fetch_assoc($productdetails)) {
                                        ?>

                                        <tr class="odd gradeX">
                                            <td><?php echo $row['ProductDetailId'] ?></td>
                                            <td><?php echo $row['ProdId'] ?></td>
                                            <td><?php echo $row['ProdName'] ?></td>
                                            <td><img src="../public/images/items/<?php echo $row['Image'] ?>" style="width: 100%;"></td>
                                            <td>$ <?php echo $row['Price'] ?></td>
                                            <td><?php echo $row['StoreQuantity'] ?></td>
                                            <td><?php if ($row['StoreQuantity'] == 0) {
                                            ?><input type="text" name="<?php echo $row['ProductDetailId'] ?>" placeholder="" min="0" value="OutOfStock" readonly=""/><?php
                                                } else {
                                                    ?><input type="number" name="<?php echo $row['ProductDetailId'] ?>" placeholder="" min="0" max="<?php echo $row['StoreQuantity'] ?>" value="0" required=""/><?php
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

            <button type="submit" class="btn btn-default">Submit</button>
        </form>
        <?php
        /* END:INTERFACE */
    }
} else {
    header("Location: ./login.php");
}

