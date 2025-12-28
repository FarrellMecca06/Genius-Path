<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'GeniusPath' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'SNc]W==8xDJ`X?P_xPPkAO&LqR.mH7yz%M`IAgVb<[e3YupY[u`Jwpx?ZT~$;RZ(' );
define( 'SECURE_AUTH_KEY',  '#7`ukpm(=mw^-vCgJAc#XkyRnR&pvyle01=d8^v-CrCst3}{}L&C5PiCiB`2LJ87' );
define( 'LOGGED_IN_KEY',    '05  hRUT;[4_n(V&_cx.>5dLNsw:^yC!p!;<|dL4ma@NG$oFbew;0Ta7dw5PcCr8' );
define( 'NONCE_KEY',        '@54O>$q>Bs ME-;5xw/hxE=v5JqEn`QP@CUrn8(.f6k~blHBFbJ`(aM-7pO)ihVe' );
define( 'AUTH_SALT',        'j(C) ?g/aAqP;5D5]I<G0dS!G:t^kwpo]*HaP6 ZnL`T C68-0U!0W`` H37F@>G' );
define( 'SECURE_AUTH_SALT', '%bshO!gCM-HQG}7Y9.;xI/`-oF..Wk*tchGOwYH/G_$m|CiR9._svt@,CFhpQ;r[' );
define( 'LOGGED_IN_SALT',   '&|5e7ghS:Rf#P){zxD0|5yr&y9O9NN.QIuLM_o%w5lVtf4S;&+!-sVea2b-P_~a@' );
define( 'NONCE_SALT',       '(i~2JB!wW.Fj#JCVY5u= |sueI!{Uz6SwCAP1dwVajyefoR=uMz9zpNYv<{0ox#.' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
