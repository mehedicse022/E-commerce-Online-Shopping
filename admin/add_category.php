<?php
include 'partials/header.php';
require '../vendor/autoload.php';

// import the Intervention Image Manager Class
use Intervention\Image\ImageManager;
?>
<?php
//get user input
if (isset($_POST['add_category'])) {
    $categoryName = trim($_POST['cat_name']);
    $categoryPhoto = '';
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
                ->resize(300,200)
                ->save($dest);

        //move_uploaded_file($_FILES['cat_photo']['tmp_name'], $dest);
    }
//if no errors DB upload

    if (empty($errors)) {
        $query = $connection->prepare("INSERT INTO `categories`(category_name,category_photo) VALUES(:category_name,:category_photo)");
        $query->bindValue(':category_name', $categoryName);
        $query->bindValue(':category_photo', $categoryPhoto);
        $query->execute();
        //message the user.
        $msgs[] = "Category added successfully";
    }
}
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <?php include 'partials/sidebar.php' ?>
        <div class="col-md-8 mt-4 mb-5">
            <p class="h2">Add Category</p>
            <form action="add_category.php" method="post" enctype="multipart/form-data">
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
                    <input type="text" name="cat_name" id="cat_name" class="form-control" required="1">
                </div>

                <div class="form-group">
                    <label for="cat_photo">Category Photo</label>
                    <input type="file" name="cat_photo" id="cat_photo" class="form-control">
                </div>
                <div class="form-group">
                    <button name="add_category" class="btn btn-success">Add Category</button>
                    <a href="categories.php" class="btn btn-danger">Cancel</a>
                </div>
            </form>


        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /content container -->

<?php include_once 'partials/footer.php'; ?>




