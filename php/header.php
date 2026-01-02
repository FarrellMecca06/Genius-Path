<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userName = $_SESSION['user_full_name'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <title>GeniusPath – Find Your Future</title>
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>?v=<?php echo time(); ?>">
    <?php wp_head(); ?> 
</head>
<body <?php body_class(); ?>>

<nav class="navbar">
    <div class="nav-left">
    <a href="<?php echo home_url(); ?>" class="logo">
    <img src="<?php echo get_template_directory_uri(); ?>/../image/logo.png" alt="GeniusPath Logo" class="nav-logo-img">
    </a>
        <ul class="nav-links">
            <li><a href="<?php echo home_url(); ?>">Home</a></li>
            <li><a href="<?php echo home_url('/self_discovery.php'); ?>">Self Discovery</a></li>
            <li><a href="<?php echo home_url('/careers.php'); ?>">Career Paths</a></li>
            <?php if ($userName): ?>
                <li><a href="<?php echo home_url('/logout.php'); ?>" class="btn-outline">Logout</a></li>
            <?php endif; ?>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <li><a href="<?php echo home_url('/login.php'); ?>" class="btn-outline">Login</a></li>
                <li><a href="<?php echo home_url('/register.php'); ?>" class="btn-primary">Get Started</a></li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="nav-right">
        <?php if ($userName): ?>
            <span class="user-pill">Hi, <?php echo htmlspecialchars($userName); ?></span>
        <?php endif; ?>
    </div>
</nav>