<?php
// 1. Muat koneksi dan WordPress
include __DIR__ . '/config.php';
// Penting jika file ini diakses langsung di folder theme
if (!defined('ABSPATH')) {
    require_once('../../../wp-load.php'); 
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Logika Login (Sama seperti kode Anda...)
// ... (Bagian IF POST, validasi, dan wp_redirect di sini) ...

// 3. Tampilkan HTML (Hanya jika belum redirect)
?>
<!DOCTYPE html>
<html>
   </html>

<?php
// JANGAN ADA header() LAGI DI SINI!