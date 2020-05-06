<?php

if ($_COOKIE['UserRole'] == 1) {
    require_once '../model/0ConnectDB.php';
    if (!empty($_POST['deleleProduct'])) {
        $ProductId = $_POST['deleleProduct'];
        $queryString = "DELETE FROM tblProduct WHERE ProdId=$ProductId;";
        runQueryMySql($queryString);
        header("Location: ../view/admin_index.php?area=productsmanagement");
    }

    if (!empty($_POST['updateProductController']) && !empty($_POST['name']) && !empty($_POST['price']) && !empty($_POST['description'])) {
        $id = $_POST['updateProductController'];
        $name = truthString($_POST['name']);
        $categoryId = $_POST['oldCategory'];
        if (!empty($_POST['chosenCategoryId'])) {
            $categoryId = $_POST['chosenCategoryId'];
        }

        $price = $_POST['price'];
        $desciption = truthString($_POST['description']);
        $image = $_POST['image'];

        /**/
        if (isset($_FILES['image3']) && $_FILES['image3']['size'] != 0) {
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
        $queryString = "UPDATE tblProduct "
                . "SET ProdName='$name', CategoryId='$categoryId', Price='$price', Description='$desciption', Image='$image' "
                . "WHERE ProdId='$id';";

        runQueryMySql($queryString);
        header("Location: ../view/admin_index.php?area=productsmanagement");
    }

    if (!empty($_POST['addProductName']) && !empty($_POST['price']) && !empty($_POST['description']) && !empty($_POST['chosenCategoryId']) && isset($_FILES['image2']) && $_FILES['image2']['size'] != 0) {
        $name = truthString($_POST['addProductName']);
        $categoryId = $_POST['chosenCategoryId'];
        $price = $_POST['price'];
        $desciption = truthString($_POST['description']);
//        $image = $_POST['image'];
//        sett image follow id
//        && isset($_FILES['image']) && $_FILES['image']['size'] != 0
        /**/
        $temp_name = $_FILES['image2']['tmp_name'];
        $nameImage = $_FILES['image2']['name'];
        $parts = explode(".", $nameImage);
        $lastIndex = count($parts) - 1;
        $extension = $parts[$lastIndex];
//        echo "test1";

        $str3 = "SELECT `AUTO_INCREMENT` as 'NextId'
FROM  INFORMATION_SCHEMA.TABLES
WHERE TABLE_SCHEMA = 'CartOnline'
AND   TABLE_NAME   = 'tblProduct';";
        $rs3 = runQueryMySql($str3);
        while ($row3 = mysqli_fetch_assoc($rs3)) {
            $nextProdId = $row3['NextId'];
        }

        //
        $image = "$nextProdId.$extension";
        $desciption2 = "../public/images/items/$image";
        move_uploaded_file($temp_name, $desciption2);


        /**/
        $queryString = "insert into tblProduct(ProdName,CategoryId,Price,Description,image) values "
                . "('$name','$categoryId','$price','$desciption','$image');";

        runQueryMySql($queryString);
        header("Location: ../view/admin_index.php?area=productsmanagement");
//        if ($result->num_rows == 1) {
//            
//        }
//        else{
////            echo "<script type='text/javascript'>alert('Add unsuccessfully, maybe double category name');</script>";
//        }
//        echo "tes1";
    }
    header("Location: ../view/admin_index.php?area=productsmanagement");
//     echo "test2";
}


