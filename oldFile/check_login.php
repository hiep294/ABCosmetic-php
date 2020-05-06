<!--may reload page to see the cookie-->
<?php
if (isset($_POST["emailuser"]) && $_POST["passworduser"]) {
    require_once '../model/0ConnectDB.php';
    $email = truthString($_POST['emailuser']);
//    echo $email."<br>";
    $pass = truthString($_POST['passworduser']);
    $tokenpass = passwordToToken($pass);
//    echo $tokenpass."<br>";
    /* find user */
    $str = "select * from tblstaff where UserEmail='$email' AND  Password='$tokenpass'";
    $result = runQueryMySql($str);
//    $test = $result->row_nums;
//    echo "Row is: " . $test;
//    while ($row = mysqli_fetch_assoc($result)) {
//        setcookie("UserEmail", $row['UserEmail'], time() + 60 * 60 * 24, "/");
//        setcookie("UserRole", $row['UserRole'], time() + 60 * 60 * 24, "/");
//        echo $row['UserEmail']."<br>";
//        echo $row['Password']."<br>";
//    }
//    echo "Role is: " . $_COOKIE['UserRole'];
//    echo "Row is: " . $result->num_rows;

    if ($result->num_rows == 1) { //if result exist, set cookie, and go to the homepage
        /* set cookie, / effect to all pages */
        while ($row = mysqli_fetch_assoc($result)) {
            setcookie("UserId", $row['UserId'], time() + 60 * 60 * 24, "/");
            setcookie("UserName", $row['UserName'], time() + 60 * 60 * 24, "/");
            setcookie("UserPhone", $row['UserPhone'], time() + 60 * 60 * 24, "/");
            setcookie("UserEmail", $row['UserEmail'], time() + 60 * 60 * 24, "/");
            setcookie("StoreId", $row['StoreId'], time() + 60 * 60 * 24, "/");
            setcookie("UserRole", $row['UserRole'], time() + 60 * 60 * 24, "/");
        }
//        header("Refresh:0");//reload page to set cookie
        if (getcookie('UserRole') == 1) {
            header("Location: ../view/admin_index.php?area=homepage");
        } elseif (getcookie('UserRole') == 2) {
            header("Location: ../view/national_manager_index.php?area=homepage");
        } else {
            
            //$_COOKIE['UserRole'] == 3
            header("Location: ../view/sale_staff_index.php?area=homepage");
        }
    } else {
        echo $result->num_rows;
//        header("Location: http://localhost:8888/GCH17086_PHP_Version1/view/login.html"); //chuyển hướng về login
//        die();        
    }

    /* test set cookie */
//    setcookie("EmailUser", $email, time()+60*60*24,"/");
    //statement:find the user:
//    $queryString = " Select * from tblStaff where UserId=$id and Password='$pass' ";
//    $result = runQueryMySql($queryString);
//    if(!$result){
//        
//    }
//    echo "Cookie value: ".$_COOKIE["EmailUser"]."<br>";
//    echo $pass."<br>";
//    //remove cookie
////        setcookie("Email", "", time()-60*60*25,"/");
//        echo "Cookie value: ".$_COOKIE[Email]."<br>";
//        echo $pass."<br>";
}
?>
