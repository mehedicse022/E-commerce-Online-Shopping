<?php
include_once 'partials/header.php';

if(empty($_SESSION) || empty($_SESSION['id'] || !isset($_SESSION['username']))){
    header('Location: index.php');
}

if (isset($_POST['change_password'])) {
    $oldPassword = trim($_POST['old_password']);
    $newPassword = trim($_POST['new_password']);
    $errors = [];
    $msgs = [];
    
    
    
    //validation
    if (strlen($oldPassword) < 6 || strlen($newPassword) < 6 ) {
        $errors[] = "Password must be at least 6 characters";
    }
    
    
    //if no errors    
    if(empty($errors)){
        $query = $connection->prepare('SELECT admin_id,email,password FROM `admins` WHERE `username` = :username');
        $query->bindValue(':username', $_SESSION['username']);
        $query->execute();
        $adminData = $query->fetch();
       
        
        if(password_verify($oldPassword, $adminData['password'])){
            $update_query = $connection->prepare('UPDATE `admins` SET `password` = :password  WHERE `username` = :username');
            $update_query->bindValue('username',$_SESSION['username']);
            $update_query->bindValue(':password',  password_hash($newPassword, PASSWORD_BCRYPT));            
            $update_query->execute();
            
            $msgs[] = "Password Changed successfully!";
        } else{
            $errors[] = "Invalid Old Password"; 
        }
           
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
                    <label for="old_password">Old Password</label>
                    <input type="password" name="old_password" id="old_password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" id="new_password" class="form-control">
                </div>
                <div class="form-group">
                    <button name="change_password" class="btn btn-xs btn-success">Change Password</button>
                    <a href="dashboard.php" class="btn btn-info" >Back</a>
                </div>
               
            </form>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /content container -->

<?php include_once 'partials/footer.php'; ?>