<?php

//By Anvar Ashurov

require_once('../../database_op/connect.php');
require_once('../../database_op/credentials.php');

$sql = "CREATE TABLE `$db`.$hackathon(
    `hackID` INT(3) NOT NULL AUTO_INCREMENT, 
     PRIMARY KEY(hackID),
    `hackName` VARCHAR(100) NOT NULL,
    `hackDesc` VARCHAR(1000),
    `hackPrize` VARCHAR(100),
    `hackInfo` VARCHAR(1000), 
    `hackCity` VARCHAR(100),
    `hackState` CHAR(2),
    `hackStartDate` DATE, 
    `hackEndDate` DATE,
    `hackTime` TIME,
    `hackLink` VARCHAR(255) NOT NULL,
    `hackImageURL` VARCHAR(255),
    `hackImageBinary`LONGBLOB);";

if(!$conn->query($sql)){
    $json = array('error'=>"$conn->error");
    echo json_encode($json);
}

else {
    $json = array('success' => "You have created table $hackathon!");
    echo json_encode($json);
}




