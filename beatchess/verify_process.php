<?php
// Start the session to access verification code
session_start();

// Check if verification code is submitted
if (isset($_POST['verification_code'])) {
    // Get the submitted verification code
    $submitted_code = $_POST['verification_code'];
    
    // Get the verification code from the session
    $verification_code = $_SESSION['verification_code'];
    
    // Check if submitted code matches the stored code
    if ($submitted_code === $verification_code) {
        // Verification successful, update user details in the database
        echo "enterd to submit process";
        
        // Connect to your database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "beatchess";

        $conn = mysqli_connect($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Retrieve form data
        $first_name = $_SESSION['first_name'];
        $last_name = $_SESSION['last_name'];
        $country = $_SESSION['country'];
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
        
        // Update user details in the database
        $sql = "INSERT INTO users (firstname, lastname, country, username, pass_word) VALUES ('$first_name', '$last_name', '$country', '$username', '$password')";

        if ($conn->query($sql) === TRUE) {
            $user_id = mysqli_insert_id($conn); 
            echo "User details updated successfully!";
            $sql_skill = "INSERT INTO skill (id, level, points, wins, lost) VALUES ('$user_id', '1', '0', '0', '0')";
            if ($conn->query($sql_skill) === TRUE) {
                echo "Skill details updated successfully!";
                // Redirect to profile.php with userId passed through session
                $_SESSION['id'] = $user_id;
                header("Location: welcome.html");
                exit();
            } else {
                echo "Error updating skill details: " . $conn->error;
            }
        } else {
            echo "Error updating user details: " . $conn->error;
        }
        
        $conn->close();
    } else {
        // Verification code does not match
        echo "Verification code does not match!";
    }
} else {
    // Verification code not submitted
    echo "Verification code is required!";
}
?>
