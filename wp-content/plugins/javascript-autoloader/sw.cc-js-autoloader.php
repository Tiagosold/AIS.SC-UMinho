<?php
/*
Plugin Name: JavaScript AutoLoader
Plugin URI: http://petersplugins.com/free-wordpress-plugins/javascript-autoloader/
Description: This Plugin allows you to load additional JavaScript files without the need to change files in the Theme directory. To load additional JavaScript files just put them into a directory named jsautoload.
Version: 1.4
Author: Peter's Plugins, smartware.cc
Author URI: http://petersplugins.com
Text Domain: javascript-autoloader
License: GPL2+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( plugin_dir_path( __FILE__ ) . '/inc/class-js-autoloader.php' );

$javascript_autoloader = new Javascript_Autoloader( __FILE__ );

?>