<?php
require_once '../includes/header.php';
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: my-blogs.php");
    exit();
}

$blog_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch blog details
$stmt = $pdo->prepare("SELECT * FROM blogPost WHERE id = ? AND user_id = ?");
$stmt->execute([$blog_id, $user_id]);
$blog = $stmt->fetch();

if (!$blog) {
    header("Location: my-blogs.php");
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
        $stmt = $pdo->prepare("UPDATE blogPost SET title = ?, content = ? WHERE id = ? AND user_id = ?");
        if ($stmt->execute([$title, $content, $blog_id, $user_id])) {
            header("Location: my-blogs.php?updated=success");
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
            <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($blog['title']); ?>" required>
        </div>

        <div class="form-group">
            <label for="content">Blog Content</label>
            <textarea name="content" id="editor" rows="10"><?php echo htmlspecialchars($blog['content']); ?></textarea>
        </div>

        <button type="submit">Update Blog</button>
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