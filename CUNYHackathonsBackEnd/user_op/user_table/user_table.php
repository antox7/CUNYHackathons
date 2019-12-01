<?php

//By Anvar Ashurov

require_once('../../database_op/connect.php');

$sql = "CREATE TABLE `$db`.$users(
          `id` INT (3) AUTO_INCREMENT PRIMARY KEY,
          `email` VARCHAR(100) NOT NULL,
          `password` VARCHAR(100) NOT NULL,
          `hash` VARCHAR(100) NOT NULL,
          `verified` char(1),
          `active` char(1) 
          );";

if(!$conn->query($sql)){
    $json = array('error'=>"$conn->error");
    echo json_encode($json);
}

else {
    $json = array('success' => "You have created table $users!");
    echo json_encode($json);
    
    $pwd = "0000";
    $adminpwd = md5($pwd);
    $adminhash = password_hash($pwd, PASSWORD_BCRYPT);
    $conn->query("INSERT INTO `$db`.$users(email, password, hash) VALUE ('$admin', '$adminpwd', '$adminhash');") or die($conn->error);
}
    