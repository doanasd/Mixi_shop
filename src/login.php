
<?php
include "./page/header.php";

// Xử lý logic đăng nhập khi có dữ liệu POST gửi lên
if (isset($_POST['username']) && isset($_POST['password'])) {
    $name = $_POST['username'];
    $passwd = $_POST['password'];

    if ($name == "" || $passwd == "") {
        echo "<script>alert('Hãy điền đầy đủ thông tin')</script>";
    } else {
        require_once "./func/connect.php";
        
        // LƯU Ý BẢO MẬT: Code này đang dính lỗi SQL Injection do nối chuỗi trực tiếp.
        // Bạn có thể dùng lỗi này để demo tấn công ' OR 1=1 -- 
        $sql = "SELECT * FROM users WHERE username = '$name' AND password = '$passwd'";
        
        $rs = $conn->query($sql);
        if ($rs->num_rows > 0) {
            $_SESSION['username'] = $name;
            $row = $rs->fetch_assoc();
            
            // Phân quyền chuyển hướng
            if ($row['role'] == "admin") {
                $_SESSION['role'] = "admin";
                echo "<script>
                   alert('Đăng nhập thành công! Chào mừng Admin.');
                   window.location.href='./admin/index.php';
                   </script>";
            } else {
                // Mặc định là user
                $_SESSION['role'] = "user";
                echo "<script>
                    alert('Đăng nhập thành công!');
                    window.location.href='index.php';
                    </script>";
            }
        } else {
            echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu!')</script>";
        }
    }
}
?>

<main>
    <div class="login-container">
        <form action="" method="post" class="login-form">
            <section class="Login-header">
                <h1>ĐĂNG NHẬP</h1>
            </section>
            
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