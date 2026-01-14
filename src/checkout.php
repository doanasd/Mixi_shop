<?php
session_start();
include "./page/header.php";

// Kiểm tra xem có submit form sang không
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['final_total'])) {
    
    // --- LỖ HỔNG Ở ĐÂY ---
    // Server tin tưởng tuyệt đối giá trị client gửi lên
    $amount_to_pay = $_POST['final_total']; 
    
    // Giả lập lưu đơn hàng vào DB (Code demo)
    $message = "Thanh toán thành công!";
    $color = "green";

    // Xóa giỏ hàng sau khi thanh toán
    unset($_SESSION['cart']);
} else {
    // Nếu vào trực tiếp thì đá về trang chủ
    echo "<script>window.location.href='index.php';</script>";
    exit;
}
?>

<main style="padding: 100px; text-align: center;">
    <div style="background: white; padding: 50px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); display: inline-block;">
        
        <i class="fa-regular fa-circle-check" style="font-size: 80px; color: <?php echo $color; ?>; margin-bottom: 20px;"></i>
        
        <h2 style="color: <?php echo $color; ?>; margin-bottom: 20px;"><?php echo $message; ?></h2>
        
        <p style="font-size: 18px; margin-bottom: 30px;">
            Số tiền bạn đã thanh toán: 
            <b style="color: #BD0000; font-size: 24px;">
                <?php echo number_format($amount_to_pay, 0, '', '.'); ?>đ
            </b>
        </p>

        <p>Cảm ơn bạn đã mua hàng tại Mixue!</p>
        <br>
        <a href="index.php" style="text-decoration: none; color: blue;">Quay về trang chủ</a>
    </div>
</main>

<?php include "./page/footer.php"; ?>