<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdraw</title>

    <style>
        h2,
        h3 {
            text-align: center;
            color: black;
        }

        h1 {
            text-align: center;
            color: white;
        }

        body {
            background-color: #f2f2f2;
            margin: 0;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 10px;
            overflow: hidden;
            background-color: black;
            
        }

        li {
            float: right;
        }

        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        li.brand-name{
            padding: 14px 20px;
            font-size: 45px;
            color: white;
            float: left;
        }

        li a:hover {
        background-color: darkgray;
        }

        #content {
            padding: 20px;
            /* Adjust the padding to your preference */
        }

        #chessCanvas {
            margin-left: 40%;
        }
        #inform {
            margin-left: 20px; /* Adjust as needed */
        }

        #inform p {
            color: darkblue; /* Paragraph color */
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
        }

        #submit-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        #submit-button:hover {
            background-color: #45a049;
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
<ul>
  <li><a href="event.php?user_id=<?php echo $user_id; ?>&username=<?php echo $userData['username']; ?>">Matches</a></li>
  <li><a href="challenge.php?user_id=<?php echo $user_id; ?>&username=<?php echo $userData['username']; ?>">Challenges</a></li>
  <li><a href="profile.php?user_id=<?php echo $user_id; ?>&username=<?php echo $userData['username']; ?>">Profile</a></li>
  <li class="brand-name">BeatChess.com</li>
</ul>
<div id="user-info">
        <?php
        $user_id = $_GET['user_id'] ?? '';
        $username = $_GET['username'] ?? '';
        
        // Print the user ID and username
        echo "User ID: $user_id <br>";
        echo "Username: $username";
        ?>
</div>
<div id="inform">
<h1>Note</h1>
    <p>Withdraw money you should have a PayPal account...</p>
    <form id="withdraw-form">
        <label for="paypal_username">PayPal Username/Email:</label>
        <input type="text" id="paypal_username" name="paypal_username">
        <label for="paypal_payment_link">PayPal Payment Link:</label>
        <input type="text" id="paypal_payment_link" name="paypal_payment_link">
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount">
        <input type="submit" id="submit-button" value="Submit">
    </form>
</div>
<script>
    document.getElementById("withdraw-form").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission

        // Get form values
        var paypalUsername = document.getElementById("paypal_username").value;
        var paypalPaymentLink = document.getElementById("paypal_payment_link").value;
        var amount = parseFloat(document.getElementById("amount").value);

        // Perform validation
        if (isNaN(amount) || amount <= 0) {
            alert("Please enter a valid amount.");
            return;
        }

        // Here, you can perform additional validation, such as checking if the amount is less than the balance
        // However, you need to implement server-side validation as client-side validation can be bypassed

        // AJAX request to submit form data
        const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Handle the response if needed
                    console.log(xhr.responseText);
                }
            };

            // Specify the PHP script URL
            const url = 'updateWithdraw.php';

            // Prepare the data to be sent to the server
            const data = new FormData();
            data.append('user_id', '<?php echo $user_id; ?>');
            data.append('paypal_username', paypalUsername);
            data.append('paypal_payment_link', paypalPaymentLink);
            data.append('amount', amount);

            // Send the POST request to the server
            xhr.open('POST', url, true);
            xhr.send(data);
    });
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