<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
require 'config.php'; // Ensure the path is correct

// Fetch user balance using PDO
$user_id = 7; // Replace with dynamic user ID if needed
$query = "SELECT balance FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $user_id]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$balance = $row ? $row['balance'] : "N/A"; // Handle missing balance
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #000;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        .balance-box {
            background-color: #003366;
            width: 200px;
            height: 200px;
            margin: 20px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <header>
        <h1>BeatChess.com</h1>
    </header>

    <div class="container">
        <h1>Admin Panel</h1>

        <div class="balance-box">
            <?php echo "Balance: $" . htmlspecialchars($balance); ?>
        </div>

    </div>

</body>
</html>
