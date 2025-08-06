<?php

namespace LaravelDesktopNotifications\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool send(array $data)
 * @method static bool success(string $title, string $message, array $options = [])
 * @method static bool error(string $title, string $message, array $options = [])
 * @method static bool warning(string $title, string $message, array $options = [])
 * @method static bool info(string $title, string $message, array $options = [])
 * @method static bool isRunning()
 * @method static array|null getStatus()
 * @method static string getElectronUrl()
 * @method static void setElectronUrl(string $url)
 * 
 * @see \LaravelDesktopNotifications\Services\DesktopNotificationService
 */
class DesktopNotification extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'desktop-notification';
    }
} 