<?php
session_start();
include "database.php";

// 1. Đổi đường dẫn ra ngoài thư mục webroot (Bảo mật tuyệt đối)
$targer_dir = "/var/www/uploads/";

if (!file_exists($targer_dir)) {
    mkdir($targer_dir, 0777, true);
}

$target_file = $targer_dir . basename($_FILES["fileupload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if ($_FILES["fileupload"]["size"] > 5000000) {
    echo "<script>alert('File quá lớn (Max 5MB)!'); window.location.href='../profile.php';</script>";
    $uploadOk = 0;
}

// 2. MỞ KHÓA TÍNH NĂNG KIỂM TRA ĐUÔI FILE (Defense-in-Depth)
$allowed_types = array('jpg', 'png', 'jpeg', 'gif', 'jfif'); // Đã thêm jfif theo thực tế của bạn
if (!in_array($fileType, $allowed_types)) {
    echo "<script>alert('Chỉ được upload file ảnh!'); window.location.href='../profile.php';</script>";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "<script>alert('Upload thất bại!'); window.location.href='../profile.php';</script>";
} else {
    // 3. Logic lưu DB vẫn giữ nguyên (Chỉ lưu tên file, không lưu đường dẫn)
    if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file)) {
        $filename = basename($_FILES["fileupload"]["name"]);
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
