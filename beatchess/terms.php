<?php
$userId = $_GET['userId'];
$username = $_GET['username'];

// You can now use $userId and $username as needed
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background-color: #fff;
            margin: 0;
        }
        .navigation {
            list-style-type: none;
            margin: 0;
            padding: 10px;
            overflow: hidden;
            background-color: black;
            border-bottom: 1px solid white;
        }

        .nav_item {
            float: right;
        }

        .nav_item a {
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
        .content {
            width: 100%;
            text-align: left;
            padding: 20px;
        }
        .content ul{
            background: white;
        }
        .instructions {
            list-style-type: disc;
            padding-left: 20px;
        }

        .instructions li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <ul class="navigation">
        <li class="nav_item"><a href="event.php?user_id=<?php echo $user_id; ?>&username=<?php echo $userData['username']; ?>">Matches</a></li>
        <li class="nav_item"><a href="challenge.php?user_id=<?php echo $user_id; ?>&username=<?php echo $userData['username']; ?>">Challenges</a></li>
        <li class="nav_item"><a href="profile.php?user_id=<?php echo $user_id; ?>&username=<?php echo $userData['username']; ?>">Profile</a></li>
        <li class="brand-name">BeatChess.com</li>
    </ul>
    <div class ="content">
        <h2>How to Play</h2>
        <ul class = "instructions">
            <li>before make a challenge check weather your account balance is greater than challenge value</li>
            <li>Unless recharge your account</li>
            <li>If you accept a challenge then also your account balance should be greater than challenge value</li>
            <li>Once you make or accept a challenge relevent challenge value is reduced from your account balance. If you win the challenge both wined and your reduced amount will be add into your account</li>
            <li>15 % of service charge will be charged from every wining amount</li>
            <li>Once you fixed your match with someone then you can chat with him and fix an easy time slot for both of you.</li>
            <li>Once you started game you can't refresh of leave the page untill end of the game. otherwise you will lost.</li>
            <li>Only one chance will be provided. So please play at your best and win.</li>
            <li>Item 4</li>
        </ul>
        <h2>How to withdraw</h2>
    </div>
</body>
</html>