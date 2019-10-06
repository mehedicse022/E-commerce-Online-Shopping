
<?php
require 'connection.php';
if(isset($_GET['id'])){
$query = $connection->prepare("SELECT * FROM `products` WHERE `product_id` = :product_id");
$query->bindValue(':product_id',$_GET['id'],PDO::PARAM_INT);
$query->execute();
$pro_data = $query->fetch();

}


?>
<?php include_once 'partials/header.php';?>
<div class="container">

      <div class="row">

       <?php include_once 'partials/sidebar.php' ;?>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9">
            
          <div class="card mt-4 mb-5">
              <img class="card-img-top img-fluid" src="uploads/pro_images/<?php echo $pro_data['product_photo']?>" alt="pro_image">
            <div class="card-body mb-4">
              <h3 class="card-title"><?php echo $pro_data['product_name']?></h3>
              <h4>Tk.<?php echo $pro_data['product_price']?></h4>
              <p class="card-text"><?php echo $pro_data['product_details']?></p>
              <a href="cart.php" class="btn btn-success">Add to Cart</a>
            </div>
             
          </div>
           
        </div>
        
        <!-- /.col-lg-9 -->

      </div>

    </div>
<br><br>
<?php include_once 'partials/footer.php';?>