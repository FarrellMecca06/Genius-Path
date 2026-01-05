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
