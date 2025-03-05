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
define( 'DB_NAME', 'ctcvndn_check_in' );

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
define( 'AUTH_KEY',         'ubD,:rWPAtq$dEW]:;Jq&(&gynO?zmP:v!LerBshd)<;AwfBtZ/HsopS:=8k0/-P' );
define( 'SECURE_AUTH_KEY',  'pj;=^>8vm/=RJpMafWFj8uO(m54LQZ*Ov;ic*oaqMcLzwkt^fu)I4hgpV~2$BFlM' );
define( 'LOGGED_IN_KEY',    'v(ie]Ms>O7Djpw29k(fAL.ZfB~IA_spQ9LMpYb-9hej%j)+wa?IDQg|Pv69qu6!l' );
define( 'NONCE_KEY',        '^ij*xasYo+1=D=:bnIZj2u~Z$,KxG|XE56G=8JW^Ii&&c}D`=ke7X+{G{V=o|e#}' );
define( 'AUTH_SALT',        '}=kh%|TgpnYiqjAjHdEPF`qb6 v^m<*]h^qgs5kh22d_{NSyucKwLEe)STCQ6b<J' );
define( 'SECURE_AUTH_SALT', '-)Vcd4UVN%6}%O_(iJcX|t?X RQ}lfm!.BqkmZDU}ob+.2o<)1ofhxB$ctCLwM$Q' );
define( 'LOGGED_IN_SALT',   'c.e;:?X-t`u4]@S0]uEe^F#$O[^%3H47dkv#LSwoQk#evU)JVP8&l}MR(@~esadm' );
define( 'NONCE_SALT',       'Ccx!&RYg:qp;ib(c W:sstJc=U>aJw7C97]x#:oR86b;^60/=Jt.2<e9BXbK_b6%' );

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
