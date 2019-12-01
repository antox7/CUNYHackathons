<?php

//by Anvar Ashurov
//Require active database connection

require_once('../../database_op/connect.php');
require_once('../../database_op/credentials.php');

$sql = "CREATE TABLE `$db`.$group(
    `groupID` INT(3) NOT NULL AUTO_INCREMENT, 
     PRIMARY KEY(groupID),
    `groupName` VARCHAR(100) NOT NULL,
    `hackName` VARCHAR(100));";

if(!$conn->query($sql)){
    $json = array('error'=>"$conn->error");
}
else {
    $json = array('success' => "You have created table $group to store group info!");
}
echo json_encode($json);