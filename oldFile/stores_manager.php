<?php

if ($_COOKIE['UserRole'] == 1) {
    require_once '../model/0ConnectDB.php';
    if (!empty($_POST['deleleStore'])) {
        $StoreId = $_POST['deleleStore'];
        $queryString = "DELETE FROM tblStore WHERE StoreId=$StoreId;";
        runQueryMySql($queryString);
        header("Location: ../view/admin_index.php?area=storesmanagement");
    }

    if (!empty($_POST['idUpdateGoController']) && !empty($_POST['address']) && !empty($_POST['phone'])) {
        $id = $_POST['idUpdateGoController'];
        $addess = truthString($_POST['address']);
        $phone = truthString($_POST['phone']);
        $queryString="UPDATE tblStore "
                . "SET StoreAddress='$addess',StorePhone='$phone' "
                . "WHERE StoreId=$id";
        runQueryMySql($queryString);
        header("Location: ../view/admin_index.php?area=storesmanagement");
    }

    if (!empty($_POST['addStoreAdd']) && !empty($_POST['phone'])) {
        $storeName = truthString($_POST['addStoreAdd']);
        $phone = truthString($_POST['phone']);
        //string
        $queryString = "insert into tblStore(StoreAddress,StorePhone) values "
                . "('$storeName','$phone');";
        
        runQueryMySql($queryString);
        header("Location: ../view/admin_index.php?area=storesmanagement");
//        if ($result->num_rows == 1) {
//            
//        }
//        else{
////            echo "<script type='text/javascript'>alert('Add unsuccessfully, maybe double category name');</script>";
//        }
    }
    header("Location: ../view/admin_index.php?area=storesmanagement");
}


