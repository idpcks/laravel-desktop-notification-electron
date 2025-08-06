# Laravel Desktop Notifications

A Laravel package for displaying desktop notifications using Electron. This package allows you to send notifications from your Laravel application directly to the desktop screen in the bottom right corner.

## 🚀 Features

- **Easy Installation**: Simple `composer require` installation
- **Desktop Notifications**: Display notifications on desktop using Electron
- **Multiple Types**: Support for success, error, warning, and info notifications
- **Customizable**: Configurable notification appearance and behavior
- **Cross-Platform**: Works on Windows, macOS, and Linux
- **Laravel Integration**: Seamless integration with Laravel framework
- **Artisan Commands**: Built-in commands for installation, starting, and testing

## 📦 Installation

### Quick Install (Recommended)

```bash
# Install the package
composer require laravel-desktop-notification-electron/desktop-notifications

# Run the installer
php artisan desktop-notifications:install

# Start the Electron app
php artisan desktop-notifications:start --background
```

That's it! The package is now ready to use.

### Manual Installation

If you prefer manual installation:

```bash
# 1. Install the package
composer require laravel-desktop-notification-electron/desktop-notifications

# 2. Publish configuration and Electron app
php artisan vendor:publish --provider="LaravelDesktopNotifications\DesktopNotificationServiceProvider"

# 3. Install Electron dependencies
cd electron-app
npm install

# 4. Start the Electron app
npm start
```

## 🎯 Quick Start

### 1. Send Your First Notification

```php
use LaravelDesktopNotifications\Facades\DesktopNotification;

// Basic notification
DesktopNotification::send('Hello!', 'This is your first notification');

// Typed notifications
DesktopNotification::success('Success!', 'Operation completed');
DesktopNotification::error('Error!', 'Something went wrong');
DesktopNotification::warning('Warning!', 'Please check input');
DesktopNotification::info('Info', 'Here is some information');
```

### 2. Test Notifications

```bash
# Test all notification types
php artisan desktop-notifications:test

# Test specific notification type
php artisan desktop-notifications:test --type=success

# Check Electron app status
php artisan desktop-notifications:test --type=status
```

### 3. Add Routes for Testing

Add these routes to your `routes/web.php`:

```php
use App\Http\Controllers\NotificationController;

Route::get('/test-notification', [NotificationController::class, 'test']);
Route::get('/test-success', [NotificationController::class, 'success']);
Route::get('/test-error', [NotificationController::class, 'error']);
Route::get('/test-warning', [NotificationController::class, 'warning']);
Route::get('/test-info', [NotificationController::class, 'info']);
Route::get('/notification-status', [NotificationController::class, 'status']);
```

## 🛠️ Usage

### Basic Usage

```php
use LaravelDesktopNotifications\Facades\DesktopNotification;

// Send a basic notification
DesktopNotification::send($title, $message, $options);

// Send typed notifications
DesktopNotification::success($title, $message, $options);
DesktopNotification::error($title, $message, $options);
DesktopNotification::warning($title, $message, $options);
DesktopNotification::info($title, $message, $options);
```

### Advanced Usage

```php
// Send notification with custom options
DesktopNotification::send('Custom Notification', 'With custom settings', [
    'icon' => 'path/to/icon.png',
    'duration' => 10000,
    'sound' => true,
    'url' => 'https://example.com'
]);

// Check if Electron app is running
if (DesktopNotification::isRunning()) {
    echo 'Electron app is running!';
}

// Get Electron app status
$status = DesktopNotification::getStatus();
```

### Queue Integration

```php
// Send notification via queue
DesktopNotification::send('Queued Notification', 'This will be sent via queue')
    ->onQueue('notifications');
```

### Event Integration

```php
// In your event listener
public function handle(OrderCreated $event)
{
    DesktopNotification::success(
        'New Order!',
        "Order #{$event->order->id} has been created"
    );
}
```

## ⚙️ Configuration

