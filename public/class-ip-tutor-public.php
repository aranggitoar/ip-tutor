<?php

/**
 * The public-facing functionality of IP Tutor.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @since						0.3.0
 * @package					IP_Tutor
 * @subpackage			IP_Tutor/public
 * @author					Aranggi Toar <aranggi.josef@gmail.com>
 */
class IP_Tutor_Public
{

	/**
	 * The ID of IP Tutor.
	 *
	 * @since			0.3.0
	 * @access		private
	 * @var				string		$ip_tutor
	 *						The ID of IP Tutor.
	 */
	private $ip_tutor;

	/**
	 * The version of IP Tutor.
	 *
	 * @since    	0.3.0
	 * @access   	private
	 * @var      	string		$version
	 *						The current version of IP Tutor.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since			0.3.0
	 * @param     string		$ip_tutor
	 *						The name of IP Tutor.
	 * @param     string    $version
	 *						The version of IP Tutor.
	 */
	public function __construct( $ip_tutor, $version ) {

		$this->ip_tutor = $ip_tutor;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.3.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run()
		 * function defined in IP_Tutor_Loader as all of the hooks are
		 * defined in that particular class.
		 *
		 * The IP_Tutor_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style(
			$this->ip_tutor,
			plugin_dir_url( __FILE__ ) . 'css/plugin-name-public.css',
			array(),
			$this->version,
			'all'
		);

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    0.3.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run()
		 * function defined in IP_Tutor_Loader as all of the hooks are
		 * defined in that particular class.
		 *
		 * The IP_Tutor_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script(
			$this->ip_tutor,
			plugin_dir_url( __FILE__ ) . 'js/plugin-name-public.js',
			array( 'jquery' ),
			$this->version,
			false
		);

	}

}

?>
