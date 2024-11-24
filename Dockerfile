# Base image with PHP and Apache
FROM php:8.2-apache

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copy application code into the container
COPY . /var/www/html/

# Set the working directory
WORKDIR /var/www/html/

# Adjust permissions for the application
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Expose port 80 for Apache
EXPOSE 80
