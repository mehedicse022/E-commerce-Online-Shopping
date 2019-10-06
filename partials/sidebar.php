<?php

$query = $connection->prepare('SELECT * FROM `categories`');
$query->execute();

$cat_data = $query->fetchAll();




?>



<div class="col-lg-3">

    <h1 class="h3">Categories</h1><br>
    
    
    <div class="list-group">
        <?php foreach ($cat_data as $v_cat){?>
        <a href="single_category.php?id=<?php echo $v_cat['category_id'];?>" class="list-group-item"><?php echo $v_cat['category_name'];?></a>
        <?php }?>
    </div>

</div>