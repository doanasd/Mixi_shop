<?php
session_start();

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