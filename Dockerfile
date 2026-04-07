FROM php:8.1-apache

# Cài đặt các extension cần thiết cho MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy source code vào container
COPY src/ /var/www/html/

# Tạo thư mục uploads, TẠO SẴN file log honeypot và cấp quyền cho www-data
RUN mkdir -p /var/www/html/uploads && \
    touch /var/www/honeypot_access.log && \
    chown -R www-data:www-data /var/www/html/uploads /var/www/honeypot_access.log

EXPOSE 80
