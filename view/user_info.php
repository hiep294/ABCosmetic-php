<?php
if (isset($_COOKIE['UserRole'])) {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">User Information</h1>
        </div>

        <!-- /.col-lg-12 -->
    </div>

    <div style="font-size: 23px;">
        <?php
        echo "ID: " . $_COOKIE["UserId"] . "<br>";
        echo "Name: " . $_COOKIE["UserName"] . "<br>";
        echo "Phone: " . $_COOKIE["UserPhone"] . "<br>";
        echo "Email: " . $_COOKIE["UserEmail"] . "<br>";
        echo "StoreId: " . $_COOKIE["StoreId"] . "<br>";
        ?></div>
    <?php
    $role;
    if ($_COOKIE["UserRole"] == 1) {
        $role = "Admin";
    } elseif ($_COOKIE["UserRole"] == 2) {
        $role = "National Manager";
    } elseif ($_COOKIE["UserRole"] == 3) {
        $role = "Sale Staff";
    }
    ?>
    <div style="font-size: 23px;">
        <?php
        echo "Role: " . $role . "<br>" . "<br>";
        ?></div>
    <!--<a href="http://localhost:8888/GCH17086_PHP_Version1/controller/change_password.php">
        <button type="button" style="font-size: 23px;">Change Password</button></a>-->


    <?php
}
?>