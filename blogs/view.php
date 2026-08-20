<?php
require_once '../includes/header.php';
require_once '../config/db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../index.php");
    exit();
}

$blog_id = $_GET['id'];

// Fetch single blog post with author details
$stmt = $pdo->prepare("
    SELECT blogPost.*, user.username 
    FROM blogPost 
    JOIN user ON blogPost.user_id = user.id 
    WHERE blogPost.id = ?
");
$stmt->execute([$blog_id]);
$blog = $stmt->fetch();

if (!$blog) {
    echo "<h2>Blog post not found.</h2>";
    require_once '../includes/footer.php';
    exit();
}
?>

<div class="single-blog-container">
    <h1><?php echo htmlspecialchars($blog['title']); ?></h1>
    
    <div class="blog-meta">
        <span>By <strong><?php echo htmlspecialchars($blog['username']); ?></strong></span> | 
        <span>Published on <?php echo date('M d, Y', strtotime($blog['created_at'])); ?></span>
    </div>

    <hr>

    <!-- Blog Content -->
    <div class="blog-content">
        <?php 
            // Display raw text or markdown content safely
            echo nl2br(htmlspecialchars($blog['content'])); 
        ?>
    </div>

    <!-- Authorization Check: Show Edit/Delete buttons ONLY to post author -->
    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $blog['user_id']): ?>
        <div class="blog-actions">
            <a href="edit.php?id=<?php echo $blog['id']; ?>" class="btn-edit">Edit Post</a>
            <a href="delete.php?id=<?php echo $blog['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this post?');">Delete Post</a>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../includes/footer.php'; ?>