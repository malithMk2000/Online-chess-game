<?php
// Include the main PHPMailer class file
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to send verification email with recovery link
function sendVerificationEmail($email, $recoveryLink) {
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
    $mail->Subject = 'Password Recovery';
    $mail->Body    = "Click the following link to recover your password: $recoveryLink";

    // Send the email
    try {
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Process the form submission
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the email input
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    
    // Generate a recovery link (replace example.com with your actual recovery page URL)
    $recoveryLink = "http://localhost/chess/recovery_page.php";
    
    // Send the recovery email
    if (sendVerificationEmail($email, $recoveryLink)) {
        $message = 'Recovery email has been sent to your Mail.';
    } else {
        $message = 'Recovery email could not be sent. Mailer Error.';
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
        .content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            text-align: center;
        }
        .message {
            color: darkblue;
        }
        input[type="submit"] {
            background-color: black;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: darkgray;
        }
        label {
            color: darkblue;
            font-weight: bold;
        }
        input[type="email"] {
            width: 300px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
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
    <div class="content">
        <div class="container">
            <h2>Enter your email to recover your password:</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" required><br><br>
                <input type="submit" value="Send Link">
            </form>
            <?php if (!empty($message)): ?>
                <p class="message" id="message"><?php echo $message; ?></p>
            <?php endif; ?>
        </div>
    </div>
    <script>
        // Function to hide the message after 10 seconds
        window.onload = function() {
            setTimeout(function() {
                var message = document.getElementById('message');
                if (message) {
                    message.style.display = 'none';
                }
            }, 10000); // 10000 milliseconds = 10 seconds
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
