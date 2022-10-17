<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://facebook.com/hv.sombrilla
 * @since      1.0.0
 *
 * @package    Sombrilla_Importer
 * @subpackage Sombrilla_Importer/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Sombrilla_Importer
 * @subpackage Sombrilla_Importer/includes
 * @author     HV Sombrilla <hvaldezpolanco@gmail.com>
 */
class Sombrilla_Importer_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'sombrilla-importer',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}
	
}
