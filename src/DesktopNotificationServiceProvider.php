<?php

namespace LaravelDesktopNotifications;

use Illuminate\Support\ServiceProvider;
use LaravelDesktopNotifications\Services\DesktopNotificationService;

class DesktopNotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Merge default configuration
        $this->mergeConfigFrom(
            __DIR__.'/../config/desktop-notifications.php', 'desktop-notifications'
        );

        // Register the main service as a singleton
        $this->app->singleton(DesktopNotificationService::class, function ($app) {
            $config = $app['config']->get('desktop-notifications');
            
            return new DesktopNotificationService(
                $config['electron_url'] ?? 'http://localhost:3000',
                $config['timeout'] ?? 5
            );
        });

        // Register facade accessor
        $this->app->alias(DesktopNotificationService::class, 'desktop-notification');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish configuration file
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/desktop-notifications.php' => config_path('desktop-notifications.php'),
            ], 'desktop-notifications-config');

            // Publish Electron app files
            $this->publishes([
                __DIR__.'/../electron-app' => base_path('electron-app'),
            ], 'desktop-notifications-electron');

            // Publish all assets
            $this->publishes([
                __DIR__.'/../config/desktop-notifications.php' => config_path('desktop-notifications.php'),
                __DIR__.'/../electron-app' => base_path('electron-app'),
            ], 'desktop-notifications');

            // Register commands
            $this->commands([
                \LaravelDesktopNotifications\Console\InstallCommand::class,
                \LaravelDesktopNotifications\Console\StartCommand::class,
                \LaravelDesktopNotifications\Console\TestCommand::class,
            ]);
        }

        // Auto-discover facade
        if (!class_exists('DesktopNotification')) {
            class_alias(\LaravelDesktopNotifications\Facades\DesktopNotification::class, 'DesktopNotification');
        }
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [
            DesktopNotificationService::class,
            'desktop-notification',
        ];
    }
} 