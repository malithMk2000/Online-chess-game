<?php
session_start();

// Check if the user is authenticated
if(isset($_SESSION['username']) && isset($_SESSION['id'])) {
    $username = $_SESSION['username'];
    $userId = $_SESSION['id'];

    $opponentId = isset($_GET['opponentId']) ? $_GET['opponentId'] : '';
    $challengeId = isset($_GET['challengeId']) ? $_GET['challengeId'] : '';
    // You can pass this information to your JavaScript
    echo '<script>';
    echo 'var username = "' . $username . '";';
    echo 'var userId = "' . $userId . '";';
    echo 'var opponentId = "' . $opponentId . '";';
    echo 'var challengeId = "' . $challengeId . '";';
    echo '</script>';
    // Use $_SESSION['username'] and $_SESSION['id'] as needed
} else {
    // Redirect to login page if not authenticated
    header("Location: index.php");
    exit();
}
?>
<?php
//echo "This is file 1.<br>";

// Include file2.php
include 'web socket server/script.php';
?>



<head>
    <title>BeatChess.com - Chess(Multiplayer)</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        h2, h3 {
            text-align: center;
            color: black;
        }
        h1{
            text-align: center;
            color: white;
        }

        body {
            background: url('images/board.jpeg') center/cover fixed;
            background-color: #f2f2f2;
            margin: 0;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 10px;
            overflow: hidden;
            background-color: black;
            border-bottom: 1px solid white;
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
            padding: 20px; /* Adjust the padding to your preference */
        }

        #chessCanvas {
            margin-left: 40%;
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
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            console.log('Username:', username);
            console.log('UserID:', userId);

            const urlParams = new URLSearchParams(window.location.search);
            const opponentId = urlParams.get('opponentId');
            const challengeId = urlParams.get('challengeId');
            // Now you can use opponentId as needed in your JavaScript code
            console.log('Opponent ID:', opponentId);
            console.log('Challenege Id: ', challengeId);
            
            
        });
    </script>

    
</head>

<body>
    <ul>
        <li><a href="event.php?user_id=<?php echo $user_id; ?>&username=<?php echo $userData['username']; ?>">Matches</a></li>
        <li><a href="challenge.php?user_id=<?php echo $user_id; ?>&username=<?php echo $userData['username']; ?>">Challenges</a></li>
        <li><a href="profile.php?user_id=<?php echo $user_id; ?>&username=<?php echo $userData['username']; ?>">Profile</a></li>
        <li class="brand-name">BeatChess.com</li>
    </ul>
    <div id="content">
        <div style="float: left;">
            <h2 id="currentTeamText"></h2>
            <h2>White pieces lost:</h2>
            <h3 id="whiteCasualities"></h3>
            <h2>Black pieces lost:</h2>
            <h3 id="blackCasualities"></h3>
            <h2 id="totalVictories"></h2>
        </div>
        <div style="float: left;">
            <canvas id="chessCanvas" width="400" height="400"></canvas>
        </div>
    </div>
    <br><br><br><br><br><br>
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
