<?php
require 'connection.php';
session_start();
$page = 'cart';

if (isset($_POST['quantity'])) {
    foreach ($_POST['quantity'] as $id => $quantity) {
        $_SESSION['cart'][$id] = $quantity;
    }
}

if (isset($_POST['order'])) {
    $fname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $shipping = trim($_POST['shipping']);
    //insert into users table
    $user_query = $connection->prepare('SELECT `user_id` FROM `users` WHERE `email` = :email OR `phone_number` = :phone_number');
    $user_query->bindValue(':email', $email);
    $user_query->bindValue(':phone_number', $phone);
    $user_query->execute();
    $u_data = $user_query->fetch();
    if ($user_query->rowCount() === 1) {
        $user_id = $u_data['user_id'];
    } else {
        //insert into users table
        $user_query = $connection->prepare('INSERT INTO `users`(`fullname`,`email`,`phone_number`) VALUES(:fullname,:email,:phone_number)');
        $user_query->bindValue(':fullname', $fname);
        $user_query->bindValue(':email', $email);
        $user_query->bindValue(':phone_number', $phone);
        $user_query->execute();
        $user_id = $connection->lastInsertId();
    }



    //insert into orders
    $order_query = $connection->prepare('INSERT INTO `orders`(`user_id`,`shipping_address`,`total_amount`,`payment_method`,`status`) VALUES(:user_id,:shipping_address,:total_amount,:payment_method,:status)');
    $order_query->bindValue(':user_id', $user_id);
    $order_query->bindValue(':shipping_address', $shipping);
    $order_query->bindValue(':total_amount', trim($_POST['total_amount']));
    $order_query->bindValue(':payment_method', trim($_POST['payment_method']));
    $order_query->bindValue(':status', 'pending');
    $order_query->execute();
    $order_id = $connection->lastInsertId();

    //insert into order_products
    foreach ($_SESSION['cart'] as $id => $quantity) {
        $stmt = $connection->prepare('INSERT INTO `ordered_products`(`order_id`,`product_id`,`quantity`) VALUES(:order_id,:product_id,:quantity)');
        $stmt->bindValue(':order_id', $order_id);
        $stmt->bindValue(':product_id', $id);
        $stmt->bindValue(':quantity', $quantity);
        $stmt->execute();
    }

    unset($_SESSION['cart']);
    $_SESSION['msg'] = 'Order Placed Successfully!!';
    header('Location: index.php');
}
?>
<?php include_once 'partials/header.php'; ?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <?php include_once 'partials/sidebar.php'; ?>
        <!-- /.col-lg-3 -->

        <div class="col-md-9 mt-4 mb-4">
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>Product Name</td>
                            <td>Product qty</td>
                            <td>Unit Price</td>
                            <td>Product Total</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $product_total = $total_sum = 0; ?>
                        <?php foreach ($_SESSION['cart'] as $id => $quantity) { ?>
                            <?php
                            $query = $connection->prepare("SELECT * FROM `products` WHERE `product_id` = :id");
                            $query->bindValue(':id', $id, PDO::PARAM_INT);
                            $query->execute();
                            $pro_data = $query->fetch();

                            $product_total = $quantity * $pro_data['product_price'];
                            $total_sum += $product_total;
                            ?>
                            <tr>
                                <td><?php echo $pro_data['product_name']; ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td><?php echo $pro_data['product_price']; ?></td>
                                <td><?php echo $product_total; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                    <td colspan="3">Total Price(in Tk.)</td>
                    <td><?php echo $total_sum; ?></td>
                    </tfoot>
                </table>
            </div>
            <!-- /.row -->
            <div class="col-lg-9">

                <form action="" method="post">
                    <input type="hidden" value="<?php echo $total_sum; ?>" name="total_amount">
                    <div class="form-group">
                        <label for="fullname">Fullname</label>
                        <input type="text" name="fullname" id="fullname" class="form-control" required="">

                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>

                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" name="phone" id="phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="shipping">Shipping Address</label>
                        <textarea name="shipping" id="shipping" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="payment_method">Payment Method</label>
                        <input type="radio" name="payment_method" value="cod" checked=""> Cash on Delivery
                    </div>
                    <div class="form-group">
                        <button name="order" class="btn btn-xs btn-success">Place Order</button>
                    </div>
                </form>

            </div>
            <!-- /. form row -->
        </div>
        <!-- /.col-lg-9 -->
    </div>
    <!-- /.row -->
</div>
<!-- /content container -->
<?php include_once 'partials/footer.php'; ?>

