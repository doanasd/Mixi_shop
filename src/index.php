<?php 
include "./page/header.php"; 
require_once "./func/database.php"; 

// Lấy từ khóa tìm kiếm từ URL
$keyword = isset($_GET['q']) ? $_GET['q'] : "";

// Gọi hàm lấy sản phẩm (đã viết ở các bước trước)
// Lưu ý: Hàm này trong database.php cũng đang dính SQL Injection nếu bạn chưa sửa
$products = getAllProducts($keyword); 

// Các hàm lấy sản phẩm phụ
$newest_products = getNewestProducts();
$best_selling_products = getBestSellingProducts();
$top_rated_products = getTopRatedProducts();
?>

    <main>
        <?php if($keyword): ?>
            <div style="text-align: center; margin-top: 20px; color: #333;">
                <h3>Kết quả tìm kiếm cho: 
                    <span style="color: red; font-weight: bold;">
                        <?php echo $keyword; ?> 
                    </span>
                </h3>
            </div>
        <?php endif; ?>
        <section class="title">
            <b></b>
            <h3>DANH SÁCH SẢN PHẨM</h3>
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
                <p style="width: 100%; text-align: center;">Không tìm thấy sản phẩm nào.</p>
            <?php endif; ?>
        </section>

        <section class="title">
            <b></b>
            <h3>SẢN PHẨM NỔI BẬT</h3>
            <b></b>
        </section>
        
        <section class="product-big">
             <section class="intro-product">
                <p>MỚI NHẤT</p>
                <?php foreach ($newest_products as $item): ?>
                <section class="intro-product-sub">
                    <div class="describe">
                        <a href="detail.php?id=<?php echo $item['id']; ?>">
                            <img src="<?php echo $item['image']; ?>" alt="">
                        </a>
                        <div class="describe-sub">
                            <a href="detail.php?id=<?php echo $item['id']; ?>" style="text-decoration: none; color: inherit;">
                                <p><?php echo $item['name']; ?></p>
                            </a>
                            <strong><?php echo formatPrice($item['price']); ?></strong>
                        </div>
                    </div>
                    <hr>
                </section>
                <?php endforeach; ?>
            </section>
            
            </section>

    </main>

<?php
    // Xử lý khi người dùng gửi bình luận
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment_content'])) {
        $cmt_content = $_POST['comment_content'];
        
        // Nếu đã đăng nhập thì lấy tên user, chưa thì lấy tên "Khách ẩn danh"
        $cmt_user = isset($_SESSION['username']) ? $_SESSION['username'] : "Khách ẩn danh";
        
        if(!empty($cmt_content)){
            addComment($cmt_user, $cmt_content);
            echo "<script>window.location.href='index.php';</script>"; // Refresh để hiện comment mới
        }
    }

    // Lấy danh sách comment
    $list_comments = getComments();
    ?>

    <section class="comment-section">
        <div class="comment-container">
            <h3 class="comment-title">ĐÁNH GIÁ TỪ KHÁCH HÀNG</h3>
            
            <div class="comment-form">
                <form action="index.php" method="POST">
                    <textarea name="comment_content" placeholder="Bạn nghĩ gì về đồ uống của chúng tôi?" required></textarea>
                    <button type="submit">GỬI ĐÁNH GIÁ</button>
                </form>
            </div>

            <div class="comment-list">
                <?php foreach ($list_comments as $cmt): ?>
                <div class="comment-item">
                    <div class="cmt-avatar">
                        <img src="img/download.jfif" alt="User">
                    </div>
                    <div class="cmt-body">
                        <strong><?php echo $cmt['username']; ?></strong>
                        <span class="cmt-time"><?php echo date("d/m/Y H:i", strtotime($cmt['created_at'])); ?></span>
                        
                        <p class="cmt-text">
                            <?php echo $cmt['content']; ?>
                        </p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

<?php include "./page/footer.php"; ?>