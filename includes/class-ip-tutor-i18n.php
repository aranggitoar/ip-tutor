<?php

/**
 * Define the internationalization functionality.
 *
 * Loads and defines IP Tutor's internationalization files to prepare 
 * them for translation.
 *
 * @since						0.3.0
 * @package					IP_Tutor
 * @subpackage			IP_Tutor/includes
 * @author					Aranggi Toar <aranggi.josef@gmail.com>
 */
class IP_Tutor_i18n
{


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.3.0
	 */
	public function load_plugin_textdomain()
	{

		load_plugin_textdomain(
			'ip-tutor',
			false,
			dirname( __FILE__ ) . '/languages/'
		);

	}



}

?>
