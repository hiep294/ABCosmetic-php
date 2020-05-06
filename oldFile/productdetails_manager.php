<?php

if ($_COOKIE['UserRole'] == 1) {
    require_once '../model/0ConnectDB.php';
    if (!empty($_POST['deleleProductDetail'])) {
        $id = $_POST['deleleProductDetail'];
        $queryString = "DELETE FROM tblProductDetail WHERE ProductDetailId=$id;";
        runQueryMySql($queryString);
        header("Location: ../view/admin_index.php?area=productdetailsmanagement");
    }

    if (!empty($_POST['updateStoreQuantity'])) {
        
        $StoreQuantity = $_POST['updateStoreQuantity'];
        $id = $_POST['productdetailId'];
        $queryString="UPDATE tblProductDetail "
                . "SET StoreQuantity='$StoreQuantity' "
                . "WHERE ProductDetailId=$id";
        runQueryMySql($queryString);
        header("Location: ../view/admin_index.php?area=productdetailsmanagement");
    }

    if (!empty($_POST['newStoreQuantity']) && !empty($_POST['chosenStore']) && !empty($_POST['chosenProduct'])) {
        $ProdId = $_POST['chosenProduct'];
        $StoreId = $_POST['chosenStore'];
        $StoreQuantity = $_POST['newStoreQuantity'];
        //string
        $queryString = "insert into tblProductDetail(ProdId,StoreId,StoreQuantity) values "
                . "('$ProdId','$StoreId','$StoreQuantity');";
        
        runQueryMySql($queryString);
        header("Location: ../view/admin_index.php?area=productdetailsmanagement");
//        if ($result->num_rows == 1) {
//            
//        }
//        else{
////            echo "<script type='text/javascript'>alert('Add unsuccessfully, maybe double category name');</script>";
//        }
    }
    header("Location: ../view/admin_index.php?area=productdetailsmanagement");
}


