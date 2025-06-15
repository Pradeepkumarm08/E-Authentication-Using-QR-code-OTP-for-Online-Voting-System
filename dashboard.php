<?php
session_start();
include("db.php");

if (!isset($_SESSION['email'])) {
    echo "<script>alert('Please log in first!'); window.location.href='index.php';</script>";
    exit;
}

$email = $_SESSION['email']; 

$query = "SELECT name FROM signup WHERE email='$email'";
$result = mysqli_query($con, $query);
$user_data = mysqli_fetch_assoc($result);
$name = $user_data['name'];
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

    <marquee behavior="scroll" direction="left" class="marquee-text">
            Important News :: Tamil Nadu CM 2026 has Started.... Don't forget to Vote.... One Vote can Change Everything.... Don't Delay!!!!
        </marquee>
        <div class="container mt-4">
        <h2>Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
        <p>Explore the upcoming elections and stay informed.</p>
    </div>    
    <div id="electionCarousel" class="carousel slide mt-4" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#electionCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#electionCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#electionCarousel" data-bs-slide-to="2"></button>
        </div>
        <center>
        <div class="carousel-inner" style=" width : 950px;">
            <div class="carousel-item active">
                <img src="assests/tn-election.jpg" class="d-block w-100" alt="Tamil Nadu Election 2026">
                <div class="carousel-caption d-none d-md-block">
                    
                </div>
            </div>
            <div class="carousel-item">
                <img src="assests/kerala-election.jpg" class="d-block w-100" alt="Kerala Election 2026">
                <div class="carousel-caption d-none d-md-block">
                    
                </div>
            </div>
            <div class="carousel-item">
                <img src="assests/ap-election.jpg" class="d-block w-100" alt="Andhra Pradesh Election 2026">
                <div class="carousel-caption d-none d-md-block">
                
                </div>
            </div>
        </div>
    </center>
        <button class="carousel-control-prev" type="button" data-bs-target="#electionCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#electionCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
    <marquee><h4 style="font-style: italic;">Select Election Via State-wise</h4></marquee>
    <button style="
    background: rgba(255, 0, 0, 0.2);
    
    padding: 15px 30px;
    font-size: 18px;
    border: bold;
    border-radius: 15px;
    cursor: pointer;
    transition: 0.4s ease-in-out;
    backdrop-filter: blur(10px); /* Blur Effect */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    height : 150px;   width : 220px;   margin-left : 20px;  margin-right : 20px;  margin-top :20px;
    margin-bottom : 20px;
"
onmouseover="this.style.background='rgba(0, 123, 255, 0.8)'; this.style.color='white'; this.style.boxShadow='0 5px 15px rgba(0, 123, 255, 0.6)';"
onmouseout="this.style.background='rgba(255,0,0,0.2)'; this.style.color='white'; this.style.boxShadow='0 5px 15px rgba(0, 0, 0, 0.2)';">Tamil Nadu</button> 
<button style="
    background: rgba(255, 0, 0, 0.2);
    color : d70040;
    padding: 15px 30px;
    font-size: 18px;
    border: bold;
    border-radius: 15px;
    cursor: pointer;
    transition: 0.4s ease-in-out;
    backdrop-filter: blur(10px); /* Blur Effect */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    height : 150px;   width : 220px;   margin-left : 20px;  margin-right : 20px;  margin-top :20px;
    margin-bottom : 20px;
"
onmouseover="this.style.background='rgba(0, 123, 255, 0.8)'; this.style.color='white'; this.style.boxShadow='0 5px 15px rgba(0, 123, 255, 0.6)';"
onmouseout="this.style.background='rgba(255,0,0,0.2)'; this.style.color='white'; this.style.boxShadow='0 5px 15px rgba(0, 0, 0, 0.2)';">Tamil Nadu</button> 

  

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <footer style="background-color: #007bff; color: white; text-align: center; padding: 15px; position: relative; bottom: 0; width: 100%; font-size: 16px;">
    © 2024 Election Portal | All Rights Reserved By Team 17 | <a href="#" style="color: yellow; text-decoration: none;">Privacy Policy</a>
</footer>

</body>
</html>
