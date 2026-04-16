<?php
session_start();
require_once 'func/connect.php';

// Kiểm tra xem có nhận được ID của sản phẩm trong giỏ hàng cần xóa không
if (isset($_GET['id'])) {
    $cart_item_id = $_GET['id'];

    // 🔴 [LỖ HỔNG IDOR NẰM Ở ĐÂY] 🔴
    // Lệnh SQL chỉ xóa dựa vào id truyền trên URL.
    // Nó KHÔNG kiểm tra xem cái id giỏ hàng đó có thuộc về người đang đăng nhập hay không.
    $sql = "DELETE FROM cart WHERE id = '$cart_item_id'";

    /* 👉 [MẸO CHO BẠN KHI THUYẾT TRÌNH]: 
    Nếu code an toàn (Secure Code), câu lệnh trên bắt buộc phải là:
    $sql = "DELETE FROM cart WHERE id = '$cart_item_id' AND user_id = '" . $_SESSION['user_id'] . "'";
    */

    if (mysqli_query($conn, $sql)) {
        echo "<script>window.location.href='cart.php';</script>";
    } else {
        echo "Lỗi xóa: " . mysqli_error($conn);
    }
}
?>
