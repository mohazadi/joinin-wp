<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://faryan.cloud/joinin
 * @since             3.0.0
 * @package           JoinIN
 *
 * @wordpress-plugin
 * Plugin Name:       JoinIN
 * Plugin URI:        https://github.com/mohazadi/joinin-wp
 * Description:       JoinIN is an open source web conferencing system. This plugin integrates JoinIN into WordPress allowing bloggers to create and manage meetings rooms by using a Custom Post Type. For more information on setting up your own JoinIN server or for using an external hosting provider visit https://faryan.cloud/joinin/support.
 * Version:           3.0.0-beta.4
 * Author:            mmd.azadi@gmail.com
 * Author URI:        https://azadiweb.ir.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       JoinIN.IR
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 3.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'JOININ_VERSION', '3.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-joinin-activator.php
 */
function activate_joinin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-joinin-activator.php';
	JoinIN_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-joinin-deactivator.php
 */
function deactivate_joinin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-joinin-deactivator.php';
	JoinIN_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_joinin' );
register_deactivation_hook( __FILE__, 'deactivate_joinin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-joinin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    3.0.0
 */
function run_joinin() {

	$plugin = new JoinIN();
	$plugin->run();

}
run_joinin();


function userdate($time, $format) {
    $tz = date_default_timezone_get();
    date_default_timezone_set('Asia/Tehran');
    $fday = date_i18n( $format, $time);
    date_default_timezone_set($tz);

    return $fday;
}


// Increase the timeout
add_filter( 'http_request_timeout', 'joinin_request_timeout' );
function joinin_request_timeout( $val ) {
    return 30;
}
