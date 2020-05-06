<?php
if ($_COOKIE['UserRole'] == 1) {

    
    //require Admin COntroller
    require_once '../controller/AdminController.php';
    //create an object of connection
    $hiep= new AdminController();    
    
        /*control the $_GET and $_POST*/
    if (!empty($_POST['deleleCategory'])) {
        $CategoryIdDeleted = $_POST['deleleCategory'];
        $hiep->deleteCategory($CategoryIdDeleted);
        header("Location: ./admin_index.php?area=categoriesmanagement");
    }
    /*control the $_GET and $_POST*/
    
    //get result: all categories from DB
    $result = $hiep->viewAllCategories("");
    ?>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Category Management</h1>
        </div>

        <!-- /.col-lg-12 -->
    </div>

<form action="./admin_index.php?area=categories_add_update" method="post" >
        <!--get value of category Id for $_POST['updateCategory']-->
        <input type="hidden" name="addCategory" value="yes"/>
        <input type="submit" value="Add A Category"/>
    </form>


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    DataTables Advanced Tables
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Category Id</th>
                                <th>Category Name</th>
                                <th>Description</th>
                                <th>Delete</th>
                                <th>Update</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $row['CategoryId'] ?></td>
                                    <td><?php echo $row['CategoryName'] ?></td>
                                    <td><?php echo $row['Description'] ?></td>
                                    <td><form class="frminline" action="./admin_categories_management.php" method="post" 
                                              onsubmit="return confirmDelete();">
                                            <!--get value of category Id for $_POST['deleleCategory']-->
                                            <input type="hidden" name="deleleCategory" value="<?php echo $row['CategoryId'] ?>"/>
                                            <input type="submit" value="delete"/>
                                        </form></td>

                                    <td><form class="frminline" action="./admin_index.php?area=categories_add_update" method="post">
                                            <!--get value of category Id for $_POST['updateCategory']-->
                                            <input type="hidden" name="updateCategory" value="<?php echo $row['CategoryId'] ?>"/>
                                            <input type="submit" value="update"/>
                                        </form></td>
                                </tr>
                                <?php
                                
                            }
                            ?>
                        <script>
                            function confirmDelete() {
                                var r = confirm("Are you sure you would like to delete?");
                                if (r) {
                                    return true;
                                } else {
                                    return false;
                                }
                            }
                        </script>
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->

                </div>

                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.panel -->
    </div>

    <!-- /.col-lg-12 -->


    <?php
}else{
    header("Location: ./login.php");
}
?>