<?php

setcookie("UserId", '', time() - 60 * 60 * 24 * 2, "/");
setcookie("UserName", '', time() - 60 * 60 * 24 * 2, "/");
setcookie("UserPhone", '', time() - 60 * 60 * 24 * 2, "/");
setcookie("UserEmail", '', time() - 60 * 60 * 24 * 2, "/");
setcookie("StoreId", '', time() - 60 * 60 * 24 * 2, "/");
setcookie("UserRole", '', time() - 60 * 60 * 24 * 2, "/");

header("Location: ../view/login.html");
?>
