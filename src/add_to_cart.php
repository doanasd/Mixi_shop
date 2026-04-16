<?php
session_start();

// Kiểm tra xem Session lưu thông tin đăng nhập có tồn tại không
// (Lưu ý: Thay 'user_id' hoặc 'username' bằng đúng tên biến session mà file login.php của bạn đang set)
if (!isset($_SESSION['user_id']) && !isset($_SESSION['username'])) {
    echo "<script>
        alert('Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!');
        window.location.href = 'login.php';
    </script>";
    exit(); // Chặn đứng luồng code, không cho thực thi phần thêm giỏ hàng phía dưới
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $id = $_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    // Khởi tạo giỏ hàng nếu chưa có
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Nếu sản phẩm đã có trong giỏ -> cộng dồn số lượng
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += $quantity;
    } else {
        // Nếu chưa có -> thêm mới
        $_SESSION['cart'][$id] = $quantity;
    }

    // Chuyển hướng về trang giỏ hàng
    echo "<script>alert('Đã thêm vào giỏ hàng!'); window.location.href='cart.php';</script>";
} else {
    header("Location: index.php");
}
?>
