<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       no
 * @since      1.0.0
 *
 * @package    Vs_Ymaps
 * @subpackage Vs_Ymaps/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Vs_Ymaps
 * @subpackage Vs_Ymaps/includes
 * @author     shamag <otbacmhe@gmail.com>
 */
class Vs_Ymaps_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'vs-ymaps',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
