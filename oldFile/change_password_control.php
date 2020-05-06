<?php

if (isset($_COOKIE['UserRole'])) {//check exist user

    require_once '../model/0ConnectDB.php';

//write query
    if (isset($_POST['oldpass']) && isset($_POST['newpass'])) {
//    if ($_POST['changed'] = 'changeok') {
//        alertMessage("Password is changed successfully!");
//    } elseif ($_POST['changed'] = 'notyet') {
//        alertMessage("Wrong old password! Password is not changed!");
//    }
        /* change password to true string */
        $oldpass = truthString($_POST['oldpass']);
        $newpass = truthString($_POST['newpass']);
        // change to token
        $oldpassToken = passwordToToken($oldpass);
        $newpassToken = passwordToToken($newpass);
        $id = $_COOKIE['UserId'];
        //
        $queryString = "Select * from tblStaff where UserId='$id' AND Password='$oldpassToken'";
        $result = runQueryMySql($queryString);
        if ($result->num_rows == 1) {
            $queryString2 = "Update tblStaff "
                    . "SET Password='$newpassToken' "
                    . "WHERE UserId='$id'";
            runQueryMySql($queryString2);
            echo "<script type='text/javascript'>alert('Changed pass successfully');</script>";
        }else{
            echo "<script type='text/javascript'>alert('Wrong old pass');</script>";
//            echo $oldpassToken."<br>";
//            echo $id;
        }
    }
}


