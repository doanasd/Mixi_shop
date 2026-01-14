<?php 
// Header đã có session_start()
include "./page/header.php";
require_once "./func/database.php";

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

// Lấy thông tin user
// Nếu có tham số GET 'user' (IDOR vulnerability potential) thì lấy theo đó, nếu không lấy của chính mình
if (isset($_GET['user'])) {
    $name = $_GET['user'];
    $row = profile($name); // Cần đảm bảo hàm profile() trong database.php lấy theo username
} else {
    $name = $_SESSION['username'];
    $row = profile($name);
}

// Xử lý ảnh đại diện mặc định nếu chưa có
$avatar_path = !empty($row['avatars']) ? "./uploads/" . $row['avatars'] : "img/download.jfif";
?>

<main style="padding: 50px 0;">
    <div style="width: 90%; max-width: 1000px; margin: 0 auto; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1); display: flex; gap: 50px;">
        
        <div style="width: 30%; text-align: center;">
            <div style="width: 200px; height: 200px; margin: 0 auto 20px; overflow: hidden; border-radius: 50%; border: 5px solid #eee;">
                <img src="<?php echo $avatar_path; ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            
            <h2 style="margin-bottom: 20px; color: #BD0000;"><?php echo $row['username']; ?></h2>

            <form action="./func/upload.php" method="post" enctype="multipart/form-data" style="background: #f9f9f9; padding: 15px; border-radius: 5px;">
                <label style="display: block; margin-bottom: 10px; font-weight: bold; color: #555;">Đổi ảnh đại diện:</label>
                <input type="file" name="fileupload" style="width: 100%; margin-bottom: 10px; font-size: 13px;">
                <button type="submit" style="background: #BD0000; color: white; border: none; padding: 8px 15px; border-radius: 3px; cursor: pointer; width: 100%;">
                    <i class="fa-solid fa-upload"></i> Tải lên
                </button>
            </form>
        </div>

        <div style="flex: 1;">
            <h3 style="border-bottom: 2px solid #BD0000; padding-bottom: 10px; margin-bottom: 25px; color: #333;">Thông tin cá nhân</h3>
            
            <form action="./admin/update.php" method="post">
                <input type="hidden" name="username" value="<?php echo $row['username']; ?>">

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Họ và tên:</label>
                    <input type="text" name="fullname" value="<?php echo $row['fullname']; ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Số điện thoại:</label>
                    <input type="text" name="phone" value="<?php echo $row['phone']; ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Email:</label>
                    <input type="email" name="email" value="<?php echo $row['email']; ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Địa chỉ:</label>
                    <input type="text" name="location" value="<?php echo $row['location']; ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                </div>

                <div style="margin-top: 30px; display: flex; gap: 15px;">
                    <button type="submit" style="background: #28a745; color: white; border: none; padding: 12px 30px; border-radius: 5px; font-weight: bold; cursor: pointer;">
                        <i class="fa-solid fa-check"></i> Lưu thay đổi
                    </button>
                    
                    <a href="logout.php" style="background: #6c757d; color: white; padding: 12px 30px; border-radius: 5px; font-weight: bold; text-decoration: none;">
                        <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                    </a>
                    
                    <?php if($_SESSION['role'] == 'admin'): ?>
                    <a href="./admin/index.php" style="background: #007bff; color: white; padding: 12px 30px; border-radius: 5px; font-weight: bold; text-decoration: none;">
                        <i class="fa-solid fa-gear"></i> Trang quản trị
                    </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</main>

<style>
    @media (max-width: 768px) {
        main > div {
            flex-direction: column;
        }
        main > div > div {
            width: 100% !important;
        }
    }
</style>

<?php include "./page/footer.php"; ?>