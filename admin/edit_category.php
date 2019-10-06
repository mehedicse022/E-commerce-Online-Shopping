<?php include 'partials/header.php';?>
<?php 

if(empty($_SESSION) || empty($_SESSION['id'] || empty($_SESSION['username']))){
    header('Location: index.php');
}

?>
<?php

require '../vendor/autoload.php';

// import the Intervention Image Manager Class
use Intervention\Image\ImageManager;
?>
<?php
$query = $connection->prepare('SELECT category_name,category_photo FROM `categories` WHERE `category_id`= :category_id');
$query->bindValue(':category_id',$_GET['id'], PDO::PARAM_INT);
$query->execute();
$data = $query->fetch();


//get user input
if (isset($_POST['edit_category'])) {
    $categoryName = trim($_POST['cat_name']);
    $categoryPhoto = $data['category_photo'];
    $errors = [];
    $msgs = [];
    //validate

    if (strlen($_POST['cat_name']) < 3) {
        $errors[] = 'Category name must be at least 3 characters';
    }

    if (!empty($_FILES['cat_photo']['tmp_name'])) {
        $categoryPhoto = time() . $_FILES['cat_photo']['name'];
        $dest = '../uploads/cat_images/' . $categoryPhoto;
        // create an image manager instance with favored driver
        $image = new ImageManager();

        $image->make($_FILES['cat_photo']['tmp_name'])
                ->resize(300, 200)
                ->save($dest);
        unlink('../uploads/cat_images/' . $data['category_photo']);
        //move_uploaded_file($_FILES['cat_photo']['tmp_name'], $dest);
    }
//if no errors DB upload

    if (empty($errors)) {
        $query = $connection->prepare("UPDATE `categories` SET `category_name` = :category_name ,`category_photo`= :category_photo WHERE `category_id`= :category_id");
        $query->bindValue(':category_id', $_GET['id'], PDO::PARAM_INT);
        $query->bindValue(':category_name', $categoryName);
        $query->bindValue(':category_photo', $categoryPhoto);
        $query->execute();
//        var_dump($query->execute());die();
        if ($query->rowCount() === 1) {
            //message the user.
            $msgs[] = "Category updated successfully";


            $query = $connection->prepare('SELECT * FROM `categories` WHERE `category_id`= :category_id');
            $query->bindValue(':category_id', $_GET['id'], PDO::PARAM_INT);
            $query->execute();
            $data = $query->fetch();
        }
    }
}
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
<?php include 'partials/sidebar.php' ?>
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
                    <label for="cat_name">Category Name</label>
                    <input type="text" name="cat_name" id="cat_name" class="form-control" value="<?php echo $data['category_name']; ?>" required="1">
                </div>

                <div class="form-group">

                    <label for="cat_photo">Category Photo</label>
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





