<?php include_once 'partials/header.php'; ?>

<?php
$msgs = [];
$errors = [];



if (empty($_GET['token']) || !isset($_GET['token'])) {
    header('Location: index.php');
}else {
    $query = $connection->prepare('SELECT * FROM `admins` WHERE `activation_token` = :activation_token');
    $query->bindValue(':activation_token', $_GET['token'], PDO::PARAM_INT);
    $query->execute();
    $admin_data = $query->fetch();

    if ($query->rowCount() === 0) {
        header('Location: index.php');
    }
}

$token = $_GET['token'];
$query = $connection->prepare("UPDATE `admins` SET `active` = 1 WHERE `activation_token` = :token ");
$query->bindValue('token', trim($token));
$query->execute();

if ($query->rowCount() === 1) {
    $msgs[] = 'Your account is activated.';
    $query = $connection->prepare('UPDATE `admins` SET `activation_token` = NULL WHERE `activation_token` = :token');
    $query->bindValue('token', trim($_GET['token']));
    $query->execute();
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
            <a class="btn btn-success" href="index.php">You can login now.</a>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /content container -->

<?php include_once 'partials/footer.php'; ?>