<?php
include_once 'partials/header.php';

if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $errors = [];
    $msgs = [];
    
    
    
    //validation
    if (strlen($username) < 6) {
        $errors[] = "Username must be at least 6 characters";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }
    
    
    //if no errors
    
    if(empty($errors)){
        $query = $connection->prepare('SELECT admin_id,email,password FROM `admins` WHERE username = :username');
        $query->bindValue(':username', strtolower($username));
        $query->execute();
        $data = $query->fetch();
       
        
        if($query->rowCount() === 1 && password_verify($password, $data['password'])){
            $_SESSION['id'] = $data['admin_id'];
            $_SESSION['username'] = $username;
            header('Location: dashboard.php');
            
        }
        
        $errors[] = 'Invalid username or password ';        
        
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
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control">

                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <button name="login" class="btn btn-xs btn-success">Login</button>
                    <a href="register.php" class="btn btn-info" >Registration</a>
                </div>
                <a href="forgot_password.php">forgot your password?</a>
            </form>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /content container -->

<?php include_once 'partials/footer.php'; ?>