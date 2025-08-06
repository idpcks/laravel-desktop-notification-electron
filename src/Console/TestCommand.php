<?php

namespace LaravelDesktopNotifications\Console;

use Illuminate\Console\Command;
use LaravelDesktopNotifications\Facades\DesktopNotification;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'desktop-notifications:test 
                            {--type=all : Type of notification to test (all, basic, success, error, warning, info, status)}';

    /**
     * The console command description.
     */
    protected $description = 'Test desktop notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->option('type');

        $this->info('🧪 Testing Laravel Desktop Notifications...');
        $this->newLine();

        // Test status first
        $this->testStatus();

        if ($type === 'status') {
            return Command::SUCCESS;
        }

        $this->newLine();

        // Test notifications based on type
        switch ($type) {
            case 'basic':
                $this->testBasic();
                break;
            case 'success':
                $this->testSuccess();
                break;
            case 'error':
                $this->testError();
                break;
            case 'warning':
                $this->testWarning();
                break;
            case 'info':
                $this->testInfo();
                break;
            case 'all':
            default:
                $this->testAll();
                break;
        }

        $this->newLine();
        $this->info('✅ Testing completed!');

        return Command::SUCCESS;
    }

    private function testStatus()
    {
        $this->info('📊 Checking Electron app status...');

        try {
            $isRunning = DesktopNotification::isRunning();
            $status = DesktopNotification::getStatus();

            if ($isRunning) {
                $this->info('✅ Electron app is running');
                $this->line("Status: " . json_encode($status, JSON_PRETTY_PRINT));
            } else {
                $this->warn('⚠️  Electron app is not running');
                $this->line('Please start the Electron app first: php artisan desktop-notifications:start');
            }
        } catch (\Exception $e) {
            $this->error('❌ Error checking status: ' . $e->getMessage());
        }
    }

    private function testBasic()
    {
        $this->info('📤 Sending basic notification...');

        try {
            DesktopNotification::send(
                'Test Notification',
                'This is a test notification from Laravel Artisan command!'
            );
            $this->info('✅ Basic notification sent successfully');
        } catch (\Exception $e) {
            $this->error('❌ Error sending basic notification: ' . $e->getMessage());
        }
    }

    private function testSuccess()
    {
        $this->info('📤 Sending success notification...');

        try {
            DesktopNotification::success(
                'Success!',
                'This is a success notification test'
            );
            $this->info('✅ Success notification sent successfully');
        } catch (\Exception $e) {
            $this->error('❌ Error sending success notification: ' . $e->getMessage());
        }
    }

    private function testError()
    {
        $this->info('📤 Sending error notification...');

        try {
            DesktopNotification::error(
                'Error!',
                'This is an error notification test'
            );
            $this->info('✅ Error notification sent successfully');
        } catch (\Exception $e) {
            $this->error('❌ Error sending error notification: ' . $e->getMessage());
        }
    }

    private function testWarning()
    {
        $this->info('📤 Sending warning notification...');

        try {
            DesktopNotification::warning(
                'Warning!',
                'This is a warning notification test'
            );
            $this->info('✅ Warning notification sent successfully');
        } catch (\Exception $e) {
            $this->error('❌ Error sending warning notification: ' . $e->getMessage());
        }
    }

    private function testInfo()
    {
        $this->info('📤 Sending info notification...');

        try {
            DesktopNotification::info(
                'Info',
                'This is an info notification test'
            );
            $this->info('✅ Info notification sent successfully');
        } catch (\Exception $e) {
            $this->error('❌ Error sending info notification: ' . $e->getMessage());
        }
    }

    private function testAll()
    {
        $this->info('📤 Sending all types of notifications...');
        $this->newLine();

        $tests = [
            ['Basic', 'basic'],
            ['Success', 'success'],
            ['Error', 'error'],
            ['Warning', 'warning'],
            ['Info', 'info']
        ];

        foreach ($tests as $test) {
            $this->line("Testing {$test[0]} notification...");
            
            try {
                switch ($test[1]) {
                    case 'basic':
                        DesktopNotification::send("Test {$test[0]}", "This is a {$test[1]} notification test");
                        break;
                    case 'success':
                        DesktopNotification::success("Test {$test[0]}", "This is a {$test[1]} notification test");
                        break;
                    case 'error':
                        DesktopNotification::error("Test {$test[0]}", "This is a {$test[1]} notification test");
                        break;
                    case 'warning':
                        DesktopNotification::warning("Test {$test[0]}", "This is a {$test[1]} notification test");
                        break;
                    case 'info':
                        DesktopNotification::info("Test {$test[0]}", "This is a {$test[1]} notification test");
                        break;
                }
                
                $this->info("✅ {$test[0]} notification sent");
                
                // Small delay between notifications
                sleep(1);
            } catch (\Exception $e) {
                $this->error("❌ Error sending {$test[0]} notification: " . $e->getMessage());
            }
        }
    }
} 