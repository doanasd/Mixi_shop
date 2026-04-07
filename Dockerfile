FROM php:8.1-apache

# Cài đặt các extension cần thiết cho MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy source code vào container
COPY src/ /var/www/html/

# Tạo thư mục uploads (nếu chưa có) và phân quyền cho web server
RUN mkdir -p /var/www/html/uploads && \
    chown -R www-data:www-data /var/www/html/uploads

EXPOSE 80
