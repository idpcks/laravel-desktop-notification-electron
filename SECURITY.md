# Security Policy

## Supported Versions

Use this section to tell people about which versions of your project are currently being supported with security updates.

| Version | Supported          |
| ------- | ------------------ |
| 1.0.x   | :white_check_mark: |
| < 1.0   | :x:                |

## Reporting a Vulnerability

If you discover a security vulnerability within Laravel Desktop Notifications, please send an email to security@example.com. All security vulnerabilities will be promptly addressed.

Please do not create a public GitHub issue for security vulnerabilities.

### What to include in your report

- A clear description of the vulnerability
- Steps to reproduce the issue
- Potential impact of the vulnerability
- Suggested fix (if any)

### Response timeline

- **Initial response**: Within 48 hours
- **Status update**: Within 1 week
- **Fix release**: Within 30 days (depending on severity)

### Responsible disclosure

We follow responsible disclosure practices:

1. **Report privately**: Send security reports to security@example.com
2. **Investigation**: We'll investigate and confirm the vulnerability
3. **Fix development**: We'll develop a fix
4. **Testing**: We'll test the fix thoroughly
5. **Release**: We'll release the fix and credit you (if desired)
6. **Public disclosure**: We'll publicly disclose the vulnerability after the fix is available

### Recognition

Security researchers who responsibly disclose vulnerabilities will be:

- Listed in our security acknowledgments
- Given credit in the release notes
- Offered a place in our security hall of fame

## Security Best Practices

When using this package:

1. **Keep dependencies updated**: Regularly update the package and its dependencies
2. **Use HTTPS**: Always use HTTPS in production environments
3. **Validate input**: Validate all input data before sending notifications
4. **Monitor logs**: Monitor Laravel logs for any suspicious activity
5. **Network security**: Ensure the Electron app is only accessible from trusted sources

## Security Features

This package includes several security features:

- **Input validation**: All notification data is validated
- **Error handling**: Secure error handling prevents information leakage
- **Logging**: Comprehensive logging for security monitoring
- **Timeout protection**: Request timeouts prevent hanging connections

## Contact

For security-related questions or concerns:

- **Email**: security@example.com
- **PGP Key**: [Add your PGP key here if you have one]

## Security Updates

Security updates will be released as patch versions (e.g., 1.0.1, 1.0.2) and will be clearly marked in the changelog. 