<?php
session_start();
require_once 'func/connect.php';

// 1. Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Vui lòng đăng nhập để xem giỏ hàng!'); window.location.href='login.php';</script>";
    exit();
}

$current_user_id = $_SESSION['user_id'];

// 2. Lấy dữ liệu Giỏ hàng chuẩn (Bao gồm cả số lượng và ảnh sản phẩm)
$sql = "SELECT cart.id as cart_id, cart.quantity, products.name, products.price, products.img 
        FROM cart 
        JOIN products ON cart.product_id = products.id 
        WHERE cart.user_id = '$current_user_id'";
$result = mysqli_query($conn, $sql);

$total_all = 0; // Biến tính tổng tiền toàn bộ giỏ hàng
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng - Mixi Shop</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS Phục hồi giao diện Giỏ hàng cực đẹp */
        .cart-wrapper {
            max-width: 1000px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .cart-title {
            text-align: center;
            color: #d32f2f; /* Màu đỏ Mixi */
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: bold;
        }
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .cart-table th, .cart-table td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }
        .cart-table th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
        }
        .cart-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
        .btn-delete {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 12px;
            border: 1px solid #e74c3c;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn-delete:hover {
            background-color: #e74c3c;
            color: white;
        }
        .cart-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fdfdfd;
            padding: 20px;
            border: 1px dashed #ccc;
            border-radius: 8px;
        }
        .total-price {
            font-size: 22px;
            color: #d32f2f;
            font-weight: bold;
        }
        .btn-checkout {
            background-color: #d32f2f;
            color: white;
            padding: 12px 30px;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.3s;
            box-shadow: 0 4px 6px rgba(211, 47, 47, 0.3);
        }
        .btn-checkout:hover {
            background-color: #b71c1c;
        }
        .empty-cart {
            text-align: center;
            padding: 50px;
            color: #7f8c8d;
            font-size: 18px;
        }
    </style>
</head>
<body>

    <?php include "./page/header.php"; ?>

    <main>
        <div class="cart-wrapper">
            <h1 class="cart-title">🛒 GIỎ HÀNG CỦA BẠN</h1>

            <?php if (mysqli_num_rows($result) > 0): ?>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): 
                            // Tính thành tiền cho từng sản phẩm
                            $subtotal = $row['price'] * $row['quantity'];
                            $total_all += $subtotal; // Cộng dồn vào tổng hóa đơn
                        ?>
                        <tr>
                            <td><img src="./img/<?php echo $row['img']; ?>" alt="Product Image" class="cart-img" onerror="this.src='./img/default.jpg'"></td>
                            
                            <td style="font-weight: bold;"><?php echo $row['name']; ?></td>
                            <td><?php echo number_format($row['price']); ?> đ</td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td style="color: #e67e22; font-weight: bold;"><?php echo number_format($subtotal); ?> đ</td>
                            
                            <td>
                                <a href="remove_cart.php?id=<?php echo $row['cart_id']; ?>" class="btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <div class="cart-summary">
                    <div class="total-price">
                        Tổng thanh toán: <?php echo number_format($total_all); ?> đ
                    </div>
                    <a href="checkout.php" class="btn-checkout">💳 TIẾN HÀNH THANH TOÁN</a>
                </div>

            <?php else: ?>
                <div class="empty-cart">
                    <img src="./img/empty-cart.png" alt="Empty Cart" style="width: 150px; opacity: 0.5; margin-bottom: 20px;" onerror="this.style.display='none'">
                    <p>Giỏ hàng của bạn đang trống.</p>
                    <a href="index.php" style="color: #d32f2f; text-decoration: none; font-weight: bold;">← Tiếp tục mua sắm</a>
                </div>
            <?php endif; ?>

        </div>
    </main>

    <?php include "./page/footer.php"; ?>

</body>
</html>
