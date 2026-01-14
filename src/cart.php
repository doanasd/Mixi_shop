<?php
// Include header (đã có session_start bên trong)
include "./page/header.php";
require_once "./func/database.php";

// Lấy giỏ hàng từ session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total_bill = 0;
?>

<main style="padding: 50px; min-height: 500px;">
    <h2 style="text-align: center; color: #BD0000; margin-bottom: 30px; text-transform: uppercase;">Giỏ hàng của bạn</h2>

    <?php if (count($cart) > 0): ?>
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
                    <?php foreach ($cart as $id => $quantity): 
                        $product = getProductById($id);
                        if ($product):
                            // Tính thành tiền (cho phép số âm để demo lỗi logic)
                            $subtotal = $product['price'] * $quantity;
                            $total_bill += $subtotal;
                    ?>
                    <tr style="text-align: center; border-bottom: 1px solid #ddd;">
                        <td style="padding: 15px; font-weight: bold; color: #333;">
                            <a href="detail.php?id=<?php echo $id; ?>" style="text-decoration: none; color: inherit;">
                                <?php echo $product['name']; ?>
                            </a>
                        </td>
                        <td>
                            <img src="<?php echo $product['image']; ?>" width="60" style="border-radius: 5px;">
                        </td>
                        <td><?php echo formatPrice($product['price']); ?></td>
                        
                        <td style="font-weight: bold; <?php if($quantity < 0) echo 'color: red;'; ?>">
                            <?php echo $quantity; ?>
                        </td>

                        <td style="color: #BD0000; font-weight: bold;">
                            <?php echo formatPrice($subtotal); ?>
                        </td>
                        
                        <td>
                            <a href="remove_cart.php?id=<?php echo $id; ?>" onclick="return confirm('Bạn có chắc muốn xóa?')" style="color: #888;">
                                <i class="fa-solid fa-trash"></i> Xóa
                            </a>
                        </td>
                    </tr>
                    <?php endif; endforeach; ?>
                </tbody>
                <tfoot>
                    <tr style="font-size: 18px; font-weight: bold; background-color: #f2f2f2;">
                        <td colspan="4" style="text-align: right; padding: 20px;">TỔNG THANH TOÁN:</td>
                        <td style="color: #BD0000; padding: 20px; font-size: 20px;">
                            <?php echo formatPrice($total_bill); ?>
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