<?php

namespace LaravelDesktopNotifications\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use LaravelDesktopNotifications\DesktopNotificationServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            DesktopNotificationServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        // Setup desktop notifications config
        $app['config']->set('desktop-notifications.electron_url', 'http://localhost:3000');
        $app['config']->set('desktop-notifications.timeout', 5);
    }
} 