<?php

/**
 * The admin-specific functionality of IP Tutor.
 *
 * Defines this plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @since						0.3.0
 * @package					IP_Tutor
 * @subpackage			IP_Tutor/public
 * @author					Aranggi Toar <aranggi.josef@gmail.com>
 */
class IP_Tutor_Admin
{

	/**
	 * @since    	0.3.0
	 * @access   	private
	 * @var      	string			$plugin_name
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
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.3.0
	 */
	public function enqueue_styles()
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

		wp_enqueue_style(
			$this->plugin_name,
			IP_TUTOR_ADMIN_LOCATION_URL . 'css/ip-tutor-admin.css',
			array(),
			$this->version,
			'all'
		);

	}


	/**
	 * Register the JavaScript for the admin area.
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
			IP_TUTOR_ADMIN_LOCATION_URL . 'js/ip-tutor-admin.js',
			array( 'jquery' ),
			$this->version,
			false
		);

	}


	/**
	 * Initialize arguments for IP Tutor's main CPT.
	 *
	 * @since			0.1.0
	 * @return		array				$args
	 *						The collection of arguments for registering post
	 *						types.
	 */
	public function initialize_ip_tutor_cpt()
	{

		$labels = array(
			'name' => 'Instructors (Instructor Page for Tutor LMS)',
			'singular_name' => 'Instructor',
		);

		$args = array(
			'labels' => $labels,
			'description' => __( 'Instructor pages for Tutor LMS.', 'tutor' ), 
			'hierarchical' => true,
			'public' => true,
			'has_archive' => true,
			'show_ui' => true,
			'show_in_menu' => false,
			'show_in_rest' => true,
			'supports' => array( 'title', 'thumbnail' ),
			'rewrite' => array( 'slug' => $this->get_main_cpt_slug() ),
		);

		return $args;

	}


	/**
	 * Register IP Tutor's main CPT.
	 *
	 * @since			0.1.0
	 */
	public function register_ip_tutor_cpt()
	{
		register_post_type( $this->get_main_cpt_name(), $this->initialize_ip_tutor_cpt() );
	}


	/**
	 * Initialize the new post type as a submenu of Tutor LMS.
	 * Reference for the action hook: tutor/classes/Admin.php.
	 *
	 * @since			0.2.0
	 */
	public function initialize_ip_tutor_submenu()
	{
		add_submenu_page(
			'tutor',
			__('Instructors', 'tutor'),
			__('Instructors', 'tutor'),
			'manage_tutor', 
			'edit.php?post_type=ip-tutor',
			null
		);
	}


	/**
	 * Load metaboxes for IP Tutor's main CPT admin view.
	 *
	 * @since			0.2.0
	 * @param			boolean			$echo
	 *						To echo the $output or return the $output
	 * @return		string			$output
	 *						The contents of the included file.
	 */
	public function load_ip_tutor_ci_metabox_view( $echo = true )
	{
		ob_start();
		include IP_TUTOR_LOCATION
			. 'admin/partials/ip-tutor-common-information-metabox.php';
		$output = ob_get_clean();

		if ($echo){
			echo $output;
		} else{
			return $output;
		}
	}


	/**
	 * Load metaboxes for IP Tutor's main CPT admin view.
	 *
	 * @since			0.2.0
	 * @param			boolean			$echo
	 *						To echo the $output or return the $output
	 * @return		string			$output
	 *						The contents of the included file.
	 */
	public function load_ip_tutor_ca_metabox_view( $echo = true )
	{
		ob_start();
		include IP_TUTOR_LOCATION
			. 'admin/partials/ip-tutor-course-assignment-metabox.php';
		$output = ob_get_clean();

		if ($echo){
			echo $output;
		} else{
			return $output;
		}
	}


	/**
	 * Register the loaded metaboxes for IP Tutor's main CPT admin view.
	 */
	public function register_metabox_for_tutor_submenu()
	{
		add_meta_box(
			'common-info-metabox',
			__( 'Common Information', 'ip-tutor' ),
			array( $this, 'load_ip_tutor_ci_metabox_view' ),
			$this->main_cpt_name
		);

		add_meta_box(
			'courses-assignment-metabox',
			__( 'Course Assignment', 'ip-tutor' ),
			array( $this, 'load_ip_tutor_ca_metabox_view' ),
			$this->main_cpt_name
		);
	}


	/**
	 * Save the inserted metadatas into database.
	 *
	 * @param			int					$post_ID
	 *						ID of the current post.
	 */
	public function save_instructor_page_meta( $post_ID )
	{
		include_once "includes/ip-tutor-general-functions.php";

		if ( ! empty( $_POST['job_title'] ) ) {
			$job_title = sanitize_text_field( $POST['job_title'] );
			update_post_meta( $post_ID, 'job_title', $job_title );
		}

		if ( ! empty( $_POST['short_biography'] ) ) {
			$bio = sanitize_text_field( $POST['short_biography'] );
			update_post_meta( $post_ID, 'short_biography', $bio );
		}

		// Add values into assigned_courses metadata.
		if ( ! empty( $_POST['assign_courses'] ) ) {
			$courses_to_assign = sanitize_text_field( $_POST['assign_courses'] );

			if ( $courses_to_assign ) {

			}

			if ( substr_count( $courses_to_assign, ',' ) > 0 ) {
				$courses_to_update = explode( ",", $courses_to_assign, 50 );
				$str_post_ID = $post_ID;
				settype( $str_post_ID, "string" );
				foreach ( $courses_to_update as $id) {
					settype( $id, "string" );
					update_post_meta( $id, 'assigned_instructors', $post_ID );
				}
			}

			update_post_meta( $post_ID, 'assigned_courses', $courses_to_assign );
		}

		// Remove values from assigned_courses metadata.
		if ( ! empty( $_POST['deassign_courses'] ) ){
			$courses_to_deassign = sanitize_text_field( $_POST['deassign_courses'] );
			$currently_assigned = get_post_meta( $post_ID, 'assigned_courses' );
			$available_course_ids = get_posts(array(
				'fields'					=> 'ids',
				'post_per_page'		=> -1,
				'post_type'				=> 'courses'
			));

			if ( substr_count( $courses_to_deassign[0], "," ) > 0 ) {
				$courses_to_deassign = explode( ",", $courses_to_deassign[0], 50 );
			} 

			if ( ! check_page_id_existence( $courses_to_deassign, $available_course_ids ) ) {
				if ( is_array( $courses_to_deassign ) ) {
					foreach ( $courses_to_deassign as $id ) {
						if ( in_array( $id, $available_course_ids ) ) {
							$key = array_search( $id, $available_course_ids );
							unset( $courses_to_deassign[$key] );
						}
					}
				} else {
					unset( $courses_to_deassign );
				}
			}

			if ( count( $currently_assigned ) > 0 && substr_count( $currently_assigned[0], "," ) > 0 ) {
				$currently_assigned = explode( ",", $currently_assigned[0], 50 );

					foreach ( $courses_to_deassign as $id ) {
						if ( in_array( $id, $currently_assigned ) ) {
							$key = array_search( $id, $currently_assigned );
							unset( $currently_assigned[$key] );
							/* $currently_assigned = remove_items_from_array( $id, $currently_assigned ); */
						}
					}

				if ( count( $currently_assigned ) === 0 ) {
					delete_post_meta( $post_ID, 'assigned_courses' );
				} else {
					$transitional_arr = $currently_assigned;
					$currently_assigned = [];
					$currently_assigned[0] = implode( ",", $transitional_arr );

					update_post_meta( $post_ID, 'assigned_courses', $currently_assigned[0] );
				}
			} else if ( ! isset( $courses_to_deassign ) ) {
				return;
			} else {
				delete_post_meta( $post_ID, 'assigned_courses' );
			}
		}
	}


	/**
	 * TODO: Use functions specifically for manipulating array.
	 * Rearrange the order of Tutor LMS's submenus.
	 *
	 * IP Tutor's CPT admin view will be displayed after the submenu
	 * 'Tags' and before the submenu 'Students' of Tutor LMS.
	 *
	 * @since			0.1.0
	 * @param			array				$menu_order
	 *						The current admin sidebar menu order.
	 * @return		array				$menu_order
	 *						The modified admin sidebar menu order.
	 */
	public function tutor_submenu_reorder_for_ip_tutor( $menu_order )
	{
		global $submenu;

		// For debugging.
		//echo '<pre>'.print_r($submenu['tutor'],true).'</pre>';
		$tutor_arr = array();
		$tutor_arr[] = $submenu['tutor'][0];
		$tutor_arr[] = $submenu['tutor'][1];
		$tutor_arr[] = $submenu['tutor'][2];
		$tutor_arr[] = $submenu['tutor'][8];
		$tutor_arr[] = $submenu['tutor'][3];
		$tutor_arr[] = $submenu['tutor'][4];
		$tutor_arr[] = $submenu['tutor'][5];
		$tutor_arr[] = $submenu['tutor'][6];
		$tutor_arr[] = $submenu['tutor'][7];
		$tutor_arr[] = $submenu['tutor'][9];
		$tutor_arr[] = $submenu['tutor'][10];
		$tutor_arr[] = $submenu['tutor'][11];
		$submenu['tutor'] = $tutor_arr;

		return $menu_order;
	}


	/**
	 * Load metaboxes for IP Tutor's addition to Tutor LMS's admin view.
	 *
	 * @since			0.2.0
	 * @param			boolean			$echo
	 *						To echo the $output or return the $output
	 * @return		string			$output
	 *						The contents of the included file.
	 */
	public function load_ip_tutor_metabox_view_for_tutor(
		$echo = true )
	{
		ob_start();
		include IP_TUTOR_LOCATION
			. 'admin/partials/ip-tutor-metaboxes-for-tutor-courses-cpt.php';
		$output = ob_get_clean();

		if ($echo){
			echo $output;
		} else{
			return $output;
		}
	}


	/**
	 * Register the loaded metaboxes for IP Tutor's addition to Tutor
	 * LMS's admin view.
	 */
	public function register_ip_metabox_for_tutor()
	{
		add_meta_box(
			'ip-tutor-instructor',
			__( 'Instructor Page', 'tutor' ),
			array( $this, 'load_ip_tutor_metabox_view_for_tutor' ),
			$this->tutor_courses_cpt_name
		);
	}

}

?>
