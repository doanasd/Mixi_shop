<?php
session_start();
require_once 'func/connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Chỉ lấy username và password để đảm bảo an toàn cho cấu trúc DB cũ
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; 
    
    // Kiểm tra trùng lặp
    $check_sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Tên đăng nhập đã tồn tại!'); window.history.back();</script>";
    } else {
        // CÂU LỆNH RÚT GỌN: Chỉ chèn username và password
        $insert_sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        
        if (mysqli_query($conn, $insert_sql)) {
            echo "<script>alert('Đăng ký thành công!'); window.location.href='login.php';</script>";
        } else {
            // Dòng này cực kỳ quan trọng để debug
            echo "Lỗi hệ thống: " . mysqli_error($conn); 
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
