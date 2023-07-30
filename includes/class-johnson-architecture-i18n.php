<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://gpeterson@moxcar.com
 * @since      1.0.0
 *
 * @package    Johnson_Architecture
 * @subpackage Johnson_Architecture/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Johnson_Architecture
 * @subpackage Johnson_Architecture/includes
 * @author     Gino Peterson <gpeterson@moxcar.com>
 */
class Johnson_Architecture_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'johnson-architecture',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
