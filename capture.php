<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 

header("Content-Type: application/json"); 


$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email']) || !isset($data['image'])) {
    echo json_encode(["status" => "error", "message" => "Invalid data received"]);
    exit;
}

$email = trim($data['email']);
$image = $data['image'];


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["status" => "error", "message" => "Invalid email format"]);
    exit;
}


if (!preg_match('/^data:image\/(png|jpeg);base64,/', $image)) {
    echo json_encode(["status" => "error", "message" => "Invalid image format"]);
    exit;
}


$image_parts = explode(";base64,", $image);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];
$image_base64 = base64_decode($image_parts[1]);

$file_name = "captured_" . time() . "." . $image_type;
$file_path = "uploads/" . $file_name;
file_put_contents($file_path, $image_base64); 


$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = true;
    $mail->Username = 'pragadeesh903@gmail.com'; 
    $mail->Password = 'jwri gmrm ngis jwri'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   
    $mail->Port = 465;

    $mail->setFrom('pragadeesh903@gmail.com', 'Security Alert');
    $mail->addAddress($email); 
    $mail->addAttachment($file_path, 'CapturedImage.png');

    $mail->isHTML(true);
    $mail->Subject = 'Security Alert: Suspicious Login Attempt';
    $mail->Body = "<p>Someone attempted to log into your account multiple times. See the attached image for details.</p>";

    $mail->send();
    echo json_encode(["status" => "success", "message" => "Image captured and sent"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Mail error: " . $mail->ErrorInfo]);
}
?>
