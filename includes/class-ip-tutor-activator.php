<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since						0.3.0
 * @package					IP_Tutor
 * @subpackage			IP_Tutor/includes
 * @author					Aranggi Toar <aranggi.josef@gmail.com>
 */
class IP_Tutor_Activator {

	/**
	 * TODO: Add default settings for slug name and page examples.
	 * Short Description.
	 *
	 * Long Description.
	 *
	 * @since			0.3.0
	 */
	public static function activate( $file = __FILE__ ) {
		register_uninstall_hook( $file, 'uninstaller' );
		return;
	}


	/**
	 * TODO: How?
	 * Delete created databases.
	 *
	 * @since			0.3.0
	 */
	private function uninstaller()
	{
		return;	
	}


}

?>
