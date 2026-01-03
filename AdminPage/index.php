<?php
/**
 * Admin landing page for Genius-Path theme (moved)
 */
// Load WordPress environment
require_once __DIR__ . '/../../../../wp-load.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$is_admin = isset($_SESSION['admin_id']);

if (!$is_admin) {
    wp_redirect(home_url('/login.php?type=admin'));
    exit;
}

global $wpdb;

// Get simple stats
$counts = [];
$counts['local_users'] = (int) $wpdb->get_var("SELECT COUNT(*) FROM users");
$counts['career_paths'] = (int) $wpdb->get_var("SELECT COUNT(*) FROM career_paths");
$counts['assessments'] = (int) $wpdb->get_var("SELECT COUNT(*) FROM user_assessments");
$counts['wp_users'] = (int) $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->prefix . "users");

// Simple admin panel
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin Dashboard — GeniusPath</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        body{font-family:Arial,Helvetica,sans-serif;background:#f6f8fa;margin:0;padding:2rem}
        .card{max-width:900px;margin:0 auto;background:white;padding:1.5rem;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,.06)}
        h1{margin:0 0 0.5rem}
        .links{margin-top:1rem}
        .links a{display:inline-block;margin-right:1rem;padding:.5rem .8rem;background:#2673c2;color:#fff;border-radius:6px;text-decoration:none}
    </style>
</head>
<body>
    <div class="card">
        <h1>Administrator Panel</h1>
        <p>Welcome, <?php echo esc_html($_SESSION['admin_full_name'] ?? 'Administrator'); ?>.</p>
        <div class="links">
            <a href="<?php echo esc_url(home_url('/wp-content/themes/Genius-Path/AdminPage/manage-users.php')); ?>">Manage Users (Local)</a>
            <a href="<?php echo esc_url(home_url('/wp-content/themes/Genius-Path/AdminPage/manage-careers.php')); ?>">Manage Career Paths</a>
            <a href="<?php echo esc_url(home_url('/wp-content/themes/Genius-Path/AdminPage/manage-assessments.php')); ?>">Manage Assessments</a>
            <a href="<?php echo esc_url(home_url('/wp-admin/')); ?>">WP Dashboard</a>
            <a href="<?php echo esc_url(home_url('/logout.php')); ?>">Logout</a>
        </div>
        <hr style="margin:1rem 0">
        <div style="display:flex;gap:1rem;flex-wrap:wrap;margin-top:1rem">
            <div style="background:#f3f4f6;padding:1rem;border-radius:8px;min-width:160px">
                <strong><?php echo number_format_i18n($counts['local_users']); ?></strong>
                <div>Local Users</div>
            </div>
            <div style="background:#f3f4f6;padding:1rem;border-radius:8px;min-width:160px">
                <strong><?php echo number_format_i18n($counts['wp_users']); ?></strong>
                <div>WP Users</div>
            </div>
            <div style="background:#f3f4f6;padding:1rem;border-radius:8px;min-width:160px">
                <strong><?php echo number_format_i18n($counts['career_paths']); ?></strong>
                <div>Career Paths</div>
            </div>
            <div style="background:#f3f4f6;padding:1rem;border-radius:8px;min-width:160px">
                <strong><?php echo number_format_i18n($counts['assessments']); ?></strong>
                <div>Assessments</div>
            </div>
        </div>
    </div>
</body>
</html>
