<?php

$dsn = 'mysql:host=localhost;dbname=ecommerce_uy21';
$username = 'root';
$password = '';
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
); 

try{
  $connection = new PDO($dsn,$username,$password);
//Set the error reporting mode.
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//Set fetch mode
$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

//echo "Database connection successful!";
} catch (Exception $e) {
    echo "Connection Failed".$e->getMessage();
}


