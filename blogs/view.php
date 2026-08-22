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
    echo "<div class='container'><h2>Blog post not found.</h2></div>";
    require_once '../includes/footer.php';
    exit();
}
?>

<div class="single-blog-container" style="max-width: 800px; margin: 30px auto; padding: 0 20px;">
    <h1><?php echo htmlspecialchars($blog['title']); ?></h1>
    <p class="blog-meta" style="color: #666; margin-bottom: 20px;">
        By <strong><?php echo htmlspecialchars($blog['username']); ?></strong> 
        on <?php echo date('M d, Y', strtotime($blog['created_at'])); ?>
    </p>

    <div class="blog-content">
        <!-- Render full HTML content including embedded images -->
        <?php echo $blog['content']; ?>
    </div>
</div>

<style>
    /* Ensure uploaded images scale nicely within the blog view */
    .blog-content img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 15px 0;
        border-radius: 8px;
    }
</style>

<?php require_once '../includes/footer.php'; ?>