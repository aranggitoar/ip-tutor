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
			IP_TUTOR_PUBLIC_LOCATION_URL . 'css/ip-tutor-public.css',
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
			IP_TUTOR_PUBLIC_LOCATION_URL . 'js/ip-tutor-public.js',
			array( 'jquery' ),
			$this->version,
			false
		);

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
	private static function get_current_course_instructor_post_id(
		$post_ID )
	{
		return get_post_meta( $post_ID, 'assigned_instructors' )[0];
	}


	/**
	 * TODO: Check if the current theme doesn't have the required
	 * template and copy a modified one.
	 *
	 * Assemble the IP Tutor instructor's data.
	 *
	 * @since     0.4.0
	 * @param			int					$post_ID
	 *						ID of the current post.
	 * @return    array
	 *						The requested Tutor LMS course instructor data.
	 */
	public static function get_ip_tutor_instructor_data( $post_ID )
	{
    if ( get_post_type( $post_ID ) === "ip-tutor" ) {
      $ip_page_id = $post_ID;
    } else {
      $ip_page_id =
        IP_Tutor_Public::get_current_course_instructor_post_id(
          $post_ID );
    }
    $name = get_the_title( $ip_page_id );
    $bio = get_post_meta( $ip_page_id, 'short_biography' )[0];
    $job_title = get_post_meta( $ip_page_id, 'job_title' )[0];
    $profile_picture_url = get_post_meta( $ip_page_id,
      'profile_picture' )[0]['url'];
    $profile_url = get_permalink( $ip_page_id );
    $course_count = '';
    $total_students = '';

    return array (
      'ID' => $ip_page_id,
      'name' => $name,
      'bio' => $bio,
      'job_title' => $job_title,
      'profile_picture_url' => $profile_picture_url,
      'profile_url' => $profile_url,
      'course_count' => $course_count,
      'total_students' => $total_students
    );
	}

}

?>
