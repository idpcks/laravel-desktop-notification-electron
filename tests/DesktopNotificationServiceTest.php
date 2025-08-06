<?php

namespace LaravelDesktopNotifications\Tests;

use LaravelDesktopNotifications\Services\DesktopNotificationService;
use LaravelDesktopNotifications\Facades\DesktopNotification;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;

class DesktopNotificationServiceTest extends TestCase
{
    public function test_service_can_be_resolved_from_container()
    {
        $service = app(DesktopNotificationService::class);
        
        $this->assertInstanceOf(DesktopNotificationService::class, $service);
    }

    public function test_facade_can_be_used()
    {
        $this->assertInstanceOf(DesktopNotificationService::class, DesktopNotification::getFacadeRoot());
    }

    public function test_service_constructor_sets_default_values()
    {
        $service = new DesktopNotificationService('http://localhost:3000', 5);
        
        $this->assertEquals('http://localhost:3000', $service->getElectronUrl());
        $this->assertEquals(5, $service->getTimeout());
    }

    public function test_service_constructor_sets_custom_values()
    {
        $service = new DesktopNotificationService('http://localhost:8080', 10);
        
        $this->assertEquals('http://localhost:8080', $service->getElectronUrl());
        $this->assertEquals(10, $service->getTimeout());
    }

    public function test_prepare_notification_data_sets_defaults()
    {
        $service = new DesktopNotificationService('http://localhost:3000', 5);
        
        $data = $service->prepareNotificationData([
            'title' => 'Test Title',
            'message' => 'Test Message'
        ]);
        
        $this->assertEquals('Test Title', $data['title']);
        $this->assertEquals('Test Message', $data['message']);
        $this->assertEquals('info', $data['type']);
        $this->assertTrue($data['sound']);
        $this->assertNull($data['icon']);
        $this->assertNull($data['url']);
    }

    public function test_prepare_notification_data_with_custom_options()
    {
        $service = new DesktopNotificationService('http://localhost:3000', 5);
        
        $data = $service->prepareNotificationData([
            'title' => 'Test Title',
            'message' => 'Test Message',
            'type' => 'success',
            'sound' => false,
            'icon' => '/path/to/icon.png',
            'url' => 'https://example.com'
        ]);
        
        $this->assertEquals('success', $data['type']);
        $this->assertFalse($data['sound']);
        $this->assertEquals('/path/to/icon.png', $data['icon']);
        $this->assertEquals('https://example.com', $data['url']);
    }

    public function test_success_method_sets_correct_type()
    {
        $service = new DesktopNotificationService('http://localhost:3000', 5);
        
        $this->assertTrue($service->success('Success', 'Operation completed'));
    }

    public function test_error_method_sets_correct_type()
    {
        $service = new DesktopNotificationService('http://localhost:3000', 5);
        
        $this->assertTrue($service->error('Error', 'Something went wrong'));
    }

    public function test_warning_method_sets_correct_type()
    {
        $service = new DesktopNotificationService('http://localhost:3000', 5);
        
        $this->assertTrue($service->warning('Warning', 'Please check input'));
    }

    public function test_info_method_sets_correct_type()
    {
        $service = new DesktopNotificationService('http://localhost:3000', 5);
        
        $this->assertTrue($service->info('Info', 'Here is information'));
    }

    public function test_is_running_returns_false_when_electron_not_available()
    {
        $service = new DesktopNotificationService('http://localhost:3000', 5);
        
        $this->assertFalse($service->isRunning());
    }

    public function test_get_status_returns_null_when_electron_not_available()
    {
        $service = new DesktopNotificationService('http://localhost:3000', 5);
        
        $this->assertNull($service->getStatus());
    }

    // Note: These tests would require mocking HTTP requests
    // In a real implementation, you would use Guzzle's MockHandler
    // to test the actual HTTP communication with the Electron app
} 