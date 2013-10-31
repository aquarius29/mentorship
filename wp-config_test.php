<?php
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
define('DB_NAME', 'niosite_mentorship');

/** MySQL database username */
define('DB_USER', 'niosite_mentor');

/** MySQL database password */
define('DB_PASSWORD', 'mentor123');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** MySQL hostname */

define('FTP_HOST', 'ftp://localhost:1121');
define('FTP_USER', 'dionysis');
define('FTP_PASS', 'shut_down');


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
define('AUTH_KEY',         '@4Va_V+|o3+X_V,v/#*p`F/1oNlR0EaeGB~fHfL;m~/.2P^W})y4Rq_D5h#hiokM');
define('SECURE_AUTH_KEY',  '):cD@/^Dm^%SQaXJt~g5,uxJ-,2,/+.|+wi*h.GGF|fkyX+DFE^G<8Mn*]Pm~i[n');
define('LOGGED_IN_KEY',    '%TOleSRY3fTPzr[0t^I)|B[OH+$-9Sl8+|sF+D4/v=1K|.-_TvTYN4qfPNNtZOU9');
define('NONCE_KEY',        ']#Ky+Y-K<m)h6[M/U=nkLuo$ C[:]OdmmOjwJzh~Hig1|^V6rAXohLF!wvR@4^$*');
define('AUTH_SALT',        '[^nnm@-En#V3T%5|T::7/RQL]qiv-dVnz?hD|TYZICd))|EW)BMADp=0q|^xN}gl');
define('SECURE_AUTH_SALT', 'B.~^K@45iwS`%ki>)03i.pip$FEj9_&@e!ok8DQhKJd!z/UC0<wQAW=<-P|KlnU.');
define('LOGGED_IN_SALT',   'uD+l+zE*^lSaD<S,+5>1pKKB}}_~+1{Rn,Rx1sq7Q [pdRV!2N2&ST{w2Evg`_@a');
define('NONCE_SALT',       'tQnc&5|xOnk_7p}w6T6@P:q-V)J(VlHC~<~)oTuRbyQ7@YK%S!^MqiG{lEw)RUB+');

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
