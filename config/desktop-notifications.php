<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Electron App Configuration
    |--------------------------------------------------------------------------
    |
    | This is the URL where your Electron app is running. The Laravel
    | application will send notifications to this URL.
    |
    */
    'electron_url' => env('DESKTOP_NOTIFICATION_URL', 'http://localhost:3000'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | Timeout in seconds for HTTP requests to the Electron app.
    |
    */
    'timeout' => env('DESKTOP_NOTIFICATION_TIMEOUT', 5),

    /*
    |--------------------------------------------------------------------------
    | Default Notification Settings
    |--------------------------------------------------------------------------
    |
    | Default settings for notifications sent from Laravel.
    |
    */
    'defaults' => [
        'type' => 'info',
        'silent' => false,
        'sound' => true,
        'icon' => null,
        'url' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Types
    |--------------------------------------------------------------------------
    |
    | Available notification types and their default settings.
    |
    */
    'types' => [
        'success' => [
            'icon' => null,
            'sound' => true,
            'silent' => false,
        ],
        'error' => [
            'icon' => null,
            'sound' => true,
            'silent' => false,
        ],
        'warning' => [
            'icon' => null,
            'sound' => true,
            'silent' => false,
        ],
        'info' => [
            'icon' => null,
            'sound' => false,
            'silent' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | Whether to log notification attempts and results.
    |
    */
    'logging' => [
        'enabled' => env('DESKTOP_NOTIFICATION_LOGGING', true),
        'level' => env('DESKTOP_NOTIFICATION_LOG_LEVEL', 'info'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto-start Electron App
    |--------------------------------------------------------------------------
    |
    | Whether to automatically start the Electron app if it's not running.
    | This requires the Electron app to be installed and accessible.
    |
    */
    'auto_start' => env('DESKTOP_NOTIFICATION_AUTO_START', false),

    /*
    |--------------------------------------------------------------------------
    | Electron App Path
    |--------------------------------------------------------------------------
    |
    | Path to the Electron app executable. Used when auto_start is enabled.
    |
    */
    'electron_path' => env('DESKTOP_NOTIFICATION_APP_PATH', null),
]; 