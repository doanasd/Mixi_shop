<?php
include "connect.php";

// --- CÁC HÀM CŨ (USER - Giữ nguyên) ---
function profile($name)
{
    global $conn;
    $sql = "SELECT * from users where username = '$name'";
    $rs = $conn->query($sql);
    $row = $rs->fetch_assoc();
    return $row;
}
function upload($name,$file){
    global $conn;
    $sql = "UPDATE users SET avatars = '$file' WHERE username = '$name'";
    $conn->query($sql);
}
function updateProfile($name,$phone,$email,$location,$fullname){
    global $conn;
    $sql = "UPDATE users SET phone = '$phone', email = '$email', location = '$location', fullname = '$fullname' WHERE username = '$name'";
    $conn->query($sql);
}
function users(){
    global $conn;
    $sql = "SELECT * from users where role = 'user'";
    $rs = $conn->query($sql);
    return $rs;
}
function delete($id){
    global $conn;
    $sql = "DELETE FROM users WHERE id = $id";
    $conn->query($sql);
}
function find($name){
    global $conn;
    $sql = "SELECT * from pages where name = '$name'";
    $rs = $conn->query($sql);
    return $rs;
}

// --- CÁC HÀM MỚI (SẢN PHẨM - Dùng cho trang chủ/chi tiết/giỏ hàng) ---

// 1. Lấy danh sách sản phẩm (có tìm kiếm)
function getAllProducts($keyword = "") {
    global $conn;
    $sql = "SELECT * FROM products";
    if ($keyword != "") {
        // Nối chuỗi trực tiếp -> Để demo SQL Injection
        $sql .= " WHERE name LIKE '%" . $keyword . "%'";
    }
    $result = $conn->query($sql);
    $products = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    return $products;
}

// 2. Lấy chi tiết 1 sản phẩm
function getProductById($id) {
    global $conn;
    // Lỗi bảo mật IDOR/SQLi: Không validate ID
    $sql = "SELECT * FROM products WHERE id = " . $id; 
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}

// 3. Lấy 3 sản phẩm MỚI NHẤT
function getNewestProducts() {
    global $conn;
    $sql = "SELECT * FROM products ORDER BY id DESC LIMIT 3";
    $result = $conn->query($sql);
    $list = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $list[] = $row;
        }
    }
    return $list;
}

// 4. Lấy 3 sản phẩm BÁN CHẠY (Random demo)
function getBestSellingProducts() {
    global $conn;
    $sql = "SELECT * FROM products ORDER BY RAND() LIMIT 3";
    $result = $conn->query($sql);
    $list = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $list[] = $row;
        }
    }
    return $list;
}

// 5. Lấy 3 sản phẩm XẾP HẠNG CAO (Random demo)
function getTopRatedProducts() {
    global $conn;
    $sql = "SELECT * FROM products ORDER BY RAND() LIMIT 3";
    $result = $conn->query($sql);
    $list = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $list[] = $row;
        }
    }
    return $list;
}

// 6. Format tiền tệ
function formatPrice($price) {
    return number_format($price, 0, '', '.') . 'đ';
}

// Lấy tất cả tin tức
function getAllNews() {
    global $conn;
    $sql = "SELECT * FROM news ORDER BY created_at DESC";
    $result = $conn->query($sql);
    $list = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $list[] = $row;
        }
    }
    return $list;
}

// Lấy chi tiết tin tức theo ID
function getNewsById($id) {
    global $conn;
    // Vẫn để lỗ hổng SQL Injection ở đây nếu bạn muốn demo sau này
    $sql = "SELECT * FROM news WHERE id = " . $id;
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}

// --- CHỨC NĂNG BÌNH LUẬN ---

// Hàm thêm bình luận
function addComment($username, $content) {
    global $conn;
    
    // BƯỚC 1: Xử lý ký tự đặc biệt để tránh lỗi SQL Injection (tránh bị crash)
    // Hàm này sẽ thêm dấu \ trước dấu ' (ví dụ: ' thành \') để SQL hiểu đó là văn bản
    $content = mysqli_real_escape_string($conn, $content);
    
    // BƯỚC 2: Lưu vào DB
    // LƯU Ý: Dù đã escape lỗi SQL, nhưng chúng ta VẪN KHÔNG dùng htmlspecialchars()
    // nên mã <script> vẫn được lưu nguyên vẹn -> Lỗ hổng Stored XSS vẫn còn đó.
    $sql = "INSERT INTO comments (username, content) VALUES ('$username', '$content')";
    
    $conn->query($sql);
}

// Hàm lấy danh sách bình luận
function getComments() {
    global $conn;
    $sql = "SELECT * FROM comments ORDER BY created_at DESC";
    $result = $conn->query($sql);
    $list = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $list[] = $row;
        }
    }
    return $list;
}

?>

