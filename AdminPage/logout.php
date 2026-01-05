<?php
/**
 * Admin Logout - Standalone/Independent
 */
include 'config.php';

// Destroy session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to login
redirect('admin_login.php');
exit;
?>
