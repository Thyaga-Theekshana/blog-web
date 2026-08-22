<?php
require_once 'includes/header.php';
require_once 'config/db.php';

// Fetch all blog posts with author usernames
$stmt = $pdo->prepare("
    SELECT blogPost.*, user.username 
    FROM blogPost 
    JOIN user ON blogPost.user_id = user.id 
    ORDER BY blogPost.created_at DESC
");
$stmt->execute();
$blogs = $stmt->fetchAll();
?>

<!-- Compact Header Section -->
<section class="workspace-header">
    <div class="workspace-inner" style="flex-direction: column; align-items: center; text-align: center; gap: 8px;">
        <h1 class="workspace-title">Latest Stories</h1>
        <p class="workspace-sub">Explore insights, tutorials, and perspectives from our community.</p>
    </div>
</section>

<div class="divider"></div>

<div class="home-container">
    <?php if (isset($_GET['created']) && $_GET['created'] === 'success'): ?>
        <div class="success-box">Blog post created successfully!</div>
    <?php endif; ?>

    <?php if (isset($_GET['deleted']) && $_GET['deleted'] === 'success'): ?>
        <div class="success-box">Blog post deleted successfully!</div>
    <?php endif; ?>

    <?php if (empty($blogs)): ?>
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fa-regular fa-folder-open" style="font-size: 3rem;"></i>
            </div>
            <h3>No blogs published yet</h3>
            <p>The feed is currently empty. Check back later for new stories.</p>
        </div>
    <?php else: ?>
        <div class="blog-grid">
            <?php foreach ($blogs as $blog): ?>
                <div class="blog-card">
                    <div class="card-badge">Story</div>
                    <h3>
                        <a href="blogs/view.php?id=<?php echo $blog['id']; ?>">
                            <?php echo htmlspecialchars($blog['title']); ?>
                        </a>
                    </h3>
                    <p class="blog-meta">
                        By <strong><?php echo htmlspecialchars($blog['username']); ?></strong> 
                        &middot; <?php echo date('M d, Y', strtotime($blog['created_at'])); ?>
                    </p>
                    <p class="blog-excerpt">
                        <?php 
                            $excerpt = substr(strip_tags($blog['content']), 0, 150);
                            echo htmlspecialchars($excerpt) . (strlen($blog['content']) > 150 ? '...' : '');
                        ?>
                    </p>
                    <div class="card-footer">
                        <a href="blogs/view.php?id=<?php echo $blog['id']; ?>" class="read-more">Read Article &rarr;</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>