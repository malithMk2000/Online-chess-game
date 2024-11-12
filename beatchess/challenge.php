<?php
session_start();

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "beatchess";

    $conn = mysqli_connect($servername, $username, $password, $database);
    //echo "User ID: " . $user_id;
   

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch user data from the database (adjust the query based on your database structure)
    $sql = "SELECT u.firstname, u.lastname
        FROM users u
        WHERE u.id = '$user_id'";


    $result = mysqli_query($conn, $sql);

    if ($result) {
        $userData = mysqli_fetch_assoc($result);

       
    } else {
        // Query execution error
        die("Error: " . mysqli_error($conn));
    }
    //var_dump($userData);

    mysqli_close($conn);
}
?>

<script>
    // Function to refresh the content of the 'names' div
    function refreshNames(userId,username) {
        var namesDiv = document.getElementById('challenges');
        
        // Make an AJAX request to fetch updated content
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Update the content of the 'names' div with the response
                namesDiv.innerHTML = xhr.responseText;
            }
        };
        xhr.open('GET', 'refreshNames.php?user_id=' + userId + '&username=' + username, true);
        xhr.send();
    }

// Call refreshNames() every 5 seconds
    setInterval(function() {
        refreshNames(<?php echo $_GET['user_id']; ?>, '<?php echo $_GET['username']; ?>');

    }, 1000);

</script>


