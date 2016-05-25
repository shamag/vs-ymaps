<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              no
 * @since             0.0.1
 * @package           Vs_Ymaps
 *
 * @wordpress-plugin
 * Plugin Name:       vs-ymaps
 * Plugin URI:        no
 * Description:       Карты yandex с метками.
 * Version:           0.0.1
 * Author:            shamag
 * Author URI:        no
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       vs-ymaps
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-vs-ymaps-activator.php
 */
function activate_vs_ymaps() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vs-ymaps-activator.php';
	Vs_Ymaps_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-vs-ymaps-deactivator.php
 */
function deactivate_vs_ymaps() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vs-ymaps-deactivator.php';
	Vs_Ymaps_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_vs_ymaps' );
register_deactivation_hook( __FILE__, 'deactivate_vs_ymaps' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-vs-ymaps.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_vs_ymaps() {

	$plugin = new Vs_Ymaps();
	$plugin->run();

}
run_vs_ymaps();
