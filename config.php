<?php 

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'blog_application');

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "db connected";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>