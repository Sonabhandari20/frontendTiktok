# Use the official PHP image with Apache
FROM php:8.0-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy the frontend and PHP code to the container
COPY . /var/www/html

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Expose the port the container listens on
EXPOSE 80

# Start the Apache server
CMD ["apache2-foreground"]
