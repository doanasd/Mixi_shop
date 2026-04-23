<?php
    // 1. Đổi thành tên service database trong file docker-compose.yml
    $servername = "mixishop-db-server.cpokqmmuq5tj.ap-southeast-1.rds.amazonaws.com";
    $username = "admin";
    
    // 2. Lấy mật khẩu linh hoạt từ biến môi trường của Docker
    $pass = getenv('DB_PASSWORD'); 
    
    $database = "mixi_shop";

    $conn = new mysqli($servername, $usname, $pass, $database);
    if ($conn->connect_error){
        die("Connection failed: ".$conn->connect_error);
    } 
?>
