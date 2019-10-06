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
            <p class="h2">Edit Category</p>
            <form action="" method="post" enctype="multipart/form-data">
<?php if (!empty($errors)) { ?>
                    <div class="alert alert-danger">
    <?php foreach ($errors as $error) { ?>
                            <p><?php echo $error ?></p>  
    <?php } ?>
                    </div>   
        <?php } ?>
        <?php if (!empty($msgs)) { ?>
                    <div class="alert alert-success">
    <?php foreach ($msgs as $msg) { ?>
                            <p><?php echo $msg ?></p>  
                    <?php } ?>
                    </div>   
                    <?php } ?>

                <div class="form-group">
                    <label for="admin_name">Admin Name</label>
                    <input type="text" name="admin_name" id="admin_name" class="form-control" value="<?php echo $data['category_name']; ?>" required="1">
                </div>

                <div class="form-group">

                    <label for="cat_photo">Admin Photo</label>
                    <img width="100px;"src="../uploads/cat_images/<?php echo $data['category_photo']; ?>" class="mb-4">
                    <input type="file" name="cat_photo" id="cat_photo" class="form-control">
                </div>
                <div class="form-group">
                    <button name="edit_category" class="btn btn-success">Edit Category</button>
                    <a href="categories.php" class="btn btn-danger">Cancel</a>
                </div>

            </form>


        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /content container -->

<?php include_once 'partials/footer.php'; ?>

