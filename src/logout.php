<?php
session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit(); // Thiếu dòng này là nguyên nhân chính gây lag trạng thái đăng xuất
?>
