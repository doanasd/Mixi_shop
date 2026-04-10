# Sử dụng PHP 7.4 kèm Apache làm nền tảng
FROM php:7.4-apache

# 1. Cài đặt các phần mở rộng MySQL cần thiết cho ứng dụng
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 2. Bật module rewrite của Apache (cần thiết cho các framework/router)
RUN a2enmod rewrite

# 3. Tạo file log cho Honeypot nằm NGOÀI thư mục public của web
# Điều này giúp hacker không thể truy cập trực tiếp file log từ trình duyệt
RUN touch /var/www/honeypot_access.log && \
    chown www-data:www-data /var/www/honeypot_access.log && \
    chmod 664 /var/www/honeypot_access.log

# 4. Copy toàn bộ mã nguồn từ thư mục src vào container
COPY ./src /var/www/html/

# 5. Phân quyền cho thư mục uploads (để demo kịch bản upload shell)
RUN mkdir -p /var/www/html/uploads && \
    chown -R www-data:www-data /var/www/html/uploads && \
    chmod -R 755 /var/www/html/uploads

# Thiết lập thư mục làm việc
WORKDIR /var/www/html

# Expose cổng 80 nội bộ
EXPOSE 80
