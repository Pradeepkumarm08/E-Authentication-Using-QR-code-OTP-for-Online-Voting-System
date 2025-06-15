<?php
session_start();
include("db.php");

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $mail = $_POST['email'];
    $password = $_POST['password'];
    if($password =="admin" && $mail =="admin@gmail.com"){
        header("location: admin.php");
    }
    if (!empty($mail) && !empty($password) && !is_numeric($mail)) {
        $query = "SELECT * FROM signup WHERE email='$mail' LIMIT 1";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);

            if ($user_data['pass'] == $password) {
                $_SESSION['email'] = $mail; 
                $_SESSION['login_attempts'] = 0; 
                header("location: dashboard.php");
                exit;
            }
        }

        $_SESSION['login_attempts']++;

        if ($_SESSION['login_attempts'] % 3 == 0) {
            echo "<script>window.onload = function() { captureAndSend('$mail'); }</script>";
            unset($_SESSION['login_attempts']);
        }

        echo "<script>alert('Wrong Username or Password');</script>";
    } else {
        echo "<script>alert('Wrong Username or Password');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="login-form">
        <div class="container">
            <div class="main">
                <div class="content">
                    <h2>Login Here</h2>
                    <form id="loginForm" action="index.php" method="POST">
                        <input type="email" name="email" id="email" placeholder="Enter your Registered E-mail" required>
                        <input type="password" name="password" id="password" placeholder="Enter your Password" required>
                        <button class="btn" type="submit">Submit</button>
                    </form>
                    <p class="account">Don't Have An Account? <a href="demo.php">Register</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js" defer></script>
</body>
</html>
