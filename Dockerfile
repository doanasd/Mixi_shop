FROM php:8.1-apache

# Cài đặt các extension cần thiết cho MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy source code vào container
COPY src/ /var/www/html/

# Phân quyền cho thư mục upload (nếu có)
RUN chown -R www-data:www-data /var/www/html/uploads

EXPOSE 80
