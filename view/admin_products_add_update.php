<?php
if ($_COOKIE['UserRole'] == 1) {
    require_once '../controller/AdminController.php';
    $hiep = new AdminController();
    //view all category


    /* DO STH WITH PRODUCTS */
    if (!empty($_POST['doUpdateProductDB'])) {
        $id = $_POST['id'];
        $name = $hiep->DBConnection->truthString($_POST['name']);
        $categoryId = $_POST['oldCategory'];
        if (!empty($_POST['chosenCategoryId'])) {
            $categoryId = $_POST['chosenCategoryId'];
        }

        $price = $_POST['price'];
        $desciption = $hiep->DBConnection->truthString($_POST['des']);
        $image = $hiep->DBConnection->truthString($_POST['image']);

        /**/
        if (isset($_FILES['image3']) && $_FILES['image3']['size'] != 0) {
            //delete the old image
            $path = "../public/images/items/$image";
            unlink($path);
            //create new image
            $temp_name = $_FILES['image3']['tmp_name'];
            $nameImage = $_FILES['image3']['name'];
            $parts = explode(".", $nameImage);
            $lastIndex = count($parts) - 1;
            $extension = $parts[$lastIndex];
//        echo "test1";
            //
            $image = "$id.$extension";
            $desciption2 = "../public/images/items/$image";
            move_uploaded_file($temp_name, $desciption2);
        }

        /**/
        //string
        $hiep->updateProduct($id, $name, $categoryId, $price, $desciption, $image);
        header("Location: ../view/admin_index.php?area=productsmanagement");
    }

    if (!empty($_POST['addProductDB']) && isset($_FILES['image']) && $_FILES['image']['size'] != 0) {
        $name = $hiep->DBConnection->truthString($_POST['name']);
        $categoryId = $_POST['chosenCategoryId'];
        $price = $_POST['price'];
        $desciption = $hiep->DBConnection->truthString($_POST['des']);
//        $image = $_POST['image'];
//        sett image follow id
//        && isset($_FILES['image']) && $_FILES['image']['size'] != 0
        /**/
        $temp_name = $_FILES['image']['tmp_name'];
        $nameImage = $_FILES['image']['name'];
        $parts = explode(".", $nameImage);
        $lastIndex = count($parts) - 1;
        $extension = $parts[$lastIndex];

//        echo "test1";
//        $rs3 = $hiep->DBConnection->runQueryMySql($str3);
        $nextProdId = $hiep->predictTheNextId("tblProduct");
//        while ($row3 = mysqli_fetch_assoc($rs3)) {
//            $nextProdId = $row3['NextId'];
//        }
        //
        $image = "$nextProdId.$extension";
        $desciption2 = "../public/images/items/$image";
        move_uploaded_file($temp_name, $desciption2);


        /**/
        $hiep->addProduct($name, $categoryId, $price, $desciption, $image);
        header("Location: ../view/admin_index.php?area=productsmanagement");
//        if ($result->num_rows == 1) {
//            
//        }
//        else{
////            echo "<script type='text/javascript'>alert('Add unsuccessfully, maybe double category name');</script>";
//        }
//        echo "tes1";
    }
    /* ENDDO STH WITH PRODUCTS */
    /**/
    /**/
    /**/
    $result2 = $hiep->viewAllCategories("");
    /* INTERFACE */
    //
    if (!empty($_POST['updateProduct'])) {
        $id = $_POST['updateProduct'];
        $result = $hiep->viewAllProducts($id);
        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['ProdName'];
            $categoryId = $row['CategoryId'];
            $price = $row['Price'];
            $desciption = $row['Description'];
            $image = $row['Image'];
        }
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Update Product</h1>
            </div>

            <!-- /.col-lg-12 -->
        </div>
        <!--        <form action="../controller/products_manager.php" method="post"> -->
        <form action="./admin_products_add_update.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-4">
                    <input type="hidden" class="form-control" name="doUpdateProductDB" value="keepGoing">
                    <div class="form-group">
                        <label for="text">Product Id:</label>
                        <input type="text" class="form-control" name="id" value="<?php echo $id; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="text">Product Name:</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" required="">
                    </div>

                    <div class="form-group">
                        <label for="text">Price:</label>
                        <input type="number" step="any" class="form-control" name="price" value="<?php echo $price; ?>" required="" min="0">
                    </div>
                    <div class="form-group">
                        <label for="text">Description:</label>                
                        <textarea class="form-control" name="des" rows="10" cols="30" required=""><?php echo $desciption; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="text">Update Image (if necessary):</label>    
                        <input type="file" name="image3">
                        <input type="hidden" class="form-control" name="image" value="<?php echo $image; ?>"><br>
                        <span style="font-weight: bold;">The Current Image:</span><img src="../public/images/items/<?php echo $image; ?>" style="width: 70%;">
                    </div>            

                </div>
                <div class="col-lg-8">
                    <div class="form-group">
                        <label for="text">The Current Category Id:</label>
                        <input type="text" class="form-control" name="oldCategory" value="<?php echo $categoryId; ?>" readonly>
                    </div>
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Category Id</th>
                                <th>Category Name</th>
                                <th>Choose</th>
                            </tr>
                        </thead>
                        <tbody>

        <?php
        while ($row2 = mysqli_fetch_assoc($result2)) {
            ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $row2['CategoryId'] ?></td>
                                    <td><?php echo $row2['CategoryName'] ?></td>
                                    <td>
                                        <!--get value of category Id for $_POST['deleleCategory']-->
                                        <input type="radio" name="chosenCategoryId" value="<?php echo $row2['CategoryId'] ?>"/>
                                    </td>
                                </tr>
            <?php
        }
        ?>    
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
            </div>
            <!--/Category/-->
        </form>
        <?php
    }

    if (!empty($_POST['addProduct'])) {
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Add New Product</h1>
            </div>
        </div>
        <!--<form action="../controller/products_manager.php" method="post">-->
        <form action="./admin_products_add_update.php" method="post" enctype="multipart/form-data"> 
            <div class="row">
                <div class="col-lg-4">
                    <input type="hidden" name="addProductDB" value="keepGoing">
                    <div class="form-group">
                        <label for="text">Product Name:</label>
                        <input type="text" class="form-control" name="name" required="">
                    </div>
                    <div class="form-group">
                        <label for="text">Price:</label>
                        <input type="number" step="any" class="form-control" name="price" required=""  min="0">
                    </div>
                    <div class="form-group">
                        <label for="text">Description:</label>                
                        <textarea class="form-control" name="des" rows="10" cols="30" required=""></textarea>
                    </div>
                    <div class="form-group">
                        <label for="text">Image:</label>                
                        <input type="file" name="image" required="">
                        <!--<input type="text" class="form-control" name="image">-->
                    </div>   
                </div>

                <div class="col-lg-8">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Category Id</th>
                                <th>Category Name</th>
                                <th>Choose</th>
                            </tr>
                        </thead>
                        <tbody>

        <?php
        while ($row2 = mysqli_fetch_assoc($result2)) {
            ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $row2['CategoryId'] ?></td>
                                    <td><?php echo $row2['CategoryName'] ?></td>
                                    <td>
                                        <!--get value of category Id for $_POST['deleleCategory']-->
                                        <input type="radio" name="chosenCategoryId" value="<?php echo $row2['CategoryId'] ?>" required=""/>
                                    </td>
                                </tr>
            <?php
        }
        ?>    
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
            </div>
            <!--/Category/-->
        </form>
        <?php
    }
}else{
    header("Location: ./login.php");
}
?>
