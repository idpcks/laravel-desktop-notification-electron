const { ipcRenderer } = require('electron');

// Elements
const statusText = document.getElementById('statusText');
const versionText = document.getElementById('versionText');
const logContainer = document.getElementById('logContainer');

// Initialize
document.addEventListener('DOMContentLoaded', async () => {
    try {
        // Get app status
        const status = await ipcRenderer.invoke('get-app-status');
        
        if (status.isReady) {
            statusText.textContent = 'Ready';
            versionText.textContent = status.version;
            addLog('Application started successfully', 'success');
        } else {
            statusText.textContent = 'Initializing...';
            addLog('Application is initializing...', 'info');
        }
        
        // Listen for notification events
        ipcRenderer.on('notification-sent', (event, data) => {
            addLog(`Notification sent: ${data.title}`, 'success');
        });
        
        ipcRenderer.on('notification-error', (event, error) => {
            addLog(`Notification error: ${error}`, 'error');
        });
        
    } catch (error) {
        statusText.textContent = 'Error';
        addLog(`Initialization error: ${error.message}`, 'error');
    }
});

// Function to add log entries
function addLog(message, type = 'info') {
    const logEntry = document.createElement('div');
    logEntry.className = `log-entry ${type}`;
    
    const timestamp = new Date().toLocaleTimeString();
    logEntry.innerHTML = `
        <span class="timestamp">[${timestamp}]</span>
        <span class="message">${message}</span>
    `;
    
    logContainer.appendChild(logEntry);
    
    // Keep only last 50 logs
    while (logContainer.children.length > 50) {
        logContainer.removeChild(logContainer.firstChild);
    }
    
    // Auto-scroll to bottom
    logContainer.scrollTop = logContainer.scrollHeight;
}

// Add some CSS for log styling
const style = document.createElement('style');
style.textContent = `
    .log-entry {
        padding: 5px 10px;
        margin: 2px 0;
        border-radius: 3px;
        font-family: monospace;
        font-size: 12px;
    }
    
    .log-entry.success {
        background-color: #e8f5e8;
        color: #2e7d32;
        border-left: 3px solid #4caf50;
    }
    
    .log-entry.error {
        background-color: #ffebee;
        color: #c62828;
        border-left: 3px solid #f44336;
    }
    
    .log-entry.warning {
        background-color: #fff3e0;
        color: #ef6c00;
        border-left: 3px solid #ff9800;
    }
    
    .log-entry.info {
        background-color: #e3f2fd;
        color: #1565c0;
        border-left: 3px solid #2196f3;
    }
    
    .timestamp {
        font-weight: bold;
        margin-right: 10px;
    }
    
    #logContainer {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        background-color: white;
    }
`;
document.head.appendChild(style); 