<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "beatchess";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve data from the AJAX request
$challengeId = $_POST['challengeId'];
$senderId = $_POST['senderId'];
$receiverId = $_POST['receiverId'];
$content = $_POST['content'];

// Insert the message into the messages table
$sql = "INSERT INTO messages (chatId, senderId, receiverId, content) VALUES ($challengeId, $senderId, $receiverId, '$content')";
if (mysqli_query($conn, $sql)) {
    echo "Message added successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