<head>
    <title>BeatChess.com - Chess(Multiplayer)</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        /*end nav bar*/
        #content {
            padding: 20px;
            /* Adjust the padding to your preference */
        }

        #chessCanvas {
            margin-left: 40%;
        }

        #user-info {
            top: 120px;
            right: 10px;
            padding: 10px;
            background-color: #ddd;
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

        .icon-container {
            display: flex;
            gap: 10px;
            position: fixed; /* Position the icon container fixed to the right */
            top: 16%; /* Distance from the top of the page */
            right: 20px; /* Distance from the right of the page */
        }

        .icon-button {
            background: none;
            border: none;
            cursor: pointer;
            
        }

        .icon-button img {
            width: 40px;
            height: 40px;
        }
        .icon-button:hover {
            transform: scale(1.1); /* Optional: Adding a slight scale effect on hover */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Optional: Adding a shadow effect on hover */
        }
        #profile-dropdown {
            display: none;
            position: absolute;
            top: 180px; /* Adjust according to your layout */
            right: 30px;
            width: 200px;
            height: 200px;
            background-color: black;
            border-radius: 10px;
            color: white;
            text-align: center;
            line-height: 200px; /* Center the text vertically */
        }

        .profile-initials {
            width: 50px;
            height: 50px;
            background-color: black;
            color: white;
            border: 2px solid white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: bold;
            margin: 10px auto 20px; /* Center and add some bottom margin */
        }
        .profile-dropdown-buttons {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
        }

        .profile-button {
            background-color: black;
            color: white;
            border: none;
            padding: 8px 16px; /* Adjusted padding */
            border-radius: 5px;
            border: 2px solid white;
            cursor: pointer;
            margin:10px;
        }

        .profile-button:hover {
            background-color: lightgray;
        }

        .challenge-display{
            background: #FAF8EF;
            width: 60%;
            margin: 2% 20% 2% 20%;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding-top:10px;
            height: auto;
        }
        
        #challenges {
            display: flex;
            flex-direction: column; /* Display challenges in a column layout */
            gap: 0px;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            height: auto; /* Optional: Adjust the height as needed */
            text-align: center; /* Center text within the element */
            margin: 0; /* Remove any default margin */
            padding: 0;
        }
        #challenges p{
            color: red;
            margin: 0; /* Remove any default margin */
            padding: 0;
        }
        .new-challenge {
            text-align: center;
            border: 1px solid #ccc; /* Optional: Add a border for better visibility */
            padding: 20px;
            border-radius: 10px; /* Rounded corners for the container */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Optional: Add some shadow for depth */
        }

        .new-challenge h2 {
            margin-bottom: 20px;
        }

        .new-challenge form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .new-challenge input[type="number"],
        .new-challenge button {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }

        .new-challenge button {
            background-color: black;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .new-challenge button:hover {
            background-color: darkgray;
        }

        .background-image {
            position: relative;
            width: 100%;
            height: 100%;
            background: url('images/background.jpg') no-repeat center center fixed;
            background-size: cover;
            overflow: hidden;
        }

    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const profileIcon = document.getElementById('profile-icon');
        const profileDropdown = document.getElementById('profile-dropdown');

        const firstName = "<?php echo $userData['firstname']; ?>";
        const lastName = "<?php echo $userData['lastname']; ?>";

        const initials = firstName.charAt(0).toUpperCase() + lastName.charAt(0).toUpperCase();
        document.getElementById('profile-initials').textContent = initials;

        profileIcon.addEventListener('click', function (event) {
            event.stopPropagation();
            if (profileDropdown.style.display === 'none' || profileDropdown.style.display === '') {
                profileDropdown.style.display = 'block';
            } else {
                profileDropdown.style.display = 'none';
            }
        });

        document.addEventListener('click', function (event) {
            if (!profileDropdown.contains(event.target) && event.target !== profileIcon) {
                profileDropdown.style.display = 'none';
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
   
        document.getElementById('logout-button').addEventListener('click', function () {
            window.location.href = 'index.html';
        });
    });
    
    function redirectToEdit(userId) {
        window.location.href = 'editaccount.php?user_id=' + userId;
    }
    </script>
    
</head>

<body>
    
<?php
    $user_id = $_GET['user_id'] ?? '';
    $username = $_GET['username'] ?? '';

?>
<ul>
  <li><a href="event.php?user_id=<?php echo $user_id; ?>&username=<?php echo $username; ?>">Matches</a></li>
  <li><a href="challenge.php?user_id=<?php echo $user_id; ?>&username=<?php echo $username; ?>">Challenges</a></li>
  <li><a href="profile.php?user_id=<?php echo $user_id; ?>&username=<?php echo $username; ?>">Profile</a></li>
  <li class="brand-name">BeatChess.com</li>
</ul>

<div class="icon-container">
            <a href="event.php?user_id=<?php echo $user_id; ?>&username=<?php echo $username; ?>" class="icon-button">
                <img src="images/notification.png" alt="Notification Icon">
            </a>
            <button class="icon-button" id="profile-icon">
                <img src="images/profile.png" alt="Profile Icon">
            </button>
    </div>
    <div id="profile-dropdown">
        <div class="profile-initials" id="profile-initials">AB</div>
        <div class="profile-dropdown-buttons">
            <button class="profile-button" id="edit-button" onclick="redirectToEdit(<?php echo $user_id; ?>)">Edit</button>
            <button class="profile-button" id="logout-button">Log Out</button>
        </div>
            
    </div>

<div class="challenge-display">
<h3>Open Challenges</h3>
<div id = "challenges">
    
    <?php

        include 'data base/config.php';

        // Query to retrieve open challenges
        $sql = "SELECT * FROM challenge WHERE status = 'open' AND id_made != '{$_GET['user_id']}'";
        $result = mysqli_query($conn, $sql);

        // Display open challenges
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<p>";
                echo "Challenge by <a href='player.php?opponentId={$row['id_made']}'>{$row['name_made']}</a> - Value: {$row['value']}";
                //echo " <a href='player.php?opponentId={$opponentId}'>View Profile</a>";
                echo " <form action='accept.php' method='post'>";
                echo " <input type='hidden' name='challengeId' value='{$row['id']}'>";
                echo "<input type='hidden' name='user_id' value='{$_GET['user_id']}'>";
                echo "<input type='hidden' name='username' value='{$_GET['username']}'>";
                echo " <button type='submit'>Accept Challenge</button>";
                echo " </form>";
                echo "</p>";
                
            }
        } else {
            echo "No open challenges.";
        }

        // Close the database connection
        mysqli_close($conn);
    ?>
</div>
</div>
<div class="new-challenge">
    <h2>Create New Challenge</h2>

    <form action="reate_challenge.php" method="post">
        <?php
        // Check if user_id and username are set in the URL
        if (isset($_GET['user_id']) && isset($_GET['username'])) {
            $defaultPlayerName = $_GET['username'];
            // Set the default player name as a hidden input field
            echo "<input type='hidden' name='user_id' value='{$_GET['user_id']}'>";
            echo "<input type='hidden' name='playerName' value='$defaultPlayerName'>";
        }
        ?>
        <label for="challengeValue">Challenge Value ($):</label>
        <input type="number" id="challengeValue" name="challengeValue" required>
        <br>

        <button type="submit">Create Challenge</button>
    </form>
</div>
<br><br><br>
<footer>
    <div class="footer-content">
        <div class="copyright">
            &copy; 2024 NovaCore All rights reserved.
        </div>
        <div class="footer-links">
            <a href="terms.php">Terms & Conditions</a>
            <a href="about.html">About</a>
        </div>
    </div>
</footer>
<script>
    refreshNames(<?php echo $_GET['user_id']; ?>, '<?php echo $_GET['username']; ?>');

</script>

