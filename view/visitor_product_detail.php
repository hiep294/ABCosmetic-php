

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <!-- /*for rating*/ -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- css -->
        <link rel="stylesheet" href="../public/css/laptop.css">
    </head>
    <body>
        <?php
        require_once './visitor_header.html';
////require_once 'slider.html';
//
//        require_once '../model/0ConnectDB.php';
////if connect go error
//        if ($conn->error) {
//            die($conn->error);
//        }
        require_once '../controller/VisitorController.php';

        $hiep = new VisitorController();

        $id = 1000; //default is the first product
//write query
        if (isset($_GET["product"])) {
            $id = $_GET["product"];
        }

//query
//        $query = "select * from tblProduct where ProdId=$id";
//run query:
        $result = $hiep->viewAllProducts($id);
//if running query get error
        if (!result) {
            die($conn->error);
        }
        ?>
        <div class="row" style="background-color: white;margin: auto">
            <?php
            // put your code here
            //connect Datbase

            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="row">
                    <div class="col-sm-5">
                        <div>
                            <a href="#">
                                <img src="../public/images/items/<?php echo $row['Image'] ?>" alt="Lights" class="imgProduct">
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4 justify2">
                        <h2><?php echo $row['ProdName'] ?></h2>

                        <!-- rating -->
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <h5 class="ita2">Review:</h5>

                        <p><?php echo $row['Description'] ?></p>
                    </div>
                    <div class=""></div>
                    <div class="col-sm-3 justify2">
                        <h2>Order detail</h2>
                        <h5>
                            Product ID: <?php echo $row['ProdId'] ?>
                        </h5>
                        <h5>Price: <span class="bold2 blueColor">  US$ <?php echo $row['Price'] ?></span></h5>
                        Available stores:
                        <select name="Available_stores">
                            <?php
                            $rssql = $hiep->tblProductDetail_tblStore($id);
                            while ($store = mysqli_fetch_array($rssql)) {
                                $StoreId = $store[0];
                                $Address = $store[1];
                                echo "<option value='$StoreId'>$Address</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <?php
            }
            ?>
        </div>
    </body>
</html>

<?php
require_once './visitor_footer.html';
?>

