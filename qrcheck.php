<!DOCTYPE html>
<html>
<head>
    <title>QR Code Authentication</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .header {
            background-color: #0084ff;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header-left {
            display: flex;
            align-items: center;
        }
        .header-left img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .header-left h1 {
            color: white;
            font-size: 20px;
            margin: 0;
        }
        .header-right a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }
        .container {
            margin-top: 100px;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
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
            transition: background 0.3s;
        }
        button:hover {
            background-color: #218838;
        }
        .loading-screen {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(255, 255, 255, 0.95);
            z-index: 999;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .spinner {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #0084ff;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin-top: 20px;
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
            <img src="assests/logo.jpg" alt="Election Portal Logo" width="40" height="40">
            <h1>Election Commission of India</h1>
        </div>
        <div class="header-right">
            <a href="dashboard.php">Home</a>
            <a href="qrcheck.php">Vote</a>
            <a href="result.php">Results</a>
            <a href="about.php">About Us</a>
            <a href="profile.php">Profile</a>
        </div>
    </div>

    <div class="container">
        <h2>Upload QR Code for Authentication</h2>
        <form id="authForm" action="authenticate.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="qr_image" accept="image/*" required><br>
            <button type="submit">Authenticate</button>
        </form>
    </div>

    <div class="loading-screen" id="loadingScreen">
        <div>Please wait... Redirecting</div>
        <div class="spinner"></div>
    </div>

    <script>
        document.getElementById('authForm').addEventListener('submit', function (e) {
            e.preventDefault(); 
            document.getElementById('loadingScreen').style.display = 'flex';

            
            setTimeout(() => {
                this.submit();
            }, 2000);
        });
    </script>
</body>
</html>
