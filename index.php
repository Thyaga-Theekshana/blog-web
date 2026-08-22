<?php
require_once 'includes/header.php';
require_once 'config/db.php';

$stmt = $pdo->prepare("
    SELECT blogPost.*, user.username 
    FROM blogPost 
    JOIN user ON blogPost.user_id = user.id 
    ORDER BY blogPost.created_at DESC
");
$stmt->execute();
$blogs = $stmt->fetchAll();
?>

<div class="home-container">
    <h2 class="section-title">Latest Posts</h2>

    <?php if (isset($_GET['created']) && $_GET['created'] === 'success'): ?>
        <div class="success-box">Blog post created successfully!</div>
    <?php endif; ?>

    <?php if (isset($_GET['deleted']) && $_GET['deleted'] === 'success'): ?>
        <div class="success-box">Blog post deleted successfully!</div>
    <?php endif; ?>

    <?php if (empty($blogs)): ?>
        <p>No blogs published yet. Be the first to write one!</p>
    <?php else: ?>
        <div class="blog-grid">
            <?php foreach ($blogs as $blog): ?>
                <div class="blog-card">
                    <h3>
                        <a href="blogs/view.php?id=<?php echo $blog['id']; ?>">
                            <?php echo htmlspecialchars($blog['title']); ?>
                        </a>
                    </h3>
                    <p class="blog-meta">
                        By <strong><?php echo htmlspecialchars($blog['username']); ?></strong> 
                        on <?php echo date('M d, Y', strtotime($blog['created_at'])); ?>
                    </p>
                    <p class="blog-excerpt">
                        <?php 
                            $excerpt = substr(strip_tags($blog['content']), 0, 140);
                            echo htmlspecialchars($excerpt) . (strlen($blog['content']) > 140 ? '...' : '');
                        ?>
                    </p>
                    <a href="blogs/view.php?id=<?php echo $blog['id']; ?>" class="read-more">Read More &rarr;</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>