<?php  $page = 'admins';?>
<?php include_once 'partials/header.php';?>
<?php

$stmt = $connection->prepare('SELECT * FROM `admins`');
$stmt->execute();
$admin_data = $stmt->fetchAll();

?>






<!-- Page Content -->
<div class="container">
    <div class="row">
        <?php include 'partials/sidebar.php'?>
        <div class="col-md-8 mt-4 mb-5">       
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Admin Name</td>
                        <td>Admin Photo</td>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admin_data as $admin){?>
                    <tr>
                        <td><?php echo $admin['admin_id'];?></td>
                        <td><?php echo $admin['username'];?></td>
                        <td><img width="100px;"src="../uploads/admin_images/<?php echo $admin['admin_photo'];?>"></td>
                    
                    </tr>
                    <?php }?>
                </tbody>
            </table> 
            
            
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /content container -->

<?php include_once 'partials/footer.php'; ?>

