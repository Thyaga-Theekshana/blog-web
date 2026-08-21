<?php
session_start();
require_once '../config/db.php';

// Authentication Check
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $blog_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Authorization Check: Delete ONLY if post belongs to logged-in user
    $stmt = $pdo->prepare("DELETE FROM blogPost WHERE id = ? AND user_id = ?");
    $stmt->execute([$blog_id, $user_id]);

    header("Location: ../index.php?deleted=success");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}
?>