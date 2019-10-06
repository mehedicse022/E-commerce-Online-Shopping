<?php require_once 'connection.php'; session_start(); ?>


<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> Ecommerce UY 21</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/shop-homepage.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="dashboard.php">Ecommerce UY 21</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
         <?php if(!empty($_SESSION)){?>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            
          <ul class="navbar-nav">
            <li class="nav-item <?php if($page == 'dashboard'){echo 'active';}?>">
              <a class="nav-link" href="dashboard.php">Dashboard
<!--                <span class="sr-only">(current)</span>-->
              </a>
            </li>
            <li class="nav-item <?php if($page == 'categories'){echo 'active';}?>">
              <a class="nav-link" href="categories.php">Categories</a>
            </li>
            
             <li class="nav-item <?php if($page == 'products'){echo 'active';}?>">
              <a class="nav-link" href="products.php">Products</a>
            </li>
            <li class="nav-item <?php if($page == 'orders'){echo 'active';}?>">
              <a class="nav-link" href="orders.php">Orders</a>
            </li>
           
            <li class="nav-item <?php if($page == 'users'){echo 'active';}?>">
              <a class="nav-link" href="users.php">Users</a>
            </li>
            <li class="nav-item <?php if($page == 'admins'){echo 'active';}?>">
              <a class="nav-link" href="admins.php">Admins</a>
            </li>
          </ul>
            
        </div>
       
        <div class="pull-right" style="color:#fff;">
            <i class="fa fa-user"></i>&nbsp;<?php echo $_SESSION['username'];?>
        </div>
        <?php }else{?>
        <div class="pull-right">
            <a href="index.php" class="btn btn-success btn-xs">Login</a>
            <a href="register.php" class="btn btn-info btn-xs">Register</a>
        </div>
        <?php }?>
      </div>
    </nav>
