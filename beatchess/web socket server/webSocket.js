// websocket.js

class WebSocketManager {
    constructor() {
        if (!WebSocketManager.instance) {
            this.socket = new WebSocket('ws://');
            WebSocketManager.instance = this;
        }

        return WebSocketManager.instance;
    }
}

const webSocketManager = new WebSocketManager();

export { webSocketManager };
