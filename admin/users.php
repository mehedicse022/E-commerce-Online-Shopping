<?php  $page = 'users';?>

<?php include_once 'partials/header.php'; ?>

<?php
//get all data from DB
$user_query = $connection->prepare('SELECT * FROM `users`');
$user_query->execute();
$users = $user_query->fetchAll();
?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <?php include 'partials/sidebar.php'?>
        <div class="col-md-8 mt-4 mb-5">
            
            <h3>Users Table</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>User Email</th>
                        <th>Phone Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user_data) { ?>
                       
                        <tr>
                            <td><?php echo $user_data['user_id']; ?></td>
                            <td><?php echo $user_data['fullname']; ?></td>
                            <td><?php echo $user_data['email']; ?></td>
                            <td><?php echo $user_data['phone_number']; ?></td>
                            <td align="center">
                                <a class="btn btn-danger" href="delete_user.php?id=<?php echo $user_data['user_id'];?>">Delete</a>
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

