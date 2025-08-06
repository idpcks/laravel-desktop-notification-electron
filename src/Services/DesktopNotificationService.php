<?php

namespace LaravelDesktopNotifications\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class DesktopNotificationService
{
    protected Client $httpClient;
    protected string $electronUrl;
    protected int $timeout;

    public function __construct(string $electronUrl, int $timeout = 5)
    {
        $this->electronUrl = rtrim($electronUrl, '/');
        $this->timeout = $timeout;
        
        $this->httpClient = new Client([
            'timeout' => $this->timeout,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * Send a notification to the desktop
     */
    public function send(array $data): bool
    {
        try {
            $response = $this->httpClient->post($this->electronUrl . '/api/notifications', [
                'json' => $this->prepareNotificationData($data),
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            
            if ($result && isset($result['success']) && $result['success']) {
                Log::info('Desktop notification sent successfully', [
                    'title' => $data['title'] ?? 'Unknown',
                    'method' => $result['method'] ?? 'unknown'
                ]);
                return true;
            }

            Log::warning('Desktop notification failed', [
                'title' => $data['title'] ?? 'Unknown',
                'response' => $result
            ]);
            return false;

        } catch (RequestException $e) {
            Log::error('Desktop notification request failed', [
                'title' => $data['title'] ?? 'Unknown',
                'error' => $e->getMessage(),
                'url' => $this->electronUrl
            ]);
            return false;
        } catch (\Exception $e) {
            Log::error('Desktop notification error', [
                'title' => $data['title'] ?? 'Unknown',
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Send a success notification
     */
    public function success(string $title, string $message, array $options = []): bool
    {
        return $this->send(array_merge($options, [
            'title' => $title,
            'message' => $message,
            'type' => 'success'
        ]));
    }

    /**
     * Send an error notification
     */
    public function error(string $title, string $message, array $options = []): bool
    {
        return $this->send(array_merge($options, [
            'title' => $title,
            'message' => $message,
            'type' => 'error'
        ]));
    }

    /**
     * Send a warning notification
     */
    public function warning(string $title, string $message, array $options = []): bool
    {
        return $this->send(array_merge($options, [
            'title' => $title,
            'message' => $message,
            'type' => 'warning'
        ]));
    }

    /**
     * Send an info notification
     */
    public function info(string $title, string $message, array $options = []): bool
    {
        return $this->send(array_merge($options, [
            'title' => $title,
            'message' => $message,
            'type' => 'info'
        ]));
    }

    /**
     * Check if the Electron app is running
     */
    public function isRunning(): bool
    {
        try {
            $response = $this->httpClient->get($this->electronUrl . '/api/status', [
                'timeout' => 2,
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            return $result && isset($result['isReady']) && $result['isReady'];

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get the status of the Electron app
     */
    public function getStatus(): ?array
    {
        try {
            $response = $this->httpClient->get($this->electronUrl . '/api/status');
            return json_decode($response->getBody()->getContents(), true);

        } catch (\Exception $e) {
            Log::error('Failed to get Electron app status', [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Prepare notification data for sending
     */
    protected function prepareNotificationData(array $data): array
    {
        $defaults = [
            'title' => 'Laravel Notification',
            'message' => '',
            'type' => 'info',
            'silent' => false,
            'sound' => true,
            'icon' => null,
            'url' => null,
            'timestamp' => now()->toISOString(),
        ];

        return array_merge($defaults, $data);
    }

    /**
     * Get the Electron app URL
     */
    public function getElectronUrl(): string
    {
        return $this->electronUrl;
    }

    /**
     * Set the Electron app URL
     */
    public function setElectronUrl(string $url): void
    {
        $this->electronUrl = rtrim($url, '/');
    }
} 