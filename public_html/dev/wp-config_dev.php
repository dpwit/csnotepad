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
define('DB_NAME', 'call02_db');

/** MySQL database username */
define('DB_USER', 'call02_sql');

/** MySQL database password */
define('DB_PASSWORD', '6eCkTEBeiR52Q86Q');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**So no FTP required */
define('FS_METHOD', 'direct');
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ',+bn.F$&9br!}2xA6+Y#GGEU5/nFd8TTNOojuSDm1VUw<fNM)N~RM.3oYv;6yVn%');
define('SECURE_AUTH_KEY',  'A%lBJ+(dlp]N=XF8yf)4I]dz)?j?Y1,y%icQUn>mYr=X(L1Aw$I`uDba0/1cVwNT');
define('LOGGED_IN_KEY',    '}+Xs8C68z`oRSNbf@6e!-X?Qb7LDO<1Vy>avQ43e{~BtI]g9M VAO:tE;N!bc<2z');
define('NONCE_KEY',        ']Uo[N61=MfS=U_}`aTbw!G5W8C*k]`-8wEG8S4#9b`^0o2i$4<*9S9?W9x|]D:[#');
define('AUTH_SALT',        '1fD;Tmw}HgS_w=H@*#zLO1E[`az&^9-7mU!UpijFMb<aFwkl1;!SN573^x1O]y&9');
define('SECURE_AUTH_SALT', 'e*oH& wK+gRty;|L|bgm&998~R3lEQKX+#zK`|&SIT-TMbI}RJ!<,*zpCw7$IWJk');
define('LOGGED_IN_SALT',   'u}B)JanFC>D-/x#2n`0h;Fuo0zknUeAYL?0/%(,i>,k#9JS(C`]hImiG,/{50m95');
define('NONCE_SALT',       'Uq5E]!C BW~WM/*b|;R~`R0Z`3sBRsyqhw|*ayU93Yu?vfw#$NAWTMiXzmp;3VF8');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'dev_';

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
