<?php 
include "./page/header.php"; 
require_once "./func/database.php"; 

$products = getAllProducts(); // Lấy tất cả sản phẩm
?>

<main>
    <section class="title">
        <b></b>
        <h3>THỰC ĐƠN</h3>
        <b></b>
    </section>
    
    <section class="content">
        <?php if(count($products) > 0): ?>
            <?php foreach ($products as $item): ?>
            <section class="product">
                <div class="hover-image">
                    <a href="detail.php?id=<?php echo $item['id']; ?>">
                        <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                    </a>
                    <div class="hover-product">
                        <a href="detail.php?id=<?php echo $item['id']; ?>" style="text-decoration: none; color: white;">
                            <h3>XEM NGAY</h3>
                        </a>
                    </div>
                </div>
                <p>Mixue</p>
                <h6>
                    <a href="detail.php?id=<?php echo $item['id']; ?>" style="text-decoration: none; color: black;">
                        <?php echo $item['name']; ?>
                    </a>
                </h6>
                <strong><?php echo formatPrice($item['price']); ?></strong>
            </section>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; width: 100%;">Chưa có sản phẩm nào.</p>
        <?php endif; ?>
    </section>
</main>

<?php include "./page/footer.php"; ?>