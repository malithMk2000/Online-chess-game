<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['submit'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "beatchess";

    // Establish a database connection
    $conn = mysqli_connect($servername, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Sanitize user input
    $userInput = mysqli_real_escape_string($conn, $_POST['Username']);
    $passInput = mysqli_real_escape_string($conn, $_POST['Password']);

    // SQL query to check if the user exists
    $sql = "SELECT * FROM users WHERE username = '$userInput' AND pass_word = '$passInput'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if ($row = mysqli_fetch_assoc($result)) {
            // Login successful, set session variables
            $_SESSION['username'] = $row['username'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['login_success'] = true;

            // Check if the logged-in user is an admin
            $adminEmails = ['muthumalith@gmail.com', 'codezen8@gmail.com'];

            if (in_array($row['username'], $adminEmails)) {
                // Redirect to the admin panel if the user is an admin
                header("Location: adminpanal.php");
            } else {
                // Redirect to the user welcome page if not an admin
                header("Location: welcome.html");
            }
            exit();
        } else {
            // No matching user found
            echo "Invalid username or password.";
        }
    } else {
        // Query execution error
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
