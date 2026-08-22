<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/db.php';

// Restrict to logged-in users
if (!isset($_SESSION['user_id'])) {
    header('Location: /blog-app/auth/login.php');
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch user's posts
$stmt = $pdo->prepare("SELECT * FROM blogPost WHERE user_id = :uid ORDER BY created_at DESC");
$stmt->execute(['uid' => $userId]);
$posts = $stmt->fetchAll();
?>

<section class="workspace-header">
    <div class="workspace-inner">
        <div>
            <h1 class="workspace-title">My Blogs</h1>
            <p class="workspace-sub">Manage your writing and drafts.</p>
        </div>
        <div class="workspace-actions">
            <a href="/blog-app/blogs/create.php" class="btn btn-primary btn-pill">+ New Post</a>
        </div>
    </div>
</section>

<div class="container">
    <?php if (empty($posts)): ?>
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
            </div>
            <h3>No blogs published yet</h3>
            <p>You haven't written any posts yet. Share your thoughts with the community today.</p>
            <a href="/blog-app/blogs/create.php" class="btn btn-primary btn-pill">Write Your First Post &rarr;</a>
        </div>
    <?php else: ?>
        <div class="blog-grid">
            <?php foreach ($posts as $post): ?>
                <div class="blog-card">
                    <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                    <p class="blog-meta">Created on <?php echo date('M d, Y', strtotime($post['created_at'])); ?></p>
                    <p class="blog-excerpt">
                        <?php 
                            $excerpt = substr(strip_tags($post['content']), 0, 150);
                            echo htmlspecialchars($excerpt) . (strlen($post['content']) > 150 ? '...' : '');
                        ?>
                    </p>
                    <div class="card-actions">
                        <a href="/blog-app/blogs/edit.php?id=<?php echo $post['id']; ?>" class="btn btn-secondary">Edit</a>
                        <a href="/blog-app/blogs/delete.php?id=<?php echo $post['id']; ?>" class="btn btn-danger" onclick="return confirm('Delete this post?');">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
