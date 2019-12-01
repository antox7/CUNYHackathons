<?php

//By Anvar Ashurov
//PHPMailer SEND MAIL FOR VERIFICATION

require_once('../database_op/connect.php');
require_once('../database_op/credentials.php');
require_once('../mail.php');

if ($_POST['email'] && $_POST['password'] && $_POST['password2']) {

    //This checks if email includes pattern CUNY.EDU
    if (preg_match('/cuny.edu/', $_POST['email'])) {

        //Prevent SQL Injection attacks
        $email = $conn->real_escape_string($_POST['email']);

        //Encrypt password provided by user
        $password = md5($conn->real_escape_string($_POST['password']));
        $password2 = md5($conn->real_escape_string($_POST['password2']));
        //This is used in future as I implement Email Confirmation
        $hash = substr(md5(microtime()),rand(0,26),5);
        //Check if email exists in Database
        $result = $conn->query("SELECT * FROM $users WHERE email='$email'") or die($conn->error);

        if ($result->num_rows > 0) {

            $json = array('user_exists' => "Account for $email already exists. Please sign in.");
            echo json_encode($json);
        }
        else {

            if ($password == $password2) {

                //Insert new user into Database
                $sql = "INSERT INTO $users (email, password, hash) VALUES('$email', '$password', '$hash')";
                if ($conn->query($sql)) {
                    $stmt = $conn->query("UPDATE $users SET active = '0' where email = '$email'");
                    $stmt2 = $conn->query("UPDATE $users SET verified = '0' where email = '$email'");
                    if (!$stmt) {
                        $json = array('error' => 'Error has occurred. Please try again later.');
                        echo json_encode($json);
                    }
                    else {
                        $json = array('user_created' => 'The user has been created.');
                        $to = "$email";
                        $subject = "Please verify your account.";
                        $body = '
                             Hello '.$email.',
                             Thank you for signing up!
                             Please click this link to activate your account:
                             http://localhost/CUNYHackathonsBackEnd/user_op/verify.php?email='.$email.'&hash='.$hash;
                        sendmail($to,"there", $subject, $body);
                    }
                }
                else {

                    $json = $conn->error;
                }
                echo json_encode($json);
            }
            else {

                $json = array('password_not_match' => 'Password does not match.');
                echo json_encode($json);
            }
        }
    }
    else {

        //If Pattern mentioned all the way above in the IF statement is not met, then ..
        $json = array('domain_error' => 'Make sure to use your CUNY email');
        echo json_encode($json);
    }
}
else {

    $json = array('empty_entry' => 'Make sure the required field(s) are not empty');
    echo json_encode($json);
}



























/*


if ($_POST['email'] && $_POST['password'] && $_POST['password2']) {

    //This checks if email includes pattern CUNY.EDU
    if (preg_match('/cuny.edu/', $_POST['email'])) {

        //Prevent SQL Injection attacks
        $email = $conn->real_escape_string($_POST['email']);

        //Encrypt password provided by user
        $password = md5($conn->real_escape_string($_POST['password']));
        $password2 = md5($conn->real_escape_string($_POST['password2']));

        //This is used in future as I implement Email Confirmation
        $hash = password_hash($password, PASSWORD_BCRYPT);

        //Check if email exists in Database
        $result = $conn->query("SELECT * FROM $users WHERE email='$email'") or die($conn->error);

        if ($result->num_rows > 0) {

            $json = array('user_exists' => "Account for $email already exists. Please sign in.");
            echo json_encode($json);
        }
        else {

            if ($password == $password2) {

                //Insert new user into Database
                $sql = "INSERT INTO $users (email, password, hash) VALUES('$email', '$password', '$hash')";

                if ($conn->query($sql)) {

                    $json = array('user_created' => 'The user has been created.');

                }
                else {

                    $json = $conn->error;
                }
                echo json_encode($json);
            }
            else {

                $json = array('password_not_match' => 'Password does not match.');
                echo json_encode($json);
            }
        }
    }
    else {

        //If Pattern mentioned all the way above in the IF statement is not met, then ..
        $json = array('domain_error' => 'Make sure to use your CUNY email');
        echo json_encode($json);
    }
}
else {

    $json = array('empty_entry' => 'Make sure the required field(s) are not empty');
    echo json_encode($json);
}



*/