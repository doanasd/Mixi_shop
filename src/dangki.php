<?php
include "./page/header.php";
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['passwd']) && isset($_POST['email']) && isset($_POST['phone'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwd = $_POST['passwd'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role= "user";
    if ($username == "" || $password == "" || $passwd == "" || $email == "" || $phone == "") {
        echo "<script>alert('Hãy điền đầy đủ thông tin')</script>";
    } else {
        if ($_POST['password'] != $_POST['passwd']) {
            echo "<script>alert('mật khẩu không trùng khớp')</script>";
        } else {
            require_once "./func/connect.php";
            $sql = "INSERT INTO users (username,password,email,phone,role) VALUES ('$username','$password','$email','$phone','$role')";
            $rs = $conn->query($sql);
            if ($rs){
                $_SESSION['role']='user';
                $_SESSION['username']=$username;
                echo "<script>
                    alert('Đăng kí thành công');
                    window.location.href='index.php';
                    </script>";
            }
        }
    } 
}
?>
    <nav>
        <ul>
            <li>
                <a href="index.php">TRANG CHỦ</a>
            </li>
            <li>
                <a href="gioithieu.php">GIỚI THIỆU</a>
            </li>
            <li>
                <a href="menu.php">MENU</a>
            </li>
            <li>
                <a href="">TIN TỨC</a>
            </li>
            <li>
                <a href="lienhe.php">LIÊN HỆ</a>
            </li>
        </ul>
    </nav>

    <main>
        <form action="" method="post">
            <section class="Login-header">
                <h1>ĐĂNG KÍ</h1>
            </section>
            <input type="text" name="username" placeholder="Tên đăng nhập hoặc email">
            <br>
            <input type="password" name="password" id="" placeholder="Nhập mật khẩu">
            <br>
            <input type="password" name="passwd" id="" placeholder="Nhập lại mật khẩu">
            <br>
            <input type="text" name="email" placeholder="Email">
            <br>
            <input type="text" name="phone" placeholder="Số điện thoại">
            <br>
            <h5><a href="login.php" style="text-decoration: none;padding-top: 50px;">Create acount</a></h5>
            <br>
            <input type="submit" value="ĐĂNG KÍ">
            <br>
            <!-- <p>Bạn đã có tài khoản?</p> -->

        </form>
    </main>
    <?php include "./page/footer.php"; ?>