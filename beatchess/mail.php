<?php
// Include the main PHPMailer class file
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Create a new PHPMailer instance
function sendVerificationEmail($email, $code) {
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    // Enable debugging
    $mail->SMTPDebug = 0;

    // Set up SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'muthumalith@gmail.com';
    $mail->Password = '';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    // Set up sender and recipient
    $mail->setFrom('muthumalith@gmail.com', 'BeatChess.com');
    $mail->addAddress($email);

    // Set email subject and body
    $mail->Subject = 'BeatChess Verification Code';
    $mail->Body    = "Your verification code is: $code";

    // Send the email
    try {
        $mail->send();
        $_SESSION['mail_status'] = 'Verification code has been sent to your Mail.';
    } catch (Exception $e) {
        $_SESSION['mail_status'] = 'Verification code could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
}
?>
