<?php

require_once('../database_op/connect.php');
require_once('../database_op/credentials.php');

if($_POST['groupName']) {
    $groupName = $conn->real_escape_string($_POST['groupName']);

    $sql = "SELECT groupID FROM $group WHERE groupName = '$groupName'";
    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    $groupID = $result['groupID'];

    $sql = "SELECT chatPath FROM $chat AS Chat WHERE Chat.groupID = '$groupID'";
    $result = $conn->query($sql);

    //This contains the path
    $result = $result->fetch_assoc();
    $my_file = $result['chatPath'];
    // Open the file
    $fp = @fopen($my_file, 'r');
    // Add each line to an array
    $json[] = array();
    if ($fp) {
        $json = explode("\n", fread($fp, filesize($my_file)));
    }
    echo json_encode($json);
}
else {
    $json = array('error' => 'Required field is missing');
    echo json_encode($json);
}
