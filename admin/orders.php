<?php $page = 'orders'; ?>
<?php include_once 'partials/header.php'; ?>

<?php
//get all data from DB
$order_q = $connection->prepare('SELECT * FROM `orders`');
$order_q->execute();
$order = $order_q->fetchAll();
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <?php include 'partials/sidebar.php' ?>
        <div class="col-md-8 mt-4 mb-5">
            <h3>Orders Table</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Shipping Address</th>
                        <th>Payment Method</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order as $order_data) { ?>
                        <?php
                        $user_query = $connection->prepare('SELECT * FROM `users` WHERE `user_id` = :id');
                        $user_query->bindValue(':id', $order_data['user_id']);
                        $user_query->execute();
                        $u_data = $user_query->fetch();
                        ?>
                        <tr>
                            <td><?php echo $order_data['order_id']; ?></td>
                            <td><?php echo $u_data['fullname']; ?></td>
                            <td><?php echo $order_data['shipping_address']; ?></td>
                            <td><?php echo $order_data['payment_method']; ?></td>
                            <td><?php echo $order_data['total_amount']; ?></td>
                            
                            <td><?php echo $order_data['status']; ?></td>
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
