<?php
// Hàm ghi log tấn công
function log_attack() {
    $log_file = __DIR__ . '/../../honeypot_access.log'; // File này sẽ để Wazuh đọc
    
    $timestamp = date("Y-m-d H:i:s");
    $ip = $_SERVER['REMOTE_ADDR'];
    $method = $_SERVER['REQUEST_METHOD'];
    $url = $_SERVER['REQUEST_URI'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
    // Lấy dữ liệu POST (quan trọng để biết hacker nhập gì, password gì, lệnh cmd gì)
    $post_data = "";
    if ($method == 'POST') {
        // Lọc bớt dữ liệu rác nếu cần
        $post_data = " | POST_DATA: " . json_encode($_POST);
    }

    // Format log: [Time] [IP] [Method] [URL] [UserAgent] [PostData]
    $log_entry = "[$timestamp] IP: $ip | $method $url | UA: $user_agent $post_data" . PHP_EOL;

    // Ghi vào file
    file_put_contents($log_file, $log_entry, FILE_APPEND);
}

// Chạy hàm log
log_attack();
?>