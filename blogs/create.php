<?php
require_once '../includes/header.php';
require_once '../config/db.php';

// Authorization Check: Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title']);
    $content = trim($_POST['content']);
    $user_id = $_SESSION['user_id'];

    // Basic Validations
    if (empty($title) || empty($content)) {
        $errors[] = "Title and Content cannot be empty.";
    }

    // Insert blog into database
    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO blogPost (user_id, title, content) VALUES (?, ?, ?)");
        if ($stmt->execute([$user_id, $title, $content])) {
            header("Location: ../index.php?created=success");
            exit();
        } else {
            $errors[] = "Failed to create blog post. Please try again.";
        }
    }
}
?>

<div class="form-container">
    <h2>Create New Blog Post</h2>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="create.php" method="POST">
        <div class="form-group">
            <label for="title">Blog Title</label>
            <input type="text" name="title" id="title" required value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="content">Blog Content (Markdown supported)</label>
            <textarea name="content" id="markdown-editor" rows="10"><?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : ''; ?></textarea>
        </div>

        <button type="submit">Publish Blog</button>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>