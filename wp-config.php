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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'project4' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define('WP_MEMORY_LIMIT', '256M');

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
define( 'AUTH_KEY',         'm[o2-j150$%?;K<7$ JieLiUzCu<#bco5N@$ 0`jQHWx[jqr.POln6`l?+=N9[Ez' );
define( 'SECURE_AUTH_KEY',  'v|dx{{PJ$I1}ue+0!=YQ?,uqKO(i4zF]OGq{&8<N~fa+|IGxkI:2rD;eP5Wt*-e.' );
define( 'LOGGED_IN_KEY',    'z,`?D%3:o04*fk]h%Kx2f%r6KRd,y;wivKj&$Y~5y}z:-8PROP9! mgCO{3Fl<0}' );
define( 'NONCE_KEY',        'SDOCc+sqcp&O_ >g+,)H@[@s6-U:<>vqm&6{G0GhW<q:)>h<.}HMpRshz~%_ijTP' );
define( 'AUTH_SALT',        'i`L=NL`uv=gx3d ]{!jn6.F4xaf-]SM0je7;_]J^?a;j*(ewKR(DHXc~uIns uhL' );
define( 'SECURE_AUTH_SALT', '?-O<S($}xlyhS(unHG!8 AX$n<)%7s6Ah+wd|e}V.$OvzxXSYy8v+35vl/Rzr}D4' );
define( 'LOGGED_IN_SALT',   'E(z*G,[)pLkS|t;@v>aQAU<?CTo##_n4jI+3<:GFm(`*(;~bl+mGtOfrLX^S>[rP' );
define( 'NONCE_SALT',       'KV-ctXLp.,MNm)}0.I)RsBv!6Qe/)psdnZ8_ lDvr%%@#={6LfNav7kp]34@rVtW' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
