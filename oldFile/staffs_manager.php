<?php

if ($_COOKIE['UserRole'] == 1) {
    require_once '../model/0ConnectDB.php';
    if (!empty($_POST['deleleStaff'])) {
        $StaffId = $_POST['deleleStaff'];
        $queryString = "DELETE FROM tblStaff WHERE UserId=$StaffId;";
        runQueryMySql($queryString);
        header("Location: ../view/admin_index.php?area=staffsmanagement");
    }

    if (!empty($_POST['StaffId']) && !empty($_POST['StaffName']) && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['therole'])) {
        $id = $_POST['StaffId'];
        $name= truthString($_POST['StaffName']);
        $phone = truthString($_POST['phone']);
        $email = truthString($_POST['email']);
        $storeid= $_POST['oldStoreId'];
        if (!empty($_POST['chosenStoreId'])) {
            $storeid = $_POST['chosenStoreId'];
        }
        
        $role = $_POST['therole'];        
        $queryString="UPDATE tblStaff "
                . "SET UserName='$name',UserPhone='$phone',UserEmail='$email',StoreId='$storeid',UserRole='$role' "
                . "WHERE UserId=$id";
        runQueryMySql($queryString);
        header("Location: ../view/admin_index.php?area=staffsmanagement");
    }

    if (!empty($_POST['addStaffName']) && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['pass']) && !empty($_POST['therole']) && !empty($_POST['chosenStoreId'])) {
//        echo "test";
        $name = truthString($_POST['addStaffName']);
        $phone = truthString($_POST['phone']);
        $email = truthString($_POST['email']);
        $pass = $_POST['pass'];
        $passToken = passwordToToken($pass);
        $role = $_POST['therole'];
        $storeId = $_POST['chosenStoreId'];
        //string
        $queryString = "insert into tblStaff(UserName,UserPhone,UserEmail,StoreId,Password,UserRole) values "
                . "('$name','$phone','$email','$storeId','$passToken','$role');";
        
        runQueryMySql($queryString);
        header("Location: ../view/admin_index.php?area=staffsmanagement");
//        if ($result->num_rows == 1) {
//            
//        }
//        else{
////            echo "<script type='text/javascript'>alert('Add unsuccessfully, maybe double category name');</script>";
//        }
    }
    header("Location: ../view/admin_index.php?area=staffsmanagement");
}


