# Base image with PHP and Apache
FROM php:8.2-apache

# Update the package manager and install required PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip && \
    docker-php-ext-install pdo pdo_mysql mysqli && \
    docker-php-ext-enable pdo_mysql mysqli && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy application code into the container
COPY . /var/www/html/

# Set the working directory
WORKDIR /var/www/html/

# Adjust permissions for the application
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Enable Apache rewrite module (optional, but common for PHP apps)
RUN a2enmod rewrite

# Expose port 80 for Apache
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
