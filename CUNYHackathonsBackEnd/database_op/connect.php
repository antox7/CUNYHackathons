<?php

//By Anvar Ashurov

require_once('credentials.php');

//connection string to mysql database
$conn = new mysqli($host, $user, $pass, $db);

//echos json object response to identify error
if (!$conn) {
    $json = array('error' => "Connection to $db has not been established");
    echo json_encode($json);
}

//echos success if the connection was established
/*
else {
    $json = array('success' => "Connection to $db has been successfully established!");
    echo json_encode($json);
}
*/
