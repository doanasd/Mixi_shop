<?php
session_start();
require_once 'func/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Tên đăng nhập đã tồn tại!'); window.history.back();</script>";
    } else {
        // Chỉ chèn các trường chúng ta có, các trường khác (fullname, role...) sẽ lấy giá trị NULL/Default đã set ở bước 1
        $sql = "INSERT INTO users (username, password, email, phone) VALUES ('$username', '$password', '$email', '$phone')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Đăng ký thành công!'); window.location.href='login.php';</script>";
        }
    }
}
?>
<?php include "./page/header.php"; ?>
<div class="login-container">
    <form action="dangki.php" method="post" class="login-form">
        <h1>ĐĂNG KÝ</h1>
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Số điện thoại" required>
        <input type="submit" value="ĐĂNG KÝ">
    </form>
</div>
<?php include "./page/footer.php"; ?>
