<?php

//By Anvar Ashurov

require_once('credentials.php');

// Create connection
$conn = new mysqli($host, $user, $pass);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Create database
$sql = "CREATE DATABASE $db";
if ($conn->query($sql) === TRUE) {
    $json = array("$db created successfully");
}
else {
    $json = array('error' => "Either database by $db already exists or we could not connect to MySQL Server.
                              ERROR: $conn->error");
}
echo json_encode($json);