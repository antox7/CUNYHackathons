<?php

//By Anvar Ashurov

require_once('../database_op/connect.php');
require_once('../database_op/credentials.php');
//Group insertion. Unique chat file is assigned to group.

if($_POST['groupName'] && $_POST['hackathonName']) {

    $groupName = $conn->real_escape_string($_POST['groupName']);
    $hackName = $conn->real_escape_string($_POST['hackathonName']);
    $memberDesc = $conn->real_escape_string($_POST['missingMemberList']);

    $result = $conn->query("SELECT * FROM $group WHERE groupName = '$groupName'");

    //group exists
    if ($result->num_rows != 0) {
        $json = array('group_exists' => "Group name $groupName already exists. Please try another group name!");
        echo json_encode($json);
    }
    //group is inserted
    else {
        $sql = "INSERT INTO $group (groupName, hackName) VALUES ('$groupName', '$hackName');";
        if ($conn->query($sql)) {
            $json = array('group_created' => "Congratulations! $groupName has been created! Let's hire coders now!");
            //insertion check
            $sql = "SELECT groupID FROM $group WHERE groupName = '$groupName' AND hackName = '$hackName'";
            //need to store in result for further manipulation
            $result = $conn->query($sql);
            //if group does not exist, then SQL will return null. Else, exactly 1 since Group name is uniquely chosen by User.
            if ($result->num_rows > 0) {
                //If we are in this IF statement, then Group exists;
                $result = $result->fetch_assoc();
                //Insert groupid in chat so we have unique chat for group
                $groupID = $result['groupID'];
                //generate unique name for our file
                $fileName = md5($groupName);
                //specify directory
                $filePath = "../chat_op/messages/$fileName.txt";
                $relativePathDb = "messages/$fileName.txt";
                //create file
                $createFile = fopen($filePath, 'w');
                //assigned chatPath and group that chat belongs to.
                $sql = "INSERT INTO $chat(chatPath, groupID) VALUES ('$relativePathDb', '$groupID')";
                //***********Fix this. Insert all rows of data.
                $sql2 = "INSERT INTO $wanted(memberDesc, groupID) VALUES ('$memberDesc', '$groupID')";

                if ($conn->query($sql) && $conn->query($sql2)) {
                    $json = array('success' => 'Both group and chat are set up!');
                }
                else {
                    $json = array('error' => "Error while creating chat: $conn->error");
                }
                echo json_encode($json);
            }
            else {
                $json = array('error' => "Group not found. Weird error. Not your fault. $conn->error");
                echo json_encode($json);
            }
        }
        else {
            $json = array('error' => "Insertion was not processed. Group was not created: $conn->error");
            echo json_encode($json);
        }
    }
}
else {
    $json = array('error' => 'Required field(s) missing.');
    echo json_encode($json);
}


//At this point, Group is created and paired with chat.





/*

if(isset($_POST)) {
    $groupName = $conn->real_escape_string($_POST['groupName']);
    $hackName = $conn->real_escape_string($_POST['hackathonName']);

    $result = $conn->query("SELECT * FROM $group WHERE groupName = '$groupName'");

    //group exists
    if ($result->num_rows > 1) {
         $json = array('group_exists' => "Group name $groupName already exists. Please try another group name!");
    }
    //group is inserted
    else {
        $sql = "INSERT INTO $group (groupName, hackName) VALUES ('$groupName', '$hackName');";
        if ($conn->query($sql)) {
            $json = array('group_created' => "Congratulations! $groupName has been created! Let's hire coders now!");
            echo json_encode($json);
            //insertion check
            $sql = "SELECT groupID FROM $group WHERE groupName = '$groupName' AND hackName = '$hackName'";
            //need to store in result for further manipulation
            $result = $conn->query($sql);
            //if group does not exist, then SQL will return null. Else, exactly 1 since Group name is uniquely chosen by User.
            if ($result->num_rows > 0) {
                echo "5";
                //If we are in this IF statement, then Group exists;
                $result = $result->fetch_assoc();
                //Insert groupid in chat so we have unique chat for group
                $groupID = $result['groupID'];
                //generate unique name for our file
                $fileName = md5($groupName);
                //specify directory
                $filePath = "../chat_op/messages/$fileName.txt";
                //create file
                $createFile = fopen($filePath, 'w');
                //assigned chatPath and group that chat belongs to.
                $sql = "INSERT INTO $chat(chatPath, groupID) VALUES ('$filePath', '$groupID')";
                if ($conn->query($sql)) {
                    echo "6";
                    $json = array('success' => 'Both group and chat are set up!');
                } else {
                    echo "7";
                    $json = array('error' => "Error while creating chat: $conn->error");
                }
                echo json_encode($json);
            } else {
                echo "8";
                $json = array('error' => "Group not found. Weird error. Not your fault. $conn->error");
                echo json_encode($json);
            }
            echo "9";
            echo json_encode($json);
        } else {
            $json = array('error' => "Insertion was not processed. Group was not created: $conn->error");
            echo json_encode($json);
        }
    }
}
else {
    $json = array('error'=>'Make POST request');
    echo json_encode($json);
}
//At this point, Group is created and paired with chat.


 */
