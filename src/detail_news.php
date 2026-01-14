<?php 
include "./page/header.php"; 
require_once "./func/database.php"; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $news = getNewsById($id);
} else {
    echo "<script>window.location.href='tintuc.php';</script>";
    exit;
}
?>

<main>
    <?php if ($news): ?>
        <div class="news-detail-container">
            <h1 class="news-title"><?php echo $news['title']; ?></h1>
            <p class="news-date"><i class="fa-regular fa-clock"></i> Đăng ngày: <?php echo date("d/m/Y H:i", strtotime($news['created_at'])); ?></p>
            
            <div class="news-feature-img">
                <img src="<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>">
            </div>
            
            <div class="news-body">
                <?php echo nl2br($news['content']); ?>
            </div>
            
            <div class="back-btn">
                <a href="tintuc.php"><i class="fa-solid fa-arrow-left"></i> Quay lại danh sách tin</a>
            </div>
        </div>
    <?php else: ?>
        <p style="text-align: center; padding: 50px;">Bài viết không tồn tại.</p>
    <?php endif; ?>
</main>

<?php include "./page/footer.php"; ?>