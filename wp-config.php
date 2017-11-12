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
define('WP_CACHE', true);
define( 'WPCACHEHOME', 'C:\wamp64\www\wp-content\plugins\wp-super-cache/' );
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'adminifmg');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'YI*H:h[$4`Av _(1^/lGW[ZHUYpOU*v:P^/pBOBRc&?&CiVl%USQ.Ns?[6:T606H');
define('SECURE_AUTH_KEY',  'O5~3Z*<P60T74RR.^~W}yRn`Sf:wrVNP.r_fg|jPH@nG`#xP.9dvOF0#f<,Bc2d]');
define('LOGGED_IN_KEY',    '=vAIC{kM{i4ZBS9!~pmeu,$H-0V&0H a?nym(&qOafeJj]0pf}*MljhUPz/q4o4h');
define('NONCE_KEY',        '3z=xR0z 5z&Y@_tqU-c g(pb>&1Ge>cwU+!#Q*CS6AV4TNlSxLnYte(>p|+4>2<m');
define('AUTH_SALT',        'l|#${s/NCP>XPYHJfn@!fTT8&2oCBj]T^;YK1B>(k?}1lI=|$G~ba%+`#=j /)NE');
define('SECURE_AUTH_SALT', '3LvmJ)~60,WCcb9x.`3)L1ibWC_AqfI.DaMvZxeMr}-kj@B;Bbcxb3[q}Gj<]M-c');
define('LOGGED_IN_SALT',   'iLhra,?OCoei](i!_$6|OW#[imH&U >w7WHn&*W8m&3hM;Nou@|SR^<C1+>mTv,|');
define('NONCE_SALT',       ':/V`SlDw{)MQ91Q{7|KvcKli2mhw/>2[F]F-OLP8$MfDj}Bmg$tz@0r^qLo><Xaa');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
