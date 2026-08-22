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
    <title>Bloggera</title>
    <link rel="stylesheet" href="/blog-app/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
</head>
<body>
    <header class="site-header">
        <nav class="navbar">
            <div class="logo">
                <a href="/blog-app/index.php">Bloggera</a>
            </div>
            <ul class="nav-links">
                <li><a href="/blog-app/index.php" class="nav-item">Home</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/blog-app/blogs/my_blogs.php" class="nav-item">My Blogs</a></li>
                    <li><a href="/blog-app/blogs/create.php" class="nav-item">Create Blog</a></li>
                    <li><span class="user-welcome">Hello, <?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?></span></li>
                    <li><a href="/blog-app/auth/logout.php" class="btn btn-pill btn-logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="/blog-app/auth/login.php" class="btn btn-pill btn-secondary">Login</a></li>
                    <li><a href="/blog-app/auth/register.php" class="btn btn-pill btn-primary">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main class="container">