<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         'w4:J(aHdJ^wR=AE%v#_ARR^LHl~aTE!$=U3~#!|4ubn)JEd*o:5q;?z7nO77^qBc' );
define( 'SECURE_AUTH_KEY',  'J]xGdi`O8?P,Eg$kxN+z_G&VPu4d_x(&/:X:J({RB 2X`9Oc{C3,TY/X<a4X9uE.' );
define( 'LOGGED_IN_KEY',    'P.R:L=(c*;*HX!,z%2QP7*400<,#r]_|CtBIKHddxq{NkX:s>aHwK ;M,]j9-_@z' );
define( 'NONCE_KEY',        'y_#094~.Eg K^9HPLN=sBm0|,bZ*fP%efkU2{7DFt#{jS[M{ksy]-^06 znTurUW' );
define( 'AUTH_SALT',        '-YO@rJ5iLNL3Jq)[AT.sxmxiVp&;P2h/#v)vhf>k==M{S{tAFkO#Y!}QLuh2u)3H' );
define( 'SECURE_AUTH_SALT', '-t[2!:}::H4 UuUJa_4Q%;$|LVE:,7/G]hBht{mx6I7^m>>xX9KmMh93kF;]wI=%' );
define( 'LOGGED_IN_SALT',   'Vn/ZE+Ud@w{pHgl|K|8As&%9EVIWEJ=tGSU1fQRq<f,*VNx&0Qw#cq[oK+$z0&D;' );
define( 'NONCE_SALT',       'w)_i@hn/,bN2cPl8?P2*vD]^S8/h{n7%{,PjHmfl>gD6[uRmy*=$27y[ZmihTIpO' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
