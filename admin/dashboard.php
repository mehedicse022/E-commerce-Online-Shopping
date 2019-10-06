
<?php include_once 'partials/header.php'; ?>


<?php 

$page = 'dashboard';

if(empty($_SESSION) || empty($_SESSION['id'] || !isset($_SESSION['username']))){
    header('Location: index.php');
}



?>



<!-- Page Content -->
<div class="container">
    <div class="row">
        <?php include 'partials/sidebar.php'?>
        <div class="col-md-8 mt-4">
            
            <div class="alert alert-success">
                <p>You are logged in as <?php echo $_SESSION['username']?> </p>
                
            </div>
            
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /content container -->

<?php include_once 'partials/footer.php'; ?>