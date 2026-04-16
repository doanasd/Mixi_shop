<?php
require_once 'func/connect.php'; // Gọi file kết nối DB của bạn

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nhận dữ liệu từ form (giả sử input name là username và password)
    $username = $_POST['username'];
    $password = $_POST['password']; 
    
    // 1. Kiểm tra xem tên đăng nhập đã bị ai lấy chưa
    $check_sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Tên đăng nhập này đã tồn tại! Vui lòng chọn tên khác.'); window.history.back();</script>";
    } else {
        // 2. Thực hiện thêm user mới
        // (Nếu hệ thống của bạn dùng md5 thì đổi thành md5($password))
        $insert_sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        
        if (mysqli_query($conn, $insert_sql)) {
            echo "<script>alert('Đăng ký thành công! Chào mừng bạn đến với Mixi Shop.'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra: " . mysqli_error($conn) . "'); window.history.back();</script>";
        }
    }
}
?>

<main>
    <div class="login-container">
        <form action="" method="post" class="login-form">
            <section class="Login-header">
                <h1>ĐĂNG KÝ TÀI KHOẢN</h1>
            </section>
            
            <input type="text" name="username" placeholder="Tên đăng nhập" required>
            
            <input type="password" name="password" placeholder="Mật khẩu" required>
            
            <input type="password" name="passwd" placeholder="Nhập lại mật khẩu" required>
            
            <input type="email" name="email" placeholder="Email" required>
            
            <input type="text" name="phone" placeholder="Số điện thoại" required>
            
            <input type="submit" value="ĐĂNG KÝ">
            
            <h5>
                <a href="login.php">Bạn đã có tài khoản? Đăng nhập ngay</a>
            </h5>
        </form>
    </div>
</main>

<?php include "./page/footer.php"; ?>
