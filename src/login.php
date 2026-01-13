<?php
include "./page/header.php";
if (isset($_POST['username']) && isset($_POST['password'])) {
    $name = $_POST['username'];
    $passwd = $_POST['password'];

    if ($name == "" || $passwd == "") {
        echo "<script>alert('Hãy điền đầy đủ thông tin')</script>";
    } else {
        require_once "./func/connect.php";
        $sql = "SELECT * FROM users WHERE username = '$name' AND password = '$passwd'";
        $rs = $conn->query($sql);
        if ($rs->num_rows > 0) {
            $_SESSION['username'] = $name;
            $row = $rs->fetch_assoc();
            if ($row['role'] == "admin") {
                $_SESSION['role'] = "admin";
                echo "<script>
                   alert('Đăng nhập thành công');
                   window.location.href='./admin/index.php';
                   </script>";
            } else {
                if ($row['role'] == "user") {
                    $_SESSION['role'] = "user";
                    echo "<script>
                    alert('Đăng nhập thành công');
                    window.location.href='index.php';
                    </script>";
                }
            }
        } else {
            echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu')</script>";
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
            <h1>ĐĂNG NHẬP</h1>
        </section>
        <input type="text" name="username" placeholder="Tên đăng nhập hoặc email">
        <br>
        <input type="password" name="password" id="" placeholder="Nhập mật khẩu">
        <br>
        <h5><a href="dangki.php" style="text-decoration: none;padding-top: 50px;">Don't have account?</a></h5>
        <br>
        <input type="submit" value="ĐĂNG NHẬP">
        <br>
        <!-- <p>Bạn đã có tài khoản?</p> -->

    </form>
</main>
<?php include "./page/footer.php"; ?>