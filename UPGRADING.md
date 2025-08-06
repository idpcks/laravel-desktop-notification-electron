# Upgrading Laravel Desktop Notifications

This guide will help you upgrade Laravel Desktop Notifications to newer versions.

## Upgrading to 1.0.0

### Breaking Changes

- **Namespace Change**: The package namespace has been updated to `LaravelDesktopNotifications`
- **Service Provider**: The service provider class name has changed
- **Configuration**: Configuration structure has been updated

### Migration Steps

1. **Update Package**
   ```bash
   composer update laravel-desktop-notification-electron/desktop-notifications
   ```

2. **Update Service Provider Registration**
   
   In `config/app.php`, update the provider registration:
   ```php
   'providers' => [
       // Old
       // App\Providers\DesktopNotificationServiceProvider::class,
       
       // New
       LaravelDesktopNotifications\DesktopNotificationServiceProvider::class,
   ],
   ```

3. **Update Facade Alias**
   
   In `config/app.php`, update the facade alias:
   ```php
   'aliases' => [
       // Old
       // 'DesktopNotification' => App\Facades\DesktopNotification::class,
       
       // New
       'DesktopNotification' => LaravelDesktopNotifications\Facades\DesktopNotification::class,
   ],
   ```

4. **Update Usage in Code**
   
   Update your imports:
   ```php
   // Old
   use App\Facades\DesktopNotification;
   
   // New
   use LaravelDesktopNotifications\Facades\DesktopNotification;
   ```

5. **Update Configuration**
   
   The configuration structure has been updated. Run:
   ```bash
   php artisan vendor:publish --provider="LaravelDesktopNotifications\DesktopNotificationServiceProvider" --force
   ```

6. **Reinstall Electron App**
   ```bash
   php artisan desktop-notifications:install --force
   ```

### New Features

- **Artisan Commands**: New commands for installation, starting, and testing
- **Auto-Discovery**: Package now supports Laravel's auto-discovery
- **Better Error Handling**: Improved error handling and logging
- **Enhanced Configuration**: More configuration options available

## General Upgrade Guidelines

### Before Upgrading

1. **Backup Your Project**
   ```bash
   # Backup your entire project
   cp -r your-project your-project-backup
   
   # Backup your database
   php artisan backup:run
   ```

2. **Check Compatibility**
   - Review the changelog for breaking changes
   - Check Laravel version compatibility
   - Verify PHP version requirements

3. **Test in Development**
   - Test the upgrade in a development environment first
   - Run all your tests
   - Test notification functionality

### During Upgrade

1. **Update Dependencies**
   ```bash
   composer update laravel-desktop-notification-electron/desktop-notifications
   ```

2. **Run Migration Commands**
   ```bash
   # Publish new configuration
   php artisan vendor:publish --provider="LaravelDesktopNotifications\DesktopNotificationServiceProvider"
   
   # Reinstall Electron app if needed
   php artisan desktop-notifications:install --force
   ```

3. **Clear Caches**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   ```

### After Upgrade

1. **Test Functionality**
   ```bash
   # Test notifications
   php artisan desktop-notifications:test
   
   # Check status
   php artisan desktop-notifications:test --type=status
   ```

2. **Update Code**
   - Update any deprecated method calls
   - Update configuration usage
   - Update import statements

3. **Monitor Logs**
   - Check Laravel logs for any errors
   - Monitor notification delivery
   - Verify Electron app functionality

## Version Compatibility

| Package Version | Laravel Version | PHP Version | Node.js Version |
|----------------|----------------|-------------|-----------------|
| 1.0.0          | 8.0 - 11.x     | 8.0+        | 16.0+           |

## Troubleshooting Upgrades

### Common Issues

1. **Service Provider Not Found**
   ```bash
   # Clear autoload cache
   composer dump-autoload
   
   # Clear Laravel caches
   php artisan config:clear
   php artisan cache:clear
   ```

2. **Configuration Errors**
   ```bash
   # Republish configuration
   php artisan vendor:publish --provider="LaravelDesktopNotifications\DesktopNotificationServiceProvider" --force
   ```

3. **Electron App Issues**
   ```bash
   # Reinstall Electron app
   php artisan desktop-notifications:install --force
   
   # Check Node.js version
   node --version
   npm --version
   ```

4. **Notification Not Working**
   ```bash
   # Test connection
   php artisan desktop-notifications:test --type=status
   
   # Restart Electron app
   php artisan desktop-notifications:start --background
   ```

### Getting Help

If you encounter issues during upgrade:

1. Check the [troubleshooting section](../README.md#troubleshooting)
2. Review the [changelog](../CHANGELOG.md)
3. Search existing issues on GitHub
4. Create a new issue with detailed information

## Rollback Plan

If you need to rollback:

1. **Restore Backup**
   ```bash
   # Restore project files
   cp -r your-project-backup/* your-project/
   
   # Restore database if needed
   php artisan backup:restore
   ```

2. **Downgrade Package**
   ```bash
   composer require laravel-desktop-notification-electron/desktop-notifications:^0.9.0
   ```

3. **Clear Caches**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   composer dump-autoload
   ```

## Support

For upgrade support:

- Check the documentation
- Review the changelog
- Search existing issues
- Create a new issue with upgrade details 