<?php
session_start();
include("db.php"); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if (!isset($_SESSION['otp'])) {
    $_SESSION['otp'] = mt_rand(100000, 999999);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $vid = trim($_POST['vid'] ?? '');
    $phno = trim($_POST['phno'] ?? '');
    $pass = trim($_POST['password'] ?? '');
    $email = trim($_POST['email'] ?? '');

    $_SESSION['email'] = $email; 
    $_SESSION['phno'] = $phno;
    $_SESSION['name'] = $name;
    $_SESSION['vid'] = $vid;
    $_SESSION['pass'] = $pass;

    
    $query = "SELECT * FROM signup WHERE email = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        
        echo "<script>alert('This email is already registered. Please log in.');</script>";
    } else {
        
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                $mail = new PHPMailer(true);

            
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'pragadeesh903@gmail.com';
                $mail->Password = 'jwri gmrm ngis jwri'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

            
                $mail->setFrom('pragadeesh903@gmail.com', 'Pragadeeshwaran S');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'E-mail Verification';
                $mail->Body = 'Your OTP is ' . $_SESSION['otp'];

                $mail->send();
                echo "<script>alert('OTP sent to your email.'); window.location.href='otp_qr.php';</script>";
                exit();
            } catch (Exception $e) {
                echo "<script>alert('Mail could not be sent. Error: {$mail->ErrorInfo}');</script>";
            }
        } else {
            echo "<script>alert('Please enter a valid email address.');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    
    <div class="container">
       
        <div class="left">
            <h1>Sign Up Now!</h1>
            <p>Here you can register and Get your Personalised QR code</p>
        </div>    
        <div class="right">
            
            <form id="signup-form" action="" method="POST">
                <label for="name">Your Name :</label>
                <input type="text" id="name" required placeholder="Enter Fullname " name="name"  required>
                <label for="vid">Voter id :</label>
                <input type="text" id="name" required placeholder="Enter Voter id " name="vid" required>
                <label for="name">Phone Number :</label>
                <input type="text" id="phno" required  placeholder="Enter 10-digit Phone Number " name="phno" required>
                <label for="password">Password :</label>
                <input type="password" id="password"  placeholder="Enter Password" name="password" reqiured>
                <label for="email">Email :</label>    
                <div style="display: flex; align-items: center; gap: 10px;">
                    <input type="email" style="flex: 1; padding: 8px; width: 65%;" placeholder="Enter E-mail" name="email" id="email">
                    <button  onclick="document.getElementById('hiddenInput').style.display='block'" 
                        style="background-color: red; color: white; border: none; padding: 8px 15px; cursor: pointer; border-radius: 35px;" name="verify" href="otp_qr.php">
                         Verify  
                    </button>
                
                    
                </div>
               
                
                <p>Already have an account ? <a href="index.php">Login Here</a></p>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
