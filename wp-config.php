<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
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

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '0JC.OIb.:FsAtQYAD|amN-S:EuarZa9>.~ZcX^v[lsooK1mt([/K}Dd1m,o!9[ ?' );
define( 'SECURE_AUTH_KEY',  '&d^ON]rS%!v%w,xFVx$CA|j#uRMCqHb+wcl=xfl1)!T|=Y?k|@>CL{Ee{mJWNz9>' );
define( 'LOGGED_IN_KEY',    'ycR$ORXOq(!iwf8_a<OrLn~j~HByBKy%5ldNH$(]sNY3f#5qXn+84pAu~jXRW~*=' );
define( 'NONCE_KEY',        'EKExC*y0{E%M02]yXKD!{Gt5].#P)1eY90,L#4v@SH;qO^rx<]5`Qd-t@6Q9y^-B' );
define( 'AUTH_SALT',        'rkY9!X=im[M an[(|Tv:u~HE9$$p{4z#WF iF`L%n{;#F;*=js$BCuP#Dd1B4~s~' );
define( 'SECURE_AUTH_SALT', '_h;nh.yvAEQBEJM^AL;[X,UY=35D:9.ucdC}FG#hrS*l`Hl5;KY$84^b?(}P:S,^' );
define( 'LOGGED_IN_SALT',   'FXTbG7!T8B>rBqh=kCfq.UR|n;,3;tWrrNpZW;OW_|+kv8l,-YOXy2NTw,z=:bt:' );
define( 'NONCE_SALT',       ',=^eVRXYJG[^U?!JJAKxIgB5_4zEI&_9Eb{X*O!7@9f&|6BWd9Qls[Fyg@ToiI.A' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
