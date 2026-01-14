<?php
session_start();
include "database.php";

// Đường dẫn thư mục chứa file upload
$targer_dir = "../uploads/";

// Kiểm tra nếu thư mục chưa tồn tại thì tạo mới (để tránh lỗi)
if (!file_exists($targer_dir)) {
    mkdir($targer_dir, 0777, true);
}

$target_file = $targer_dir . basename($_FILES["fileupload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// 1. Kiểm tra kích thước file (Cho phép tối đa 5MB)
if ($_FILES["fileupload"]["size"] > 5000000) {
    echo "<script>alert('File quá lớn (Max 5MB)!'); window.location.href='../profile.php';</script>";
    $uploadOk = 0;
}

// 2. [LỖ HỔNG BẢO MẬT] - UNRESTRICTED FILE UPLOAD
// Đoạn code kiểm tra đuôi file đã bị COMMENT (Vô hiệu hóa)
// Hacker có thể upload file .php (webshell) để chiếm quyền điều khiển server.

/* $allowed_types = array('jpg', 'png', 'jpeg', 'gif');
if (!in_array($fileType, $allowed_types)) {
    echo "Chỉ được upload file ảnh";
    $uploadOk = 0;
}
*/

// Tiến hành upload
if ($uploadOk == 0) {
    echo "<script>alert('Upload thất bại!'); window.location.href='../profile.php';</script>";
} else {
    // Di chuyển file từ thư mục tạm sang thư mục uploads
    if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file)) {
        
        $filename = basename($_FILES["fileupload"]["name"]);
        
        // Cập nhật tên file vào database cho user hiện tại
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