// File: src/debug_url.php
<?php
if (isset($_GET['url'])) {
    $url = $_GET['url'];
    // Lỗ hổng: Không kiểm tra URL đầu vào, cho phép gọi đến IP nội bộ Cloud
    echo file_get_contents($url); 
}
?>
