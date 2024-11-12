const WebSocket = require('ws');
const http = require('http');
const server = http.createServer();
const wss = new WebSocket.Server({ noServer: true });
const clients = new Map(); // Track connected clients {userId: socket}
const onlineUsers = new Set(); // Set of userIds that are online

wss.on('connection', (socket, request) => {
    let userId = null; // Will be assigned after login

    socket.on('message', (message) => {
        const messageString = (Buffer.isBuffer(message)) ? message.toString('utf-8') : message;
        const parsedMessage = JSON.parse(messageString);

        switch (parsedMessage.type) {
            case 'login':
                userId = parsedMessage.userId;
                clients.set(userId, socket);
                onlineUsers.add(userId);
                console.log(`User ID ${userId} logged in`);
                broadcastOnlineUsers();
                break;
            case 'chess_move':
            case 'chat':
            case 'play_request':
            case 'UpdateCasualties':
            case 'colorAssign':
            case 'challengeAccepted':
            case 'UpdateWinner':
                console.log(`Received: ${messageString}`);
                broadcastToOthers(socket, messageString);
                break;
            default:
                console.log(`Unknown message type: ${parsedMessage.type}`);
        }
    });

    socket.on('close', () => {
        console.log('Client disconnected');
        if (userId) {
            onlineUsers.delete(userId);
            clients.delete(userId);
            broadcastOnlineUsers();
        }
    });
});

server.on('upgrade', (request, socket, head) => {
    wss.handleUpgrade(request, socket, head, (socket) => {
        wss.emit('connection', socket, request);
    });
});

function broadcastOnlineUsers() {
    const onlineUserList = Array.from(onlineUsers);
    const message = JSON.stringify({ type: 'onlineUsers', users: onlineUserList });
    broadcastToAll(message);
}

function broadcastToAll(message) {
    wss.clients.forEach((client) => {
        if (client.readyState === WebSocket.OPEN) {
            client.send(message);
        }
    });
}

function broadcastToOthers(sender, message) {
    wss.clients.forEach((client) => {
        if (client !== sender && client.readyState === WebSocket.OPEN) {
            client.send(message);
        }
    });
}

const port = 3000;
server.listen(port, () => {
    console.log(`Server listening on port ${port}`);
});