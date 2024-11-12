<?php
session_start();

if (isset($_POST['id'])) {
    $user_id = $_POST['id'];

    // Retrieve transaction value from the POST request
    $transaction_value = $_POST['transaction_value'] ?? 0;

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "beatchess";

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve existing balance from the database
    $sql = "SELECT balance FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $existing_balance = $row['balance'];

    // Calculate new balance
    $new_balance = $existing_balance + $transaction_value;

    // Update balance in the database
    $update_sql = "UPDATE users SET balance = $new_balance WHERE id = '$user_id'";
    if (mysqli_query($conn, $update_sql)) {
        echo "Balance updated successfully";
    } else {
        echo "Error updating balance: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "User ID not found in session";
}
?>
