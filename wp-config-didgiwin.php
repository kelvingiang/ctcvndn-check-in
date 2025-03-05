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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
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
define( 'AUTH_KEY',         '-AFL*yFB#qJIPjJ)s:3VqfWi7@$!i{R#}<pXBt!{?d%TLn~gOf)Sq!x4]NL%8$|P' );
define( 'SECURE_AUTH_KEY',  'rjilvOCuqurknuoh0vLxJd})A0`R~m8GHkX[;j/:Q:z]@ZN.VVE_$8/KV1f:%j]=' );
define( 'LOGGED_IN_KEY',    'ttq2x<T)6du{/th3L=jO#4:(PfciI63Lk>kG{{QcKJvRBri>C?,p5kD7<MM)^L)M' );
define( 'NONCE_KEY',        '[V7J1FF#83Xk(eX,vDiM&l(UvbFxK2J^WJMz_|smIlTugUZ*pAPH>< Pc:yKUFWV' );
define( 'AUTH_SALT',        'IJIyyy<0MtKP pA)eh)D<X)1@=Y?k&Fa=@%n,pvsbtU_.sIgKN~dzUOqOk^Dqer3' );
define( 'SECURE_AUTH_SALT', '%MT^lf86A;:FSb>VC@#[+J+Q:=IXlOgie1K9FM!uyZsz5^+n2J?nu5XtIU;B[(~4' );
define( 'LOGGED_IN_SALT',   '~zq}C>mG:4%Tmw<_h+*Pz!b&{~j&*FqEJ9Mdo)6t8&0S1?~kHH;|qe492u*fTqv,' );
define( 'NONCE_SALT',       '>7XrMK@]%nKJ-|6y28,{(6!g$T,0^zfpj|2(yCT,=3KyS@vVsd,N@(?(>Zd!B;>7' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpci_';

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
