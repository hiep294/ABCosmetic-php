<?php
require_once '../model/DBConnection.php';
$hiep = new DBConnection();
if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['storeid']) && isset($_POST['password']) && isset($_POST['therole'])) {
    $name= $hiep->truthString($_POST['name']);
    $phone=$hiep->truthString($_POST['phone']);
    $email=$hiep->truthString($_POST['email']);
    $storeid=$hiep->truthString($_POST['storeid']);
    $testP=$hiep->truthString($_POST['password']);
    $password= $hiep->passwordToToken($testP);
//    echo $password;
    $therole=$hiep->truthString($_POST['therole']);
    $str="insert into tblStaff(UserName,UserPhone,UserEmail,StoreId,Password,UserRole) values "
            . "('$name','$phone','$email',$storeid,'$password',$therole)";    
    $result=$hiep->runQueryMySql($str);
    if ($result) {
        echo "insert a $therole successfully!";
    }else{
        echo "error somewhere";
    }
}

?>
