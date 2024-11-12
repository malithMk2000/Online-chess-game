<?php
// Establish a database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "beatchess";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the challengeId from the POST data
$challengeId = $_POST['challengeId'];

// Update the winner_id column in the challenge table
$sql = "UPDATE challenge SET winner_id = 20 WHERE id = $challengeId";
error_log("SQL Query: $sql");
if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

// Close connection
$conn->close();
?>
