<?php
session_start();
include "./page/header.php";
require_once "./func/database.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $product = getProductById($id);
} else {
    echo "Sản phẩm không tồn tại!";
    exit;
}
?>

<main style="padding: 50px;">
    <?php if ($product): ?>
        <div style="display: flex; justify-content: center; gap: 50px; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            
            <div style="width: 400px;">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" style="width: 100%; border-radius: 10px;">
            </div>

            <div style="width: 500px;">
                <h2 style="color: #BD0000; margin-bottom: 20px;"><?php echo $product['name']; ?></h2>
                <h3 style="color: #333; margin-bottom: 20px;">Giá: <?php echo number_format($product['price'], 0, '', '.'); ?>đ</h3>
                
                <p style="margin-bottom: 30px; line-height: 1.6;">
                    <?php echo isset($product['description']) ? $product['description'] : "Mô tả đang cập nhật..."; ?>
                </p>

                <form action="add_to_cart.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <label for="quantity">Số lượng:</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" style="padding: 10px; width: 60px; margin-right: 20px;">
                    
                    <button type="submit" style="background-color: #BD0000; color: white; padding: 10px 20px; border: none; font-weight: bold; cursor: pointer;">
                        THÊM VÀO GIỎ HÀNG <i class="fa-solid fa-cart-plus"></i>
                    </button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <h3 style="text-align: center;">Sản phẩm không tìm thấy!</h3>
    <?php endif; ?>
</main>

<?php include "./page/footer.php"; ?>