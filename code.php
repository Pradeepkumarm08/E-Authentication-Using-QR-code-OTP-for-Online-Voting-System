<?php
session_start();
include('db.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$name =isset($_GET['name']);
        $vid = isset($_GET['vid']);
        $phno = isset($_GET['phno']);
        $pass = isset($_GET['password']);
        $email =isset($_GET['email']);      

$mail = new PHPMailer(true);
$otp = mt_rand(100000, 999999);
$temp=$otp;

try {

    $email = isset($_GET['email']) ? trim($_GET['email']) : '';

    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Invalid or empty email address.');
    }

    
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = true;
    $mail->Username = 'pragadeesh903@gmail.com';
    $mail->Password = 'jwri gmrm ngis jwri';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;    
    $mail->Port = 465;
   
    

    $mail->setFrom('pragadeesh903@gmail.com', 'Pragadeeshwaran S');
    $mail->addAddress($email, 'Pragadeeshwaran'); // Ensure email is valid


    $mail->isHTML(true);
    $mail->Subject = 'E-mail Verification';
    $mail->Body    = 'Your OTP is '. $otp;

    $mail->send();
    echo "<script type='text/javascript'> alert('Mail Sent')</script>";  
    header("location: otp_qr.php");
                        
} catch (Exception $e) {
    echo "<script type='text/javascript'> alert('Can't Able to Send Mail')</script>";  
    header("location: index.php");
}
?>


