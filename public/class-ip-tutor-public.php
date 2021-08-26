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
	 * @var				string			$plugin_name
	 *						The name of this plugin.
	 */
	private $plugin_name;

	/**
	 * @since    	0.3.0
	 * @access   	private
	 * @var      	string			$version
	 *						The current version of this plugin.
	 */
	private $version;


	/**
	 * @since    	0.2.0
	 * @access   	private
	 * @var      	string			$main_cpt_name
	 *						The main CPT name of this plugin.
	 */
	private $main_cpt_name;


	/**
	 * @since    	0.2.0
	 * @access   	private
	 * @var      	string			$main_cpt_slug
	 *						The main slug name of this plugin.
	 */
	private $main_cpt_slug;


	/**
	 * @since    	0.3.0
	 * @access   	private
	 * @var      	string			$tutor_courses_cpt_name
	 *						The course CPT name of Tutor LMS.
	 */
	private $tutor_courses_cpt_name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since			0.3.0
	 * @param     string			$plugin_name
	 *						The name of this plugin.
	 * @param     string			$version
	 *						The version of this plugin.
	 * @param     string			$main_cpt_name
	 *						The main CPT name of this plugin.
	 * @param     string			$main_cpt_slug
	 *						The main slug name of this plugin.
	 * @param     string			$tutor_courses_cpt_name
	 *						The course CPT name of Tutor LMS.
	 */
	public function __construct( $plugin_name, $version, $main_cpt_name,
		$main_cpt_slug, $tutor_courses_cpt_name )
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->main_cpt_name = $main_cpt_name;
		$this->main_cpt_slug = $main_cpt_slug;
		$this->tutor_courses_cpt_name = $tutor_courses_cpt_name;

	}


	/**
	 * Retrieve the main CPT name this plugin.
	 *
	 * @since     0.3.0
	 * @return    string
	 *						The main CPT name of this plugin.
	 */
	public function get_main_cpt_name()
	{
		return $this->main_cpt_name;
	}


	/**
	 * Retrieve the main CPT slug of this plugin.
	 *
	 * @since     0.3.0
	 * @return    string
	 *						The main CPT slug of this plugin.
	 */
	public function get_main_cpt_slug()
	{
		return $this->main_cpt_slug;
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
			$this->plugin_name,
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
	public function enqueue_scripts()
	{

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
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/plugin-name-public.js',
			array( 'jquery' ),
			$this->version,
			false
		);

	}


	/**
	 * TODO FOR ALL THE FOLLOWING FUNCTIONS: Integrate with the
	 * default instructor assignment logic and database management.
	 * Tutor has a specific table created for assigned instructors and
	 * their basic informations.
	 */


	/**
	 * Retrieve the requested Tutor LMS course instructor short biography.
	 *
	 * @since     0.3.0
	 * @param			int					$post_ID
	 *						ID of the current post.
	 * @return    string
	 *						The requested Tutor LMS course instructor short
	 *						biography.
	 */
	public static function get_current_course_instructor_bio( $post_ID )
	{
		return get_post_meta( $post_ID, 'short_biography' )[0];
	}


	/**
	 * Retrieve the requested Tutor LMS course instructor job title.
	 *
	 * @since     0.3.0
	 * @param			int					$post_ID
	 *						ID of the current post.
	 * @return    string
	 *						The requested Tutor LMS course instructor job title.
	 */
	public static function get_current_course_instructor_job_title(
		$post_ID )
	{
		return get_post_meta( $post_ID, 'job_title' )[0];
	}


	/**
	 * TODO: Check if there is more than one instructor assigned.
	 *
	 * Retrieve the requested Tutor LMS course instructor post id.
	 *
	 * @since     0.3.0
	 * @param			int					$post_ID
	 *						ID of the current post.
	 * @return    string
	 *						The requested Tutor LMS course instructor post id.
	 */
	public static function get_current_course_instructor_post_id(
		$post_ID )
	{
		return get_post_meta( $post_ID, 'assigned_instructors' )[0];
	}


	/**
	 * TODO: Check if the current theme doesn't have the required
	 * template and copy a modified one.
	 *
	 * Retrieve the requested Tutor LMS course instructor name.
	 *
	 * @since     0.3.0
	 * @param			int					$post_ID
	 *						ID of the current post.
	 * @return    string
	 *						The requested Tutor LMS course instructor name.
	 */
	public static function get_current_course_instructor_name(
		$post_ID )
	{
		$ip_page_id =
			IP_Tutor_Public::get_current_course_instructor_post_id(
				$post_ID );

		return get_the_title( $ip_page_id );
	}

}

?>
