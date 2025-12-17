<?php
// config.php
$host = "localhost";      // sesuaikan
$db   = "database"; // sesuaikan
$user = "root";           // sesuaikan
$pass = "root";               // sesuaikan

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>