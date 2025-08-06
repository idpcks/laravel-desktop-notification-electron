const express = require('express');
const cors = require('cors');
const { ipcMain } = require('electron');

class NotificationServer {
    constructor(electronApp) {
        this.app = express();
        this.electronApp = electronApp;
        this.port = process.env.PORT || 3000;
        
        this.setupMiddleware();
        this.setupRoutes();
    }

    setupMiddleware() {
        // Enable CORS
        this.app.use(cors({
            origin: '*',
            methods: ['GET', 'POST', 'PUT', 'DELETE'],
            allowedHeaders: ['Content-Type', 'Authorization']
        }));

        // Parse JSON bodies
        this.app.use(express.json({ limit: '10mb' }));
        
        // Parse URL-encoded bodies
        this.app.use(express.urlencoded({ extended: true }));
    }

    setupRoutes() {
        // Health check endpoint
        this.app.get('/api/status', (req, res) => {
            res.json({
                isReady: this.electronApp.isReady(),
                isQuitting: this.electronApp.isQuitting || false,
                version: this.electronApp.getVersion(),
                timestamp: new Date().toISOString()
            });
        });

        // Notification endpoint
        this.app.post('/api/notifications', async (req, res) => {
            try {
                const notificationData = req.body;
                
                // Validate required fields
                if (!notificationData.title || !notificationData.message) {
                    return res.status(400).json({
                        success: false,
                        error: 'Title and message are required'
                    });
                }

                // Send notification through Electron
                const result = await this.sendNotification(notificationData);
                
                res.json(result);
                
            } catch (error) {
                console.error('Error processing notification:', error);
                res.status(500).json({
                    success: false,
                    error: error.message
                });
            }
        });

        // Get app info
        this.app.get('/api/info', (req, res) => {
            res.json({
                name: 'Laravel Desktop Notifications',
                version: this.electronApp.getVersion(),
                platform: process.platform,
                arch: process.arch,
                nodeVersion: process.version,
                uptime: process.uptime(),
                timestamp: new Date().toISOString()
            });
        });

        // Restart app endpoint
        this.app.post('/api/restart', (req, res) => {
            try {
                this.electronApp.relaunch();
                this.electronApp.exit();
                res.json({ success: true, message: 'App restarting...' });
            } catch (error) {
                res.status(500).json({
                    success: false,
                    error: error.message
                });
            }
        });

        // Error handling middleware
        this.app.use((error, req, res, next) => {
            console.error('Server error:', error);
            res.status(500).json({
                success: false,
                error: 'Internal server error'
            });
        });

        // 404 handler
        this.app.use('*', (req, res) => {
            res.status(404).json({
                success: false,
                error: 'Endpoint not found'
            });
        });
    }

    async sendNotification(notificationData) {
        return new Promise((resolve) => {
            // Use IPC to send notification to main process
            ipcMain.handleOnce('send-notification', async (event, data) => {
                try {
                    // Try native notification first
                    const nativeResult = await this.electronApp.webContents.send('show-notification', data);
                    
                    if (nativeResult && nativeResult.success) {
                        return nativeResult;
                    }
                    
                    // Fallback to custom notification
                    const customResult = await this.electronApp.webContents.send('show-custom-notification', data);
                    return customResult;
                    
                } catch (error) {
                    return {
                        success: false,
                        error: error.message
                    };
                }
            });

            // Trigger the notification
            this.electronApp.webContents.send('send-notification', notificationData);
            
            // Resolve after a short delay
            setTimeout(() => {
                resolve({
                    success: true,
                    method: 'electron-ipc',
                    message: 'Notification sent via IPC'
                });
            }, 100);
        });
    }

    start() {
        return new Promise((resolve, reject) => {
            try {
                this.server = this.app.listen(this.port, () => {
                    console.log(`Notification server running on port ${this.port}`);
                    resolve();
                });

                this.server.on('error', (error) => {
                    console.error('Server error:', error);
                    reject(error);
                });

            } catch (error) {
                console.error('Failed to start server:', error);
                reject(error);
            }
        });
    }

    stop() {
        if (this.server) {
            this.server.close();
            console.log('Notification server stopped');
        }
    }
}

module.exports = NotificationServer; 