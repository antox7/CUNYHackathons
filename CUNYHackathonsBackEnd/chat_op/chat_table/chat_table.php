<?php
//by Anvar Ashurov
//Require active database connection
require_once('../../database_op/connect.php');
require_once('../../database_op/credentials.php');

$sql = "CREATE TABLE `$db`.$chat(
    `chatID` INT(3) NOT NULL AUTO_INCREMENT, 
     PRIMARY KEY(chatID),
    `chatPath` VARCHAR(100) NOT NULL,
    `groupID` INT(3) NOT NULL, 
     FOREIGN KEY(groupID)REFERENCES $group(groupID));";

if(!$conn->query($sql)){
    $json = array('error'=>"$conn->error");
}
else {
    $json = array('success' => "You have created table $chat to store chat related data!");
}
echo json_encode($json);
