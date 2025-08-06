const { app, BrowserWindow, ipcMain, Notification, screen } = require('electron');
const path = require('path');
const notifier = require('node-notifier');
const NotificationServer = require('./server');

let mainWindow;
let notificationWindow;
let notificationServer;

// Fungsi untuk membuat window utama (tersembunyi)
function createMainWindow() {
  mainWindow = new BrowserWindow({
    width: 400,
    height: 300,
    show: false, // Window tersembunyi
    webPreferences: {
      nodeIntegration: true,
      contextIsolation: false
    },
    icon: path.join(__dirname, 'assets/icon.png')
  });

  mainWindow.loadFile('index.html');
  
  // Mencegah window ditutup
  mainWindow.on('close', (event) => {
    event.preventDefault();
    mainWindow.hide();
  });
}

// Fungsi untuk membuat window notifikasi
function createNotificationWindow() {
  const { width, height } = screen.getPrimaryDisplay().workAreaSize;
  
  notificationWindow = new BrowserWindow({
    width: 350,
    height: 100,
    x: width - 370, // Pojok kanan
    y: height - 120, // Pojok bawah
    frame: false,
    alwaysOnTop: true,
    skipTaskbar: true,
    resizable: false,
    webPreferences: {
      nodeIntegration: true,
      contextIsolation: false
    },
    show: false
  });

  notificationWindow.loadFile('notification.html');
  
  // Auto hide setelah beberapa detik
  notificationWindow.on('show', () => {
    setTimeout(() => {
      if (notificationWindow && !notificationWindow.isDestroyed()) {
        notificationWindow.hide();
      }
    }, 5000); // 5 detik
  });
}

// Event ketika app siap
app.whenReady().then(async () => {
  createMainWindow();
  createNotificationWindow();
  
  // Start HTTP server
  try {
    notificationServer = new NotificationServer(app);
    await notificationServer.start();
    console.log('HTTP server started successfully');
  } catch (error) {
    console.error('Failed to start HTTP server:', error);
  }
  
  // Handle window activation
  app.on('activate', () => {
    if (BrowserWindow.getAllWindows().length === 0) {
      createMainWindow();
    }
  });
});

// Handle semua window ditutup
app.on('window-all-closed', () => {
  if (process.platform !== 'darwin') {
    app.quit();
  }
});

// IPC Handlers untuk komunikasi dengan Laravel
ipcMain.handle('show-notification', async (event, notificationData) => {
  try {
    // Gunakan native notification jika tersedia
    if (Notification.isSupported()) {
      const notification = new Notification({
        title: notificationData.title || 'Laravel Notification',
        body: notificationData.message,
        icon: notificationData.icon || path.join(__dirname, 'assets/icon.png'),
        silent: notificationData.silent || false
      });
      
      notification.show();
      
      notification.on('click', () => {
        if (notificationData.url) {
          require('electron').shell.openExternal(notificationData.url);
        }
      });
      
      return { success: true, method: 'native' };
    } else {
      // Fallback ke node-notifier
      notifier.notify({
        title: notificationData.title || 'Laravel Notification',
        message: notificationData.message,
        icon: notificationData.icon || path.join(__dirname, 'assets/icon.png'),
        sound: !notificationData.silent,
        wait: true,
        url: notificationData.url
      });
      
      return { success: true, method: 'node-notifier' };
    }
  } catch (error) {
    console.error('Error showing notification:', error);
    return { success: false, error: error.message };
  }
});

// Handler untuk custom notification window
ipcMain.handle('show-custom-notification', async (event, notificationData) => {
  try {
    if (notificationWindow && !notificationWindow.isDestroyed()) {
      notificationWindow.webContents.send('display-notification', notificationData);
      notificationWindow.show();
      return { success: true, method: 'custom-window' };
    }
    return { success: false, error: 'Notification window not available' };
  } catch (error) {
    console.error('Error showing custom notification:', error);
    return { success: false, error: error.message };
  }
});

// Handler untuk mendapatkan status app
ipcMain.handle('get-app-status', () => {
  return {
    isReady: app.isReady(),
    isQuitting: app.isQuitting,
    version: app.getVersion()
  };
});

// Handler untuk restart app
ipcMain.handle('restart-app', () => {
  app.relaunch();
  app.exit();
});

// Handle app quit
app.on('before-quit', () => {
  app.isQuitting = true;
  if (notificationServer) {
    notificationServer.stop();
  }
}); 