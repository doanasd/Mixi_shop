<?php
session_start();
require_once 'func/connect.php';

if (isset($_GET['id'])) {
    $cart_id = mysqli_real_escape_string($conn, $_GET['id']);

    // 🔴 LỖ HỔNG IDOR: Chỉ xóa theo ID truyền lên, không check user_id
    // Hacker chỉ cần đổi ?id= thành số khác là xóa được hàng của người khác
    $sql = "DELETE FROM cart WHERE id = '$cart_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: cart.php");
    }
}
?>
