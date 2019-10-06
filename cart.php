<?php
require 'connection.php';
session_start();
$page = 'cart';

?>
<?php
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if (isset($_GET['id'])) {

    if (array_key_exists((int) trim($_GET['id']), $_SESSION['cart'])) {
        $_SESSION['cart'][(int) trim($_GET['id'])] ++;
    } else {
        $_SESSION['cart'][(int) trim($_GET['id'])] = 1;
    }
}
if (isset($_GET['action']) && $_GET['action'] === 'clear') {
    unset($_SESSION['cart']);
}
?>

<?php include_once 'partials/header.php';?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <?php include_once 'partials/sidebar.php'; ?>
        <!-- /.col-lg-3 -->

        <div class="col-md-9 mt-4 mb-4">
            <div class="row">

                <?php if (!empty($_SESSION['cart'])) { ?>
                    <h3>Product Cart</h3>  

                    <table class="table table-bordered">
                        <form  action="checkout.php" method="post">
                            <thead>
                                <tr>
                                    <td>Product Name</td>
                                    <td>Product QTY</td>
                                    <td>Product Price(in tk.)</td>

                                </tr>
                            </thead>

                            <?php foreach (array_unique($_SESSION['cart']) as $id => $quantity) { ?>
                                <?php
                                $query = $connection->prepare("SELECT * FROM `products` WHERE `product_id` = :id");
                                $query->bindValue(':id', $id, PDO::PARAM_INT);
                                $query->execute();
                                $pro_data = $query->fetch();
                                ?>
                                <tbody>
                                    <tr>
                                        <td><?php echo $pro_data['product_name']; ?></td>
                                        <td><input type="number" name="quantity[<?php echo $pro_data['product_id'];?>]"value="<?php echo $quantity; ?>"></td>
                                        <td><?php echo $pro_data['product_price']; ?></td>

                                    </tr>
                                </tbody>
                            <?php } ?>

                    </table> 
                    <button type="submit" class=" btn btn-info float-right">Proceed to Checkout</button>
                    </form>
                    <a href="cart.php?action=clear" class="btn btn-warning">Clear Cart</a>
                <?php } else { ?>
                    <div class="alert alert-info">
                        No products added to cart.
                    </div>
                <?php } ?>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

</div>
<!-- /content container -->

<?php include_once 'partials/footer.php'; ?>
