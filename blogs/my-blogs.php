<?php
require_once '../includes/header.php';
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT * FROM blogPost 
    WHERE user_id = ? 
    ORDER BY created_at DESC
");
$stmt->execute([$user_id]);
$my_blogs = $stmt->fetchAll();
?>

<div class="home-container">
    <?php if (empty($my_blogs)): ?>
        <div class="empty-state-box">
            <p>You haven't published any stories yet.</p>
        </div>
    <?php else: ?>
        <h2 class="section-title">Your Contributions</h2>
        <div class="blog-grid">
            <?php foreach ($my_blogs as $blog): ?>
                <div class="blog-card">
                    <h3>
                        <a href="view.php?id=<?php echo $blog['id']; ?>">
                            <?php echo htmlspecialchars($blog['title']); ?>
                        </a>
                    </h3>
                    <p class="blog-meta">
                        Published on <?php echo date('M d, Y', strtotime($blog['created_at'])); ?>
                    </p>
                    <p class="blog-excerpt">
                        <?php 
                            $excerpt = substr(strip_tags($blog['content']), 0, 140);
                            echo htmlspecialchars($excerpt) . (strlen($blog['content']) > 140 ? '...' : '');
                        ?>
                    </p>
                    <div class="blog-actions">
                        <a href="view.php?id=<?php echo $blog['id']; ?>" class="read-more">View Post</a>
                        <a href="edit.php?id=<?php echo $blog['id']; ?>" class="btn-edit-text">Edit</a>
                        <a href="delete.php?id=<?php echo $blog['id']; ?>" class="btn-delete-text" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../includes/footer.php'; ?>