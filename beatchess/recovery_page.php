<?php
session_start(); // Start the session

// Include the main PHPMailer class file
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = "";
// Function to send OTP to email
function sendVerificationEmail($email, $code) {
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    // Enable debugging
    $mail->SMTPDebug = 0;

    // Set up SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'muthumalith@gmail.com';
    $mail->Password = ''; 
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    // Set up sender and recipient
    $mail->setFrom('muthumalith@gmail.com', 'BeatChess.com'); 
    $mail->addAddress($email);

    // Set email subject and body
    $mail->Subject = 'Password Recovery OTP';
    $mail->Body    = "Your OTP for password recovery is: $code";

    // Send the email
    try {
        $mail->send();
        $_SESSION['otp'] = $code; // Store the OTP in session
        $GLOBALS['message'] = "An OTP has been sent to your email.";
    } catch (Exception $e) {
        $GLOBALS['message'] = "Failed to send OTP. Please try again later.";
    }
}

// Function to update password in the database
function updatePassword($email, $password) {
    // Replace this with your database connection code
    // Assuming you are using PDO for database operations
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=beatchess', 'root', '0703484972Mk#');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update password in the database
        $stmt = $pdo->prepare("UPDATE users SET pass_word = :password WHERE username = :email");
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $GLOBALS['message'] = "Password updated successfully.";
    } catch (PDOException $e) {
        $GLOBALS['message'] = "Failed to update password: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['send_otp'])) {
        // Generate a random OTP (One Time Password)
        $otp = mt_rand(100000, 999999);

        // Get the email address from the form
        $email = $_POST['email'];

        // Send the OTP to the email address
        sendVerificationEmail($email, $otp);
    } elseif (isset($_POST['submit'])) {
        // Check if OTP matches
        $enteredOTP = $_POST['otp']; // OTP entered by the user
        $storedOTP = $_SESSION['otp']; // OTP sent to the user's email

        if ($enteredOTP == $storedOTP) {
            // OTP matched, update the password
            $email = $_POST['email'];
            $newPassword = $_POST['new_password'];
            updatePassword($email, $newPassword);
        } else {
            $GLOBALS['message'] = "OTP does not match. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Recovery</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }
        .header {
            background-color: black;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: flex;
            flex-direction: column; /* Stack children vertically */
            align-items: center; /* Center children horizontally */
            justify-content: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        form {
            width: 100%; /* Take up full width */
            max-width: 300px; /* Limit width to prevent stretching */
            display: flex;
            flex-direction: column; /* Stack children vertically */
        }

        form div {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column; /* Stack children vertically */
        }
        .message {
            color: darkblue;
        }
        

        label {
            margin-bottom: 5px;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border-radius: 5px;
            border: 1px solid #ccc;
            width:300px;
        }

        button {
            margin-top: 10px; /* Add some space between input and button */
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border-radius: 5px;
            border: none;
            background-color: black;
            color: white;
            cursor: pointer;
            width: auto;
            padding: 10px 20px;
        }
        button:hover {
            background-color: darkgray;
        }
        footer {
            background-color: darkblue;
            color: white;
            padding: 20px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            margin-left: 20px; /* Adjust spacing between links */
        }

        .footer-links a:hover {
            text-decoration: underline;
        }
        
    </style>
</head>
<body>
    <div class="header">
        <h1>BeatChess.com</h1>
    </div>
    <div class="container">
    <h2>Password Recovery</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>
        </div>
        <div>
            <label for="otp">OTP:</label>
            <input type="text" id="otp" name="otp">
        </div>
        <div>
            <button type="submit" name="send_otp">Send OTP</button>
        </div>
        <div>
            <button type="submit" name="submit">Submit</button>
        </div>
    </form>
    <?php if (!empty($message)): ?>
                <p class="message" id="message"><?php echo $message; ?></p>
    <?php endif; ?>
    </div>
    <script>
        // Preserve the values of email and new_password fields on form submission
        window.onload = function() {
            document.getElementById('email').value = '<?php echo isset($_POST["email"]) ? $_POST["email"] : "" ?>';
            document.getElementById('new_password').value = '<?php echo isset($_POST["new_password"]) ? $_POST["new_password"] : "" ?>';
        };
    </script>

<footer>
    <div class="footer-content">
        <div class="copyright">
            &copy; 2024 BeatChess.com All rights reserved.
        </div>
        <div class="footer-links">
            <a href="#">Terms & Conditions</a>
            <a href="#">About</a>
        </div>
    </div>
    </footer>
</body>
</html>
