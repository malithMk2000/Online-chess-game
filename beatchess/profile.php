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
    $sql = "SELECT u.firstname, u.lastname, u.username, u.balance, s.level, s.points, s.wins, s.lost 
        FROM users u
        JOIN skill s ON u.id = s.id
        WHERE u.id = '$user_id'";


    $result = mysqli_query($conn, $sql);

    if ($result) {
        $userData = mysqli_fetch_assoc($result);
        $challengeSql = "SELECT * FROM challenge WHERE id_made = '$user_id'";
        $challengeResult = mysqli_query($conn, $challengeSql);
       
    } else {
        // Query execution error
        die("Error: " . mysqli_error($conn));
    }
    //var_dump($userData);

    mysqli_close($conn);
} else {
    // Redirect to the login page if the user ID is not present in the session
    header("Location: index.html");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>BeatChess.com - Chess(Multiplayer)</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            closeLightbox();
            <?php
            if (isset($_SESSION['login_success']) && $_SESSION['login_success'] === true) {
                // Display an alert if the session variable indicating successful login is set
                echo 'document.getElementById("myModal").style.display = "block";';
                // Unset the session variable to prevent showing the alert again on page refresh
                unset($_SESSION['login_success']);
            }
            ?>
            
            const userId = <?php echo $_SESSION['id']; ?>; // Get the user ID from the session
            const username = '<?php echo $_SESSION['username']; ?>'; // Get the username from the session

            // Connect to the WebSocket server
            const socket = new WebSocket('ws://localhost:3000');

            // WebSocket on open event
            socket.addEventListener('open', (event) => {
                // Send the user information to the server
                const userInfo = {
                    type: 'login',
                    userId: userId,
                    username: username,
                };
                socket.send(JSON.stringify(userInfo));
            });

            document.querySelector('.terms').addEventListener('click', function() {
                window.location.href = 'terms.php?userId=' + userId + '&username=' + encodeURIComponent(username);
            });

            document.querySelector('.later').addEventListener('click', function() {
                window.location.href = 'profile.php';
            });

            // WebSocket on message event
            socket.addEventListener('message', (event) => {
                // Handle messages received from the server
                const message = JSON.parse(event.data);
                console.log('Received message:', message);
                // Add logic to handle different message types
            });

            // WebSocket on close event
            socket.addEventListener('close', (event) => {
                console.log('WebSocket connection closed:', event);
            });

            function animateNumber(element, start, end, duration) {
        let startTime = null;

        function animation(currentTime) {
            if (startTime === null) startTime = currentTime;
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const value = Math.floor(progress * (end - start) + start);
            element.textContent = value;

            if (progress < 1) {
                requestAnimationFrame(animation);
            }
        }

        requestAnimationFrame(animation);
    }

    document.querySelectorAll('.info-circle .inner-circle p .animated-number').forEach((element) => {
        const endValue = parseInt(element.closest('p').dataset.value, 10);
        animateNumber(element, 1, endValue, 4000);
    });
        });
    </script>



    <style>
        /* Base styles */
body {
    font-family: 'Tahoma', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #fff;
}

h1, h2, h3 {
    text-align: center;
}

h1 {
    color: white;
}

h2, h3 {
    color: black;
}

/* Navigation bar */
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
    font-size: 16px;
}

li.brand-name {
    float: left;
    padding: 14px 16px;
    font-size: 24px;
    color: white;
}

li a:hover {
    background-color: darkgray;
}

/* Main container */
#content {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
}

#animation {
    flex: 1;
    padding: 20px 0;
}

/* Buttons */
.action-button {
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    margin: 5px;
    transition: filter 0.3s;
}

.recharge-button {
    background-color: blue;
}

.withdraw-button {
    background-color: red;
}

.action-button:hover {
    filter: brightness(85%);
}

.button-container {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 20px;
}

/* Challenges section */
#challenges {
    width: 90%;
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    text-align: center;
    background: white;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.challenge-info {
    cursor: pointer;
    transition: background-color 0.3s ease;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
}

.challenge-info:hover {
    background-color: #f0f0f0;
    color: darkblue;
}

/* Footer */
footer {
    background-color: darkblue;
    color: white;
    padding: 20px 0;
    width: 100%;
    position: fixed;
    bottom: 0;
    left: 0;
}

.footer-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    padding: 0 20px;
}

.footer-links a {
    color: white;
    text-decoration: none;
    margin: 0 10px;
}

.footer-links a:hover {
    text-decoration: underline;
}

/* Main content adjustment */
#main-container {
    display: flex;
    flex-direction: column;
    padding: 20px;
    margin-bottom: 80px; /* Add space for the footer */
}

/* Info circles */
.info-container {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 40px;
}

.info-circle {
    position: relative;
    width: 120px;
    height: 120px;
    border-radius: 50%;
}

.rotating-elements {
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    animation: animate 0.5s linear infinite;
}

