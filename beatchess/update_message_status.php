<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "beatchess";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$challengeId = $_POST['challengeId'];
$userId = $_POST['userId'];

$sql = "UPDATE messages 
        SET status = 'read' 
        WHERE chatId = ? 
          AND receiverId = ? 
          AND status = 'unread'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $challengeId, $userId);
$result = $stmt->execute();

if ($result) {
    echo "Message status updated successfully";
} else {
    echo "Error updating message status: " . $conn->error;
}

$stmt->close();
$conn->close();
?>