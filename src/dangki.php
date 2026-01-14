<?php
include "./page/header.php";

// Xử lý logic đăng ký
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['passwd']) && isset($_POST['email']) && isset($_POST['phone'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwd = $_POST['passwd'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = "user";

    // Kiểm tra rỗng
    if ($username == "" || $password == "" || $passwd == "" || $email == "" || $phone == "") {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin!');</script>";
    } else {
        // Kiểm tra mật khẩu nhập lại
        if ($password != $passwd) {
            echo "<script>alert('Mật khẩu nhập lại không khớp!');</script>";
        } else {
            require_once "./func/connect.php";
            
            // Kiểm tra xem username đã tồn tại chưa (Optional - Code thêm cho chặt chẽ)
            $check_sql = "SELECT * FROM users WHERE username = '$username'";
            if($conn->query($check_sql)->num_rows > 0){
                echo "<script>alert('Tên đăng nhập đã tồn tại!');</script>";
            } else {
                // LỖ HỔNG SQL INJECTION: Vẫn giữ nguyên việc nối chuỗi trực tiếp để bạn demo
                $sql = "INSERT INTO users (username, password, email, phone, role) VALUES ('$username', '$password', '$email', '$phone', '$role')";
                
                if ($conn->query($sql)) {
                    // Đăng ký thành công -> Tự động đăng nhập luôn
                    $_SESSION['role'] = 'user';
                    $_SESSION['username'] = $username;
                    
                    echo "<script>
                        alert('Đăng ký thành công! Chào mừng bạn đến với Mixue.');
                        window.location.href='index.php';
                        </script>";
                } else {
                    echo "<script>alert('Lỗi đăng ký: " . $conn->error . "');</script>";
                }
            }
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