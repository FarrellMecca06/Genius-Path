<?php
/**
 * Standalone Admin Configuration
 * Independent dari aplikasi utama dan WordPress
 */

// Database Credentials
$host = "localhost";
$db = "geniuspath";
$db_user = "root";
$db_pass = "";

try {
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection to Database Failed: " . $e->getMessage());
}

// Session Configuration
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Helper Functions (Independent dari WordPress)
function redirect($url) {
    header("Location: " . $url);
    exit;
}

function get_current_url() {
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    return $url;
}

function base_url() {
    return "http://" . $_SERVER['HTTP_HOST'] . "/WAD-Project/wordpress/wp-content/themes/Genius-Path/AdminPage/";
}

?>