@keyframes animate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.rotating-elements span {
    position: absolute;
    width: 100%;
    height: 100%;
    background: linear-gradient(#33ccff, #ff0066);
    border-radius: 50%;
}

.rotating-elements span:nth-child(1) { filter: blur(5px); }
.rotating-elements span:nth-child(2) { filter: blur(10px); }
.rotating-elements span:nth-child(3) { filter: blur(20px); }
.rotating-elements span:nth-child(4) { filter: blur(55px); }

.inner-circle {
    position: absolute;
    top: 5px;
    right: 5px;
    bottom: 5px;
    left: 5px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background-color: black;
    color: white;
}

.inner-circle span {
    font-size: 14px;
    font-weight: bold;
}

.inner-circle .value {
    font-size: 18px;
    margin-top: 5px;
}

/* Icon container */
.icon-container {
    display: flex;
    gap: 10px;
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
}

.icon-button {
    background: none;
    border: none;
    cursor: pointer;
    transition: transform 0.3s, box-shadow 0.3s;
}

.icon-button img {
    width: 40px;
    height: 40px;
}

.icon-button:hover {
    transform: scale(1.1);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

/* Profile dropdown */
#profile-dropdown {
    display: none;
    position: fixed;
    top: 70px;
    right: 20px;
    width: 200px;
    background-color: black;
    border-radius: 10px;
    color: white;
    text-align: center;
    border: 1px solid white;
    z-index: 1001;
    padding: 20px;
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
    margin: 0 auto 20px;
}

.profile-dropdown-buttons {
    display: flex;
    flex-direction: column;
}

.profile-button {
    background-color: black;
    color: white;
    border: 2px solid white;
    padding: 8px 16px;
    border-radius: 5px;
    cursor: pointer;
    margin: 5px 0;
    transition: background-color 0.3s;
}

.profile-button:hover {
    background-color: #333;
}

/* Background image */
.background-image {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('images/background.jpg') no-repeat center center fixed;
    background-size: cover;
    z-index: -1;
}

/* Name styling */
.name h2 {
    font-weight: bold;
    color: transparent;
    background: url('images/ice.gif') repeat;
    -webkit-background-clip: text;
    background-clip: text;
    background-size: cover;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1002;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: white;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    border-radius: 10px;
    width: 90%;
    max-width: 500px;
    text-align: center;
}

.modal-buttons {
    margin-top: 20px;
    display: flex;
    justify-content: space-between;
}

.modal-button {
    padding: 10px 20px;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.modal-button:not(.later) {
    background-color: blue;
}

.modal-button.later {
    background-color: #f44336;
}

/* Media Queries for Responsiveness */
@media screen and (max-width: 768px) {
    li a {
        font-size: 14px;
        padding: 10px 12px;
    }

    li.brand-name {
        font-size: 20px;
    }

    .info-circle {
        width: 100px;
        height: 100px;
    }

    .inner-circle span {
        font-size: 12px;
    }

    .inner-circle .value {
        font-size: 16px;
    }

    .icon-container {
        top: 10px;
        right: 10px;
    }

    .icon-button img {
        width: 30px;
        height: 30px;
    }

    #profile-dropdown {
        width: 180px;
        right: 10px;
    }

    footer {
        position: fixed; /* Change to static on smaller screens */
    }

    #main-container {
        margin-bottom: 20px; /* Reduce margin on smaller screens */
    }
}

@media screen and (max-width: 480px) {
    #challenges {
        width: 95%;
    }

    .action-button {
        width: 100%;
        margin: 5px 0;
    }

    .info-circle {
        width: 80px;
        height: 80px;
    }

    .inner-circle span {
        font-size: 10px;
    }

    .inner-circle .value {
        font-size: 14px;
    }

    .modal-content {
        width: 95%;
    }

    .modal-buttons {
        flex-direction: column;
    }

    .modal-button {
        margin-top: 10px;
    }
    footer {
        position: fixed;/* Change to static on smaller screens */
    }
    .footer-content {
        flex-direction: column;
        text-align: center;
    }

    .footer-links {
        margin-top: 10px;
    }

    .footer-links a {
        display: block;
        margin: 5px 0;
    }
}

    </style>

