<?php

//By Anvar Ashurov

require_once('../database_op/connect.php');
require_once('../database_op/credentials.php');

if ($_POST['email'] && $_POST['password']) {

    $email = $conn->real_escape_string($_POST['email']);

    $result = $conn->query("SELECT * FROM $users WHERE email='$email'"); // or die($conn->error);

    $user = $result->fetch_assoc();

    if ($result->num_rows > 0) {

        $pwFromDb = $user['password'];
        $sign_in_password = md5($conn->real_escape_string($_POST['password']));

        if ($pwFromDb == $sign_in_password) {
            if ($admin == $email) {
                $stmt = $conn->query("UPDATE $users SET active = '1' where email = '$email'");
                if ($stmt) {
                    $json = array('user' => 'Admin is logged in.');
                    echo json_encode($json);
                } else {
                    $json = array('error' => 'Error has occurred. Please try again later.');
                    echo json_encode($json);
                }
            } else {
                $stmt = $conn->query("UPDATE $users SET active = '1' where email = '$email'");
                if ($stmt) {
                    $json = array('user' => 'Regular user is logged in.');
                    echo json_encode($json);
                } else {
                    $json = array('error' => 'Error has occurred. Please try again later.');
                    echo json_encode($json);
                }
            }
        }
        else {
        $json = array('password_not_match' => 'You have entered an incorrect password. Please try again!');
        echo json_encode($json);
        }
    }
    else {
        $json = array('user_not_exist' => 'A user with such details does not exist. Please register!');
        echo json_encode($json);
    }
}

else {
    $json = array('wrong_entry' => 'Please fill out required field(s)');
    echo json_encode($json);
}
