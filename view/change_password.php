<?php
if (isset($_COOKIE['UserRole'])) {
    require_once '../controller/LoginController.php';
    $hiep = new LoginController();
    ?>
    <html>
        <head>
            <title>Change password</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <!--         Latest compiled and minified CSS 
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            
                     jQuery library 
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            
                     Latest compiled JavaScript 
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
        </head>
        <body>
            <?php
            // DO CHANGE PASS
            if (isset($_POST['oldpass']) && isset($_POST['newpass'])) {

                /* change password to true string */
                $oldpass = $hiep->DBConnection->truthString($_POST['oldpass']);
                $newpass = $hiep->DBConnection->truthString($_POST['newpass']);
                // change to token
                $oldpassToken = $hiep->DBConnection->passwordToToken($oldpass);
                $newpassToken = $hiep->DBConnection->passwordToToken($newpass);
                $id = $_COOKIE['UserId'];
                //check password                
                $result = $hiep->checkPassword($id, $oldpassToken);
                if ($result->num_rows == 1) {
                    $hiep->changePassword($id, $newpassToken);
//                    echo "<script type='text/javascript'>alert('Changed pass successfully');</script>";
                    if ($_COOKIE['UserRole'] == 1) {
                        header("Location: ../view/admin_index.php?area=homepage");
                    } elseif ($_COOKIE['UserRole'] == 2) {
                        header("Location: ../view/national_manager_index.php?area=homepage");
                    } else {

                        //$_COOKIE['UserRole'] == 3
                        header("Location: ../view/sale_staff_index.php?area=homepage");
                    }
                } else {
                    echo "<script type='text/javascript'>alert('Wrong old pass');</script>";
                    exit();
                }
            }
            //END: DO CHANGE PASS
            ?>
            <!--INTERFACE-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Change Password</h1>
                </div>

                <!-- /.col-lg-12 -->
            </div>
            <form action="./change_password.php" style='width: 50%;' method="post" onsubmit="return checkForm(this);">
                <div class="form-group">
                    <label for="pwd">Old password:</label>
                    <input type="password" class="form-control" name="oldpass" required="">
                </div>
                <div class="form-group">
                    <label for="pwd">New Password:</label>
                    <input type="password" class="form-control" name="newpass" required="">
                </div>
                <div class="form-group">
                    <label for="pwd">Confirm New Password:</label>
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" required="">
                </div>
                <button type="submit" class="btn btn-default">Confirm</button>
                <!--<button type="submit" class="btn btn-default">Confirm</button>-->
            </form>
            <script type="text/javascript">
                function checkForm(form)
                {
                    if (form.newpass.value == form.confirm_password.value) {
                        return true;
                    } else {
                        alert("Error: Please check that you've entered and confirmed your password!");
                        form.newpass.focus();
                        return false;
                    }
                }
            </script>
            <!--//source: https://www.the-art-of-web.com/javascript/validate-password/-->
            <br>         
        </body>

    </html>

    <?php
}
?>