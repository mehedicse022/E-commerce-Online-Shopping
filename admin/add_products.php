
<?php
include 'partials/header.php';
require '../vendor/autoload.php';

// import the Intervention Image Manager Class
use Intervention\Image\ImageManager;
//
$query = $connection->prepare('SELECT * FROM `categories`');
$query->execute();
$cat_data = $query->fetchAll();
?>
<?php
//get user input
if (isset($_POST['add_product'])) {
    $productName = $_POST['pro_name'];
    $cat_id = $_POST['category_id'];
    $productPrice = $_POST['pro_price'];
    $productQty = $_POST['pro_qty'];
    $productDetails = $_POST['pro_details'];
    $productPhoto = '';
    $errors = [];
    $msgs = [];
    
    
//    //validate
//
    if (strlen($_POST['pro_name']) < 4) {
        $errors[] = 'Product name must be at least 3 characters';
    }
    if (!empty($_FILES['pro_photo']['tmp_name'])) {
        $productPhoto = time() . $_FILES['pro_photo']['name'];
        $dest = '../uploads/pro_images/' . $productPhoto;
        
        // create an image manager instance with favored driver
        $image = new ImageManager();

        $image->make($_FILES['pro_photo']['tmp_name'])
                ->resize(600, 400)
                ->save($dest);

    // move_uploaded_file($_FILES['cat_photo']['tmp_name'], $dest);
    }
    ////if no errors DB upload

    if (empty($errors)) {
        $query = $connection->prepare("INSERT INTO `products`(`product_name`,`category_id`,`product_price`,`available_quantity`,`product_details`,`product_photo`) VALUES(:product_name,:category_id,:product_price,:available_quantity,:product_details,:product_photo)");
        $query->bindValue(':product_name', $productName);
        $query->bindValue(':product_price', $productPrice);
        $query->bindValue(':product_photo', $productPhoto);
        $query->bindValue(':product_details', $productDetails);
        $query->bindValue(':available_quantity', $productQty);
        $query->bindValue(':category_id', $cat_id, PDO::PARAM_INT);
        $query->execute();
        //message the user.
        $msgs[] = "Product added successfully";
    }
}
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <?php include 'partials/sidebar.php' ?>
        <div class="col-md-8 mt-4 mb-5">
            <p class="h2">Add Products</p>
            <form action="add_products.php" method="post" enctype="multipart/form-data">
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
                    <label for="pro_name">Product Name</label>
                    <input type="text" name="pro_name" id="pro_name" class="form-control" required="1">
                </div>
                <div class="form-group">
                    <label for="category_id">Product Category</label><br>
                    <select class="custom-select" name="category_id" id="category_id" required="1">
                        <option selected>Select Category</option>
                        <?php foreach ($cat_data as $v_cat) { ?>
                            <option value="<?php echo $v_cat['category_id']; ?>"><?php echo $v_cat['category_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="pro_price">Product Price</label>
                    <input type="number" name="pro_price" id="pro_price" class="form-control" required="1">
                </div>
                <div class="form-group">
                    <label for="pro_qty">Product QTY.</label>
                    <input type="text" name="pro_qty" id="pro_qty" class="form-control" required="1">
                </div>
                <div class="form-group">
                    <label for="pro_details">Product Details</label>
                    <input type="text" name="pro_details" id="pro_details" class="form-control" required="1">
                </div>

                <div class="form-group">
                    <label for="pro_photo">Product Photo</label>
                    <input type="file" name="pro_photo" id="pro_photo" class="form-control">
                </div>
                <div class="form-group">
                    <button name="add_product" class="btn btn-success">Add Product</button>
                    <a href="products.php" class="btn btn-danger">Cancel</a>
                </div>
            </form>


        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /content container -->

<?php include_once 'partials/footer.php'; ?>


