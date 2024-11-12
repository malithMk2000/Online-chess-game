<?php
session_start();

if (isset($_SESSION['id']) && isset($_POST['challenge_id'])) {
    $user_id = $_SESSION['id'];
    $challenge_id = $_POST['challenge_id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "beatchess";

    $conn = mysqli_connect($servername, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if the challenge belongs to the logged-in user before deleting
    $checkQuery = "SELECT * FROM challenge WHERE id = $challenge_id AND id_made = $user_id";
    $checkResult = mysqli_query($conn, $checkQuery);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {

        $challengeValueQuery = "SELECT value FROM challenge WHERE id = $challenge_id";
        $challengeValueResult = mysqli_query($conn, $challengeValueQuery);
        $challengeValueRow = mysqli_fetch_assoc($challengeValueResult);
        $challengeValue = $challengeValueRow['value'];
        // Delete the challenge
        $deleteQuery = "DELETE FROM challenge WHERE id = $challenge_id";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if ($deleteResult) {
            // Update the user's balance
            $updateBalanceQuery = "UPDATE users SET balance = balance + $challengeValue WHERE id = $user_id";
            $updateBalanceResult = mysqli_query($conn, $updateBalanceQuery);
            
            if ($updateBalanceResult) {
                echo "Challenge deleted successfully and balance updated";
            } else {
                echo "Error updating balance: " . mysqli_error($conn);
            }
        } else {
            echo "Error deleting challenge: " . mysqli_error($conn);
        }
    } else {
        echo "Unauthorized access or challenge not found";
    }

    mysqli_close($conn);
} else {
    echo "Invalid request";
}
?>
