<?php
// Database Credentials
$host     = 'localhost';
$db_name  = 'blog_db';
$username = 'root';
$password = ''; // XAMPP default password is empty

try {
    // PDO Connection 
    $pdo = new PDO("mysql:host={$host};dbname={$db_name};charset=utf8mb4", $username, $password);
    
    //  create Attributes for Error Handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // display error if conection fail 
    die("Database Connection Failed: " . $e->getMessage());
}
?>