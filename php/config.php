<?php
if (!file_exists(__DIR__ . '/credentials.php')) {
    die("Error: File credentials.php tidak ditemukan! Silakan buat file ini sesuai settingan komputer masing-masing.");
}

require_once __DIR__ . '/credentials.php';

try {
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection to Database Failed: " . $e->getMessage());
}
?>