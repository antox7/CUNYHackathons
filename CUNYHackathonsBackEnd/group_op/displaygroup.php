<?php

//By Anvar Ashurov

require_once('../database_op/connect.php');
require_once('../database_op/credentials.php');

//Display groups that are in hackathon (Search is based on Hackathon Name)

if($_POST['hackName']) {
    $hackName = $conn->escape_string($_POST['hackName']);
    $sql = "SELECT * FROM $group WHERE hackName = '$hackName'";
    $result = $conn->query($sql);
    $json = array();
    while ($row = $result->fetch_assoc()) {
        $json[] = array(
            'groupName' => $row['groupName']
        );
    }
    echo(json_encode($json));
}
