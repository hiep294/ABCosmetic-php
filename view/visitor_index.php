
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
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
        <!--body-->
        <!--need margin:auto-->
        <div class="row" style="background-color: white;margin: auto">
            <?php
            require_once './visitor_header.html';
            require_once './visitor_slider.html';
            require_once '../controller/VisitorController.php';

            $hiep = new VisitorController();
//            $query = "select * from tblproduct";
//do stuff: print all product:
            $result = $hiep->viewAllProducts("");
//            if (!$result) {
//                die($conn->error);
//            }
            echo "<br>";
//Looping through the results
            ?>
            <div class="col-md-10">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>

                    <div class="col-md-3 col-sm-6 col-xs-12" title="">
                        <div class="thumbnail" style="">
                            <a href="./visitor_product_detail.php?product=<?php echo $row['ProdId'] ?>">
                                <img src="../public/images/items/<?php echo $row['Image'] ?>" alt="Lights" />
                            </a>
                            <div class="caption" style="text-align:center !important">
                                <a href="./visitor_product_detail.php?product=<?php echo $row['ProdId'] ?>" class="hot"><h1 style="font-size: 1.5vw; color:black;"><?php echo $row['ProdName'] ?></h1></a>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <p class="redColor">Price: $ <?php echo $row['Price'] ?></p>
                            </div>
                            <a href="./visitor_product_detail.php?product=<?php echo $row['ProdId'] ?>"><span class="blueColor">More Info</span></a>
                        </div>
                    </div>

                    <?php
                }
                ?>
            </div>
            <div class="col-md-2">

                <form class="" action="/action_page.php">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search" name="search">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </form>
                <div class="btn-group-vertical">
                    <p><a href="#"><button type="button" class="btn btn-primary">Skin Care</button></a></p>
                    <p><a href="#"><button type="button" class="btn btn-primary">Make-up & Nails</button></a></p>
                    <p><a href="#"><button type="button" class="btn btn-primary">Hair Care & Styling</button></a></p>
                </div>

            </div>
        </div>
    </div>
    <!--body: END-->

</body>
</html>

<?php
require_once './visitor_footer.html';
?>

