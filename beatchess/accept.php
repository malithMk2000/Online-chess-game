<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "beatchess";

// Connect to the database
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle accepting challenge
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['challengeId'])) {
        $challengeId = $_POST['challengeId'];

        // Get the user_id and username of the player accepting the challenge
        // (You might need to adjust this based on how you're managing user sessions)
        $userIdAccept = $_POST['user_id'];
        $usernameAccept = $_POST['username'];
        //echo "Username Accept: " . $usernameAccept;

        // Update the challenge record with the accepting player's information
        $balanceCheckSql = "SELECT balance FROM users WHERE id = '$userIdAccept'";
        $balanceResult = mysqli_query($conn, $balanceCheckSql);
        if ($balanceResult) {
            $balanceRow = mysqli_fetch_assoc($balanceResult);
            $userBalance = $balanceRow['balance'];
            // Query challenge table to get challenge value
            $challengeValueSql = "SELECT value FROM challenge WHERE id = '$challengeId'";
            $challengeValueResult = mysqli_query($conn, $challengeValueSql);
            if ($challengeValueResult) {
                $challengeValueRow = mysqli_fetch_assoc($challengeValueResult);
                $challengeValue = $challengeValueRow['value'];
                // Check if user has sufficient balance
                if ($userBalance >= $challengeValue) {
                    // Update the challenge record with the accepting player's information
                    $updateSql = "UPDATE challenge SET id_accept = '$userIdAccept', name_accept = '$usernameAccept', status = 'accepted' WHERE id = '$challengeId'";
                    if (mysqli_query($conn, $updateSql)) {
                        echo "Challenge accepted successfully!";
                        // Deduct challenge value from user's balance
                        $newBalance = $userBalance - $challengeValue;
                        $updateBalanceSql = "UPDATE users SET balance = '$newBalance' WHERE id = '$userIdAccept'";
                        mysqli_query($conn, $updateBalanceSql);
                    } else {
                        echo "Error accepting challenge: " . mysqli_error($conn);
                    }
                } else {
                    echo "Insufficient balance!";
                }
            } else {
                echo "Error fetching challenge value: " . mysqli_error($conn);
            }
        } else {
            echo "Error fetching user balance: " . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>
