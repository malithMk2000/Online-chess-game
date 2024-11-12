<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "beatchess";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve form data
$user_id = $_POST['user_id'] ?? '';
$paypal_username = $_POST['paypal_username'] ?? '';
$paypal_payment_link = $_POST['paypal_payment_link'] ?? '';
$amount = $_POST['amount'] ?? 0;

// Perform validation
if (empty($paypal_username) || empty($paypal_payment_link) || $amount <= 0) {
    echo "Error: Invalid data provided.";
    exit;
}

// Check if the amount is less than or equal to the balance in the users table
$sql_balance = "SELECT balance FROM users WHERE id = '$user_id'";
$result_balance = mysqli_query($conn, $sql_balance);
if (!$result_balance) {
    echo "Error: " . mysqli_error($conn);
    exit;
}

$row_balance = mysqli_fetch_assoc($result_balance);
$balance = $row_balance['balance'];

if ($amount > $balance) {
    echo "Error: Insufficient balance.";
    exit;
}
try {
    // Update withdraw table
    $sql_withdraw = "INSERT INTO withdraw (user_id, paypal_username, paypal_payment_link, amount) VALUES ('$user_id', '$paypal_username', '$paypal_payment_link', '$amount')";
    if (!mysqli_query($conn, $sql_withdraw)) {
        throw new Exception("Error: " . mysqli_error($conn));
    }

    // Deduct withdrawn amount from the balance in the users table
    $new_balance = $balance - $amount;
    $sql_update_balance = "UPDATE users SET balance = $new_balance WHERE id = '$user_id'";
    if (!mysqli_query($conn, $sql_update_balance)) {
        throw new Exception("Error: " . mysqli_error($conn));
    }

    // Commit the transaction
    mysqli_commit($conn);

    echo "Withdraw request submitted successfully.";
} catch (Exception $e) {
    // Rollback the transaction if an error occurred
    mysqli_rollback($conn);
    echo $e->getMessage();
}

mysqli_close($conn);
?>
