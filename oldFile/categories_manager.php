<?php

if ($_COOKIE['UserRole'] == 1) {
    require_once '../model/0ConnectDB.php';
    if (!empty($_POST['deleleCategory'])) {
        $CategoryId = $_POST['deleleCategory'];
        $queryString = "DELETE FROM tblCategory WHERE CategoryId=$CategoryId;";
        runQueryMySql($queryString);
        header("Location: ../view/admin_index.php?area=categoriesmanagement");
    }

    if (!empty($_POST['updateCategoryController']) && !empty($_POST['Description']) && !empty($_POST['CategoryName'])) {
        $CategoryId = $_POST['updateCategoryController'];
        $CategoryName = truthString($_POST['CategoryName']);
        $Desciption = truthString($_POST['Description']);
        $queryString="UPDATE tblCategory "
                . "SET CategoryName='$CategoryName',Description='$Desciption' "
                . "WHERE CategoryId=$CategoryId";
        runQueryMySql($queryString);
        header("Location: ../view/admin_index.php?area=categoriesmanagement");
    }

    if (!empty($_POST['AddCategoryName']) && !empty($_POST['Description2'])) {
        $CategoryName = truthString($_POST['AddCategoryName']);
        $Desciption = truthString($_POST['Description2']);
        //string
        $queryString = "insert into tblCategory(CategoryName,Description) values "
                . "('$CategoryName','$Desciption');";
        
        runQueryMySql($queryString);
        header("Location: ../view/admin_index.php?area=categoriesmanagement");
//        if ($result->num_rows == 1) {
//            
//        }
//        else{
////            echo "<script type='text/javascript'>alert('Add unsuccessfully, maybe double category name');</script>";
//        }
    }
    header("Location: ../view/admin_index.php?area=categoriesmanagement");
}


