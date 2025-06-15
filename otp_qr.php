<?php
session_start();
require_once 'phpqrcode/qrlib.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
$otp_verified = false;
$qr_code_url = ""; 
include("db.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $entered_otp = trim($_POST['otp'] ?? '');

    if (isset($_SESSION['otp']) && $entered_otp == $_SESSION['otp']) {
        $otp_verified = true;
        unset($_SESSION['otp']); 

        
        $email = $_SESSION['email'] ?? '';
        $mobile = $_SESSION['phno'] ?? '';
        $name = $_SESSION['name'] ?? '';
        $vid = $_SESSION['vid'] ?? '';
        $pass = $_SESSION['pass'] ?? '';


        if (!empty($email) && !empty($mobile)) {
            
            $qr_data = "Email: $email\nMobile: $mobile\nStatus: Verified";

            
            $qr_file = "images/" . md5($email . $mobile) . ".png";
            
            
            QRcode::png($qr_data, $qr_file, QR_ECLEVEL_L, 10);

    
            $qr_code_url = $qr_file;
            $mail = new PHPMailer(true);
                
                
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'pragadeesh903@gmail.com';
                $mail->Password = 'jwri gmrm ngis jwri'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;
                $mail->setFrom('pragadeesh903@gmail.com', 'Your QR Code');
                $mail->addAddress($email);
                $mail->addAttachment($qr_code_url);
                $mail->isHTML(true);
                $mail->Subject = 'Qr Code';
                $mail->Body = "Download it and save in your local disk for future purpose";

                $mail->send();
                $query = "insert into signup (name,vid,phno, pass, email, qr) values ('$name','$vid','$mobile','$pass','$email','$qr_code_url')";
                mysqli_query($con, $query);
            
            
        } else {
            echo "<script>alert('Email or Mobile Number is missing. Please retry.');</script>";
            unset($_SESSION['otp']);
        }
    } else {
        echo "<script>alert('Invalid OTP. Please try again.');</script>";
        unset($_SESSION['otp']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP and QR Creation Page</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    
    <div class="container">
        <div class="left">
            <h1>Sign Up Now!</h1>
            <p>Here you can register and get your personalised QR code</p>
        </div>    

        <div class="right">
            <form id="signup-form" method="POST" action="otp_qr.php">
                <label for="OTP">Enter your OTP Code:</label>  
                <div style="display: flex; align-items: center; gap: 10px;">
                    <input style="flex: 1; padding: 8px; width: 65%;" placeholder="Enter your OTP" name="otp" id="otp" required>
                    <button type="submit"
                        style="background-color: red; color: white; border: none; padding: 8px 15px; cursor: pointer; border-radius: 35px;">
                         Verify  
                    </button>  
                </div>
                
                <?php if ($otp_verified && !empty($qr_code_url)): ?>
                    <label for="QR code">Your QR Code:</label>  
                    <br>
                    <img style="height: 310px; width: 310px;" src="<?= $qr_code_url ?>" alt="QR Code">  
                    <br>
                    <a href="<?= $qr_code_url ?>" download="User_QR.png">
                        <button type="button">Download</button>
                    </a>
                <?php endif; ?>

                <p>Already have an account? <a href="index.php">Login Here</a></p>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
