<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'slo_re_buzz');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'cw4717091');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'Mg/ncc-B|>QQ&qv-dY9>tn!26{)mWsYPXo8j=T+@x:=(UG],-iAL`x2z2zaH?0;O');
define('SECURE_AUTH_KEY',  'exDo7j,Ix5VR7o4Gv[&|-6D{8geLBbb1nd-~w0Z+V>-3kKUC{0!BWL{?}Y-|yqAU');
define('LOGGED_IN_KEY',    'x&baP3w!^&*qKu:8PbgO@{gf=?5uc{)QVNOa!ex+aW:%KOCQ$+wS..)vQ>^ZOuW5');
define('NONCE_KEY',        '-=XmkZjiG8-ULc-|r4-;:%;u?{OIluE7U(~=;Br[6d+tyBUmr_BUwsdQJZM3HB;.');
define('AUTH_SALT',        'd:dr3 (&x|^&T|&~M-<-)-!_e;ea`Q{W*{AdyY|v-6UZ?_;;=JTWweNFVSXBx7n0');
define('SECURE_AUTH_SALT', 'lhv{>LapGnE,7z+r{v$Y]vIkwP)bj+d+8} |[}DDTYC<<a)~@N/OQI$t^N&ODuMB');
define('LOGGED_IN_SALT',   '+OX yhz7o~wk[o# 1T|dYCBeBbQw#y,Xe*jbJadl(9_D{x?_5-CD!Tpo|T.qVdCV');
define('NONCE_SALT',       'hqc,kQ^$KpFc?Vkeu<{j2:Dcy7)i(b*7xL98h/FH:$HF0Y2bk2T89v`.uudSl/T5');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
