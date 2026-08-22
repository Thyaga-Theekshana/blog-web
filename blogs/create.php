<?php
require_once '../includes/header.php';
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (empty($title) || empty($content)) {
        $errors[] = "Both title and content are required.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO blogPost (user_id, title, content) VALUES (?, ?, ?)");
        if ($stmt->execute([$_SESSION['user_id'], $title, $content])) {
            header("Location: my-blogs.php?created=success");
            exit();
        } else {
            $errors[] = "Failed to publish blog post.";
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
            <input type="text" name="title" id="title" placeholder="Enter title" required>
        </div>

        <div class="form-group">
            <label for="content">Blog Content</label>
            <textarea name="content" id="editor" rows="10"></textarea>
        </div>

        <button type="submit">Publish Blog</button>
    </form>
</div>

<!-- Include CKEditor CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            // Base64 Upload Adapter Configuration for Image Uploads
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return {
                    upload: () => loader.file.then(file => new Promise((resolve, reject) => {
                        const reader = new FileReader();
                        reader.onload = () => resolve({ default: reader.result });
                        reader.onerror = error => reject(error);
                        reader.readAsDataURL(file);
                    }))
                };
            };
        })
        .catch(error => {
            console.error(error);
        });
</script>

<?php require_once '../includes/footer.php'; ?>