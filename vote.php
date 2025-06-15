<?php
session_start();
include("db.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['email'];
    $party = $_POST['party'];
    $sql = "SELECT * FROM vote WHERE email = '$email'";
    $result = $con->query($sql);
    if ($result->num_rows == 0) {
        $insert = "INSERT INTO vote (email, party) VALUES ('$email', '$party')";
        if ($con->query($insert) === TRUE) {
            echo "<script>alert('Vote cast successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $con->error . "');</script>";
        }
    } else {
        echo "<script>alert('You have already voted!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vote for Your Party</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            background: white;
            padding: 20px;
            margin: 50px auto;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h2 {
            color: #007bff;
        }
        .party-option {
            display: block;
            padding: 10px;
            border: 1px solid #ccc;
            margin: 10px 0;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }
        .party-option:hover {
            background: #007bff;
            color: white;
        }
        input[type="submit"] {
            background: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }
        input[type="submit"]:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Vote for Your Favorite Party</h2>
        <form method="POST" action="">
            <?php
            $partyQuery = "SELECT * FROM parties";
            $partyResult = $con->query($partyQuery);

            if ($partyResult->num_rows > 0) {
                while ($party = $partyResult->fetch_assoc()) {
                    echo "<label class='party-option'>
                        <input type='radio' name='party' value='".htmlspecialchars($party['party_name'], ENT_QUOTES)."'> "
                        .htmlspecialchars($party['party_name'])."
                    </label>";
                }
            } else {
                echo "<p>No parties available for voting.</p>";
            }
            echo "<label class='party-option'>
                    <input type='radio' name='party' value='NOTA'> VOTE FOR NOTA
                  </label>";
            ?>
            <br>
            <input type="submit" value="Vote">
        </form>
    </div>
</body>
</html>
<?php $con->close(); ?>
