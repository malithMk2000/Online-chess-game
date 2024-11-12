<?php
session_start();

if (isset($_SESSION['id']) && isset($_POST['challenge_id']) && isset($_POST['new_value'])) {
    $user_id = $_SESSION['id'];
    $challenge_id = $_POST['challenge_id'];
    $new_value = $_POST['new_value'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "beatchess";

    $conn = mysqli_connect($servername, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if the challenge belongs to the current user
    $checkOwnershipSql = "SELECT * FROM challenge WHERE id_made = '$user_id' AND id = '$challenge_id'";
    $checkOwnershipResult = mysqli_query($conn, $checkOwnershipSql);

    if ($checkOwnershipResult && mysqli_num_rows($checkOwnershipResult) > 0) {

        $existingValueSql = "SELECT value FROM challenge WHERE id = '$challenge_id'";
        $existingValueResult = mysqli_query($conn, $existingValueSql);
        $existingValueRow = mysqli_fetch_assoc($existingValueResult);
        $existingValue = $existingValueRow['value'];
        // Update the challenge value
        $updateSql = "UPDATE challenge SET value = '$new_value' WHERE id = '$challenge_id'";
        $updateResult = mysqli_query($conn, $updateSql);

        if ($updateResult) {
            // Retrieve the user's balance
            $getUserBalanceSql = "SELECT balance FROM users WHERE id = '$user_id'";
            $getUserBalanceResult = mysqli_query($conn, $getUserBalanceSql);
            $userBalanceRow = mysqli_fetch_assoc($getUserBalanceResult);
            $userBalance = $userBalanceRow['balance'];

            // Calculate the new balance
            $newBalance = $userBalance + $existingValue - $new_value;

            // Update the user's balance
            $updateUserBalanceSql = "UPDATE users SET balance = '$newBalance' WHERE id = '$user_id'";
            $updateUserBalanceResult = mysqli_query($conn, $updateUserBalanceSql);

            if ($updateUserBalanceResult) {
                echo "success";
            }  else {
            echo "Error updating challenge: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Unauthorized access to the challenge.";
    }

    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>
