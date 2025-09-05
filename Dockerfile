# Use official PHP Apache image
FROM php:8.2-apache

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY simple-sms.html /var/www/html/
COPY send-sms.php /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Configure Apache virtual host
RUN echo '<VirtualHost *:80>' > /etc/apache2/sites-available/000-default.conf
RUN echo '    DocumentRoot /var/www/html' >> /etc/apache2/sites-available/000-default.conf
RUN echo '    <Directory /var/www/html>' >> /etc/apache2/sites-available/000-default.conf
RUN echo '        Options Indexes FollowSymLinks' >> /etc/apache2/sites-available/000-default.conf
RUN echo '        AllowOverride All' >> /etc/apache2/sites-available/000-default.conf
RUN echo '        Require all granted' >> /etc/apache2/sites-available/000-default.conf
RUN echo '    </Directory>' >> /etc/apache2/sites-available/000-default.conf
RUN echo '    ErrorLog ${APACHE_LOG_DIR}/error.log' >> /etc/apache2/sites-available/000-default.conf
RUN echo '    CustomLog ${APACHE_LOG_DIR}/access.log combined' >> /etc/apache2/sites-available/000-default.conf
RUN echo '</VirtualHost>' >> /etc/apache2/sites-available/000-default.conf

# Create .htaccess file for better file access
RUN echo 'DirectoryIndex simple-sms.html' > /var/www/html/.htaccess
RUN echo 'Options -Indexes' >> /var/www/html/.htaccess

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
