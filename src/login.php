<?php
session_start();
require_once 'func/connect.php';

$error_message = ""; // Biến lưu thông báo lỗi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // LƯU Ý BẢO MẬT: Giữ nguyên lỗi SQL Injection theo cấu trúc cũ của bạn để demo
    $name = $_POST['username'];
    $passwd = $_POST['password'];

    if ($name == "" || $passwd == "") {
         $error_message = "Hãy điền đầy đủ thông tin!";
    } else {
        $sql = "SELECT * FROM users WHERE username = '$name' AND password = '$passwd'";
        $rs = $conn->query($sql);

        if ($rs && $rs->num_rows > 0) {
            $row = $rs->fetch_assoc();
            
            // 🔑 LƯU ID VÀO SESSION ĐỂ LIÊN KẾT GIỎ HÀNG VÀ CHỨC NĂNG KHÁC
            $_SESSION['user_id'] = $row['ID']; 
            $_SESSION['username'] = $row['username'];
            
            // Phân quyền chuyển hướng
            if ($row['role'] == "admin") {
                $_SESSION['role'] = "admin";
                echo "<script>
                        alert('Đăng nhập thành công! Chào mừng Admin.');
                        window.location.href='./admin/index.php';
                      </script>";
                exit(); // Bắt buộc phải có exit() để dừng kịch bản
            } else {
                $_SESSION['role'] = "user";
                echo "<script>
                        alert('Đăng nhập thành công!');
                        window.location.href='index.php';
                      </script>";
                exit(); // Bắt buộc phải có exit()
            }
        } else {
            $error_message = "Sai tài khoản hoặc mật khẩu!";
        }
    }
}
?>

<?php include "./page/header.php"; ?>

<main>
    <div class="login-container">
        <form action="" method="post" class="login-form">
            <section class="Login-header">
                <h1>ĐĂNG NHẬP</h1>
            </section>
            
            <?php if(!empty($error_message)): ?>
                <p style="color: red; text-align: center; font-weight: bold; margin-bottom: 15px;">
                    <?php echo $error_message; ?>
                </p>
            <?php endif; ?>

            <input type="text" name="username" placeholder="Tên đăng nhập hoặc email" required>
            <input type="password" name="password" id="password" placeholder="Nhập mật khẩu" required>
            
            <input type="submit" value="ĐĂNG NHẬP">
            
            <h5>
                <a href="dangki.php">Bạn chưa có tài khoản? Đăng ký ngay</a>
            </h5>
        </form>
    </div>
</main>

<?php include "./page/footer.php"; ?>
