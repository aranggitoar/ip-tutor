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
			IP_TUTOR_LOCATION_URL . 'css/plugin-name-admin.css',
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
			IP_TUTOR_LOCATION_URL . 'js/plugin-name-admin.js',
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
	public function load_ip_tutor_metabox_view( $echo = true )
	{
		ob_start();
		include IP_TUTOR_LOCATION
			. 'admin/partials/ip-tutor-metaboxes-for-instructor-cpt.php';
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
			'existing-courses-metabox',
			__( 'Existing Courses', 'ip-tutor' ),
			array( $this, 'load_ip_tutor_metabox_view' ),
			$this->main_cpt_name
		);
	}


	/**
	 * Save the inserted metadatas into database.
	 *
	 * @param			string			$post_ID
	 *						The string of post ID's separated by commas.
	 */
	public function save_instructor_page_meta( $post_ID, $post )
	{
		include_once "includes/ip-tutor-general-functions.php";

		// Add values into linked_courses metadata.
		if ( ! empty( $_POST['linked_courses'] ) ){
			$linked_courses = sanitize_text_field( $_POST['linked_courses'] );
			/* $currently_linked = get_post_meta( $post_ID, 'linked_courses' ); */
			/* $available_course_ids = get_posts(array( */
			/* 	'fields'					=> 'ids', */
			/* 	'post_per_page'		=> -1, */
			/* 	'post_type'				=> 'courses' */
			/* )); */

			/* if ( substr_count( $linked_courses[0],"," !== 0 ) ) { */
			/* 	$linked_courses = explode( ",", $linked_courses[0], 50 ); */
			/* } */ 

			/* if ( check_page_id_existence( $linked_courses, $available_course_ids ) && check_page_id_existence( $linked_courses, explode( ",", $currently_linked[0], 50 ), true )) { */
			/* 	if ( count($currently_linked) > 0 ) { */
			/* 		$currently_linked = explode( ",", $currently_linked[0], 50 ); */

			/* 		if ( is_array( $linked_courses ) ) { */
			/* 			foreach ( $linked_courses as $id ) { */
			/* 				if ( ! in_array( $id, $currently_linked ) ) { */
			/* 					array_push( $currently_linked, $id ); */
			/* 				} */
			/* 			} */
			/* 		} else { */
			/* 			array_push( $currently_linked, $linked_courses ); */
			/* 		} */

			/* 		$transitional_arr = $currently_linked; */
			/* 		$currently_linked = []; */
			/* 		$currently_linked[0] = implode( ",", $transitional_arr ); */

			/* 		update_post_meta($post_ID, 'linked_courses', $currently_linked[0]); */
			/* 	} else { */
					update_post_meta($post_ID, 'linked_courses', $linked_courses);
				/* } */
			/* } else { */
				/* return; */
			/* } */
		}

		// Remove values from linked_courses metadata.
		if ( ! empty( $_POST['deassign_courses'] ) ){
			$deassign_courses = sanitize_text_field( $_POST['deassign_courses'] );
			$currently_linked = get_post_meta( $post_ID, 'linked_courses' );
			$available_course_ids = get_posts(array(
				'fields'					=> 'ids',
				'post_per_page'		=> -1,
				'post_type'				=> 'courses'
			));

			if ( substr_count( $deassign_courses[0], "," ) > 0 ) {
				$deassign_courses = explode( ",", $deassign_courses[0], 50 );
			} 

			if ( ! check_page_id_existence( $deassign_courses, $available_course_ids ) ) {
				if ( is_array( $deassign_courses ) ) {
					foreach ( $deassign_courses as $id ) {
						if ( in_array( $id, $available_course_ids ) ) {
							$key = array_search( $id, $available_course_ids );
							unset( $deassign_courses[$key] );
						}
					}
				} else {
					unset( $deassign_courses );
				}
			}

			if ( count( $currently_linked ) > 0 && substr_count( $currently_linked[0], "," ) > 0 ) {
				$currently_linked = explode( ",", $currently_linked[0], 50 );

					foreach ( $deassign_courses as $id ) {
						if ( in_array( $id, $currently_linked ) ) {
							$key = array_search( $id, $currently_linked );
							unset( $currently_linked[$key] );
							/* $currently_linked = remove_items_from_array( $id, $currently_linked ); */
						}
					}

				if ( count( $currently_linked ) === 0 ) {
					delete_post_meta($post_ID, 'linked_courses');
				} else {
					$transitional_arr = $currently_linked;
					$currently_linked = [];
					$currently_linked[0] = implode( ",", $transitional_arr );

					update_post_meta($post_ID, 'linked_courses', $currently_linked[0]);
				}
			} else if ( ! isset( $deassign_courses ) ) {
				return;
			} else {
				delete_post_meta($post_ID, 'linked_courses');
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
