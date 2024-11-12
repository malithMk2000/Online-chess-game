<?php
// Connect to your database
$servername = "localhost";
$username = "root";
$password = "";
$database = "beatchess";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve form data and sanitize inputs
$first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
$last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
$country = mysqli_real_escape_string($conn, $_POST['country']);
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Update user data in the database
$user_id = $_GET['user_id'];
$sql = "UPDATE users SET firstname='$first_name', lastname='$last_name', country='$country', username='$username', pass_word='$password' WHERE id='$user_id'";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Record updated successfully');</script>";
    // Redirect to profile.php after a short delay
    echo "<script>setTimeout(function() { window.location.href = 'profile.php'; }, 2000);</script>";
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
