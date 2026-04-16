<?php
session_start();
require_once 'func/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; 
    
    $check_sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($result) > 0) {
        $error = "Tên đăng nhập này đã tồn tại! Vui lòng chọn tên khác.";
    } else {
        $insert_sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if (mysqli_query($conn, $insert_sql)) {
            echo "<script>alert('Đăng ký thành công! Chào mừng đến với Mixi Shop.'); window.location.href='login.php';</script>";
        } else {
            $error = "Lỗi hệ thống: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký - Mixi Shop</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS dự phòng giúp form hiển thị ngay ngắn */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; margin: 0; }
        .register-container { max-width: 450px; margin: 60px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .register-container h2 { text-align: center; color: #2c3e50; margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: bold; color: #34495e; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #cbd5e0; border-radius: 6px; box-sizing: border-box; transition: border-color 0.3s; }
        .form-group input:focus { border-color: #e74c3c; outline: none; }
        .btn-submit { width: 100%; padding: 12px; background-color: #e74c3c; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: bold; transition: background 0.3s; }
        .btn-submit:hover { background-color: #c0392b; }
        .error-msg { color: #e74c3c; text-align: center; margin-bottom: 15px; font-weight: bold; }
        .login-link { text-align: center; margin-top: 20px; color: #7f8c8d; }
        .login-link a { color: #e74c3c; text-decoration: none; font-weight: bold; }
        .login-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <?php include 'page/header.php'; ?>

    <div class="register-container">
        <h2>Tạo tài khoản Mixi Shop</h2>
        
        <?php if(isset($error)) { echo "<div class='error-msg'>$error</div>"; } ?>

        <form action="dangki.php" method="POST">
            <div class="form-group">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" id="username" name="username" placeholder="Nhập tên đăng nhập..." required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu..." required>
            </div>
            <button type="submit" class="btn-submit">Đăng ký ngay</button>
        </form>
        
        <div class="login-link">
            Đã có tài khoản? <a href="login.php">Đăng nhập tại đây</a>
        </div>
    </div>

    <?php include 'page/footer.php'; ?>
</body>
</html>
