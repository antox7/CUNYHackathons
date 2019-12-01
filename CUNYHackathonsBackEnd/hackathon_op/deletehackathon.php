<?php

//By Anvar Ashurov

require_once('../database_op/connect.php');
require_once('../database_op/credentials.php');

if($_POST['name'] && $_POST['link']) {
    
    $name = $conn->real_escape_string($_POST['name']);
    $link =  $conn->real_escape_string($_POST['link']);
    
    $result = $conn->query("SELECT * FROM $hackathon WHERE hackName = '$name' AND hackLink ='$link'");
    
    if($result->num_rows == 0) {
        $json = array('error' => "Hackathon not found.");
    }
    else {
        $sql = "DELETE FROM $hackathon WHERE hackName = '$name' AND hackLink = '$link'";
        $result = $conn->query($sql);
        if(!$result) {
            $json = array('error' => "$conn->error");
        }
        else {
            $json = array('success' => 'Hackathon has been deleted.');
        }
    }
    echo json_encode($json);
}
else {
    $json = array('error' => 'Enter required fields');
    echo json_encode($json);
}


