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



<head>
    <title>BeatChess.com - Chess(Multiplayer)</title>
    <meta charset="UTF-8">
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
        /*end nav bar*/

        #content {
            background: #FAF8EF;
            width: 60%;
            margin: 2% 20% 2% 20%;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding-top:10px;
            padding-left:30px;
            padding-bottom: 10px;
            height: auto;
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

        #chat-container {
            display: none; /* Initially hide the chat container */
            position: fixed; /* Fixed position to keep it centered */
            top: 50%; /* Center vertically */
            left: 50%; /* Center horizontally */
            transform: translate(-50%, -50%); /* Centering trick */
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 300px; /* Adjust width as needed */
            padding: 10px;
            z-index: 1000; /* Ensure it's above other content */
        }
        #close-chat {
            position: absolute;
            top: 5px;
            right: 5px;
            cursor: pointer;
            font-size: 20px;
            color: #999;
        }

        #close-chat:hover {
            color: #333;
        }
        #chat-messages {
            height: 200px;
            overflow-y: scroll;
            border-bottom: 1px solid #ccc;
            padding: 10px;
            background: black;
        }

        #chat-input {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 10px;
        }
        .name {
            text-align: center; /* Center text horizontally */
            font-weight: bold; /* Optional: make the name bold */
            margin-bottom: 10px; /* Space below the name */
        }

        .message {
            padding: 10px;
            
            color: white; /* Text color */
            display: flex; /* Fit background to text width */
            margin-top:10px;
            max-width: 80%; /* Ensure messages don't take up full width */
            word-wrap: break-word; /* Allow long words to break */
        }

        .message-green {
            background-color: green;
            border-radius: 20px 20px 0 20px; /* Rounded corners */
            border: 2px solid white;
            text-align: right; /* Align text to the right */
            margin-left: auto; /* Push the message to the right */
        }

        .message-red {
            background-color: red;
            border-radius: 20px 20px 20px 0; /* Rounded corners */
            border: 2px solid white;
            text-align: left; /* Align text to the left */
            margin-right: auto; /* Push the message to the left */
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
            position: absolute;
            top: 120px;
            right: 15px;
        }

        .icon-button {
            background: none;
            border: none;
            cursor: pointer;
            margin-left: 10px;
        }

        .icon-button img {
            width: 40px;
            height: 40px;
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

        .profile-icon {
        width: 20px; 
        height: 20px; 
        border-radius: 50%; 
        vertical-align: middle; 
        margin-right: 10px;
        border: 2px solid transparent;
        transition: border-color 0.3s ease;
    }
    .profile-icon.online {
        border-color: #32CD32; /* Light green color */
    }

    .chat-button {
    padding: 5px 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.chat-button.read {
    background-color: #007bff; /* Blue color for read messages */
    color: white;
}

.chat-button.unread {
    background-color: #28a745; /* Green color for unread messages */
    color: white;
}

.play-button {
    padding: 5px 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    background-color: #153a4d; /* Black background */
    color: #ffffff; /* White text */
}

.play-button:hover {
    background-color: #333333; /* Slightly lighter black on hover for better UX */
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



    <?php
        session_start();

        if (!isset($_SESSION['id'])) {
            // Redirect to login page if the user is not logged in
            header("Location: index.html");
            exit();
        }

        $user_id = $_SESSION['id'];
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "beatchess";

        $conn = mysqli_connect($servername, $username, $password, $database);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Fetch challenges with accepted status where the current user is involved
        $sql = "SELECT * FROM challenge WHERE status = 'accepted' AND (id_made = $user_id OR id_accept = $user_id)";
        $result = mysqli_query($conn, $sql);

    ?>


    <script>
        const socket = new WebSocket('ws://localhost:3000');
    let onlineUsers = new Set();

    socket.addEventListener('open', (event) => {
        // Send login message when connection is established
        socket.send(JSON.stringify({
            type: 'login',
            userId: '<?php echo $user_id; ?>'
        }));
    });

    socket.addEventListener('message', (event) => {
        const receivedMessage = JSON.parse(event.data);
        
        if (receivedMessage.type === 'onlineUsers') {
            onlineUsers = new Set(receivedMessage.users);
            updateOnlineStatus();
        } else if (receivedMessage.type === 'chat' && receivedMessage.to === '<?php echo $user_id; ?>') {
            displayMessages(receivedMessage);
        } else if (receivedMessage.type === 'play_request' && receivedMessage.to === '<?php echo $user_id; ?>') {
            window.location.href = `boardnew.php?opponentId=${encodeURIComponent(receivedMessage.to)}&challengeId=${encodeURIComponent(receivedMessage.challengeId)}`;
        }
    });

    function updateOnlineStatus() {
        const profileIcons = document.querySelectorAll('.profile-icon');
        profileIcons.forEach(icon => {
            const userId = icon.dataset.userId;
            if (onlineUsers.has(userId)) {
                icon.classList.add('online');
            } else {
                icon.classList.remove('online');
            }
        });
    }


        function displayMessages(messages) {
            const chatMessages = document.getElementById('chat-messages');
            var userId = '<?php echo $user_id; ?>';

            // Display the fetched messages
            if (Array.isArray(messages)) {
                // Iterate over each message and display it
                messages.forEach(message => {
                    const messageDiv = document.createElement('div');
                    messageDiv.textContent = `${message.content}`;
                    messageDiv.classList.add('message');
                    if (message.sender === userId) {
                        messageDiv.classList.add('message-green'); // Sent messages with green background
                    } else {
                        messageDiv.classList.add('message-red'); // Received messages with red background
                    }
                    chatMessages.appendChild(messageDiv);
                });
            } else {
                // If messages is not an array, display a single message
                const messageDiv = document.createElement('div');
                messageDiv.textContent = `${messages.content}`;
                messageDiv.classList.add('message');
                if (messages.direction === 'sent') {
                    if (messages.from === userId) {
                        messageDiv.classList.add('message-green'); // Sent messages with green background
                    } else {
                        messageDiv.classList.add('message-red'); // Received messages with red background
                    }
                } else {
                    if (messages.from === userId) {
                        messageDiv.classList.add('message-green'); // Sent messages with green background
                    } else {
                        messageDiv.classList.add('message-red'); // Received messages with red background
                    }
                }
                chatMessages.appendChild(messageDiv);
            }
        }

        function fetchMessages(challengeId) {
            console.log(challengeId);
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const messages = JSON.parse(xhr.responseText);
                    displayMessages(messages);
                }
            };

            // Specify the PHP script URL to fetch messages
            const url = 'fetch_messages.php';

            // Prepare the data to be sent to the server
            const data = new FormData();
            data.append('challengeId', challengeId);

            // Send the POST request to the server
            xhr.open('POST', url, true);
            xhr.send(data);
        }

    
        let currentOpponentId = null;
        let currentchallengeId = null;

        function chatWith(opponentName, opponentId, challengeId) {
            currentOpponentId = opponentId;
            currentchallengeId = challengeId;

            const nameElement = document.querySelector('#chat-container .name');
            nameElement.textContent = `Chatting with ${opponentName}`;

            const chatContainer = document.getElementById('chat-container');
            chatContainer.style.display = 'block';

            const chatMessages = document.getElementById('chat-messages');
            chatMessages.innerHTML = '';
            fetchMessages(currentchallengeId);
            updateMessageStatus(challengeId);
            updateChatButtonStatus(challengeId, 'read');
        }

    function updateMessageStatus(challengeId) {
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.responseText);
            }
        };

        const url = 'update_message_status.php';
        const data = new FormData();
        data.append('challengeId', challengeId);
        data.append('userId', '<?php echo $user_id; ?>');

        xhr.open('POST', url, true);
        xhr.send(data);
    }

    function updateChatButtonStatus(challengeId, status) {
        const chatButton = document.querySelector(`button[onclick*="${challengeId}"]`);
        if (chatButton) {
            chatButton.classList.remove('read', 'unread');
            chatButton.classList.add(status);
        }
    }



        function playWith(opponentName, opponentId, challengeId) {
            // Prepare play request
            const playRequest = {
                type: 'play_request',
                from: '<?php echo $user_id; ?>',
                to: opponentId,
                challengeId: challengeId, // Add challengeId to the play request
                url: `boardnew.php?opponentId=${opponentId}&challengeId=${challengeId}`, // Include challengeId as a query parameter
            };

                // Send play request to the server
            socket.send(JSON.stringify(playRequest));

                // Open board.html in a new tab/window
            window.location.href = `boardnew.php?opponentId=${opponentId}&challengeId=${challengeId}`;
        }

        function sendMessage() {
            // Get the message from the input field
            const messageContent = document.getElementById('message-input').value;

            if (currentOpponentId && messageContent.trim() !== '') {
                // Prepare the message object
                const message = {
                    type: 'chat',
                    from: '<?php echo $user_id; ?>',
                    to: currentOpponentId,
                    content: messageContent
                };

                // Convert the message to JSON and send it to the server
                socket.send(JSON.stringify(message));

                // Display the sent message
                displayMessages(message);
                updateMessageTable(currentchallengeId, '<?php echo $user_id; ?>', currentOpponentId, messageContent);


                
                document.getElementById('message-input').value = '';
            }
        }

        function updateMessageTable(challengeId, senderId, receiverId, content) {
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Handle the response if needed
                    console.log(xhr.responseText);
                }
            };

            // Specify the PHP script URL
            const url = 'update_message.php';

            // Prepare the data to be sent to the server
            const data = new FormData();
            data.append('challengeId', challengeId);
            data.append('senderId', senderId);
            data.append('receiverId', receiverId);
            data.append('content', content);

            // Send the POST request to the server
            xhr.open('POST', url, true);
            xhr.send(data);
        }

        function toggleChatContainer() {
            const chatContainer = document.getElementById('chat-container');
            if (chatContainer.style.display === 'none') {
                chatContainer.style.display = 'block';
            } else {
                chatContainer.style.display = 'none';
            }
        }


    </script>


    <h2>Event Page</h2>
    
    <div id="content">
        <?php
            $sql = "SELECT c.*, 
            CASE 
                WHEN EXISTS (
                    SELECT 1 
                    FROM messages m 
                    WHERE m.chatId = c.id 
                      AND m.status = 'unread'
                      AND m.receiverId = $user_id
                ) THEN 'unread'
                ELSE 'read'
            END AS status
     FROM challenge c 
     WHERE c.status = 'accepted' 
       AND (c.id_made = $user_id OR c.id_accept = $user_id)";

