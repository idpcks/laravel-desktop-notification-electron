<?php

namespace LaravelDesktopNotifications\Tests\Console;

use LaravelDesktopNotifications\Tests\TestCase;
use LaravelDesktopNotifications\Console\InstallCommand;
use Illuminate\Support\Facades\File;

class InstallCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Clean up any existing files
        if (File::exists(config_path('desktop-notifications.php'))) {
            File::delete(config_path('desktop-notifications.php'));
        }
        
        if (File::exists(base_path('electron-app'))) {
            File::deleteDirectory(base_path('electron-app'));
        }
        
        if (File::exists(base_path('examples'))) {
            File::deleteDirectory(base_path('examples'));
        }
    }

    public function test_install_command_creates_config_file()
    {
        $this->artisan(InstallCommand::class)
            ->expectsOutput('🚀 Installing Laravel Desktop Notifications...')
            ->expectsOutput('✅ Configuration file installed: config/desktop-notifications.php')
            ->assertExitCode(0);

        $this->assertTrue(File::exists(config_path('desktop-notifications.php')));
    }

    public function test_install_command_creates_electron_app_directory()
    {
        $this->artisan(InstallCommand::class)
            ->expectsOutput('✅ Created electron-app directory')
            ->assertExitCode(0);

        $this->assertTrue(File::exists(base_path('electron-app')));
    }

    public function test_install_command_creates_example_files()
    {
        $this->artisan(InstallCommand::class)
            ->expectsOutput('✅ Created example controller: examples/NotificationController.php')
            ->expectsOutput('✅ Created routes example: examples/routes-example.php')
            ->expectsOutput('✅ Created quick start guide: examples/QUICK_START.md')
            ->assertExitCode(0);

        $this->assertTrue(File::exists(base_path('examples/NotificationController.php')));
        $this->assertTrue(File::exists(base_path('examples/routes-example.php')));
        $this->assertTrue(File::exists(base_path('examples/QUICK_START.md')));
    }

    public function test_install_command_with_force_option()
    {
        // First install
        $this->artisan(InstallCommand::class)->assertExitCode(0);
        
        // Second install with force
        $this->artisan(InstallCommand::class, ['--force' => true])
            ->expectsOutput('✅ Configuration file installed: config/desktop-notifications.php')
            ->assertExitCode(0);
    }

    public function test_install_command_with_skip_deps_option()
    {
        $this->artisan(InstallCommand::class, ['--skip-deps' => true])
            ->expectsOutput('🚀 Installing Laravel Desktop Notifications...')
            ->expectsOutput('✅ Configuration file installed: config/desktop-notifications.php')
            ->expectsOutput('✅ Created electron-app directory')
            ->assertExitCode(0);
    }

    protected function tearDown(): void
    {
        // Clean up
        if (File::exists(config_path('desktop-notifications.php'))) {
            File::delete(config_path('desktop-notifications.php'));
        }
        
        if (File::exists(base_path('electron-app'))) {
            File::deleteDirectory(base_path('electron-app'));
        }
        
        if (File::exists(base_path('examples'))) {
            File::deleteDirectory(base_path('examples'));
        }
        
        parent::tearDown();
    }
} 