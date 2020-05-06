<?php
if ($_COOKIE['UserRole'] == 1) {
    require_once '../controller/AdminController.php';
    $hiep = new AdminController();
    if (!empty($_POST['doAddStoreDB'])) {
        $storeAddress = $hiep->DBConnection->truthString($_POST['address']);
        $phone = $hiep->DBConnection->truthString($_POST['phone']);
        $hiep->addStore($storeAddress, $phone);
        header("Location: ../view/admin_index.php?area=storesmanagement");
    }

    if (!empty($_POST['doUpdateStoreDB'])) {
        $id = $_POST['id'];
        $address = $hiep->DBConnection->truthString($_POST['address']);
        $phone = $hiep->DBConnection->truthString($_POST['phone']);
        $hiep->updateStore($id, $address, $phone);
        header("Location: ../view/admin_index.php?area=storesmanagement");
    }



    //INTERFACE
    if (!empty($_POST['updateStore'])) {
        //get infor of category

        $id = $_POST['updateStore'];
        $result = $hiep->viewAllStores($id);
        while ($row = mysqli_fetch_assoc($result)) {
            $address = $row['StoreAddress'];
            $phone = $row['StorePhone'];
        }
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Update Store</h1>
            </div>
        </div>
        <form action="./admin_stores_add_update.php" method="post">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <input type="hidden" name="doUpdateStoreDB" value="keepGoing">
                        <label for="name">Store Id:</label>
                        <input type="number" class="form-control" name="id" value="<?php echo $id; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="text">Address:</label>
                        <input type="text" class="form-control" name="address" value="<?php echo $address; ?>" required="">
                    </div>
                    <div class="form-group">
                        <label for="text">Phone:</label>
                        <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>" required="" placeholder="0912345678 or 0312345678" pattern="(09|03)[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]">
                    </div>            
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
            </div>
        </form>
        <?php
    }

    if (!empty($_POST['addStore'])) {
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Add New Store</h1>
            </div>
        </div>
        <form action="./admin_stores_add_update.php" method="post">
            <div class="row">
                <div class="col-lg-4">
                    <input type="hidden" name="doAddStoreDB" value="keepGoing">
                    <div class="form-group">
                        <label for="phone">Store Address:</label>
                        <input type="text" class="form-control" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="text">Phone:</label>                
                        <input type="text" class="form-control" name="phone" required 
                               placeholder="0912345678 or 0312345678"  pattern="(09|03)[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]">
                    </div>            
                    <button type="submit" class="btn btn-default">Submit</button>
                </div> 
            </div> 
        </form>
        <?php
    }
}else{
    header("Location: ./login.php");
}

