<?php

/**
 * @link						https://aranggitoar.net/ip-tutor
 * @since						0.1.0
 * @package					IP_Tutor
 *
 * Plugin Name:			Instructor Page for Tutor LMS
 * Plugin URI:			https://aranggitoar.net/ip-tutor
 * Description:			Static instructor pages for your Tutor LMS.
 * Version:					0.4.0
 * License:					GPL-3.0
 * Author:					Aranggi Toar
 * Author URI:			https://aranggitoar.net
 * Text domain:			instructor-page-for-tutor-lms
 * Domain Path:			/languages
 * 
 * Static instructor pages extension for Tutor LMS, a plugin for Wordpress.
 * Copyright (C) 2021 Aranggi Josef Toar
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation version 3 of the License.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */


// Exit when file is called directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Define the current plugin version.
 * Semantic Versioning reference - https://semver.org.
 */
define( 'IP_TUTOR_VERSION', '0.4.0' );


/**
 * Define the variables for plugin path.
 *
 * Both plugin_dir_path and plugin_dir_url gets the filesystem and
 * URL directory path with trailing slash added for the __FILE__.
 */
define( 'IP_TUTOR_LOCATION', plugin_dir_path( __FILE__ ) );
define( 'IP_TUTOR_LOCATION_URL', plugin_dir_url( __FILE__ ) );
define( 'IP_TUTOR_ADMIN_LOCATION', IP_TUTOR_LOCATION .
	'admin/' );
define( 'IP_TUTOR_ADMIN_LOCATION_URL', IP_TUTOR_LOCATION_URL
	. 'admin/' );
define( 'IP_TUTOR_PUBLIC_LOCATION', IP_TUTOR_LOCATION .
	'public/' );
define( 'IP_TUTOR_PUBLIC_LOCATION_URL', IP_TUTOR_LOCATION_URL
	. 'public/' );


/**
 * Define IP Tutor activation function.
 */
function activate_ip_tutor()
{
	require_once IP_TUTOR_LOCATION . 'includes/class-ip-tutor-activator.php';
	IP_Tutor_Activator::activate();
}


/**
 * Define IP Tutor deactivation function.
 */
function deactivate_ip_tutor()
{
	require_once IP_TUTOR_LOCATION . 'includes/class-ip-tutor-deactivator.php';
	IP_Tutor_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ip_tutor' );
register_deactivation_hook( __FILE__, 'deactivate_ip_tutor' );


/**
 * Core IP Tutor class for defining internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require IP_TUTOR_LOCATION . 'includes/class-ip-tutor.php';


/**
 * Define IP Tutor execution function,
 *
 * @since 0.3.0
 */
function run_ip_tutor()
{
	$plugin = new IP_Tutor();
	$plugin->run();
}

run_ip_tutor();

?>
