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
		'supports' => array('title', 'editor', 'thumbnail'),
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

add_filter( 'tutor_course/single/lead_info', 'print_lead_info' );
add_action( 'tutor_course/single/lead_meta/before', 'print_lead_info' );

function print_lead_info( $value )
{
	//$value = preg_replace('/<a href[.+]\/wordpress\/profile\/[.+]</a>/', '<p>GGGGGGGGGONDES</p>', $value);
	echo '<pre>'.print_r($value,true).'</pre>';
	$value = str_replace('<a href="http://localhost/wordpress/profile/ajt">ajt</a>', '<p>KERUPUK</p>', $value);
	return $value;
}

?>
