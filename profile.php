<?php
session_start();
include("db.php");

if (!isset($_SESSION['email'])) {
    echo "<script>alert('Please log in first!'); window.location.href='index.php';</script>";
    exit;
}

$email = $_SESSION['email'];

$query = "SELECT name, vid, phno, email FROM signup WHERE email=?";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "<script>alert('User not found!'); window.location.href='index.php';</script>";
    exit;
}

$stmt->close();
$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Election Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #007bff;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 10px;
            font-weight: bold;
        }
        .hero-section {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            margin-top: 20px;
        }
        .carousel img {
            height: 400px;
            object-fit: cover;
        }
        .upcoming-elections {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
        }
        .marquee-text {
            font-size: 18px;
            font-weight: bold;
            color: #D70040;
        }
        .slider-container {
            display: flex;
            overflow-x: auto;
            gap: 10px;
            padding: 10px;
            scrollbar-width: none;
        }
        .slider-container::-webkit-scrollbar {
            display: none;
        }
        .state-box {
            flex: 0 0 auto;
            padding: 15px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            width: 150px;
            text-align: center;
            font-weight: bold;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }

.dropdown {
            position: relative;
            display: inline-block;
            margin: 20px;
        }
        .dropbtn {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 5px;
        }
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            border-radius: 5px;
        }
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        .dropdown:hover .dropbtn {
            background-color: #007bff;
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
    <a class="navbar-brand text-white fw-bold" href="#">
                <img style="border-radius: 80%;" src="assests/logo.jpg" alt="Election Portal Logo" width="40" height="40" class="me-2">
                Election Commission of India <br>
                
            </a>
        <div class="container">
            
            <div style="position: absolute; top: 30px; right: 30px; text-decoration: none; color: white; font-weight: bold;">
                <a href="dashboard.php" class="nav-link d-inline text-white">Home</a>
                <a href="authenticate.php" class="nav-link d-inline text-white">Vote</a>
                <a href="result.php" class="nav-link d-inline text-white">Results</a>
                <a href="#" class="nav-link d-inline text-white">About Us</a>
                <a href="profile.php" class="nav-link d-inline text-white">Profile</a>
            </div>
        </div>
    </nav>
    
<div class="profile-container">
    <h2>Your Profile</h2>
    <hr>

    <img id="profile-preview" src="assests/profile_img.jpg" alt="Profile Picture" class="profile-img">
    
    <p><strong>Name:</strong> <?php echo htmlspecialchars($row['name']); ?></p>
    <p><strong>Voter ID:</strong> <?php echo htmlspecialchars($row['vid']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($row['phno']); ?></p>
    
    <div>
        <button class="btn">Edit Profile</button>
        <a href="index.php" class="btn">Logout</a>
    </div>
</div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <footer style="background-color: #007bff; color: white; text-align: center; padding: 15px; position: relative; bottom: 0; width: 100%; font-size: 16px;">
    © 2024 Election Portal | All Rights Reserved By Team 17 | <a href="#" style="color: yellow; text-decoration: none;">Privacy Policy</a>
</footer>

</body>
</html>












<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #007bff;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 10px;
            font-weight: bold;
        }
     

         .dropdown {
            position: relative;
            display: inline-block;
            margin: 20px;
        }
        .dropbtn {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 5px;
        }
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            border-radius: 5px;
        }
       
        
        .profile-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            background-color: white;
            text-align: center;
        }
        .profile-container h2 {
            color: #007BFF;
        }
        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #007BFF;
        }
        .btn {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        

        
    </style>
</head>
<body>

</body>
</html>
