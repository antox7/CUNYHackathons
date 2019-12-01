<?php

require_once('../database_op/connect.php');
require_once('../database_op/credentials.php');

if($_POST['groupName'] && $_POST['userName'] && $_POST['userMessage'] && $_POST['messageDate']) {

    $groupName = $conn->real_escape_string($_POST['groupName']);
    $userName = $conn->real_escape_string($_POST['userName']);
    $userMessage = $conn->real_escape_string($_POST['userMessage']);
    $messageDate = $conn->real_escape_string($_POST['messageDate']);
    //We need this to be written in the txt file
    //.anvarashurov717. : .Just a little message. . at .10:36 PM 12/26/2017
    $messageString = "$userName: $userMessage @ $messageDate \n";

    //In future, we can put in UI the groupID as an indicator to the Front-end.
    //It will make the insertion easier using current style of insertion.

    $sql = "SELECT groupID FROM $group WHERE groupName = '$groupName'";
    if ($conn->query($sql)) {
        //if there is such group, then we are in this if statement.
        $result = $conn->query($sql);
        $result = $result->fetch_assoc();
        //got the groupID, we can now look for appropriate chat path
        $groupID = $result['groupID'];

        $sql = "SELECT * FROM $chat WHERE groupID = '$groupID'";
        if($conn->query($sql)) {
            $result = $conn->query($sql);
            $result = $result->fetch_assoc();

            //Got the file path, now we are ready to write!
            $path = $result['chatPath'];
            $absolutePath = "$path";
            //Let's write into the specific file for a specific group
            //fwrite($path,$messageString);

            file_put_contents($absolutePath, $messageString, FILE_APPEND);
            $json = array('success' => "Message is posted at $path.");
           // json_encode($json);
        }
        else {
            $json = array('error' => "Query was not processed. ERROR: $conn->error");
        }
        echo json_encode($json);
    }
    else {
        $json = array('error'=>"No such group with the following name: $groupName");
        echo json_encode($json);
    }
}
else {
    $json = array('error' => 'Required field is missing');
    echo json_encode($json);
}



/*


if(isset($_POST['send'])) {

    $groupName = $conn->real_escape_string($_POST['groupName']);
    $userName = $conn->real_escape_string($_POST['userName']);
    $userMessage = $conn->real_escape_string($_POST['userMessage']);
    $messageDate = $conn->real_escape_string($_POST['messageDate']);
    //We need this to be written in the txt file
    $messageString = $userName . " : " . $userMessage . " at " . $messageDate;

    //In future, we can put in UI the groupID as an indicator to the Front-end.
    //It will make the insertion easier using current style of insertion.

    $sql = "SELECT groupID FROM $group WHERE groupName = '$groupName'";
    if ($conn->query($sql)) {
        //if there is such group, then we are in this if statement.
        $result = $conn->query($sql);
        $result = $result->fetch_assoc();
        //got the groupID, we can now look for appropriate chat path
        $groupID = $result['groupID'];

        $sql = "SELECT chatID FROM $chat WHERE groupID = '$groupID'";
        if($conn->query($sql)) {
            $result = $conn->query($sql);
            $result = $result->fetch_assoc();
            //Got the file path, now we are ready to write!
            $filePath = $result['chatPath'];

            //Let's write into the specific file for a specific group
            fwrite($filePath,$messageString);


            $json = array('success' => 'Message is posted.');
        }
        else {
            $json = array('error' => "Query was not processed. ERROR: $conn->error");
        }
        echo json_encode($json);
    }
    else {
        $json = array('error'=>"No such group with the following name: $groupName");
    }
    echo json_encode($json);
}
else {
    $json = array('error' => 'Required field is missing');
}
echo json_encode($json);


 */