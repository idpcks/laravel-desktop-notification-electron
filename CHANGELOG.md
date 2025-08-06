# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2024-01-01

### Added
- Initial release of Laravel Desktop Notifications package
- Electron app for displaying desktop notifications
- Laravel service provider with auto-discovery
- Facade for easy usage
- Artisan commands for installation, starting, and testing
- Support for multiple notification types (success, error, warning, info)
- Customizable notification appearance and behavior
- HTTP API for communication between Laravel and Electron
- Cross-platform support (Windows, macOS, Linux)
- Queue and event integration support
- Comprehensive documentation and examples

### Features
- Simple installation with `composer require`
- Auto-installation script with `php artisan desktop-notifications:install`
- Background Electron app startup
- Notification sound support
- Custom icons and URLs
- Configurable timeout and logging
- Fallback to native notifications
- Status checking and monitoring

### Technical Details
- Built with Electron for desktop application
- Express.js HTTP server for API
- GuzzleHttp for HTTP communication
- Laravel service provider pattern
- PSR-4 autoloading
- MIT license 