<?php
session_start();
include "database.php";

// 1. Đổi đường dẫn ra ngoài thư mục webroot (Bảo mật tuyệt đối)
$targer_dir = "/var/www/uploads/";

if (!file_exists($targer_dir)) {
    // SỬA LỖI B: Đổi phân quyền từ 0777 (nguy hiểm) thành 0755 (an toàn)
    mkdir($targer_dir, 0755, true);
}

// SỬA LỖI A: Thêm timestamp (thời gian) vào trước tên file để chống ghi đè
$filename = time() . "_" . basename($_FILES["fileupload"]["name"]);
$target_file = $targer_dir . $filename;
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if ($_FILES["fileupload"]["size"] > 5000000) {
    echo "<script>alert('File quá lớn (Max 5MB)!'); window.location.href='../profile.php';</script>";
    $uploadOk = 0;
}

// 2. Kiểm tra đuôi file (Defense-in-Depth)
$allowed_types = array('jpg', 'png', 'jpeg', 'gif', 'jfif');
if (!in_array($fileType, $allowed_types)) {
    echo "<script>alert('Chỉ được upload file ảnh!'); window.location.href='../profile.php';</script>";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "<script>alert('Upload thất bại!'); window.location.href='../profile.php';</script>";
} else {
    // 3. Thực hiện lưu file
    if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file)) {
        // Lưu tên file MỚI (đã có timestamp) vào database
        upload($_SESSION['username'], $filename);
        
        echo "<script>
            alert('Upload thành công! Avatar đã được cập nhật.');
            window.location.href='../profile.php';
        </script>";
    } else {
        echo "<script>alert('Có lỗi khi ghi file lên server!'); window.location.href='../profile.php';</script>";
    }
}
?>
