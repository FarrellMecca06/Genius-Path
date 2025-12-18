<?php


if (file_exists(__DIR__ . '/credentials.php')) {
    include(__DIR__ . '/credentials.php');
} else {
    die("Error: File credentials.php tidak ditemukan! Silakan buat file ini sesuai settingan komputer masing-masing.");
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi Database Gagal: " . $e->getMessage());
}
?>