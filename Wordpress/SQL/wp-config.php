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
define('DB_NAME', 'drshafi');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'xI%9({lJ8^{u3xL5va.u,]{n?U,P]G`-5_a.PTrhP/]%.P{EI~#>!XO%=].[b6li');
define('SECURE_AUTH_KEY',  'Gu[;lExlD4O`^jDe@p[OQ;%4{/8(L<;g+3>/oQ-iU7^0i17Kuf{02yz/CG>fHT{Z');
define('LOGGED_IN_KEY',    'B/0EW) <AKe2<iD_P4zOobr vjp<(XA+,lb6LWO/AmY@%/;nbT3R6:s3:Y|r@b^2');
define('NONCE_KEY',        'd f|k+nuyK+PwP/9|Yyo<N5LHL;-?jCB9@)X76kL|)|fxS7nwhI.G/d&jD{fRD|>');
define('AUTH_SALT',        ')cEO{+G|j<zBXgw(wwD(DfVAS#4eLE&ZG+$-W[srj:nu?_1yW]3Xc{Uq<2{3bTX$');
define('SECURE_AUTH_SALT', '|Ars34<u/<oWg~KD2SzaY<-8S0>EYLu%i!J{}M@FQk7FK-tlfT`l``tX9h`K9y]j');
define('LOGGED_IN_SALT',   ',[#^m2<ugo?W{rlLHvwRk)Qw8cTiSdtlW1;I}v:.<E~<;oEzQBKQMn(2Ul3[}5pL');
define('NONCE_SALT',       'Ss}ODYmp@.LYlZG%XeNo:kY)Z4jJg)E{Rmf!TC7Y|qUBR$ue%0eU0!|OeJg%339o');

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
