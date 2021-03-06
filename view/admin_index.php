<!DOCTYPE html>
<?php

if ($_COOKIE["UserRole"] == 1) {//if admin login, print admin pages
    ?>
    <html lang="en">

        <head>

            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="">
            <meta name="author" content="">

            <title>Admin Control</title>

            <!-- Bootstrap Core CSS -->
            <link href="../public/css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

            <!-- MetisMenu CSS -->
            <link href="../public/css/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

            <!-- DataTables CSS -->
            <link href="../public/css/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

            <!-- DataTables Responsive CSS -->
            <link href="../public/css/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

            <!-- Custom CSS -->
            <link href="../public/css/dist/css/sb-admin-2.css" rel="stylesheet">

            <!-- Morris Charts CSS -->
            <link href="../public/css/vendor/morrisjs/morris.css" rel="stylesheet">

            <!-- Custom Fonts -->
            <link href="../public/css/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->

        </head>

        <body>

            <div id="wrapper">

                <!-- Navigation -->
                <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="./admin_index.php?area=homepage">Admin Page</a>
                    </div>
                    <!-- /.navbar-header -->

                    <ul class="nav navbar-top-links navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="./admin_index.php?area=userinfo"><i class="fa fa-user fa-fw"></i> User Profile</a>
                                </li>
                                <li><a href="./admin_index.php?area=changepassword"><i class="fa fa-gear fa-fw"></i> Change Password</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="./login.php?action=logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                                </li>
                            </ul>
                            <!-- /.dropdown-user -->
                        </li>
                        <!-- /.dropdown -->
                    </ul>
                    <!-- /.navbar-top-links -->

                    <div class="navbar-default sidebar" role="navigation">
                        <div class="sidebar-nav navbar-collapse">
                            <ul class="nav" id="side-menu">
<!--                                <li class="sidebar-search">
                                    <div class="input-group custom-search-form">
                                        <input type="text" class="form-control" placeholder="Search...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                     /input-group 
                                </li>-->
                                <li>
                                    <a href="./admin_index.php?area=homepage"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                                </li>

                                <li>
                                    <a href="./admin_index.php?area=categoriesmanagement"><i class="fa fa-table fa-fw"></i> Category Management</a>
                                </li>
                                <li>
                                    <a href="./admin_index.php?area=productsmanagement"><i class="fa fa-table fa-fw"></i> Product Management</a>
                                </li>
                                <li>
                                    <a href="./admin_index.php?area=storesmanagement"><i class="fa fa-table fa-fw"></i> Store Management</a>
                                    <!-- /.nav-second-level -->
                                </li>
                                <li>
                                    <a href="./admin_index.php?area=productdetailsmanagement"><i class="fa fa-table fa-fw"></i> Assign Number of Products</a>
                                </li>
                                <li>
                                    <a href="./admin_index.php?area=staffsmanagement"><i class="fa fa-table fa-fw"></i> Staff Management</a>
                                </li>
                                <li>
                                    <a href="./admin_index.php?area=ordersmanagement"><i class="fa fa-table fa-fw"></i> Order Management</a>
                                </li>
                                <li>
                                    <a href="./admin_index.php?area=orderdetailsmanagement"><i class="fa fa-table fa-fw"></i> Order Detail Management</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.sidebar-collapse -->
                    </div>
                    <!-- /.navbar-static-side -->
                </nav>
                <!--CONTENT2-->
                <div id="page-wrapper">                    
                    <?php
                    switch ($_GET['area']) {
                        case "homepage":
                            require_once './homepage.php';
                            break;
                        case "userinfo":
                            require_once './user_info.php';
                            break;
                        case "changepassword":
                            require_once './change_password.php';
                            break;
                        case "categoriesmanagement":
                            require_once './admin_categories_management.php';
                            break;
                        case "categories_add_update":
                            require_once './admin_categories_add_update.php';
                            break;
                        case "productsmanagement":
                            require_once './admin_products_management.php';
                            break;
                        case "products_add_update":
                            require_once './admin_products_add_update.php';
                            break;
                        case "storesmanagement":
                            require_once './admin_stores_management.php';
                            break;
                        case "stores_add_update":
                            require_once './admin_stores_add_update.php';
                            break;
                        case "staffsmanagement":
                            require_once './admin_staffs_management.php';
                            break;
                        case "staffs_add_update":
                            require_once './admin_staffs_add_update.php';
                            break;
                        case "productdetailsmanagement":
                            require_once './admin_productdetails_management.php';
                            break;
                        case "productdetails_add_update":
                            require_once './admin_productdetails_add_update.php';
                            break;
                        case "ordersmanagement":
                            require_once './admin_orders.php';
                            break;
                        case "orderdetailsmanagement":
                            require_once './admin_orderdetails.php';
                            break;
                        case "order_update_delete":
                            require_once './admin_orders_update.php';
                            break;
                        default:
                            break;
                    }
                    ?>
                </div>

            </div>
            <!-- /#wrapper -->

            <!-- jQuery -->
            <script src="../public/css/vendor/jquery/jquery.min.js"></script>

            <!-- Bootstrap Core JavaScript -->
            <script src="../public/css/vendor/bootstrap/js/bootstrap.min.js"></script>

            <!-- Metis Menu Plugin JavaScript -->
            <script src="../public/css/vendor/metisMenu/metisMenu.min.js"></script>

            <!-- DataTables JavaScript -->
            <script src="../public/css/vendor/datatables/js/jquery.dataTables.min.js"></script>
            <script src="../public/css/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
            <script src="../public/css/vendor/datatables-responsive/dataTables.responsive.js"></script>

            <!-- Morris Charts JavaScript -->
            <script src="../public/css/vendor/raphael/raphael.min.js"></script>
            <script src="../public/css/vendor/morrisjs/morris.min.js"></script>
            <script src="../public/css/data/morris-data.js"></script>

            <!-- Custom Theme JavaScript -->
            <script src="../public/css/dist/js/sb-admin-2.js"></script>
            <script>
                $(document).ready(function () {
                    $('#dataTables-example').DataTable({
                        responsive: true
                    });
                    $('#dataTables-example2').DataTable({
                        responsive: true
                    });
                });
            </script>
        </body>

    </html>
    <?php
}else{
    header("Location: ./login.php");
}
?>