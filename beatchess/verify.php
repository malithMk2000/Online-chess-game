<?php
// Start the session to access user_id
session_start();

// Check if user is logged in and user_id is set
if (isset($_POST['submit'])) {
    //echo "Account created successfully!";
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $country = $_POST['country'];
    $username = $_POST['username'];
    $password = $_POST['password'];
}

// Function to generate random verification code
function generateVerificationCode() {
    $length = 6; // Length of the verification code
    $characters = '0123456789'; // Characters to be used in the code
    $code = '';

    // Generate random code
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $code;
}

// Function to send verification code to email
function sendVerificationCode($email, $code) {
    //console.log('enter to mail' + $email);
    require 'mail.php';
    sendVerificationEmail($email, $code);
    
}

// Generate random verification code for the user
//echo "before function! $username";
$verification_code = generateVerificationCode();
//echo "verification code  $verification_code";
sendVerificationCode($username, $verification_code);

// Store the verification code in the session
$_SESSION['verification_code'] = $verification_code;
$_SESSION['first_name'] = $first_name;
$_SESSION['last_name'] = $last_name;
$_SESSION['country'] = $country;
$_SESSION['username'] = $username;
$_SESSION['password'] = $password;


// Function to format time in minutes and seconds
function formatTime($seconds) {
    $minutes = floor($seconds / 60);
    $remaining_seconds = $seconds % 60;
    return sprintf("%02d:%02d", $minutes, $remaining_seconds);
}

// Calculate expiration time (2 minutes from now)
$expiration_time = time() + 2 * 60;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Account</title>
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
            margin-top:30px;
            margin-left:30px;
            margin-right:30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
        }
        p {
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 20px;
            width: 100%;
        }
        input[type="text"] {
            padding: 10px;
            margin: 10px 0;
            width: 300px;
            box-sizing: border-box;
            border-radius:5px;
        }
        button {
            background-color: black;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: darkgray;
        }
        .message {
            color: darkblue;
            margin-top: 20px;
            visibility: hidden;
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
    <h1>Verify Account</h1>
    <p>Enter the verification code sent to your email:</p>

    <div id="timer"></div>

    <form action="verify_process.php" method="post">
        <input type="text" name="verification_code" placeholder="Enter verification code" required>
        <button id="resendBtn" onclick="resendCode()" disabled>Resend</button>
    </form>
    <button type="submit">Submit</button>
    
    <div id="message" class="message"><?php echo isset($_SESSION['mail_status']) ? $_SESSION['mail_status'] : ''; ?></div>
    </div>

    <script>
        // Function to update timer
        function updateTimer() {
            var now = new Date().getTime();
            var expirationTime = <?php echo $expiration_time * 1000; ?>; // Expiration time in milliseconds
            var distance = expirationTime - now;

            if (distance > 0) {
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the timer
                document.getElementById("timer").innerHTML = "Time remaining: " + minutes + "m " + seconds + "s ";

                // Enable or disable the resend button based on the remaining time
                var resendBtn = document.getElementById("resendBtn");
                if (distance > 120000) { // If time remaining is greater than 2 minutes (120,000 milliseconds)
                    resendBtn.disabled = true; // Disable the button
                } else {
                    resendBtn.disabled = false; // Enable the button
                }

                // Update the timer every second
                setTimeout(updateTimer, 1000);
            } else {
                // Timer has expired, stop the timer and enable the resend button
                document.getElementById("timer").innerHTML = "Time remaining: 0m 0s";
                var resendBtn = document.getElementById("resendBtn");
                resendBtn.disabled = false; // Enable the button
            }
        }


        // Start the timer
        updateTimer();

        // Function to resend verification code
        function resendCode() {
            var now = new Date().getTime();
            var expirationTime = <?php echo $expiration_time * 1000; ?>; // Expiration time in milliseconds

            if (now < expirationTime) {
                // Timer has not expired, do not allow resend
                alert("Please wait until the timer reaches 0 to resend the verification code.");
            } else {
                // Timer has expired, allow resend
                // Code to resend verification code
                // You can implement this functionality using AJAX to resend the code without refreshing the page
                // For example:
                // var xhr = new XMLHttpRequest();
                // xhr.open("GET", "resend_verification_code.php", true);
                // xhr.send();
                // Then handle the response accordingly
                alert("Resending verification code...");
            }
            // Code to resend verification code
            // You can implement this functionality using AJAX to resend the code without refreshing the page
            // For example:
            // var xhr = new XMLHttpRequest();
            // xhr.open("GET", "resend_verification_code.php", true);
            // xhr.send();
            // Then handle the response accordingly
            //console.log('hi');
        }
        function showMessage() {
            var messageElement = document.getElementById("message");
            messageElement.style.visibility = "visible";
            setTimeout(function() {
                messageElement.style.visibility = "hidden";
            }, 10000);
        }

        // Show the message immediately
        showMessage();

        // Set interval to update the timer display every second
        setInterval(updateTimer, 1000);
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
