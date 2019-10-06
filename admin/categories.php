<?php $page = 'categories';?>

<?php include_once 'partials/header.php';?>

<?php

$query = $connection->prepare('SELECT * FROM `categories`');
$query->execute();
$data = $query->fetchAll();




?>




<!-- Page Content -->
<div class="container">
    <div class="row">
        <?php include 'partials/sidebar.php'?>
        <div class="col-md-8 mt-4 mb-5">
            <div class="alert alert-success">
                <a href="add_category.php" class="btn btn-success">Add Categories</a>
            </div>
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Category Name</td>
                        <td>Category Photo</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $d){?>
                    <tr>
                        <td><?php echo $d['category_id'];?></td>
                        <td><?php echo $d['category_name'];?></td>
                        <td><img width="100px;"src="../uploads/cat_images/<?php echo $d['category_photo'];?>"></td>
                        <td align="center">
                            <a class="btn btn-primary" href="edit_category.php?id=<?php echo $d['category_id'];?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a class="btn btn-danger" href="delete_category.php?id=<?php echo $d['category_id'];?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            <i class="" aria-hidden="true"></i>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            
            
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /content container -->

<?php include_once 'partials/footer.php'; ?>


