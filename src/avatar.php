<?php
session_start();

// Chỉ cho phép user đã đăng nhập xem ảnh (Chống lộ lọt dữ liệu)
if (!isset($_SESSION['username'])) {
    header("HTTP/1.0 403 Forbidden");
    exit;
}

$filename = isset($_GET['img']) ? $_GET['img'] : '';

// BẢO MẬT: Dùng basename() để chống tấn công Path Traversal (vd: ?img=../../../etc/passwd)
$filename = basename($filename); 
$path = "/var/www/uploads/" . $filename;

// Nếu file tồn tại trong thư mục an toàn ngoài webroot
if ($filename != '' && file_exists($path)) {
    // Trả về Header là ảnh để trình duyệt hiểu
    $mime = mime_content_type($path);
    header("Content-Type: " . $mime);
    readfile($path);
} else {
    // Nếu không có ảnh, trả về ảnh mặc định
    header("Content-Type: image/jpeg");
    readfile(__DIR__ . "/img/download.jfif");
}
?>
