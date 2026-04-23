<?php
// Lấy thông tin từ biến môi trường mà Docker Compose đã truyền vào
$servername = getenv('DB_HOST') ?: "mixishop-db-server.cpokqmmuq5tj.ap-southeast-1.rds.amazonaws.com";
$username = getenv('DB_USERNAME') ?: "admin";
$dbname = getenv('DB_NAME') ?: "mixi_shop";
$password = getenv('DB_PASSWORD'); // Mật khẩu bí mật từ Jenkins

// Kiểm tra nếu password trống (để debug)
if (!$password) {
    die("Lỗi: Không tìm thấy mật khẩu Database trong biến môi trường.");
}

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
