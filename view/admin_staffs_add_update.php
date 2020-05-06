<?php
if ($_COOKIE['UserRole'] == 1) {
    require_once '../controller/AdminController.php';
    $hiep = new AdminController();
    //DO STH
    if (!empty($_POST['doUpdateStaffDB'])) {
        $UserId = $_POST['id'];
        $UserName = $hiep->DBConnection->truthString($_POST['name']);
        $UserPhone = $hiep->DBConnection->truthString($_POST['phone']);
        $UserEmail = $hiep->DBConnection->truthString($_POST['email']);
        $StoreId = $_POST['oldStoreId'];
        if (!empty($_POST['chosenStoreId'])) {
            $StoreId = $_POST['chosenStoreId'];
        }

        $UserRole = $_POST['therole'];
        $hiep->updateStaff($UserId, $UserName, $UserPhone, $UserEmail, $StoreId, $UserRole);
        header("Location: ../view/admin_index.php?area=staffsmanagement");
    }

    if (!empty($_POST['doAddStaffDB'])) {
//        echo "test";
        $UserName = $hiep->DBConnection->truthString($_POST['name']);
        $UserPhone = $hiep->DBConnection->truthString($_POST['phone']);
        $UserEmail = $hiep->DBConnection->truthString($_POST['email']);
        $pass = $_POST['pass'];
        $Password = $hiep->DBConnection->passwordToToken($pass);
        $UserRole = $_POST['therole'];
        if ($UserRole == 1 || empty($_POST['chosenStoreId'])) {
            $StoreId = 1;
        } else {
            $StoreId = $_POST['chosenStoreId'];
        }

        //string
        $hiep->addStaff($UserName, $UserPhone, $UserEmail, $StoreId, $Password, $UserRole);
        header("Location: ../view/admin_index.php?area=staffsmanagement");
    }


    //INTERFACE
    //get all stores
    $result2 = $hiep->viewAllStores("");
    //
    if (!empty($_POST['updateStaff'])) {
        $id = $_POST['updateStaff'];
        $result = $hiep->viewAllStaffs($id);
        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['UserName'];
            $phone = $row['UserPhone'];
            $email = $row['UserEmail'];
            $storeId = $row['StoreId'];
//            $pass = $row['Password'];
            $role = $row['UserRole'];
        }
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Update Staff</h1>
            </div>
        </div>
        <form action="./admin_staffs_add_update.php" method="post"> 
            <div class="row">
                <div class="col-lg-4">
                    <input type="hidden" name="doUpdateStaffDB" value="keepGoing">
                    <div class="form-group">
                        <label for="phone">Id:</label>
                        <input type="text" class="form-control" name="id" value="<?php echo $id; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="phone">Name:</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" required="">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>" pattern="(09|03)[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]" required="">
                    </div>
                    <div class="form-group">
                        <label for="text">Email:</label>                
                        <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required="">
                    </div>

                    <!--                    <div class="form-group">
                                            <label for="text">Password:</label>                
                                            <input type="password" class="form-control" name="pass" value="<?php // echo $pass;            ?>">
                                        </div>-->
                    <div class="form-group">
                        <label for="pwd">Role: </label>

                        <?php
                        if ($role == 1) {
                            ?><input type="radio" name="therole" value="1" checked> Admin <?php
                        } else {
                            ?><input type="radio" name="therole" value="1"> Admin <?php
                        }
                        if ($role == 2) {
                            ?><input type="radio" name="therole" value="2" checked> National Manager <?php
                        } else {
                            ?><input type="radio" name="therole" value="2"> National Manager <?php
                        }
                        ?>
                        <?php
                        if ($role == 3) {
                            ?><input type="radio" name="therole" value="3" checked> Sale Staff <?php
                        } else {
                            ?><input type="radio" name="therole" value="3"> Sale Staff <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="form-group">
                        <label for="phone">The Current Store Id:</label>
                        <input type="number" class="form-control" name="oldStoreId" value="<?php echo $storeId; ?>" readonly>
                    </div>
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Store Id</th>
                                <th>Store Address</th>
                                <th>Store Phone</th>
                                <th>Choose</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            while ($row2 = mysqli_fetch_assoc($result2)) {
                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $row2['StoreId'] ?></td>
                                    <td><?php echo $row2['StoreAddress'] ?></td>
                                    <td><?php echo $row2['StorePhone'] ?></td>
                                    <td>
                                        <!--get value of category Id for $_POST['deleleCategory']-->
                                        <?php
                                        if ($row2['StoreId'] == $storeId) {
                                            ?><input type="radio" name="chosenStoreId" value="<?php echo $row2['StoreId'] ?>" checked=""/><?php
                                        } else {
                                            ?><input type="radio" name="chosenStoreId" value="<?php echo $row2['StoreId'] ?>"/><?php
                                        }
                                        ?>

                                    </td>
                                </tr>
                                <?php
                            }
                            ?>    
                        </tbody>

                    </table>
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
            </div>
            <!--/Category/-->
        </form>
        <?php
    }

    if (!empty($_POST['addStaff'])) {
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Add New Staff</h1>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <form action="./admin_staffs_add_update.php" method="post"> 
            <div class="row">
                <div class="col-lg-4">
                    <input type="hidden" name="doAddStaffDB" value="keepGoing">
                    <div class="form-group">
                        <label for="phone">Name:</label>
                        <input type="text" class="form-control" name="name" required="">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" class="form-control" name="phone" required="" 
                               placeholder="0912345678 or 0312345678"  pattern="(09|03)[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]">
                    </div>
                    <div class="form-group">
                        <label for="text">Email:</label>                
                        <input type="email" class="form-control" name="email" required="">
                    </div>
                    <div class="form-group">
                        <label for="text">Password:</label>                
                        <input type="password" class="form-control" name="pass" required="">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Role: </label>
                        <input type="radio" name="therole" value="1" required=""> Admin 
                        <input type="radio" name="therole" value="2" > National Manager                
                        <input type="radio" name="therole" value="3" id="post-format-gallery"> Sale Staff 
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
                <div class="col-lg-8" id="gallery-box">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Store Id</th>
                                <th>Store Address</th>
                                <th>Store Phone</th>
                                <th>Choose</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            while ($row2 = mysqli_fetch_assoc($result2)) {
                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $row2['StoreId'] ?></td>
                                    <td><?php echo $row2['StoreAddress'] ?></td>
                                    <td><?php echo $row2['StorePhone'] ?></td>
                                    <td>
                                        <!--get value of category Id for $_POST['deleleCategory']-->
                                        <input type="radio" name="chosenStoreId" value="<?php echo $row2['StoreId'] ?>"/>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>    
                        </tbody>
                    </table>

                </div>

            </div>
            <!--/Category/-->

        </form>
        <script>
            $(function () {
                $('input[name=therole]').on('click init-post-format', function () {
                    $('#gallery-box').toggle($('#post-format-gallery').prop('checked'));
                }).trigger('init-post-format');
            });
        </script>
<!--        <script>
            $(function () {
                $('input[name=therole]').on('click init-post-format', function () {
                    
            });
        </script>-->
        <?php
    }
}else{
    header("Location: ./login.php");
}
?>
