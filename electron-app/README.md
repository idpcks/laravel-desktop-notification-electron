# Electron App for Laravel Desktop Notifications

This directory contains the Electron application that handles desktop notifications for the Laravel Desktop Notifications package.

## 🚀 Quick Start

### Prerequisites

- Node.js 16.0 or higher
- npm (comes with Node.js)

### Installation

```bash
# Install dependencies
npm install

# Start the app
npm start

# Start in development mode
npm run dev

# Build for distribution
npm run build
```

## 📁 File Structure

```
electron-app/
├── main.js              # Main Electron process
├── server.js            # HTTP server for API
├── index.html           # Main window HTML
├── notification.html    # Notification window HTML
├── renderer.js          # Renderer process script
├── package.json         # Node.js dependencies
├── start.bat           # Windows startup script
└── start.sh            # Linux/macOS startup script
```

## 🔧 Configuration

The Electron app runs on `http://localhost:3000` by default. You can change this in the Laravel configuration file.

## 🎮 API Endpoints

- `GET /api/status` - Check if the app is running
- `POST /api/notifications` - Send a notification
- `GET /api/info` - Get app information
- `POST /api/restart` - Restart the app

## 🛠️ Development

### Running in Development Mode

```bash
npm run dev
```

This will start the app with development tools enabled.

### Building for Production

```bash
npm run build
```

This will create distributable packages for Windows, macOS, and Linux.

## 🐛 Troubleshooting

### Common Issues

1. **Port 3000 already in use**
   ```bash
   # Check what's using the port
   netstat -an | grep 3000
   
   # Kill the process or change the port
   ```

2. **Dependencies not installed**
   ```bash
   # Reinstall dependencies
   rm -rf node_modules package-lock.json
   npm install
   ```

3. **App not starting**
   ```bash
   # Check Node.js version
   node --version
   
   # Check for errors in console
   npm start
   ```

## 📝 Notes

- The Electron app runs in the background and provides an HTTP API
- Notifications appear in the bottom-right corner of the screen
- The app supports multiple notification types (success, error, warning, info)
- Custom icons and URLs are supported
- Sound notifications are enabled by default

## 🔗 Integration

This Electron app is designed to work with the Laravel Desktop Notifications package. See the main README.md for integration instructions. 