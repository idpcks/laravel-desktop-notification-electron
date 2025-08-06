# Contributing to Laravel Desktop Notifications

Thank you for your interest in contributing to Laravel Desktop Notifications! This document provides guidelines and information for contributors.

## 🚀 Getting Started

### Prerequisites

- PHP 8.0 or higher
- Composer
- Node.js 16 or higher
- npm
- Git

### Development Setup

1. **Fork and Clone**
   ```bash
   git clone https://github.com/idpcks/laravel-desktop-notification-electron.git
   cd laravel-desktop-notification-electron
   ```

2. **Install Dependencies**
   ```bash
   # Install PHP dependencies
   composer install
   
   # Install Electron dependencies
   cd electron-app
   npm install
   cd ..
   ```

3. **Setup Laravel Test Project**
   ```bash
   # Create a new Laravel project for testing
   composer create-project laravel/laravel test-laravel
   cd test-laravel
   
   # Install this package locally
   composer require ../laravel-desktop-notification-electron
   ```

## 🧪 Testing

### Running Tests

```bash
# Run PHP tests
composer test

# Test Electron app
cd electron-app
npm test
```

### Manual Testing

1. **Start Electron App**
   ```bash
   cd electron-app
   npm start
   ```

2. **Test Notifications**
   ```bash
   # In your Laravel test project
   php artisan desktop-notifications:test
   ```

## 📝 Code Style

### PHP Code Style

- Follow PSR-12 coding standards
- Use type hints and return types
- Add proper PHPDoc comments
- Keep methods small and focused

### JavaScript Code Style

- Use ES6+ features
- Follow consistent naming conventions
- Add JSDoc comments for functions
- Use meaningful variable names

## 🔧 Development Workflow

### 1. Create Feature Branch

```bash
git checkout -b feature/amazing-feature
```

### 2. Make Changes

- Write your code
- Add tests for new functionality
- Update documentation if needed
- Test thoroughly

### 3. Commit Changes

```bash
git add .
git commit -m "feat: add amazing feature"
```

### 4. Push and Create Pull Request

```bash
git push origin feature/amazing-feature
```

## 📋 Pull Request Guidelines

### Before Submitting

1. **Test Your Changes**
   - Run all tests
   - Test on different platforms (Windows, macOS, Linux)
   - Verify Electron app functionality
   - Test Laravel integration

2. **Update Documentation**
   - Update README.md if needed
   - Add examples for new features
   - Update CHANGELOG.md

3. **Check Code Quality**
   - Follow coding standards
   - Add proper error handling
   - Include meaningful commit messages

### Pull Request Template

```markdown
## Description
Brief description of the changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Testing
- [ ] Tests pass
- [ ] Manual testing completed
- [ ] Cross-platform testing done

## Checklist
- [ ] Code follows style guidelines
- [ ] Self-review completed
- [ ] Documentation updated
- [ ] CHANGELOG.md updated
```

## 🐛 Reporting Bugs

### Bug Report Template

```markdown
## Bug Description
Clear description of the bug

## Steps to Reproduce
1. Step 1
2. Step 2
3. Step 3

## Expected Behavior
What should happen

## Actual Behavior
What actually happens

## Environment
- OS: [Windows/macOS/Linux]
- PHP Version: [version]
- Laravel Version: [version]
- Node.js Version: [version]
- Package Version: [version]

## Additional Information
Screenshots, logs, or other relevant information
```

## 💡 Feature Requests

### Feature Request Template

```markdown
## Feature Description
Clear description of the requested feature

## Use Case
Why this feature is needed

## Proposed Solution
How you think it should be implemented

## Alternatives Considered
Other approaches you've considered

## Additional Information
Any other relevant information
```

## 📚 Documentation

### Updating Documentation

- Keep README.md up to date
- Add examples for new features
- Update installation instructions
- Maintain troubleshooting section

### Code Documentation

- Add PHPDoc comments to all classes and methods
- Include parameter and return type descriptions
- Add usage examples in comments

## 🔒 Security

### Reporting Security Issues

If you discover a security vulnerability, please:

1. **Do not** open a public issue
2. Email security@example.com
3. Provide detailed information about the vulnerability
4. Allow time for response before public disclosure

## 📄 License

By contributing to this project, you agree that your contributions will be licensed under the MIT License.

## 🙏 Acknowledgments

Thank you for contributing to Laravel Desktop Notifications! Your contributions help make this project better for everyone in the Laravel community. 