<!-- index.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSocket Chat</title>
</head>
<body>
    <div id="chat">
        <h2>chat</h2><br>
        <input type="text" id="messageInput" placeholder="Enter your message">
        <button id="sendButton">Send</button>
        <ul id="messages"></ul>
    </div>

    <script>
        const socket = new WebSocket('ws://localhost:3000');

        const messageInput = document.getElementById('messageInput');
        const sendButton = document.getElementById('sendButton');
        const messagesList = document.getElementById('messages');

        // Event listener for the send button
        sendButton.addEventListener('click', () => {
            const message = messageInput.value.trim();
            if (message) {
                socket.send(message);
                messageInput.value = '';
            }
        });

        // Event listener for receiving messages
        socket.addEventListener('message', (event) => {
            //const message = JSON.parse(event.data);
    // Now you can access properties of the message object
            
            const message = event.data;
            console.log(message);
            const li = document.createElement('li');
            li.textContent = message;
            messagesList.appendChild(li);
        });
    </script>
</body>
</html>
