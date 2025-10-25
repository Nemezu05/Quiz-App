# Base image: PHP + Apache
FROM php:8.2-apache

# Install MySQL server and necessary extensions
RUN apt-get update && \
    apt-get install -y default-mysql-server default-mysql-client && \
    docker-php-ext-install mysqli pdo pdo_mysql && \
    apt-get clean

# Copy project files to web root
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Initialize MySQL database
RUN service mysql start && \
    mysql -e "CREATE DATABASE IF NOT EXISTS quizdb;" && \
    mysql -e "CREATE USER IF NOT EXISTS 'quizuser'@'localhost' IDENTIFIED BY 'quizpass';" && \
    mysql -e "GRANT ALL PRIVILEGES ON quizdb.* TO 'quizuser'@'localhost';" && \
    mysql -e "FLUSH PRIVILEGES;"

# Expose ports
EXPOSE 80 3306

# Start both MySQL and Apache
CMD service mysql start && apache2-foreground
