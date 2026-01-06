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
        <?php if ($userName): ?>
            <?php 
            $config_path = __DIR__ . '/config.php';
            if (file_exists($config_path)) {
                include_once $config_path;
                $stmt = $pdo->prepare("SELECT profile_picture FROM users WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $userData = $stmt->fetch();
                $img_name = $userData['profile_picture'] ?? 'default-user.png';
                $img_url = get_template_directory_uri() . '/../image/uploads/' . $img_name;
            } else {
                $img_url = get_template_directory_uri() . '/../image/default-user.png';
            }
            ?>
            <a href="<?php echo home_url('/profile.php'); ?>" style="display: flex; align-items: center; margin-right: 15px;">
                <img src="<?php echo $img_url; ?>" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #56bbea;">
            </a>
        <?php endif; ?>

        <a href="<?php echo home_url(); ?>" class="logo">
            <img src="<?php echo get_template_directory_uri(); ?>/../image/logo.png" alt="GeniusPath Logo" class="nav-logo-img">
        </a>
        <ul class="nav-links">
            <li><a href="<?php echo home_url(); ?>">Home</a></li>
            <li><a href="<?php echo home_url('/self_discovery.php'); ?>">Self Discovery</a></li>
            <li><a href="<?php echo home_url('/careers.php'); ?>">Career Paths</a></li>
        </ul>
    </div>
    <div class="nav-right">
        <?php if ($userName): ?>
            <span class="user-pill">Hi, <?php echo htmlspecialchars($userName); ?></span>
            <a href="<?php echo home_url('/logout.php'); ?>" class="btn-outline">Logout</a>
        <?php else: ?>
            <a href="<?php echo home_url('/login.php'); ?>" class="btn-outline" style="margin-right: 10px;">Login</a>
            <a href="<?php echo home_url('/register.php'); ?>" class="btn-primary">Get Started</a>
        <?php endif; ?>
    </div>
</nav>