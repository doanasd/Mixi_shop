<?php session_start(); ?>
<!DOCTYPE php>
<php lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Boycbs</title>
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
                    <h3>ADD ANYTHING HERE OR JUST REMOVE IT...</h3>
                </section>
                <section class="content-header-sub">
                    <div class="left">
                        <a href="#">About </a>
                        <a href="#">Our Stores </a>
                        <a href="#"> Blog</a>
                        <a href="#"> Contact</a>
                        <a href="#"> FAQ</a>
                    </div>
                    <div class="right">
                        <i class="fa-brands fa-facebook" style="color: #ffffff;"></i>
                        <i class="fa-brands fa-instagram" style="color: #ffffff;"></i>
                        <i class="fa-brands fa-twitter" style="color: #ffffff;"></i>
                        <i class="fa-regular fa-envelope" style="color: #ffffff;"></i>
                    </div>
                </section>
            </section>
            <section class="header__main">
                <section class="none">
                    <i class="fa-solid fa-bars fa-xl" style="color: #c62d2d;"></i>
                </section>
                <section class="image">                </section>
                <section class="search">
                    <form action="./admin/finded.php" method="post" style="margin: 0; padding: 0; border: none;background: none;color: inherit;">
                        <input type="text" name="finded" placeholder="Tìm kiếm">
                        <button type="submit" class="submit-btn" style="background-color: transparent; border: none; cursor: pointer;">
                            <i class="fa-solid fa-magnifying-glass fa-xl" style="color: #8c8c8c; font-size: 24px;"></i>
                        </button>
                    </form>
                </section>

                <section class="icon">
                    <a href="<?php if (isset($_SESSION['username']) && $_SESSION['username'] != null) echo "profile.php";
                                else echo "login.php"; ?>"><i class="fa-solid fa-user fa-xl" style="color: #c62d2d;"></i></a>
                    <a href=""><i class="fa-solid fa-cart-shopping fa-xl" style="color: #c62d2d;"></i></a>
                </section>
            </section>
        </header>