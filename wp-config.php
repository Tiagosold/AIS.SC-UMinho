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
//define('DB_NAME', 'bitnami_wordpress');
define('DB_NAME', 'ais_wordpress');

/** MySQL database username */
//define('DB_USER', 'bn_wordpress');
define('DB_USER', 'ais');

/** MySQL database password */
//define('DB_PASSWORD', 'f8949f31a4');
define('DB_PASSWORD', 'TSI.2.MARKET');

/** MySQL hostname */
//define('DB_HOST', 'locahost:3306');
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
define('AUTH_KEY',         '10f6e31fe1005a16014c1474b5b33fc22b8a2f1093da9003fd1fc498b19b23c8');
define('SECURE_AUTH_KEY',  '0b1a7c21d7d8e98436bbec71229862e6567fa6ae04c7452d1afb9da05f0c19e2');
define('LOGGED_IN_KEY',    '71671d59c780ed2251d5c3e3f2bcf62330cf82343b6ca1490ea558da0997e4cd');
define('NONCE_KEY',        '9a426b36872aa9ffd7d5b2170593f23daa61462debcf5d52e79b5e9d52375582');
define('AUTH_SALT',        '71b90106074ffb7460aace82cc0b544bae4a5eea6a31eb81138421946dbb8d88');
define('SECURE_AUTH_SALT', 'd4649ca7f5246b15a625e54f076ed391c1f5bc585f82c9647f7743d20c38d0db');
define('LOGGED_IN_SALT',   '978327dabda9c25ca4564257c6ee4100fbb0e23fb011e0fb08b60f85c9ec68a0');
define('NONCE_SALT',       '54c9bc9081113da1e9d0b6692ec661f65c13e53694bb97e3424b055b8b3275b3');

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
define('WP_DEBUG', true);
error_reporting(E_ALL);
ini_set('display_errors', true);

/* That's all, stop editing! Happy blogging. */
/**
 * The WP_SITEURL and WP_HOME options are configured to access from any hostname or IP address.
 * If you want to access only from an specific domain, you can modify them. For example:
 *  define('WP_HOME','http://example.com');
 *  define('WP_SITEURL','http://example.com');
 *
*/

define('WP_SITEURL', 'https://' . $_SERVER['HTTP_HOST'] . '/');
define('WP_HOME', 'https://' . $_SERVER['HTTP_HOST'] . '/');
define('FORCE_SSL_ADMIN', true);

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
define('UPLOADS', 'wp-content/uploads');
define('WP_TEMP_DIR', ABSPATH . 'wp-content/');

//  Disable pingback.ping xmlrpc method to prevent Wordpress from participating in DDoS attacks
//  More info at: https://docs.bitnami.com/?page=apps&name=wordpress&section=how-to-re-enable-the-xml-rpc-pingback-feature

// remove x-pingback HTTP header
add_filter('wp_headers', function($headers) {
    unset($headers['X-Pingback']);
    return $headers;
});
// disable pingbacks
add_filter( 'xmlrpc_methods', function( $methods ) {
        unset( $methods['pingback.ping'] );
        return $methods;
});
add_filter( 'auto_update_translation', '__return_false' );

