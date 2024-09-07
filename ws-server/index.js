const WebSocket = require('ws');
const wss = new WebSocket.Server({ port: 8080 });

let clients = new Map();

wss.on('connection', (ws) => {
    console.log('Client connected');

    ws.on('message', (message) => {
        try {
            const data = JSON.parse(message);

            // Save client connections
            if (data.type === 'register') {
                clients.set(data.delegateId, ws);
                console.log(`Client registered: ${data.delegateId}`);
            }

            // Broadcast location updates
            if (data.type === 'location-update') {
                clients.forEach((client, delegateId) => {
                    if (client !== ws) {
                        client.send(JSON.stringify({
                            delegateId: data.delegateId,
                            latitude: data.latitude,
                            longitude: data.longitude
                        }));
                    }
                });
                console.log(`Location update broadcasted: ${data.delegateId}`);
            }
        } catch (error) {
            console.error('Error processing message:', error);
        }
    });

    ws.on('close', () => {
        // Remove disconnected clients
        clients.forEach((client, delegateId) => {
            if (client === ws) {
                clients.delete(delegateId);
                console.log(`Client disconnected: ${delegateId}`);
            }
        });
    });

    ws.on('error', (error) => {
        console.error('WebSocket error:', error);
    });
});

console.log('WebSocket server is running on ws://localhost:8080');
