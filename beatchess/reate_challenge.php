<!-- create_challenge.php -->

<?php
// Connect to the database (similar to your existing code)
$servername = "localhost";
$username = "root";
$password = "";
$database = "beatchess";

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve form data
$playerId = mysqli_real_escape_string($conn, $_POST['user_id']);
$playerName = mysqli_real_escape_string($conn, $_POST['playerName']);
$challengeValue = mysqli_real_escape_string($conn, $_POST['challengeValue']);

$sql_balance = "SELECT balance FROM users WHERE id = '$playerId'";
$result_balance = mysqli_query($conn, $sql_balance);
if (!$result_balance) {
    die("Error: " . mysqli_error($conn));
}

$row_balance = mysqli_fetch_assoc($result_balance);
$balance = $row_balance['balance'];

// Check if the balance is sufficient
if ($balance < $challengeValue) {
    echo "Error: Insufficient balance to create challenge!";
    exit;
}

// Insert new challenge into the challenge table
$sql = "INSERT INTO challenge (id_made, name_made, value) VALUES ('$playerId', '$playerName', '$challengeValue')";

if (mysqli_query($conn, $sql)) {
    echo "Challenge created successfully!";

    // Update user's balance after creating the challenge
    $new_balance = $balance - $challengeValue;
    $sql_update_balance = "UPDATE users SET balance = $new_balance WHERE id = '$playerId'";
    if (!mysqli_query($conn, $sql_update_balance)) {
        echo "Error updating balance: " . mysqli_error($conn);
    }
} else {
    echo "Error creating challenge: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
