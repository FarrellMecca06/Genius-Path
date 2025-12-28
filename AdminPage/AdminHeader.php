<?php
// admin_header.php
include 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] === 'student')) {
    header('Location: login.php');
    exit;
}

$userName = $_SESSION['user_full_name'] ?? 'Admin';
$userRole = $_SESSION['user_role'] ?? 'admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin – PathFinder</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .admin-layout {
            max-width: 1180px;
            margin: 1.5rem auto 2.5rem;
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 1.5rem;
            padding: 0 1.25rem;
        }
        .admin-sidebar {
            background: #0f172a;
            border-radius: 1.1rem;
            padding: 1.1rem 1rem;
            color: #e5e7eb;
        }
        .admin-sidebar h2 {
            font-size: 1.1rem;
            margin-bottom: 0.6rem;
        }
        .admin-menu {
            list-style: none;
            margin-top: 0.4rem;
        }
        .admin-menu li {
            margin-bottom: 0.35rem;
        }
        .admin-menu a {
            display: block;
            padding: 0.4rem 0.6rem;
            border-radius: 0.6rem;
            color: #e5e7eb;
            font-size: 0.9rem;
            text-decoration: none;
        }
        .admin-menu a:hover,
        .admin-menu a.active {
            background: rgba(59, 130, 246, 0.2);
        }
        .admin-main {
            min-height: 400px;
        }
        .admin-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .admin-role-pill {
            font-size: 0.8rem;
            padding: 0.25rem 0.6rem;
            border-radius: 999px;
            background: rgba(59, 130, 246, 0.12);
            color: #1d4ed8;
        }
    </style>
</head>
<body>
<header class="top-banner">
    <div class="top-banner-content">
        <span class="badge">Admin Panel</span>
        <span>Monitor users, tests, and career data</span>
        <a href="index.php" class="banner-cta">Back to site</a>
    </div>
</header>

<div class="admin-layout">
    <aside class="admin-sidebar">
        <h2>PathFinder Admin</h2>
        <p style="font-size:0.85rem;margin-bottom:0.8rem;">
            <?php echo htmlspecialchars($userName); ?>  
            <span class="admin-role-pill"><?php echo htmlspecialchars($userRole); ?></span>
        </p>
        <ul class="admin-menu">
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="admin_users.php">User Management</a></li>
            <li><a href="admin_tests.php">Interest Test</a></li>
            <li><a href="admin_careers.php">Career Management</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </aside>
    <main class="admin-main"></main>