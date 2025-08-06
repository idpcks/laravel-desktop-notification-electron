# Support Guide

Thank you for using Laravel Desktop Notifications! This guide will help you get the support you need.

## 🆘 Getting Help

### Before Asking for Help

1. **Check the Documentation**
   - Read the [README.md](README.md) thoroughly
   - Review the [installation guide](INSTALL.md)
   - Check the [examples directory](examples/)

2. **Search Existing Issues**
   - Search [GitHub Issues](https://github.com/idpcks/laravel-desktop-notification-electron/issues)
   - Look for similar problems and solutions

3. **Check Troubleshooting**
   - Review the [troubleshooting section](../README.md#troubleshooting)
   - Check the [upgrading guide](UPGRADING.md)

### How to Ask for Help

When asking for help, please provide:

1. **Environment Details**
   ```
   OS: [Windows/macOS/Linux]
   PHP Version: [e.g., 8.1.0]
   Laravel Version: [e.g., 10.0.0]
   Node.js Version: [e.g., 18.0.0]
   Package Version: [e.g., 1.0.0]
   ```

2. **Error Details**
   - Full error message
   - Stack trace (if applicable)
   - Steps to reproduce

3. **Code Examples**
   - Relevant code snippets
   - Configuration files
   - Log files

4. **What You've Tried**
   - Steps you've already attempted
   - Solutions you've already tried

## 📞 Support Channels

### GitHub Issues
- **Bug Reports**: Use the [bug report template](.github/ISSUE_TEMPLATE/bug_report.md)
- **Feature Requests**: Use the [feature request template](.github/ISSUE_TEMPLATE/feature_request.md)
- **General Questions**: Create a new issue with the "question" label

### Community Support
- **Discussions**: Use [GitHub Discussions](https://github.com/idpcks/laravel-desktop-notification-electron/discussions)
- **Stack Overflow**: Tag questions with `laravel-desktop-notification-electron`

### Direct Contact
- **Email**: support@example.com
- **Response Time**: Within 24-48 hours

## 🐛 Common Issues & Solutions

### Electron App Not Starting
```bash
# Check Node.js installation
node --version
npm --version

# Reinstall dependencies
cd electron-app
rm -rf node_modules package-lock.json
npm install

# Check port availability
netstat -an | grep 3000
```

### Notifications Not Appearing
```bash
# Check if Electron app is running
php artisan desktop-notifications:test --type=status

# Restart Electron app
php artisan desktop-notifications:start --background

# Check notification permissions
# Windows: Settings > System > Notifications
# macOS: System Preferences > Notifications
# Linux: Check notification daemon
```

### Connection Errors
```bash
# Check configuration
php artisan config:show desktop-notifications

# Test connection manually
curl http://localhost:3000/api/status

# Check firewall settings
# Ensure port 3000 is not blocked
```

### Laravel Integration Issues
```bash
# Clear Laravel caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear

# Reinstall package
composer remove laravel-desktop-notification-electron/desktop-notifications
composer require laravel-desktop-notification-electron/desktop-notifications
php artisan desktop-notifications:install --force
```

## 🔧 Debugging

### Enable Debug Mode
```php
// In config/desktop-notifications.php
'logging' => [
    'enabled' => true,
    'channel' => 'daily',
],
```

### Check Logs
```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Electron app logs
# Check the Electron app console window
```

### Test Commands
```bash
# Test all functionality
php artisan desktop-notifications:test

# Test specific components
php artisan desktop-notifications:test --type=status
php artisan desktop-notifications:test --type=success
```

## 📚 Additional Resources

### Documentation
- [Official Documentation](https://github.com/idpcks/laravel-desktop-notification-electron)
- [API Reference](../README.md#api-endpoints)
- [Configuration Options](../README.md#configuration)

### Examples
- [Basic Usage Examples](examples/NotificationController.php)
- [Route Examples](examples/routes-example.php)
- [Quick Start Guide](examples/QUICK_START.md)

### Community
- [GitHub Discussions](https://github.com/idpcks/laravel-desktop-notification-electron/discussions)
- [Stack Overflow](https://stackoverflow.com/questions/tagged/laravel-desktop-notification-electron)

## 🤝 Contributing

If you want to help improve the project:

1. **Report Bugs**: Use the bug report template
2. **Suggest Features**: Use the feature request template
3. **Submit Pull Requests**: Follow the [contributing guidelines](CONTRIBUTING.md)
4. **Improve Documentation**: Submit documentation improvements

## 💰 Commercial Support

For commercial support, enterprise features, or custom development:

- **Email**: enterprise@example.com
- **Response Time**: Within 4-8 hours
- **SLA**: Available for enterprise customers

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

**Need immediate help?** Check our [FAQ](https://github.com/idpcks/laravel-desktop-notification-electron/discussions/categories/faq) or create a [GitHub Issue](https://github.com/idpcks/laravel-desktop-notification-electron/issues/new). 