<?php

//By Anvar Ashurov

require_once('../database_op/connect.php');
require_once('../database_op/credentials.php');

if($_POST['groupName']) {

    $groupName = $conn->real_escape_string($_POST['groupName']);

    $result = $conn->query("SELECT * FROM $group WHERE groupName = '$groupName'");
    echo $result->num_rows;
    if($result->num_rows == 0) {
        $json = array('error' => "Group not found.");
    }
    else {
        $result = $result->fetch_assoc();
        $groupID = $result['groupID'];
        //Find Path
        $sql = "SELECT * FROM $chat WHERE groupID = '$groupID'";
        $result = $conn->query($sql);

        if($result->num_rows != 0) {
            $result = $conn->query($sql);
            $result = $result->fetch_assoc();
            //Got the file path, now we are ready to write!
            $path = $result['chatPath'];
            //Delete the TXT file
            unlink($path);
            //DELETE FROM CHAT TABLE
            $sql = "DELETE FROM $chat WHERE groupID = '$groupID'";
            if($conn->query($sql)) {
                $json = array('success' => "$groupName no longer has chat file and it has also been removed from the $chat table");
            }
            else {
                $json = array('error' => "$conn->error");
            }
            json_encode($json);
            //DELETE FROM GROUP TABLE
            $sql = "DELETE FROM $group WHERE groupName = '$groupName'";
            $result = $conn->query($sql);
            if (!$result) {
                $json = array('error' => "$conn->error");
            } else {
                $json = array('success' => "$groupName has been deleted!");
            }
        }
        else {
            $json = array('error' => "No group with the name: $groupName");
            echo json_encode($json);
        }
    }
}
else {
    $json = array('error' => 'Enter required fields');
    echo json_encode($json);
}


