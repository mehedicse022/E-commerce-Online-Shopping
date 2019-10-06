<?php
include_once 'partials/header.php';
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
?>
<?php
if (isset($_POST['reset'])) {
    //get the user input.
    $email = strtolower(trim($_POST['email']));
    $errors = [];
    $msgs = [];

    //Validate

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors[] = "Invalid email format!";
    }


    if (empty($errors)) {
        $stmt = $connection->prepare('SELECT `admin_id`,`password`,username FROM `admins` WHERE `email` = :email AND `active` = 1');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $admin_info = $stmt->fetch();

        if ($stmt->rowCount() === 1) {
            $reset_token = sha1($email . $admin_info['username'] . time() . $_SERVER['REMOTE_ADDR']);
            $stmt = $connection->prepare('UPDATE `admins` SET `reset_token` = :reset_token WHERE `email` = :email');
            $stmt->bindValue(':email',$email);
            $stmt->bindValue(':reset_token',$reset_token);
            $stmt->execute();

            //MAILING THE USER
            $mail = new PHPMailer(true);
            // Passing `true` enables exceptions
            try {
                //Server settings
                $mail->SMTPDebug = 2;
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
                $mail->addAddress($email, $admin_info['username']);     // Add a recipient
                //Content
                $mail->isHTML();                                  // Set email format to HTML
                $mail->Subject = 'RESET password Link';

                $mail->Body = '<p>Hello ' . $admin_info['username'] . '</p>'
                        . '<p><a href="http://localhost/ecommerce_uy21/admin/reset_password.php?token=' . $reset_token . '">Reset your Password</a></p>';


                $mail->send();
                $msgs[] = 'Email has been sent. Please reset from your email account.';
            } catch (Exception $e) {
                $errors[] = 'Email could not be sent.';
                $errors[] = 'Mailer Error: ' . $mail->ErrorInfo;
            }
        }else{
            $errors[] = "No user found with this email.";
        }
    }
    
}
?>




<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="offset-md-4 col-md-4 offset-md-4 mb-4 mt-4">
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
            <form action="forgot_password.php" method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="form-group">
                    <button name="reset" class="btn btn-xs btn-success">Reset Password</button>
                    <a href="index.php" class="btn btn-warning" >Back</a>
                </div>

            </form>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /content container -->

<?php include_once 'partials/footer.php'; ?>
