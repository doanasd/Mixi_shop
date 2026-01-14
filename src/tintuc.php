<?php 
include "./page/header.php"; 
require_once "./func/database.php"; 

$news_list = getAllNews();
?>

<main>
    <section class="title">
        <b></b>
        <h3>TIN TỨC & SỰ KIỆN</h3>
        <b></b>
    </section>
    
    <div class="news-container">
        <?php if(count($news_list) > 0): ?>
            <?php foreach ($news_list as $news): ?>
            <div class="news-card">
                <div class="news-img">
                    <a href="detail_news.php?id=<?php echo $news['id']; ?>">
                        <img src="<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>">
                    </a>
                </div>
                <div class="news-content">
                    <h4>
                        <a href="detail_news.php?id=<?php echo $news['id']; ?>">
                            <?php echo $news['title']; ?>
                        </a>
                    </h4>
                    <p class="date"><i class="fa-regular fa-clock"></i> <?php echo date("d/m/Y", strtotime($news['created_at'])); ?></p>
                    <p class="desc"><?php echo $news['short_description']; ?></p>
                    <a href="detail_news.php?id=<?php echo $news['id']; ?>" class="read-more">Xem thêm <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center;">Hiện chưa có tin tức nào.</p>
        <?php endif; ?>
    </div>
</main>

<?php include "./page/footer.php"; ?>