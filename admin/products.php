<?php 
$page = 'products';
?>

<?php include_once 'partials/header.php'; ?>

<?php
$query = $connection->prepare('SELECT * FROM `products`');
$query->execute();
$data = $query->fetchAll();
?>




<!-- Page Content -->
<div class="container">
    <div class="row">
<?php include 'partials/sidebar.php' ?>
        <div class="col-md-9 mt-4 mb-5">
            <div class="alert alert-success">
                <a href="add_products.php" class="btn btn-success">Add products</a>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Product Name</td>
                        <td>Product Price</td>
                        <td>Product Category</td>
                        <td>Product Photo</td>   
                        <td>Available Qty.</td>
                        <td>Action</td>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($data as $d) { ?>
                        <?php
                        $stmt = $connection->prepare('SELECT `category_name` FROM `categories` WHERE `category_id` = :category_id');
                        $stmt->bindValue(':category_id', $d['category_id'], PDO::PARAM_INT);
                        $stmt->execute();
                        $cat_name = $stmt->fetch();
                        ?> 
                        <tr>
                            <td><?php echo $d['product_id']; ?></td>
                            <td><?php echo $d['product_name']; ?></td>
                            <td><?php echo $d['product_price']; ?></td>
                            <td><?php echo $cat_name['category_name'] ;?></td>
                            <td><img width="100px;"src="../uploads/pro_images/<?php echo $d['product_photo']; ?>"></td>
                            <td><?php echo $d['available_quantity'];?></td>
                            <td align="center">
                                <a class="btn btn-primary btn-xs" href="edit_product.php?id=<?php echo $d['product_id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a class="btn btn-danger btn-xs" href="delete_product.php?id=<?php echo $d['product_id']; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                <i class="" aria-hidden="true"></i>
                            </td>
                        </tr>
<?php } ?>
                </tbody>
            </table>


        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /content container -->

<?php include_once 'partials/footer.php'; ?>


