# Development Dockerfile for Laravel Desktop Notifications

FROM node:18-alpine

# Install system dependencies
RUN apk add --no-cache \
    php81 \
    php81-fpm \
    php81-curl \
    php81-json \
    php81-mbstring \
    php81-openssl \
    php81-phar \
    php81-dom \
    php81-xml \
    php81-xmlwriter \
    php81-tokenizer \
    composer

# Set working directory
WORKDIR /app

# Copy package files
COPY package*.json ./
COPY composer.json ./

# Install dependencies
RUN npm install
RUN composer install --no-dev --optimize-autoloader

# Copy source code
COPY . .

# Install Electron app dependencies
RUN cd electron-app && npm install

# Expose ports
EXPOSE 3000

# Start the application
CMD ["npm", "start"] 