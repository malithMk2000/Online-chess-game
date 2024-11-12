<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


$servername = "localhost";
$username = "root";
$password = "";
$database = "beatchess";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_begin_transaction($conn);  // Start a transaction

$first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
$last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
$country = mysqli_real_escape_string($conn, $_POST['country']);
$Username = mysqli_real_escape_string($conn, $_POST['username']);
$Password = mysqli_real_escape_string($conn, $_POST['password']);

// First query
$sql = "INSERT INTO users(firstname, lastname, country, username, pass_word) VALUES ('$first_name', '$last_name', '$country', '$Username', '$Password')";

if (mysqli_query($conn, $sql)) {
    // Second query (assuming a user_id is generated for the new user)
    $user_id = mysqli_insert_id($conn);
    //echo "User ID: $user_id";
    $level = 1;
    $points = 0;
    $wins = 0;
    $lost = 0;

    $sql_skill = "INSERT INTO skill(id, level, points, wins, lost) VALUES ('$user_id', '$level', '$points', '$wins', '$lost')";

    if (mysqli_query($conn, $sql_skill)) {
        mysqli_commit($conn);  // Commit the transaction if both queries succeed
        //echo "Successfully added";
    } else {
        mysqli_rollback($conn);  // Rollback the transaction if the second query fails
        echo "Error adding skill data: " . mysqli_error($conn);
    }
} else {
    echo "Error adding user data: " . mysqli_error($conn);
}

mysqli_close($conn);

?>