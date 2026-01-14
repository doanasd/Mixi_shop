<?php 
include dirname(__DIR__) . "/func/logger.php";
// Kiểm tra session để tránh lỗi start 2 lần
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mixi Shop</title>
    <link rel="shortcut icon" href="img/download.jfif" type="image/x-icon">
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <header>
        <section class="header-top">
            <section class="hidden">
                <h3>CHÀO MỪNG ĐẾN VỚI MIXI SHOP</h3>
            </section>
            <section class="content-header-sub">
                <div class="left">
                    <a href="#">Giới thiệu </a>
                    <a href="#">Cửa hàng </a>
                    <a href="#"> Blog</a>
                    <a href="#"> Liên hệ</a>
                </div>
                <div class="right">
                    <i class="fa-brands fa-facebook" style="color: #ffffff;"></i>
                    <i class="fa-brands fa-instagram" style="color: #ffffff;"></i>
                    <i class="fa-brands fa-twitter" style="color: #ffffff;"></i>
                </div>
            </section>
        </section>
        <section class="header__main">
            <section class="none">
                <i class="fa-solid fa-bars fa-xl" style="color: #c62d2d;"></i>
            </section>
            <section class="image">
                 <a href="index.php"><img src="img/logo_mixue-removebg-preview.png" alt="" style="height: 50px;"></a>
            </section>
            
            <section class="search">
                <form action="index.php" method="get" style="margin: 0; padding: 0; border: none;background: none;color: inherit;">
                    <input type="text" name="q" placeholder="Tìm đồ uống..." value="<?php echo isset($_GET['q']) ? $_GET['q'] : ''; ?>">
                    <button type="submit" class="submit-btn" style="background-color: transparent; border: none; cursor: pointer;">
                        <i class="fa-solid fa-magnifying-glass fa-xl" style="color: #8c8c8c; font-size: 24px;"></i>
                    </button>
                </form>
            </section>

            <section class="icon">
                <a href="<?php if (isset($_SESSION['username']) && $_SESSION['username'] != null) echo "profile.php";
                            else echo "login.php"; ?>">
                    <i class="fa-solid fa-user fa-xl" style="color: #c62d2d;"></i>
                </a>
                <a href="cart.php">
                    <i class="fa-solid fa-cart-shopping fa-xl" style="color: #c62d2d;"></i>
                    
                </a>
                <span style="color: #c62d2d; font-weight: bold;">
                        (<?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>)
                    </span>
            </section>
        </section>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">TRANG CHỦ</a></li>
            <li><a href="gioithieu.php">GIỚI THIỆU</a></li>
            <li><a href="menu.php">MENU</a></li>
            <li><a href="tintuc.php">TIN TỨC</a></li>
            <li><a href="lienhe.php">LIÊN HỆ</a></li>
        </ul>
    </nav>