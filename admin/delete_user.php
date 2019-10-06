<?php
require '../connection.php';


$del = $connection->prepare('DELETE FROM `users` WHERE `user_id`= :user_id');
$del->bindValue(':user_id',$_GET['id'],PDO::PARAM_INT);
$del->execute();

if($del->rowCount() === 1){
    $del = $connection->prepare('ALTER TABLE `users`  AUTO_INCREMENT = 1');
    $del->execute();
}



header('Location: users.php');