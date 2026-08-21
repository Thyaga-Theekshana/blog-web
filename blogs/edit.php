<?php
require_once '../includes/header.php';
require_once '../config/db.php';

// Authentication Check
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../index.php");
    exit();
}

$blog_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch post and check if logged-in user is the owner
$stmt = $pdo->prepare("SELECT * FROM blogPost WHERE id = ?");
$stmt->execute([$blog_id]);
$blog = $stmt->fetch();

if (!$blog) {
    echo "<h2>Blog post not found.</h2>";
    require_once '../includes/footer.php';
    exit();
}

// Authorization Check: Prevent editing others' posts
if ($blog['user_id'] != $user_id) {
    echo "<div class='error-box'>Unauthorized action. You can only edit your own posts.</div>";
    require_once '../includes/footer.php';
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (empty($title) || empty($content)) {
        $errors[] = "Title and Content cannot be empty.";
    }

    if (empty($errors)) {
        $updateStmt = $pdo->prepare("UPDATE blogPost SET title = ?, content = ? WHERE id = ? AND user_id = ?");
        if ($updateStmt->execute([$title, $content, $blog_id, $user_id])) {
            header("Location: view.php?id=" . $blog_id);
            exit();
        } else {
            $errors[] = "Failed to update blog post.";
        }
    }
}
?>

<div class="form-container">
    <h2>Edit Blog Post</h2>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="edit.php?id=<?php echo $blog_id; ?>" method="POST">
        <div class="form-group">
            <label for="title">Blog Title</label>
            <input type="text" name="title" id="title" required value="<?php echo htmlspecialchars($blog['title']); ?>">
        </div>

        <div class="form-group">
            <label for="content">Blog Content (Markdown supported)</label>
            <textarea name="content" id="markdown-editor" rows="10"><?php echo htmlspecialchars($blog['content']); ?></textarea>
        </div>

        <button type="submit">Update Blog</button>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>