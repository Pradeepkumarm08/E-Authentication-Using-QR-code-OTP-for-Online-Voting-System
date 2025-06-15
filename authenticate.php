<?php
session_start();
include("db.php");

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$userEmail = $_SESSION['email'];

if ($con->connect_error) {
    die("Database connection failed: " . $con->connect_error);
}

$sql = "SELECT phno FROM signup WHERE email = ?";
$stmt = $con->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $con->error);
}
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $userMobile = $row['phno'];
} else {
    die("User not found in database.");
}

$stmt->close();
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Authentication</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
        }

     
        .header {
            background-color: #0084ff;
            padding: 10px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .header-left img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .header-left h1 {
            font-size: 22px;
            margin: 0;
        }

        .nav-links a {
            margin-left: 25px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

       
        .container {
            background: white;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 50px auto;
            text-align: center;
            border-radius: 8px;
        }

        input[type="file"] {
            margin-bottom: 20px;
        }

        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .error {
            color: red;
            font-weight: bold;
        }

    
        .redirecting {
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            text-align: center;
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
        }

        .spinner {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #007bff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin-bottom: 15px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

    
    <div class="header">
        <div class="header-left">
            <img style="border-radius: 80%;" src="assests/logo.jpg" alt="Election Portal Logo" width="40" height="40" class="me-2">
            <h1>Election Commission of India</h1>
        </div>
        <div class="nav-links">
            <a href="dashboard.php">Home</a>
            <a href="authenticate.php">Vote</a>
            <a href="result.php">Results</a>
            <a href="about.php">About Us</a>
            <a href="profile.php">Profile</a>
        </div>
    </div>


    <div class="container" id="auth-container">
        <h2>QR Code Authentication</h2>
        <input type="file" id="qr-input" accept="image/*" />
        <button onclick="verifyQR()">Verify QR Code</button>
        <div id="message"></div>
    </div>

   
    <div class="redirecting" id="redirecting">
        <div class="spinner"></div>
        <p>Please wait... Redirecting</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.3.1/dist/jsQR.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/spark-md5@3.0.2/spark-md5.min.js"></script>

    <script>
        const userEmail = "<?php echo $userEmail; ?>";
        const userMobile = "<?php echo $userMobile; ?>";

        function verifyQR() {
            const fileInput = document.getElementById('qr-input');
            const messageDiv = document.getElementById('message');

            if (!fileInput.files[0]) {
                messageDiv.innerHTML = "<p class='error'>Please upload a QR code image.</p>";
                return;
            }

            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const imageData = e.target.result;

                const img = new Image();
                img.src = imageData;

                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    ctx.drawImage(img, 0, 0, img.width, img.height);

                    const imageDataCanvas = ctx.getImageData(0, 0, canvas.width, canvas.height);
                    const qrCode = jsQR(imageDataCanvas.data, canvas.width, canvas.height);

                    if (qrCode) {
                        const decodedText = qrCode.data;
                        const expectedText = `Email: ${userEmail}\nMobile: ${userMobile}\nStatus: Verified`;
                        const expectedHash = SparkMD5.hash(expectedText);

                        if (SparkMD5.hash(decodedText) === expectedHash) {
                            document.getElementById('auth-container').style.display = 'none';
                            document.getElementById('redirecting').style.display = 'flex';

                            setTimeout(() => {
                                window.location.href = "vote.php";
                            }, 2000);
                        } else {
                            messageDiv.innerHTML = "<p class='error'>QR code does not match your data. Authentication failed.</p>";
                        }
                    } else {
                        messageDiv.innerHTML = "<p class='error'>Could not decode the QR code. Please make sure it's clear and valid.</p>";
                    }
                }
            };

            reader.readAsDataURL(file);
        }
    </script>
</body>
</html>
