<?php
session_start();
require_once 'func/connect.php';

// 1. Kiểm tra xem người dùng đã có Session (đã đăng nhập) chưa?
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = null;
$quantity = 1; // Mặc định số lượng là 1

// 2. Bắt dữ liệu thông minh (Hỗ trợ cả POST từ Form và GET từ URL)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    // Nếu nút bấm trên web dùng <form method="POST">
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    if (isset($_POST['quantity'])) {
        $quantity = (int)$_POST['quantity'];
    }
} elseif (isset($_GET['id'])) {
    // Nếu nút bấm trên web dùng thẻ <a href="add_to_cart.php?id=...">
    $product_id = mysqli_real_escape_string($conn, $_GET['id']);
}

// 3. Xử lý "Màn hình trắng": Nếu không có ID sản phẩm thì báo lỗi chứ không đứng im
if ($product_id == null) {
    echo "<script>alert('Lỗi: Không tìm thấy ID sản phẩm được gửi lên!'); window.history.back();</script>";
    exit();
}

// 4. Thực thi chèn vào Database (Gắn mác user_id để chống IDOR)
$sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')";

if (mysqli_query($conn, $sql)) {
    // Dùng JavaScript để chuyển trang (An toàn hơn hàm header() của PHP)
    echo "<script>window.location.href='cart.php';</script>";
} else {
    $error = mysqli_error($conn);
    echo "<script>alert('Lỗi hệ thống CSDL: $error'); window.history.back();</script>";
}
?>
