<?php
session_start();
require_once 'func/connect.php';

// Kiểm tra xem có nhận được ID của sản phẩm trong giỏ hàng cần xóa từ URL không (?id=...)
if (isset($_GET['id'])) {
    $cart_item_id = mysqli_real_escape_string($conn, $_GET['id']);

    // 🔴 [LỖ HỔNG IDOR NẰM Ở ĐÂY] 🔴
    // Lệnh SQL chỉ xóa dựa vào tham số `id` được truyền trên thanh địa chỉ (URL).
    // Hệ thống KHÔNG hề kiểm tra xem `$cart_item_id` này có thuộc về $_SESSION['user_id'] đang đăng nhập hay không.
    // Dẫn đến việc Hacker chỉ cần đổi ID trên URL là xóa được hàng của người khác!
    
    $sql = "DELETE FROM cart WHERE id = '$cart_item_id'";

    if (mysqli_query($conn, $sql)) {
        // Xóa thành công, quay về trang giỏ hàng
        echo "<script>window.location.href='cart.php';</script>";
    } else {
        echo "<script>alert('Lỗi xóa: " . mysqli_error($conn) . "'); window.location.href='cart.php';</script>";
    }
} else {
    // Nếu truy cập thẳng mà không có ?id=
    echo "<script>window.location.href='cart.php';</script>";
}
?>