<script>
    function deleteChallenge(challengeId) {
        // Confirm the user's intention before deleting
        if (confirm("Are you sure you want to delete this challenge?")) {
            // Send an AJAX request to delete the challenge
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'deleteTable.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Reload the page or update the UI as needed
                    location.reload();
                }
            };
            xhr.send('challenge_id=' + challengeId);
        }
    }

    // Function to open the Lightbox for editing
    function editChallenge(challengeId, currentValue) {
        // Set the default value in the textarea
        document.getElementById('challengeValue').value = currentValue;

        // Show the Lightbox
        document.getElementById('editLightbox').style.display = 'block';

        // Update the submit button to include challengeId
        document.getElementById('submitEdit').onclick = function () {
            submitEdit(challengeId);
        };
    }

    // Function to close the Lightbox
    function closeLightbox() {
        // Hide the Lightbox
        document.getElementById('editLightbox').style.display = 'none';
    }

    // Function to handle the submission of the edited challenge value
    function submitEdit(challengeId) {
        // Get the new challenge value from the textarea
        const newValue = document.getElementById('challengeValue').value;

        // Send an AJAX request to update the challenge value
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'updateChallenge.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Reload the page or update the UI as needed
                location.reload();
            }
        };
        xhr.send('challenge_id=' + challengeId + '&new_value=' + newValue);

        // Close the Lightbox
        closeLightbox();
    }
    function rechargeAccount() {
        const userId = '<?php echo $user_id; ?>';
        const username = '<?php echo $userData['username']; ?>';
        window.location.href = `recharge.php?user_id=${userId}&username=${username}`;
    }

    function withdrawAmount(){
        const userId = '<?php echo $user_id; ?>';
        const username = '<?php echo $userData['username']; ?>';
        window.location.href = `withdraw.php?user_id=${userId}&username=${username}`;
    }

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
    <div class="background-image">
        <ul>
            <li><a href="event.php?user_id=<?php echo $user_id; ?>&username=<?php echo $userData['username']; ?>">Matches</a></li>
            <li><a href="challenge.php?user_id=<?php echo $user_id; ?>&username=<?php echo $userData['username']; ?>">Challenges</a></li>
            <li><a href="profile.php?user_id=<?php echo $user_id; ?>&username=<?php echo $userData['username']; ?>">Profile</a></li>
            <li class="brand-name">BeatChess.com</li>
        </ul>
        <div class="icon-container">
                <a href="event.php?user_id=<?php echo $user_id; ?>&username=<?php echo $userData['username']; ?>" class="icon-button">
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

        <div id="myModal" class="modal">
        <div class="modal-content">
            <p>Please Read Terms & Conditions before you start...</p>
            <div class="modal-buttons">
                <button class="modal-button terms">Terms & Conditions</button>
                <button class="modal-button later">Later</button>
            </div>
        </div>
    </div>


        <div class="name">
            <h2><?php echo strtoupper($userData['firstname'] . ' ' . $userData['lastname']); ?></h2>
        </div>
        <div id="main-container">
            <div id="content">
                <div class="info-container">
                    <div class="info-circle">
                        
                        <div class="rotating-elements">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="inner-circle">
                            <p data-value="<?php echo $userData['balance']; ?>">
                                <span>Balance:</span><br>$<span class="animated-number">1</span>
                            </p>
                        </div>

                        
                    </div>
                    <div class="info-circle">
                        
                        <div class="rotating-elements">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="inner-circle">
                            <p data-value="<?php echo $userData['level']; ?>">
                                <span>Level:</span><br><span class="animated-number">1</span>
                            </p>
                        </div>
                    </div>
                    <div class="info-circle">
                    
                        <div class="rotating-elements">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="inner-circle">
                            <p data-value="<?php echo $userData['points']; ?>">
                                <span>Points:</span><br><span class="animated-number">1</span>
                            </p>
                        </div>
                    </div>
                    <div class="info-circle">
                        <div class="rotating-elements">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="inner-circle">
                            <p data-value="<?php echo $userData['wins']; ?>">
                                <span>Wins:</span><br><span class="animated-number">1</span>
                            </p>
                        </div>
                    </div>
                    <div class="info-circle">
                    
                        <div class="rotating-elements">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="inner-circle">
                            <p data-value="<?php echo $userData['lost']; ?>">
                                <span>Losses:</span><br><span class="animated-number">1</span>
                            </p>
                        </div>

                    </div>
                    
                </div>
                <div class="button-container">
                    <button onclick="rechargeAccount()" class="action-button recharge-button">Recharge Account</button>
                    <button onclick="withdrawAmount()" class="action-button withdraw-button">Withdraw</button>
                </div>
            </div>

        </div>
        <div id = "challenges">
            
                <div class="centered">
                    <h3>Challenges Made by You:</h3>
                </div>
                <?php
                if ($challengeResult && mysqli_num_rows($challengeResult) > 0) {
                    while ($challengeRow = mysqli_fetch_assoc($challengeResult)) {
                        echo "<p class='challenge-info'>";
                        echo "Challenge Value: {$challengeRow['value']} | Status: {$challengeRow['status']}";
                        if ($challengeRow['status'] === 'accepted') {
                            echo " | Accepted by: {$challengeRow['name_accept']}";
                        }
                        elseif ($challengeRow['status'] === 'open') {
                            // Display 'edit' and 'delete' buttons for challenges with 'open' status
                            echo "<button onclick=\"editChallenge({$challengeRow['id']}, '{$challengeRow['value']}')\">Edit</button>";
                            echo " <button onclick=\"deleteChallenge({$challengeRow['id']})\">Delete</button>";
                        }
                        echo "</p>";
                    }
                } else {
                    echo "No challenges made by you.";
                }
                ?>
            
            
                <div id="editLightbox">
                    <div id="editContent">
                        <label for="challengeValue">New Challenge Value ($):</label>
            </br>
                        <input type="text" id="challengeValue" name="challengeValue">
                        <button id="submitEdit">Submit</button>
                        <button onclick="closeLightbox()">Cancel</button>
                    </div>
                </div>
            
        </div>
        <br><br><br>
    </div>
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
</body>


</html>
