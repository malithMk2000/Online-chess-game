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

// Fetch messages for the specified chat
$sql = "SELECT senderId, content FROM messages WHERE chatId = $challengeId";
$result = mysqli_query($conn, $sql);

$messages = array();

while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = array(
        'sender' => $row['senderId'],
        'content' => $row['content']
    );
}

// Send the JSON response
echo json_encode($messages);

mysqli_close($conn);
?>
