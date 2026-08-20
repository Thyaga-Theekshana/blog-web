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
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="/index.php">MyBlogApp</a>
            </div>
            <ul class="nav-links">
                <li><a href="/index.php">Home</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/blogs/create.php">Create Blog</a></li>
                    <li><span class="user-welcome">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></span></li>
                    <li><a href="/auth/logout.php" class="btn-logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="/auth/login.php">Login</a></li>
                    <li><a href="/auth/register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main class="container">