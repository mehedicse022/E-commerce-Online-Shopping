<?php
include_once 'partials/header.php';
?>
<?php
if (empty($_GET) || !isset($_GET['token'])) {
    header('Location: index.php');
} else {
    $query = $connection->prepare('SELECT * FROM `admins` WHERE `reset_token` = :reset_token');
    $query->bindValue(':reset_token', $_GET['token'], PDO::PARAM_INT);
    $query->execute();
    $admin_data = $query->fetch();

    if ($query->rowCount() === 0) {
        header('Location: index.php');
    }
}
?>

<?php

if (isset($_POST['reset'])) {

    //USer input
    $password = trim($_POST['password']);
    $errors = [];
    $msgs = [];

    //
    if ($password < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    //no errors
    $update_query = $connection->prepare('UPDATE `admins` SET `password` = :password WHERE `reset_token` = :reset_token');
    $update_query->bindValue(':password', password_hash($password,PASSWORD_BCRYPT));
    $update_query->bindValue(':reset_token', $_GET['token'], PDO::PARAM_INT);
    $update_query->execute();

    if ($update_query->rowCount() === 1) {
        
        $msgs[] = "Password Updated ";
//        session_destroy();
    }
}
?>


<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="offset-md-4 col-md-4 offset-md-4 mb-4">
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
            <form action="" method="post">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <button name="reset" class="btn btn-xs btn-success">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /content container -->

<?php include_once 'partials/footer.php'; ?>