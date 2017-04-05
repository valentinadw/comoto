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
define('DB_NAME', 'michecada');

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
define('AUTH_KEY',         '8)L!9J*g-(ltI>2eJ}kMuC fc-bZru+y`~Us[Nau#Xq2ZIDx6 @0EKZ? xQfEHJk');
define('SECURE_AUTH_KEY',  '+o+RQDfh>TKotyFv>UAU6wmO,I<gVV.2w>?K>x[nTd)cX(^DWhnGs,Qd*C9ZxdCn');
define('LOGGED_IN_KEY',    'MLb!?gcOQyETBXDc_QG86DrE5fXCob`R<oENR2]Y`GjnO%rVJ.Jx$H7-zq]*+]`m');
define('NONCE_KEY',        'jV$ ~4@9Z*Aw2,0|}Vcoouw|rP&*+AkQ:t?g5>D@SV)|:*).?JGDooOAXzvk7ZXn');
define('AUTH_SALT',        'Ty$S-@L9T$ sN1G0S jkXZyFZY:}~cN$/1-tZL=1_1mOj;@C^D#Bn}[onH#tu}n!');
define('SECURE_AUTH_SALT', 'Ag3}spY`i75$xlM) i n*BJaAvKXf+h{ODi~`nU=L9XID1kIs}I!$4Gd@0bViD+T');
define('LOGGED_IN_SALT',   '<yJd{Ylv(4t>Cgp]^8)./dKeZjnozG$FCsO,h}V_sWu/?)lA^bS>}uiC)M;M1{#`');
define('NONCE_SALT',       'lpu}:CD}L{.fAa85328hMoIkIe[6VQB^Xzf[i,@=7T7no_4@Bg{GXphk}Xv$1fqo');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'adw_';

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
