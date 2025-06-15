<?php
  include("db.php");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}


if (isset($_POST['add_party'])) {
    $party_name = $_POST['party_name'];
    $symbol = $_POST['symbol']; 

    if (!empty($party_name)) {
        $stmt = $con->prepare("INSERT INTO parties (party_name, symbol) VALUES (?, ?)");
        $stmt->bind_param("ss", $party_name, $symbol);
        $stmt->execute();
        $stmt->close();
    }
}

if (isset($_POST['delete_party'])) {
    $party_id = $_POST['party_id'];
    $stmt = $con->prepare("DELETE FROM parties WHERE id = ?");
    $stmt->bind_param("i", $party_id);
    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manage Parties</title>
    <style>
        body {
            font-family: Arial;
            background: #f0f0f0;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        form {
            background: #fff;
            padding: 15px;
            margin-bottom: 30px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        input, button {
            padding: 10px;
            margin: 5px;
            width: 90%;
        }
        table {
            width: 100%;
            background: #fff;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }
    </style>
</head>
<body>

<h2>Admin Panel - Add Party</h2>
<form method="POST">
    <input type="text" name="party_name" placeholder="Enter Party Name" required>
    <input type="text" name="symbol" placeholder="Enter Party Symbol or Image Path (optional)">
    <button type="submit" name="add_party">Add Party</button>
</form>

<h2>Current Parties</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Party Name</th>
        <th>Symbol</th>
        <th>Action</th>
    </tr>
    <?php
    $result = $con->query("SELECT * FROM parties");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['party_name']}</td>
            <td>{$row['symbol']}</td>
            <td>
                <form method='POST' style='display:inline;'>
                    <input type='hidden' name='party_id' value='{$row['id']}'>
                    <button type='submit' name='delete_party'>Delete</button>
                </form>
            </td>
        </tr>";
    }
    ?>
</table>

</body>
</html>
