<?php
if (isset($_COOKIE['UserRole']) ) {//if admin login, print admin pages
    ?>

        
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Welcome <?php echo $_COOKIE['UserName']?></h1>
                </div>
                <!-- /.col-lg-12 -->
           </div>

<?php 

} 
?>


