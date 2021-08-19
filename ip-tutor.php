<?php
/*
Plugin Name: Instructor Page for Tutor LMS
Plugin URI: htips://alkitabkita.info
Description: Add static instructor pages into your Tutor LMS, perfect for e-learning sites with instructor accounts that are not managed by its own instructor.
Version: 0.1.1
License: GPL-3.0
Author: Aranggi Toar
Author URI: htips://aranggitoar.net
Text domain: instructor-page-for-tutor-lms

Static instructor pages extension for Tutor LMS, a plugin for Wordpress.
Copyright (C) 2021 Aranggi Josef Toar

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation version 3 of the License.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define variable for path to this plugin file.
define( 'IP_TUTOR_LOCATION', dirname( __FILE__ ) );
define( 'IP_TUTOR_LOCATION_URL', plugins_url( '', __FILE__ ) );

// For debugging.
function r($var)
{
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}

function d($var)
{
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
}


/**
 * Array sanitization, taken from Tutor LMS.
 * Reference: ./tutor/classes/Utils.php:1656-1672.
 */

function sanitize_array( $input = array() ) {
	$array = array();
  
	if ( is_array( $input ) && count( $input ) ) {
		foreach ( $input as $key => $value ) {
			if ( is_array( $value )) {
				$array[$key] = $this->sanitize_array( $value );
			} else {
				$key         = sanitize_text_field( $key );
				$value       = sanitize_text_field( $value );
				$array[$key] = $value;
			}
		}
	}

	return $array;
} 


/**
 * Register a new post type for the Instructor's Pages.
 */

function register_ip_tutor_post_types() {
	$ip_post_type = "ip-tutor";

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
		'supports' => array('title', 'thumbnail'),
		'rewrite' => array('slug' => 'instructor'),
	);

	register_post_type($ip_post_type, $args);
}

add_action('init', 'register_ip_tutor_post_types');


/**
 * Initialize the new post type as a submenu of Tutor LMS.
 * The action hook is from tutor/classes/Admin.php.
 */

function ip_tutor_init()
{
	add_submenu_page('tutor', __('Instructors', 'tutor'), __('Instructors', 'tutor'), 'manage_tutor', 'edit.php?post_type=ip-tutor', null);
}

add_action( 'tutor_admin_register', 'ip_tutor_init' );


/**
 * Register metaboxes for the new CPT's admin view.
 */

function ip_tutor_existing_courses_metabox( $echo = true )
{
	ob_start();
	include IP_TUTOR_LOCATION.'/views/metabox/ip_tutor_existing_courses_metabox.php';
	$output = ob_get_clean();

	if ($echo){
		echo $output;
	} else{
		return $output;
	}
}

function register_metabox_for_instructor_cpt()
{
	$cpt = 'ip-tutor';
	add_meta_box('existing-courses-metabox', __( 'Existing Courses', 'ip-tutor' ), 'ip_tutor_existing_courses_metabox', $cpt);
}

add_action( 'add_meta_boxes', 'register_metabox_for_instructor_cpt' );


/**
 * @param $post_ID
 *
 * Save the inserted metadatas into database.
 */

add_action( 'save_post_'.'ip-tutor', 'save_instructor_page_meta', 10, 2 );

function save_instructor_page_meta( $post_ID, $post )
{
	// Add values into linked_courses metadata.
	if ( ! empty( $_POST['linked_courses'] ) ){
		$linked_courses = sanitize_text_field( $_POST['linked_courses'] );
		$currently_linked = get_post_meta( $post_ID, 'linked_courses' );
		
		$available_course_ids = get_posts(array(
			'fields'					=> 'ids',
			'post_per_page'		=> -1,
			'post_type'				=> 'courses'
		));

		if ( in_array( $linked_courses, $available_course_ids ) ) {
			if ( count($currently_linked) > 0 ) {
				$currently_linked[0] = $currently_linked[0].','.$linked_courses;	
				update_post_meta($post_ID, 'linked_courses', $currently_linked[0]);

			} else {
				update_post_meta($post_ID, 'linked_courses', $linked_courses);
			}
		} else {
			return;
		}
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

		if ( in_array( $deassign_courses, $available_course_ids ) ) {
			if ( count( $currently_linked ) > 0 ) {
				// TODO: What about singular values?
				if ( substr_count( $deassign_courses[0],"," !== 0 )) {
					$deassign_courses = explode( ",", $deassign_courses[0], 50 );
				} 

				if ( substr_count( $currently_linked[0],"," !== 0 )) {
					$currently_linked = explode( ",", $currently_linked[0], 50 );
				} 

				if ( count( $deassign_courses ) > 1 || count( $currently_linked ) > 1 ) {
					foreach ( $deassign_courses as $id ) {
						if ( in_array( $id, $currently_linked ) ) {
							$key = array_search( $id, $currently_linked );
							unset( $currently_linked[$key] );
							$currently_linked = array_values( $currently_linked );
						}
					}

					$transitional_arr = $currently_linked;

					$currently_linked = [];
					
					$currently_linked[0] = implode( ",", $transitional_arr );
				}

				update_post_meta($post_ID, 'linked_courses', $currently_linked[0]);
			} else {
				update_post_meta($post_ID, 'linked_courses', $deassign_courses);
			}
		} else {
			return;
		}
		
	}
}


/**
 * @param $menu_order
 * @return $menu_order
 *
 * Rearrange the order of Tutor LMS's submenus so that SIP for Tutor
 * LMS will be displayed after the submenu 'Tags' and before the
 * submenu 'Students'.
 */

add_filter( 'custom_menu_order', '__return_true' );
add_filter( 'menu_order', 'tutor_submenu_reorder_for_ip' );

function tutor_submenu_reorder_for_ip( $menu_order )
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
 * Register a metabox and inserts that metabox into the view of Tutor
 * LMS's course builder. The metabox will enable the admin to link
 * existing instructor(s) page into the current course page.
 */

function ip_tutor_meta_box( $echo = true )
{
	ob_start();
	include IP_TUTOR_LOCATION.'/views/metabox/ip_instructor_metabox.php';
	$output = ob_get_clean();

	if ($echo){
		echo $output;
	} else{
		return $output;
	}
}

function register_meta_box_for_tutor()
{
	$cpt = 'courses';
	add_meta_box( 'ip-tutor-instructor', __( 'Instructor Page', 'tutor' ), 'ip_tutor_meta_box', $cpt);
}

add_action( 'add_meta_boxes', 'register_meta_box_for_tutor' );
add_action( 'tutor_course_builder_metabox_before', 'ip_tutor_meta_box' );

?>
