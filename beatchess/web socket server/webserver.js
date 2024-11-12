// server.js
const WebSocket = require('ws');
const http = require('http');
const express = require('express');
const app = express();

// Create a server instance
const server = http.createServer(app);

// Create a WebSocket server
const wss = new WebSocket.Server({ server });

// Store connected clients
const clients = new Set();

// WebSocket connection event
wss.on('connection', (ws) => {
    clients.add(ws);
    console.log('Client connected');

    // WebSocket message event
    ws.on('message', (message) => {
        console.log(`Received message: ${message}`);
        // Broadcast the message to all connected clients
        wss.clients.forEach((client) => {
            if (client !== ws && client.readyState === WebSocket.OPEN) {
                client.send(message);
            }
        });
    });

    // WebSocket close event
    ws.on('close', () => {
        clients.delete(ws);
        console.log('Client disconnected');
    });
});

// Serve static files
app.use(express.static('public'));

// Start the server
const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
    console.log(`Server started on port ${PORT}`);
});
