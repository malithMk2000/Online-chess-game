<?php
// recharge.php
include 'config.php'; // Include the database configuration file

$userId = $_GET['userId']; // Get the userId from the URL

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $referenceId = $_POST['referenceId'];

    // Prepare and execute the insert query
    $stmt = $pdo->prepare("INSERT INTO recharge (userId, referenceId) VALUES (:userId, :referenceId)");
    $stmt->execute(['userId' => $userId, 'referenceId' => $referenceId]);

    // Redirect or display a success message as needed
    echo "<script>alert('Reference ID submitted successfully!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recharge - BeatChess.com</title>
    <style>
        /* Your existing CSS styles go here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }
        header {
            background-color: #000;
            color: #fff;
            padding: 10px;
            text-align: center;
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
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .email-container {
            text-align: center; /* Center text */
            margin: 20px 0; /* Margin around the email container */
            display: flex; /* Use flexbox for layout */
            justify-content: center; /* Center items horizontally */
            align-items: center; /* Center vertically */
        }
        #email {
            margin-right: 5px; /* Reduce margin to the right of the email */
        }
        button {
            padding: 8px 10px; /* Slightly smaller padding for the button */
            margin-left: 0; /* Remove left margin */
            cursor: pointer;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
        }
        input[type="text"], input[type="submit"] {
            padding: 10px;
            margin: 10px 0;
            width: 200px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        #copy-message {
            color: darkblue;
            display: none; /* Initially hidden */
            margin-top: 10px;
            text-align: center; /* Center the message */
        }
        h2{
            text-align: center;
        }

        .consideration-container {
            text-align: center; /* Center the text */
            margin-top: 15px; /* Add some space above this section */
        }

        .consideration-container h3 {
            color: red; /* Red color for the heading */
            margin-bottom: 5px; /* Space between heading and paragraph */
        }

        .consideration-container p {
            color: black; /* Black color for the paragraph */
            margin: 0; /* No extra margin */
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   
    <script>
        $(document).ready(function() {
            $('#copy-button').on('click', function() {
                const email = $('#email').text(); // Get the email text
                navigator.clipboard.writeText(email) // Copy to clipboard
                    .then(function() {
                        $('#copy-message').text('Email copied successfully').show(); // Show success message
                        setTimeout(function() {
                            $('#copy-message').fadeOut(); // Hide message after 5 seconds
                        }, 5000);
                    })
                    .catch(function(err) {
                        console.error('Could not copy text: ', err);
                    });
            });
        });
    </script>
</head>
<body>

<header>
    <h1>BeatChess.com</h1>
</header>

<div class="container">
    <h2>Recharge Your Account</h2>
    
    <!-- Random unordered list -->
    <ul>
        <li>Please Send your recharge amount into given Skrill account.</li>
        <li>Then enter transaction ID into below and submit.</li>
        <li>Our agent will validate transaction and credited amount into your beatchess account.</li>
    </ul>

    <div class="email-container">
        <div id="email">beatchess8@gmail.com</div>
        <button id="copy-button">Copy Email</button>
    </div>
    <div id="copy-message"></div>

    <form method="post" action="">
        <input type="text" name="referenceId" placeholder="Submit Reference ID" required>
        <input type="submit" value="Submit Reference ID">
    </form>

    <div class="consideration-container">
        <h3>To be Considered</h3>
        <p>Sometimes crediting amount can take a few minutes due to busy working. So We appritiate your patient.</p>
    </div>
</div>

<footer>
    <div class="footer-content">
        <div class="copyright">
            &copy; 2024 CODEZEN All rights reserved.
        </div>
        <div class="footer-links">
            <a href="terms.php">Terms & Conditions</a>
            <a href="about.html">About</a>
        </div>
    </div>
</footer>

</body>
</html>
