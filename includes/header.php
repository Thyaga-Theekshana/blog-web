<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Application</title>
    <!-- Absolute Path for CSS -->
    <link rel="stylesheet" href="/blog-app/assets/css/style.css">
    <!-- EasyMDE Markdown Editor CSS -->
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="/blog-app/index.php">MyBlogApp</a>
            </div>
            <ul class="nav-links">
                <li><a href="/blog-app/index.php">Home</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/blog-app/blogs/create.php">Create Blog</a></li>
                    <li><span class="user-welcome">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></span></li>
                    <li><a href="/blog-app/auth/logout.php" class="btn-logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="/blog-app/auth/login.php">Login</a></li>
                    <li><a href="/blog-app/auth/register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main class="container">