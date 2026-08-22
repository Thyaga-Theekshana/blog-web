<?php
session_start();
require_once '../config/db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$errors = [];
$successMessage = '';

if (isset($_GET['registered']) && $_GET['registered'] === 'success') {
    $successMessage = "Registration successful! You can now log in.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = trim($_POST['username_email']);
    $password        = $_POST['password'];

    if (empty($usernameOrEmail) || empty($password)) {
        $errors[] = "Both fields are required.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ? OR email = ?");
        $stmt->execute([$usernameOrEmail, $usernameOrEmail]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role'];

            header("Location: ../blogs/my-blogs.php");
            exit();
        } else {
            $errors[] = "Invalid username/email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - WriteWave</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="auth-body">

    <div class="auth-card">
        <div class="auth-header">
            <span class="brand-symbol">◆</span>
            <h2>WriteWave</h2>
            <h1>Welcome Back</h1>
            <p>Sign in to your account to continue</p>
        </div>

        <?php if (!empty($successMessage)): ?>
            <div class="success-box">
                <p><?php echo htmlspecialchars($successMessage); ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username_email">Email Address or Username</label>
                <input type="text" name="username_email" id="username_email" placeholder="your@email.com" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <!-- Placeholder fixed to "Your password" -->
                    <input type="password" name="password" id="password" placeholder="Your password" required>
                    <!-- Initial icon set to fa-eye for hidden password -->
                    <i class="fa-solid fa-eye" id="togglePassword"></i>
                </div>
            </div>

            <button type="submit" class="btn-auth">Sign In</button>
        </form>

        <p class="auth-footer">Don't have an account? <a href="register.php">Create one</a></p>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            // Toggle input type between password and text
            const isPassword = password.getAttribute('type') === 'password';
            password.setAttribute('type', isPassword ? 'text' : 'password');
            
            // Hidden (password) -> fa-eye, Visible (text) -> fa-eye-slash
            this.classList.toggle('fa-eye', !isPassword);
            this.classList.toggle('fa-eye-slash', isPassword);
        });
    </script>
</body>
</html>