$result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "here";
            while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['id_made'] == $user_id) {
                        $opponentId = $row['id_accept'];
                        $opponentName = $row['name_accept'];
                    } else {
                        $opponentId = $row['id_made'];
                        $opponentName = $row['name_made'];
                    }
                    $challengeId = $row['id'];
                    $messageStatus = $row['status'];


                    echo "<p>";
                    echo "<img src='images/profile.jpg' alt='Profile Icon' class='profile-icon' data-user-id='{$opponentId}'>";
                    echo "You have match with <a href='player.php?opponentId={$opponentId}'>{$opponentName}</a>";
                    //echo " <a href='player.php?opponentId={$opponentId}'>View Profile</a>";
                    echo " <button onclick='chatWith(\"{$opponentName}\", \"{$opponentId}\", \"{$challengeId}\")' class='chat-button {$messageStatus}'>Chat</button>";
                    echo " <button onclick='playWith(\"{$opponentName}\", \"{$opponentId}\", \"{$challengeId}\")' class='play-button'>Play</button>";
                    echo "</p>";
                }
            } else {
                echo "No accepted challenges.";
            }
        ?>
    </div>
    
    
    <div id="chat-container">
        <div id="close-chat" onclick="toggleChatContainer()">×</div>
        <div class="name"></div>
        <div id="chat-messages"></div>
        <div id="chat-input">
            <input type="text" id="message-input" placeholder="Type your message...">
            <button onclick="sendMessage()">Send</button>
        </div>
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
   
</body>


<?php
mysqli_close($conn);
?>
