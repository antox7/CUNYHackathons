<?php

//by Anvar Ashurov
//Require active database connection

require_once('../../database_op/connect.php');
require_once('../../database_op/credentials.php');

$sql = "CREATE TABLE `$db`.$member(
    `userID` INT NOT NULL,
    FOREIGN KEY(userID) REFERENCES $users(ID),
    `groupID` INT NOT NULL, 
    FOREIGN KEY(groupID) REFERENCES $group(groupID));";

if(!$conn->query($sql)){
    $json = array('error'=>"$conn->error");
    echo json_encode($json);
}
else {
    $json = array('success' => "You have created table $member to store member information!");
    echo json_encode($json);
}