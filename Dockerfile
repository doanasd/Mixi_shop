# Sử dụng PHP 7.4 kèm Apache làm nền tảng
FROM php:7.4-apache

# 1. Cài đặt các phần mở rộng MySQL cần thiết
# Bổ sung lệnh dọn dẹp bộ nhớ tạm để giảm kích thước Image
RUN docker-php-ext-install mysqli pdo pdo_mysql && \
    docker-php-source delete

# 2. Bật module rewrite của Apache
RUN a2enmod rewrite

# 3. Tạo file log cho Honeypot nằm NGOÀI thư mục public
RUN touch /var/www/honeypot_access.log && \
    chown www-data:www-data /var/www/honeypot_access.log && \
    chmod 664 /var/www/honeypot_access.log

# 4. Thiết lập thư mục làm việc trước khi copy
WORKDIR /var/www/html

# 5. Copy mã nguồn (Sử dụng .dockerignore để loại bỏ rác nếu có)
COPY ./src /var/www/html/

# 6. Phân quyền chặt chẽ cho toàn bộ thư mục web
# Sau đó nới lỏng riêng cho thư mục uploads
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html && \
    mkdir -p /var/www/html/uploads && \
    chmod -R 775 /var/www/html/uploads

# Expose cổng 80
EXPOSE 80
