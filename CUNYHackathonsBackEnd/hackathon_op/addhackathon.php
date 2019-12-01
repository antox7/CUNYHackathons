<?php

//By Anvar Ashurov

require_once('../database_op/connect.php');
require_once('../database_op/credentials.php');

$hackName = $conn->real_escape_string($_POST['name']);
$hackDesc = $conn->real_escape_string($_POST['description']);
$hackPrize = $conn->real_escape_string($_POST['prize']);
$hackCity = $conn->real_escape_string($_POST['city']);
$hackState = $conn->real_escape_string($_POST['state']);
$hackStartDate = $conn->real_escape_string($_POST['startDate']);
$hackEndDate = $conn->real_escape_string($_POST['endDate']);
$hackTime = $conn->real_escape_string($_POST['hasTime']);
$hackInfo = $conn->real_escape_string($_POST['info']);
$hackLink = $conn->real_escape_string($_POST['link']);
$hackImageURL = $conn->real_escape_string($_POST['imageLink']);
//Default value is NULL because scraped hackathons have URL for images
$hackImageBinary = NULL;

if($hackName != NULL && $hackLink != NULL) {
    
    $result = $conn->query("SELECT * FROM $hackathon WHERE hackName = '$hackName' AND hackLink = '$hackLink'");
                                                 
    if ($result->num_rows > 0) {
        $json = array('hack_exists' => "$hackName is already in the list!");
        echo json_encode($json);
    }
    else{
        
        if(getimagesize($_FILES["hackathonImage"]["tmp_name"]) == FALSE) {
        //Insert without Image Upload
            $sql = "INSERT INTO $hackathon(hackName, hackDesc, hackPrize, hackInfo, hackCity, hackState,
                    hackStartDate, hackEndDate, hackTime, hackLink, hackImageURL)
                    VALUES ('$hackName', '$hackDesc', '$hackPrize', '$hackInfo', '$hackCity', '$hackState', '$hackStartDate', '$hackEndDate',
                    '$hackTime', '$hackLink', '$hackImageURL');";
        }
        else {
            $image = addslashes($_FILES['hackathonImage']['tmp_name']);
            $image = file_get_contents($image);
            $hackImageBinary = base64_encode($image);
            //Insert with Image Upload
            $sql = "INSERT INTO $hackathon(hackName, hackDesc, hackPrize, hackInfo, hackCity, hackState,
                    hackStartDate, hackEndDate, hackTime, hackLink, hackImageURL, hackImageBinary)
                    VALUES ('$hackName', '$hackDesc', '$hackPrize', '$hackInfo', '$hackCity', '$hackState', '$hackStartDate', '$hackEndDate',
                    '$hackTime', '$hackLink', '$hackImageURL', '$hackImageBinary');";
        }
        if(!$conn->query($sql)) {
            $json = array('error' => "$conn->error");
        }
        else {
            $json = array('success' => "$hackName has been added to the Hackathon table.");
        }
        echo json_encode($json);
    }
}
else {
    $json = array('error' => "Make sure to at least have Hackathon NAME and LINK!");
    echo json_encode($json);
}













































/*


require_once ('../user_op/connect.php');
require_once('../user_op/credentials.php');

$hackName = $conn->real_escape_string($_POST['name']);
$hackDesc = $conn->real_escape_string($_POST['description']);
$hackPrize = $conn->real_escape_string($_POST['prize']);
$hackCity = $conn->real_escape_string($_POST['city']);
$hackState = $conn->real_escape_string($_POST['state']);
$hackStartDate = $conn->real_escape_string($_POST['startDate']);
$hackEndDate = $conn->real_escape_string($_POST['endDate']);
$hackTime = $conn->real_escape_string($_POST['hasTime']);
$hackInfo = $conn->real_escape_string($_POST['info']);
$hackLink = $conn->real_escape_string($_POST['link']);
$hackImageURL = $conn->real_escape_string($_POST['imageLink']);
//Default value is NULL because scraped hackathons have URL for images
$hackImageBinary = NULL;

if($hackName != NULL && $hackLink != NULL) {

    if(getimagesize($_FILES["hackathonImage"]["tmp_name"]) == FALSE) {
    //Insert without Image Upload
        $sql = "INSERT INTO $hackathon(hackName, hackDesc, hackPrize, hackInfo, hackCity, hackState,
                hackStartDate, hackEndDate, hackTime, hackLink, hackImageURL)
                VALUES ('$hackName', '$hackDesc', '$hackPrize', '$hackInfo', '$hackCity', '$hackState', '$hackStartDate', '$hackEndDate',
                '$hackTime', '$hackLink', '$hackImageURL');";
    }
    else {
        $image = addslashes($_FILES['hackathonImage']['tmp_name']);
        $image = file_get_contents($image);
        $hackImageBinary = base64_encode($image);

    //Insert with Image Upload
        $sql = "INSERT INTO $hackathon(hackName, hackDesc, hackPrize, hackInfo, hackCity, hackState,
                hackStartDate, hackEndDate, hackTime, hackLink, hackImageURL, hackImageBinary)
                VALUES ('$hackName', '$hackDesc', '$hackPrize', '$hackInfo', '$hackCity', '$hackState', '$hackStartDate', '$hackEndDate',
                '$hackTime', '$hackLink', '$hackImageURL', '$hackImageBinary');";
    }
    
    if(!$conn->query($sql)) {
        $json = array('error' => "$conn->error");
    }
    else {
        $json = array('success' => "$hackName has been added to the Hackathon table.");
    }
    echo json_encode($json);
}

else {
    $json = array('error' => "Make sure to at least have Hackathon NAME and LINK!");
    echo json_encode($json);
}


*/