The configuration file is located at `config/desktop-notifications.php`:

```php
return [
    'electron_url' => env('DESKTOP_NOTIFICATIONS_URL', 'http://localhost:3000'),
    'timeout' => env('DESKTOP_NOTIFICATIONS_TIMEOUT', 5),
    
    'defaults' => [
        'title' => 'Laravel Notification',
        'duration' => 5000,
        'sound' => true,
        'icon' => null,
    ],
    
    'types' => [
        'success' => [
            'icon' => 'path/to/success-icon.png',
            'color' => '#28a745',
        ],
        'error' => [
            'icon' => 'path/to/error-icon.png',
            'color' => '#dc3545',
        ],
        'warning' => [
            'icon' => 'path/to/warning-icon.png',
            'color' => '#ffc107',
        ],
        'info' => [
            'icon' => 'path/to/info-icon.png',
            'color' => '#17a2b8',
        ],
    ],
    
    'logging' => [
        'enabled' => env('DESKTOP_NOTIFICATIONS_LOGGING', false),
        'channel' => env('DESKTOP_NOTIFICATIONS_LOG_CHANNEL', 'daily'),
    ],
];
```

## 🎮 Artisan Commands

### Installation Commands

```bash
# Install the package and set up Electron app
php artisan desktop-notifications:install

# Install with force overwrite
php artisan desktop-notifications:install --force

# Install without Electron dependencies
php artisan desktop-notifications:install --skip-deps
```

### Management Commands

```bash
# Start Electron app
php artisan desktop-notifications:start

# Start in background
php artisan desktop-notifications:start --background

# Start in development mode
php artisan desktop-notifications:start --dev
```

### Testing Commands

```bash
# Test all notification types
php artisan desktop-notifications:test

# Test specific notification type
php artisan desktop-notifications:test --type=success
php artisan desktop-notifications:test --type=error
php artisan desktop-notifications:test --type=warning
php artisan desktop-notifications:test --type=info
php artisan desktop-notifications:test --type=basic

# Check status only
php artisan desktop-notifications:test --type=status
```

## 🔧 API Endpoints

The Electron app exposes these API endpoints:

- `GET /api/status` - Check if the app is running
- `POST /api/notifications` - Send a notification
- `GET /api/info` - Get app information
- `POST /api/restart` - Restart the app

## 🐛 Troubleshooting

### Common Issues

1. **Electron app not starting**
   - Make sure Node.js and npm are installed
   - Check if port 3000 is available
   - Run `npm install` in the electron-app directory

2. **Notifications not appearing**
   - Ensure Electron app is running
   - Check notification permissions in your OS
   - Verify the URL in config file

3. **Connection errors**
   - Check if Electron app is running on the correct port
   - Verify firewall settings
   - Check the timeout configuration

### Debug Commands

```bash
# Check Node.js version
node --version

# Check npm version
npm --version

# Check if port 3000 is in use
netstat -an | grep 3000

# Test Electron app status
php artisan desktop-notifications:test --type=status
```

## 📁 File Structure

```
your-laravel-project/
├── config/
│   └── desktop-notifications.php
├── electron-app/
│   ├── main.js
│   ├── server.js
│   ├── package.json
│   ├── index.html
│   ├── notification.html
│   ├── renderer.js
│   ├── start.bat
│   └── start.sh
└── examples/
    ├── NotificationController.php
    ├── routes-example.php
    └── QUICK_START.md
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- [Electron](https://electronjs.org/) - For the desktop application framework
- [Laravel](https://laravel.com/) - For the PHP framework
- [node-notifier](https://github.com/mikaelbr/node-notifier) - For native notifications

## 📞 Support

If you encounter any issues or have questions:

1. Check the [troubleshooting section](#troubleshooting)
2. Review the [examples directory](examples/)
3. Open an issue on GitHub
4. Check the documentation

---

**Made with ❤️ for the Laravel community** 