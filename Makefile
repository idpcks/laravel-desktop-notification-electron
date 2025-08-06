# Makefile for Laravel Desktop Notifications

.PHONY: help install test build start dev clean

help: ## Show this help message
	@echo 'Usage: make [target]'
	@echo ''
	@echo 'Targets:'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  %-15s %s\n", $$1, $$2}' $(MAKEFILE_LIST)

install: ## Install all dependencies
	@echo "Installing PHP dependencies..."
	composer install
	@echo "Installing Node.js dependencies..."
	npm install
	@echo "Installing Electron app dependencies..."
	cd electron-app && npm install

test: ## Run all tests
	@echo "Running PHP tests..."
	composer test
	@echo "Running Electron app tests..."
	cd electron-app && npm test

build: ## Build the Electron app
	@echo "Building Electron app..."
	cd electron-app && npm run build

start: ## Start the Electron app
	@echo "Starting Electron app..."
	cd electron-app && npm start

dev: ## Start in development mode
	@echo "Starting in development mode..."
	cd electron-app && npm run dev

clean: ## Clean build artifacts
	@echo "Cleaning build artifacts..."
	rm -rf dist/
	rm -rf build/
	rm -rf electron-app/dist/
	rm -rf electron-app/build/
	rm -rf electron-app/out/

docker-build: ## Build Docker image
	@echo "Building Docker image..."
	docker build -t laravel-desktop-notification-electron .

docker-run: ## Run with Docker
	@echo "Running with Docker..."
	docker run -p 3000:3000 laravel-desktop-notification-electron

docker-compose-up: ## Start with Docker Compose
	@echo "Starting with Docker Compose..."
	docker-compose up -d

docker-compose-down: ## Stop Docker Compose
	@echo "Stopping Docker Compose..."
	docker-compose down

format: ## Format code with Prettier
	@echo "Formatting code..."
	npx prettier --write "**/*.{js,json,md,html}"

lint: ## Lint code
	@echo "Linting code..."
	npx eslint electron-app/**/*.js || true

package: ## Create distribution package
	@echo "Creating distribution package..."
	composer archive --format=zip --dir=dist/

release: ## Prepare for release
	@echo "Preparing for release..."
	make clean
	make install
	make test
	make build
	make package 