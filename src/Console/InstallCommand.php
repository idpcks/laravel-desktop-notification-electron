<?php

namespace LaravelDesktopNotifications\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'desktop-notifications:install 
                            {--force : Force overwrite existing files}
                            {--skip-deps : Skip installing Electron dependencies}';

    /**
     * The console command description.
     */
    protected $description = 'Install Laravel Desktop Notifications package and set up Electron app';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Installing Laravel Desktop Notifications...');
        $this->newLine();

        // Install config file
        $this->installConfig();

        // Install Electron app
        $this->installElectronApp();

        // Install dependencies
        if (!$this->option('skip-deps')) {
            $this->installDependencies();
        }

        // Create example files
        $this->createExamples();

        $this->newLine();
        $this->info('🎉 Installation completed successfully!');
        $this->newLine();
        
        $this->info('📋 Next steps:');
        $this->line('1. Start the Electron app: php artisan desktop-notifications:start');
        $this->line('2. Test notifications: php artisan desktop-notifications:test');
        $this->line('3. Check the examples in the examples/ directory');
        $this->newLine();

        return Command::SUCCESS;
    }

    private function installConfig()
    {
        $configFile = config_path('desktop-notifications.php');
        $sourceConfig = __DIR__ . '/../../config/desktop-notifications.php';

        if (File::exists($configFile) && !$this->option('force')) {
            $this->warn('Configuration file already exists. Use --force to overwrite.');
            return;
        }

        if (File::exists($sourceConfig)) {
            File::copy($sourceConfig, $configFile);
            $this->info('✅ Configuration file installed: config/desktop-notifications.php');
        }
    }

    private function installElectronApp()
    {
        $electronPath = base_path('electron-app');
        $sourcePath = __DIR__ . '/../../electron-app';

        if (!File::exists($electronPath)) {
            File::makeDirectory($electronPath, 0755, true);
            $this->info('✅ Created electron-app directory');
        }

        $files = [
            'main.js',
            'server.js',
            'index.html',
            'notification.html',
            'renderer.js',
            'package.json',
            'start.bat',
            'start.sh'
        ];

        foreach ($files as $file) {
            $source = $sourcePath . '/' . $file;
            $destination = $electronPath . '/' . $file;

            if (File::exists($source)) {
                if (File::exists($destination) && !$this->option('force')) {
                    $this->warn("File electron-app/{$file} already exists. Skipping.");
                    continue;
                }

                File::copy($source, $destination);
                $this->info("✅ Installed: electron-app/{$file}");
            }
        }
    }

    private function installDependencies()
    {
        $packageJson = base_path('electron-app/package.json');

        if (!File::exists($packageJson)) {
            $this->warn('package.json not found in electron-app directory.');
            return;
        }

        $this->info('📦 Installing Electron dependencies...');

        $currentDir = getcwd();
        chdir(base_path('electron-app'));

        // Check if npm is available
        $npmCheck = shell_exec('npm --version 2>&1');
        if (strpos($npmCheck, 'npm') !== false) {
            $this->line('Running: npm install');
            $output = shell_exec('npm install 2>&1');
            $this->line($output);
            $this->info('✅ Electron dependencies installed');
        } else {
            $this->warn('⚠️  npm not found. Please install Node.js and npm first.');
            $this->line('Download from: https://nodejs.org/');
        }

        chdir($currentDir);
    }

    private function createExamples()
    {
        $examplesDir = base_path('examples');

        if (!File::exists($examplesDir)) {
            File::makeDirectory($examplesDir, 0755, true);
        }

        // Create example controller
        $controllerContent = $this->getControllerExample();
        $controllerFile = $examplesDir . '/NotificationController.php';

        if (!File::exists($controllerFile) || $this->option('force')) {
            File::put($controllerFile, $controllerContent);
            $this->info('✅ Created example controller: examples/NotificationController.php');
        }

        // Create routes example
        $routesContent = $this->getRoutesExample();
        $routesFile = $examplesDir . '/routes-example.php';

        if (!File::exists($routesFile) || $this->option('force')) {
            File::put($routesFile, $routesContent);
            $this->info('✅ Created routes example: examples/routes-example.php');
        }

        // Create quick start guide
        $quickStartContent = $this->getQuickStartGuide();
        $quickStartFile = $examplesDir . '/QUICK_START.md';

        if (!File::exists($quickStartFile) || $this->option('force')) {
            File::put($quickStartFile, $quickStartContent);
            $this->info('✅ Created quick start guide: examples/QUICK_START.md');
        }
    }

    private function getControllerExample()
    {
        return '<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelDesktopNotifications\Facades\DesktopNotification;

class NotificationController extends Controller
{
    public function test()
    {
        // Test basic notification
        DesktopNotification::send("Test Notification", "This is a test notification from Laravel!");
        
        return response()->json(["message" => "Notification sent!"]);
    }

    public function success()
    {
        DesktopNotification::success("Success!", "Operation completed successfully");
        
        return response()->json(["message" => "Success notification sent!"]);
    }

    public function error()
    {
        DesktopNotification::error("Error!", "Something went wrong");
        
        return response()->json(["message" => "Error notification sent!"]);
    }

    public function warning()
    {
        DesktopNotification::warning("Warning!", "Please check your input");
        
        return response()->json(["message" => "Warning notification sent!"]);
    }

    public function info()
    {
        DesktopNotification::info("Info", "Here is some information for you");
        
        return response()->json(["message" => "Info notification sent!"]);
    }

    public function status()
    {
        $isRunning = DesktopNotification::isRunning();
        $status = DesktopNotification::getStatus();
        
        return response()->json([
            "is_running" => $isRunning,
            "status" => $status
        ]);
    }
}';
    }

    private function getRoutesExample()
    {
        return '<?php

// Add these routes to your routes/web.php file

use App\Http\Controllers\NotificationController;

Route::get("/test-notification", [NotificationController::class, "test"]);
Route::get("/test-success", [NotificationController::class, "success"]);
Route::get("/test-error", [NotificationController::class, "error"]);
Route::get("/test-warning", [NotificationController::class, "warning"]);
Route::get("/test-info", [NotificationController::class, "info"]);
Route::get("/notification-status", [NotificationController::class, "status"]);';
    }

    private function getQuickStartGuide()
    {
        return '# Quick Start Guide

## 1. Start the Electron App

```bash
php artisan desktop-notifications:start
```

## 2. Add Routes to Your Laravel App

Add these routes to your `routes/web.php`:

```php
use App\Http\Controllers\NotificationController;

Route::get("/test-notification", [NotificationController::class, "test"]);
Route::get("/test-success", [NotificationController::class, "success"]);
Route::get("/test-error", [NotificationController::class, "error"]);
Route::get("/test-warning", [NotificationController::class, "warning"]);
Route::get("/test-info", [NotificationController::class, "info"]);
Route::get("/notification-status", [NotificationController::class, "status"]);
```

## 3. Test Notifications

Visit these URLs in your browser:
- http://your-app.test/test-notification
- http://your-app.test/test-success
- http://your-app.test/test-error
- http://your-app.test/test-warning
- http://your-app.test/test-info
- http://your-app.test/notification-status

## 4. Use in Your Code

```php
use LaravelDesktopNotifications\Facades\DesktopNotification;

// Basic notification
DesktopNotification::send("Title", "Message");

// Typed notifications
DesktopNotification::success("Success!", "Operation completed");
DesktopNotification::error("Error!", "Something went wrong");
DesktopNotification::warning("Warning!", "Please check input");
DesktopNotification::info("Info", "Here is some information");

// Check if Electron app is running
if (DesktopNotification::isRunning()) {
    echo "Electron app is running!";
}
```

## 5. Configuration

Edit `config/desktop-notifications.php` to customize:
- Electron app URL (default: http://localhost:3000)
- Timeout settings
- Default notification options
- Logging preferences';
    }
} 