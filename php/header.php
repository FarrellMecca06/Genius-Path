<?php
// header.php

// make sure session exists
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userName = $_SESSION['user_full_name'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PathFinder – Find Your Future</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

<nav class="navbar">
    <div class="nav-left">
        <div class="logo">Path<span>Finder</span></div>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="self_discovery.php">Self Discovery</a></li>
            <li><a href="careers.php">Career Paths</a></li>
            <li><a href="dashboard.php">Progress</a></li>
        </ul>
    </div>
    <div class="nav-right">
        <?php if ($userName): ?>
            <span class="user-pill">Hi, <?php echo htmlspecialchars($userName); ?></span>
            <a href="logout.php" class="btn-outline">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn-outline">Login</a>
            <a href="register.php" class="btn-primary">Get Started</a>
        <?php endif; ?>
    </div>
</nav>