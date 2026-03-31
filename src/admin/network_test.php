// File: src/admin/network_test.php
<?php
if (isset($_POST['host'])) {
    $host = $_POST['host'];
    // Lỗ hổng: Nối chuỗi trực tiếp vào lệnh hệ thống
    shell_exec("ping -c 4 " . $host);
}
?>
