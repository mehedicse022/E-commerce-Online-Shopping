<?php
include_once 'partials/header.php';
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

if (isset($_POST['resgister'])) {
    //get the data input by user
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $errors = [];
    $msgs = [];

    
      
    //validattion
    if (strlen($username) < 6) {
        $errors[] = "Username must be at least 6 characters";
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
        $errors[] = "Invalid Email Format";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }

    //if no errors

    if (empty($errors)) {

        $activation_token = sha1($email . time() . $_SERVER['REMOTE_ADDR']);
        $password = password_hash($password, PASSWORD_BCRYPT);
        $query = $connection->prepare('INSERT INTO `admins`(`username`,`email`,`password`,`activation_token`) VALUES(:username,:email,:password,:activation_token)');
        $query->bindValue('username', strtolower($username));
        $query->bindValue('email', strtolower($email));
        $query->bindValue('password', $password);
        $query->bindValue('activation_token', $activation_token);
        $query->execute();

        $msgs[] = "Registration done successfully! ";
    }

    //email the user
//    require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    $mail = new PHPMailer(true);
      // Passing `true` enables exceptions
    try {
        //Server settings
//        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';  // Enable verbose debug output
       $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.mailtrap.io';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = '6e08dc70e5c85d';                 // SMTP username
        $mail->Password = 'a763978dee0298';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 2525;                                    // TCP port to connect to
        //Recipients
       $mail->setFrom('no-reply@gmail.com', 'UY21');
       $mail->addAddress($email, $username);     // Add a recipient
        //Content
        $mail->isHTML();                                  // Set email format to HTML
        $mail->Subject = 'Activation Link';

        $mail->Body = '<p>Hello ' . $username . '</p>'
                . '<p><a href="http://localhost/ecommerce_uy21/admin/activate.php?token='.$activation_token.'">Click to activate</a></p>';


        $mail->send();
        $msgs[] = 'Email has been sent. Please activate from your email account.';
    } catch (Exception $e) {
        $errors[] = 'Email could not be sent.';
        $errors[] = 'Mailer Error: ' . $mail->ErrorInfo;
    }

    //show message to user
}
?>



<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="offset-md-4 col-md-4 offset-md-4 mb-4" >
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
            <form action="register.php" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control">

                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control">

                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <button name="resgister" class="btn btn-xs btn-success">Register</button>
                    <a href="index.php" class="btn btn-info" >Login</a>
                </div>
            </form>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /content container -->

<?php include_once 'partials/footer.php'; ?>
