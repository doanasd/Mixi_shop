<?php
session_start();
require_once 'func/connect.php'; // Gọi file kết nối DB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nhận toàn bộ dữ liệu từ form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; 
    $passwd = $_POST['passwd']; // Mật khẩu nhập lại
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    
    // Kiểm tra mật khẩu nhập lại có khớp không
    if ($password !== $passwd) {
        echo "<script>alert('Mật khẩu nhập lại không khớp!'); window.history.back();</script>";
    } else {
        // Kiểm tra xem tên đăng nhập đã bị ai lấy chưa
        $check_sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $check_sql);
        
        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('Tên đăng nhập này đã tồn tại! Vui lòng chọn tên khác.'); window.history.back();</script>";
        } else {
            // Thực hiện thêm user mới (Bao gồm cả email và phone)
            // *Lưu ý: Nếu database bảng users của bạn không có cột email, phone thì xóa 2 trường đó đi trong câu lệnh INSERT nhé.
            $insert_sql = "INSERT INTO users (username, password, email, phone) VALUES ('$username', '$password', '$email', '$phone')";
            
            if (mysqli_query($conn, $insert_sql)) {
                echo "<script>alert('Đăng ký thành công! Chào mừng bạn đến với Mixi Shop.'); window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra: " . mysqli_error($conn) . "'); window.history.back();</script>";
            }
        }
    }
}
?>

<?php include "./page/header.php"; ?> <main>
    <div class="login-container">
        <form action="dangki.php" method="post" class="login-form">
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
