<!DOCTYPE html>
<?php
if (isset($_COOKIE["UserRole"]) && $_COOKIE["UserRole"] == 3) {//if sale staff login, print admin pages
    ?>
    <html lang="en">

        <head>

            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="">
            <meta name="author" content="">

            <title>Sale Staff Control</title>
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
                        <a class="navbar-brand" href="./sale_staff_index.php?area=homepage">Sale Staff Page</a>
                    </div>
                    <!-- /.navbar-header -->

                    <ul class="nav navbar-top-links navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="./sale_staff_index.php?area=userinfo"><i class="fa fa-user fa-fw"></i> User Profile</a>
                                </li>
                                <li><a href="./sale_staff_index.php?area=changepassword"><i class="fa fa-gear fa-fw"></i> Change Password</a>
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
                                    <a href="./sale_staff_index.php?area=homepage"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                                </li>
                                <li>
                                    <a href="./sale_staff_index.php?area=addrecord"><i class="fa fa-table fa-fw"></i> Add An Order</a>
                                </li>
                                <li>
                                    <a href="./sale_staff_index.php?area=orders"><i class="fa fa-table fa-fw"></i> View Recorded Orders</a>
                                </li>
                                



                            </ul>
                        </div>
                        <!-- /.sidebar-collapse -->
                    </div>
                    <!-- /.navbar-static-side -->
                </nav>
                <!--CONTENT-->
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
                        case "addrecord":
                            require_once './sale_staff_add_order.php';
                            break;
                        case "orders":
                            require_once './sale_staff_orders.php';
                            break;
                        case "orderdetails":
                            require_once './sale_staff_orderdetails.php';
                            break;
                        default:
                            break;
                    }
                    ?>
                </div>

            </div>
            <!-- /#wrapper -->

            <!-- jQuery -->
            
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