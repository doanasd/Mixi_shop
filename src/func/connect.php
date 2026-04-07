<?php
    // 1. Đổi thành tên service database trong file docker-compose.yml
    $servername = "db"; 
    $usname = "root";
    
    // 2. Lấy mật khẩu linh hoạt từ biến môi trường của Docker
    $pass = getenv('DB_PASSWORD'); 
    
    $database = "mixi_shop";

    $conn = new mysqli($servername, $usname, $pass, $database);
    if ($conn->connect_error){
        die("Connection failed: ".$conn->connect_error);
    } 
?>
