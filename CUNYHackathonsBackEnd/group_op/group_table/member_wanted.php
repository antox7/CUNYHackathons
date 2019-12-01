<?php

//by Anvar Ashurov
//Require active database connection

require_once('../../database_op/connect.php');
require_once('../../database_op/credentials.php');

$sql = "CREATE TABLE `$db`.$wanted(
    `mwID` INT(3) NOT NULL AUTO_INCREMENT, 
     PRIMARY KEY(mwID),
    `memberDesc` VARCHAR(200),
    `groupID` INT(3) NOT NULL, 
     FOREIGN KEY(groupID)REFERENCES $group(groupID));";

if(!$conn->query($sql)){
    $json = array('error'=>"$conn->error");
}
else {
    $json = array('success' => "You have created table $wanted to store list of members wanted!");
}
echo json_encode($json);
