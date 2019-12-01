<?php

//Changes made by Anvar Ashurov in originally available file on github (PHPMailer/PHPMailer)
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require 'vendor/autoload.php';
function sendmail($to, $name, $subject, $body)
{
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'cunyhackathons@gmail.com';                 // SMTP username
        $mail->Password = '2017CunyHackathons';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('donotreply@gmail.com', 'donotreply');
        $mail->addAddress($to, $name);     // Add a recipient
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        //$json = array('success' => 'Message has been sent');
    } catch (Exception $e) {
        $json = array('error' => "Message could not be sent. ERROR: $mail->ErrorInfo");
        return json_encode($json);
    }

}