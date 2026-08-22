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
    <title>WriteWave</title>
    <link rel="stylesheet" href="/blog-app/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="/blog-app/index.php"><span class="brand-symbol">◆</span> WriteWave</a>
            </div>
            <ul class="nav-links">
                <li><a href="/blog-app/index.php">Community Blogs</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/blog-app/blogs/my-blogs.php">Dashboard</a></li>
                    <li><a href="/blog-app/auth/logout.php">Logout</a></li>
                    <li><a href="/blog-app/blogs/create.php" class="btn-create-nav">+ Create Post</a></li>
                <?php else: ?>
                    <li><a href="/blog-app/auth/login.php">Login</a></li>
                    <li><a href="/blog-app/auth/register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <!-- Dynamic Header Hero Banner -->
        <div class="hero-banner">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <?php if (basename($_SERVER['PHP_SELF']) == 'my-blogs.php'): ?>
                    <h1>Welcome back, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Writer'); ?>.</h1>
                <?php elseif (basename($_SERVER['PHP_SELF']) == 'create.php'): ?>
                    <h1>Share Your Story</h1>
                <?php else: ?>
                    <h1>Community Blogs</h1>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <main class="container">