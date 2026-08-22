<?php
require_once '../includes/header.php';
require_once '../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: ../index.php");
    exit();
}

$stmt = $pdo->prepare("
    SELECT blogPost.*, user.username 
    FROM blogPost 
    JOIN user ON blogPost.user_id = user.id 
    WHERE blogPost.id = ?
");
$stmt->execute([$_GET['id']]);
$blog = $stmt->fetch();

if (!$blog) {
    echo "<h2>Blog post not found.</h2>";
    require_once '../includes/footer.php';
    exit();
}
?>

<div class="single-blog-container">
    <h1><?php echo htmlspecialchars($blog['title']); ?></h1>
    <p class="blog-meta">
        By <strong><?php echo htmlspecialchars($blog['username']); ?></strong> 
        on <?php echo date('M d, Y', strtotime($blog['created_at'])); ?>
    </p>

    <div class="blog-content">
        <!-- Allow HTML rendering without htmlspecialchars for rich text -->
        <?php echo $blog['content']; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>