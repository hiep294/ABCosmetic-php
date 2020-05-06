<?php
session_start();
//require LoginController
require_once '../controller/LoginController.php';
$hiep = new LoginController();

/* LOGOUT */
if ($_GET["action"] == "logout") {
    $hiep->DBConnection->unsetCookie("UserId");
    $hiep->DBConnection->unsetCookie("UserName");
    $hiep->DBConnection->unsetCookie("UserPhone");
    $hiep->DBConnection->unsetCookie("UserEmail");
    $hiep->DBConnection->unsetCookie("StoreId");
    $hiep->DBConnection->unsetCookie("UserRole");
    header("Location: ./login.php");
}
/* END: LOGOUT */

/* DO CHECK LOGIN */
if (isset($_POST["emailuser"]) && isset($_POST["passworduser"])) {
    $email = $hiep->DBConnection->truthString($_POST['emailuser']);
//    echo $email."<br>";
    $pass = $hiep->DBConnection->truthString($_POST['passworduser']);
    $tokenpass = $hiep->DBConnection->passwordToToken($pass);
//    echo $tokenpass."<br>";
    /* find user */
    $result = $hiep->checkLogin($email, $tokenpass);
    if ($result->num_rows == 1) { //if result exist, set cookie, and go to the homepage
        /* set cookie, / effect to all pages */
        while ($row = mysqli_fetch_assoc($result)) {
            $hiep->DBConnection->setCookie("UserId", $row['UserId']);
            $hiep->DBConnection->setCookie("UserName", $row['UserName']);
            $hiep->DBConnection->setCookie("UserPhone", $row['UserPhone']);
            $hiep->DBConnection->setCookie("UserEmail", $row['UserEmail']);
            $hiep->DBConnection->setCookie("StoreId", $row['StoreId']);
            $hiep->DBConnection->setCookie("UserRole", $row['UserRole']);
//            $hiep->DBConnection->unsetCookie("checkLogin");
            session_unset();
            session_destroy();
        }
//        header("Refresh:0");//reload page to set cookie
        if ($hiep->DBConnection->getcookie('UserRole') == 1) {
            header("Location: ../view/admin_index.php?area=homepage");
        } elseif ($hiep->DBConnection->getcookie('UserRole') == 2) {
            header("Location: ../view/national_manager_index.php?area=homepage");
        } else {
            //$_COOKIE['UserRole'] == 3
            header("Location: ../view/sale_staff_index.php?area=homepage");
        }
    } else {
        $_SESSION["checkLogin"] = "false";
        //set cookie
//        $hiep->DBConnection->setCookie("checkLogin", "false");
//        $hiep->DBConnection->setCookie("email", $_POST["emailuser"]);
//        $witoutLoadPage = $hiep->DBConnection->getcookie('checkLogin');
//        $witoutLoadPage2 = $hiep->DBConnection->getcookie('email');
        header("Location: ./login.php");
//        echo $result->num_rows;
    }
}
/* END:DO CHECK LOGIN */
//Login false:
?>
<!--INTERACE-->
<!--INTERACE-->
<!--INTERACE-->
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>SB Admin 2 - Bootstrap Admin Theme</title>

        <!-- Bootstrap Core CSS -->
        <link href="../public/css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../public/css/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../public/css/dist/css/sb-admin-2.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../public/css/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">



    </head>

    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please Sign In</h3>
                        </div>
                        <div class="panel-body">
                            <form action="./login.php" method="post">
                                <fieldset>
                                    <div class="form-group">


                                        <input class="form-control" placeholder="Your Email" name="emailuser" type="email" autofocus required="">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="passworduser" type="password" required="">
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                        </label>
                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <input type="submit" class="btn btn-lg btn-success btn-block" value="Login">
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="../vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../dist/js/sb-admin-2.js"></script>

    </body>

</html>


<?php
if (isset($_SESSION["checkLogin"])) {
    echo "<script type='text/javascript'>alert('Incorrect Username/Password!');</script>";
}

//
?>