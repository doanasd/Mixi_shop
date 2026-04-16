<?php
session_start();
require_once 'func/connect.php';

// Chặn nếu chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Vui lòng đăng nhập để mua hàng!'); window.location.href='login.php';</script>";
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_SESSION['user_id']; // Lấy ID từ session
    $product_id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Lưu món hàng kèm theo user_id để phân biệt chủ sở hữu
    $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', 1)";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: cart.php");
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>
