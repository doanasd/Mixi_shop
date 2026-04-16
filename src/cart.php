<?php
// 1. Phải gọi session_start() trước tiên để kiểm tra đăng nhập
session_start();
require_once 'func/connect.php';

// Kiểm tra đăng nhập (Bảo mật lớp 1)
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Vui lòng đăng nhập để xem giỏ hàng!'); window.location.href='login.php';</script>";
    exit();
}

$current_user_id = $_SESSION['user_id'];

// 2. Gọi file header (Giao diện)
include "./page/header.php";

// 3. Truy vấn lấy Giỏ hàng TỪ DATABASE (Thay vì Session như code gốc)
// Dùng products.* để lấy tất cả các cột, tránh lỗi sai tên cột
$sql = "SELECT cart.id as cart_id, cart.quantity, products.* FROM cart 
        JOIN products ON cart.product_id = products.id 
        WHERE cart.user_id = '$current_user_id'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Lỗi truy vấn Database: " . mysqli_error($conn));
}

$total_bill = 0; // Biến tính tổng tiền
?>

<main style="padding: 50px; min-height: 500px;">
    <h2 style="text-align: center; color: #BD0000; margin-bottom: 30px; text-transform: uppercase;">Giỏ hàng của bạn</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div style="max-width: 1000px; margin: 0 auto;">
            
            <table style="width: 100%; border-collapse: collapse; background: white; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                <thead>
                    <tr style="background-color: #BD0000; color: white;">
                        <th style="padding: 15px;">Sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Duyệt từng sản phẩm trong Database
                    while ($row = mysqli_fetch_assoc($result)): 
                        // Tính thành tiền
                        $subtotal = $row['price'] * $row['quantity'];
                        $total_bill += $subtotal;
                    ?>
                    <tr style="text-align: center; border-bottom: 1px solid #ddd;">
                        <td style="padding: 15px; font-weight: bold; color: #333;">
                            <a href="detail.php?id=<?php echo $row['product_id']; ?>" style="text-decoration: none; color: inherit;">
                                <?php echo $row['name']; ?>
                            </a>
                        </td>
                        <td>
                            <img src="<?php echo $row['image']; ?>" width="60" style="border-radius: 5px;" onerror="this.src='./img/default.jpg'">
                        </td>
                        
                        <td><?php echo number_format($row['price']); ?> đ</td>
                        
                        <td style="font-weight: bold; <?php if($row['quantity'] < 0) echo 'color: red;'; ?>">
                            <?php echo $row['quantity']; ?>
                        </td>

                        <td style="color: #BD0000; font-weight: bold;">
                            <?php echo number_format($subtotal); ?> đ
                        </td>
                        
                        <td>
                            <a href="remove_cart.php?id=<?php echo $row['cart_id']; ?>" onclick="return confirm('Bạn có chắc muốn xóa?')" style="color: #888;">
                                <i class="fa-solid fa-trash"></i> Xóa
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
                <tfoot>
                    <tr style="font-size: 18px; font-weight: bold; background-color: #f2f2f2;">
                        <td colspan="4" style="text-align: right; padding: 20px;">TỔNG THANH TOÁN:</td>
                        <td style="color: #BD0000; padding: 20px; font-size: 20px;">
                            <?php echo number_format($total_bill); ?> đ
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <div style="text-align: center; margin-top: 40px;">
                <a href="index.php" style="padding: 15px 30px; border: 1px solid #BD0000; color: #BD0000; text-decoration: none; border-radius: 5px; margin-right: 20px; font-weight: bold;">
                    <i class="fa-solid fa-arrow-left"></i> TIẾP TỤC MUA
                </a>
                
                <form action="checkout.php" method="POST" style="display: inline-block;">
                    <input type="hidden" name="final_total" value="<?php echo $total_bill; ?>">
                    
                    <button type="submit" style="background-color: #BD0000; color: white; padding: 15px 40px; border: none; font-weight: bold; border-radius: 5px; cursor: pointer; transition: 0.3s;">
                        THANH TOÁN NGAY <i class="fa-solid fa-credit-card"></i>
                    </button>
                </form>
             </div>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 50px;">
            <i class="fa-solid fa-cart-arrow-down" style="font-size: 60px; color: #ddd; margin-bottom: 20px;"></i>
            <p style="font-size: 18px; color: #666;">Giỏ hàng của bạn đang trống.</p>
            <br>
            <a href="index.php" style="color: #BD0000; font-weight: bold; text-decoration: none; font-size: 16px;">
                Quay lại trang chủ mua sắm ngay
            </a>
        </div>
    <?php endif; ?>
</main>

<?php include "./page/footer.php"; ?>
