<?php
if ($_COOKIE['UserRole'] == 1) {
    //require Admin COntroller
    require_once '../controller/AdminController.php';
    //create an object of connection
    $hiep = new AdminController();

    /* BEGIN: DO MOTIFYCATION */
    if (!empty($_POST['doUPDATE'])) {
        if (!empty($_POST['id']) && !empty($_POST['des']) && !empty($_POST['name'])) {
            $CategoryId = $_POST['id'];
            $CategoryName = $hiep->DBConnection->truthString($_POST['name']);
            $Description = $hiep->DBConnection->truthString($_POST['des']);
            $hiep->updateCategory($CategoryId, $CategoryName, $Description);
            header("Location: ../view/admin_index.php?area=categoriesmanagement");
        }
        //back to the category management page
        header("Location: ../view/admin_index.php?area=categoriesmanagement");
    }
    if (!empty($_POST['doADD'])) {
        if (!empty($_POST['name']) && !empty($_POST['des'])) {
            $CategoryName = $hiep->DBConnection->truthString($_POST['name']);
            $Desciption = $hiep->DBConnection->truthString($_POST['des']);
            //string
            $hiep->addCategory($CategoryName, $Desciption);
            header("Location: ../view/admin_index.php?area=categoriesmanagement");
        }
        //back to the category management page
        header("Location: ../view/admin_index.php?area=categoriesmanagement");
    }
    /* END: DO MOTIFYCATION */
    ///
    ////INTERFACE
    //////
    /* BEGIN:INTERFACE */
    if (!empty($_POST['updateCategory'])) {
        //get infor of category
        $id = $_POST['updateCategory'];
        $result = $hiep->viewAllCategories($id);
        while ($row = mysqli_fetch_assoc($result)) {
            $CategoryName = $row['CategoryName'];
            $Description = $row['Description'];
        }
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Update Category</h1>
            </div>

            <!-- /.col-lg-12 -->
        </div>
        <form action="./admin_categories_add_update.php" method="post">
            <div div class="col-lg-4">
                <input type="hidden" name="doUPDATE" value="keepGoing">
                <div class="form-group">
                    <label for="name">Category Id:</label>
                    <input type="number" class="form-control" name="id" value="<?php echo $id; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="text">Category Name:</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $CategoryName; ?>" required="">
                </div>
                <div class="form-group">
                    <label for="text">Description:</label>
                    <textarea class="form-control" name="des" rows="10" cols="30" required=""><?php echo $Description; ?></textarea>
                </div>            
                <button type="submit" class="btn btn-default">Submit</button>
            </div>  
        </form>
        <?php
    }

    if (!empty($_POST['addCategory'])) {
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Add New Category</h1>
            </div>
        </div>
        <form action="./admin_categories_add_update.php" method="post">
            <div div class="col-lg-4">
                <input type="hidden" name="doADD" value="keepGoing">
                <div class="form-group">
                    <label for="phone">Category Name:</label>
                    <input type="text" class="form-control" name="name" required="">
                </div>
                <div class="form-group">
                    <label for="text">Description:</label>                
                    <textarea class="form-control" name="des" rows="10" cols="30" required=""></textarea>
                </div>            
                <button type="submit" class="btn btn-default">Submit</button>
            </div>  
        </form>
        <?php
    }

    /* END:INTERFACE */
}else{
    header("Location: ./login.php");
}

