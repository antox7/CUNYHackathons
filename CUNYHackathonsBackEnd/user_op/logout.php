<?php

//By Anvar Ashurov

require_once('../database_op/connect.php');
require_once('../database_op/credentials.php');

//HTTP Request POST is need to be made
if ($_POST['email']) {
    $email = $_POST['email'];
    //Sets ACTIVE = 0 (logged out)
    //This gives us the opportunity to separate users that are online
    $sql = $conn->query("UPDATE $users SET active = '0' where email = '$email'");
    if ($sql) {
        $json = array('user' => 'Logged out.');
    }
    else {
        $json = array('error' => 'Unable to process Log Out');
    }
    echo json_encode($json);
}
else {
    //This is rather unnecessary(Registration is email based) but is there for formality.
    $json = array('email_not_supplied' => 'Give me email that is logging out.');
    echo json_encode($json);
}

/*
if ($_POST['email']) {
    $email = $_POST['email'];
    $sql = $conn->query("UPDATE $users SET active = '0' where email = '$email'");
    if ($sql) {
        $json = array('user' => 'Logged out.');
        echo json_encode($json);
    }
}
else {
    $json = array('email_not_supplied' => 'Give me email that is logging out.');
    echo json_encode($json);
}
*/