

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - BeatChess.com</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        header {
            background-color: #000;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form label,
        form input,
        form button {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }

        form input,
        form button {
            padding: 10px;
            box-sizing: border-box;
        }

        input[type="submit"]{
            padding: 10px;
            margin-top: 10px;
            margin-left: auto;
            margin-right: auto;
            display: block;
            cursor: pointer;
            background-color: black; /* Changed background color to black */
            color: white; /* Changed font color to white */
            border: none; /* Remove border */
            width: 200px;
            border-radius: 15px;
        }
        input[type="submit"]:hover {
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
        .error-message {
            color: red;
            font-size: 0.9em;
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function checkEmail() {
                var email = $('#username').val();
                if (email.length > 0) {
                    $.ajax({
                        url: 'check_email.php',
                        method: 'POST',
                        data: { email: email },
                        success: function(response) {
                            if (response == 'exists') {
                                $('#email-error').text('Email already been used');
                                $('input[type="submit"]').prop('disabled', true);
                            } else {
                                $('#email-error').text('');
                                $('input[type="submit"]').prop('disabled', false);
                            }
                        }
                    });
                } else {
                    $('#email-error').text('');
                    $('input[type="submit"]').prop('disabled', true);
                }
            }

            $('#username').on('input', checkEmail);

            // Disable the submit button initially
            $('input[type="submit"]').prop('disabled', true);
            
        });
    </script>
</head>

<body>

    <header>
        <h1>BeatChess.com</h1>
    </header>

    <div class="container">
        <h2>Create Account</h2>
        <form method="post" action="verify.php">
            <!-- Personal information fields -->
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name">
            <label for="country">Country</label>
            <input type="text" name="country" id="country">
            <label for="username">Email</label>
            <input type="text" name="username" id="username">
            <div id="email-error" class="error-message"></div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            <input type="submit" name="submit" value="Create Account">
        </form>
    </div>
    </br>
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
