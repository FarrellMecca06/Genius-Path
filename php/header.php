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
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <title>PathFinder – Find Your Future</title>
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>?v=<?php echo time(); ?>">
    <?php wp_head(); ?> 
</head>
<body <?php body_class(); ?>>

<nav class="navbar">
    <div class="nav-left">
        <a href="<?php echo home_url(); ?>" class="logo" style="text-decoration: none;">
            Path<span>Finder</span>
        </a>
        <ul class="nav-links">
            <li><a href="<?php echo home_url(); ?>">Home</a></li>
            <li><a href="<?php echo home_url('/self_discovery.php'); ?>">Self Discovery</a></li>
            <li><a href="<?php echo home_url('/careers.php'); ?>">Career Paths</a></li>
            <li><a href="<?php echo home_url('/dashboard.php'); ?>">Progress</a></li>
        </ul>
    </div>
    <div class="nav-right">
        <?php if ($userName): ?>
            <span class="user-pill">Hi, <?php echo htmlspecialchars($userName); ?></span>
            <a href="<?php echo home_url('/logout.php'); ?>" class="btn-outline">Logout</a>
        <?php else: ?>
            <a href="<?php echo home_url('/login.php'); ?>" class="btn-outline">Login</a>
            <a href="<?php echo home_url('/register.php'); ?>" class="btn-primary">Get Started</a>
        <?php endif; ?>
    </div>
</nav>