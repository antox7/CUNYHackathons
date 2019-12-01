<?php

//By Anvar Ashurov

require_once('../database_op/connect.php');
require_once('../database_op/credentials.php');

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']))
{
    $email = $conn->real_escape_string($_GET['email']);
    $hash = $conn->real_escape_string($_GET['hash']);

    $result = $conn->query("SELECT * FROM $users WHERE email='$email' AND hash='$hash'");
    $result = $result->fetch_assoc();

    if ( $result['id'] == Null )
    {
        $json = array('error' => "$email has already been activated or an invalid URL!");
    }
    else {
        $json = array('success' => "Your account has been activated!");

        // Set the user status to active (active = 1)
        $conn->query("UPDATE $users SET active='1' WHERE email='$email'") or die($conn->error);
        $conn->query("UPDATE $users SET verified='1' WHERE email='$email'") or die($conn->error);
    }
    echo json_encode($json);
}