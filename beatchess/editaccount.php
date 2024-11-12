<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "beatchess";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$user_id = $_GET['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $first_name = $row['firstname'];
    $last_name = $row['lastname'];
    $country = $row['country'];
    $username = $row['username'];
    $password = $row['pass_word'];
} else {
    echo "No user found";
}

mysqli_close($conn);
?>


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
            background-color: black; 
            color: white; 
            border: none; 
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
            margin-left: 20px; 
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

    </style>
</head>

<body>

    <header>
        <h1>BeatChess.com</h1>
    </header>

    <div class="container">
        
        
        <h2>Edit Account</h2>
        <form method="post" action="update.php?user_id=<?php echo $user_id; ?>">
            <!-- Personal information fields -->
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" value="<?php echo $last_name; ?>">
            <label for="country">Country</label>
            <input type="text" name="country" id="country" value="<?php echo $country; ?>">
            <label for="username">Email</label>
            <input type="text" name="username" id="username" value="<?php echo $username; ?>">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" id="password" value="<?php echo $password; ?>">
            <input type="submit" name="submit" value="Update Account">
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
