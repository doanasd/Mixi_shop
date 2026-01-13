<?php
session_start();
include "database.php";
$targer_dir = "../uploads/";
$target_file = $targer_dir . basename($_FILES["fileupload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
/*if (file_exists($target_file)) {
    echo "File đã tồn tại";
    $uploadOk = 0;
}*/
if ($_FILES["fileupload"]["size"] > 5000000) {
    echo "File quá lớn";
    $uploadOk = 0;
}
$allowed_types = array('jpg', 'png', 'jpeg', 'gif');
if (!in_array($fileType, $allowed_types)) {
    echo "Chỉ được upload file ảnh";
    $uploadOk = 0;
}
if ($uploadOk == 0) {
    echo "Upload không thành công";
} else {
    if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file)) {
        $filename=basename($_FILES["fileupload"]["name"]);
        upload($_SESSION['username'],$filename);
        echo "<script>
            alert('upload thanh cong');
            window.location.href='../profile.php';
        </script>";

    } else {
        echo "Upload không thành công";
    }
}
?>