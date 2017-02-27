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
define('DB_NAME', 'db_timetracker');

/** MySQL database username */
define('DB_USER', 'user_timeTracker');

/** MySQL database password */
define('DB_PASSWORD', 'no time for love');

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
define('AUTH_KEY',         'LY1L+M?KfE~a+pzRL,`+R=;R*S0^%qJz)hLqED H]5Dop(%j=||Cdb=x#Q8QrT+5');
define('SECURE_AUTH_KEY',  '`bgf{^NyWci~fed^`vw]f~dmu>Zv~voeA>zC;a{7h&82g:T]75n|d7`?Aa?bQiSb');
define('LOGGED_IN_KEY',    'xaibt$}[j9;_&B,# <9DOW4nwfZWmPWI9_YKLG: 4/5E5ssh].lao.bR6/i`9a8=');
define('NONCE_KEY',        'c3f{c;au{i_;AOmTNNG%WaXG- @8~g)^Q&b:FAe=5{i/,c~FBU(-2Q>waHwx`I3B');
define('AUTH_SALT',        'V={q84@N:{y%0<>RxqO-0F3# |%rM8I}_b^TN+YQ[k;{TBJmvqB#>/w^L}sa:IMH');
define('SECURE_AUTH_SALT', '9bXo<%<1|DBM1&4K d*IreQ89NNXXZ9~>ssruI>(Ds{n:=y(h@C.4W&G[%G*>ogx');
define('LOGGED_IN_SALT',   '~.SUrN7/Be?PZ3_Mke/~kgJk+Lj>h4@*g&?s{}w|5&4C|*i:>f)UBlNm!2=9FGyZ');
define('NONCE_SALT',       ';_qz*]|UQNekKsfb?%}hGRK_/_fZtTqZ4vgNJ^ot/73(We*Vp4YH3?%-m4`$?z7f');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'tbl_';

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
