<?php

/**
 * Core IP Tutor class for defining internationalization,
 * admin-specific hooks, and public-facing site hooks.
 *
 * Also for maintaining unique identifiers of this plugin as well as
 * the current version of this plugin.
 *
 * @since						0.3.0
 * @package					IP_Tutor
 * @subpackage			IP_Tutor/includes
 * @author					Aranggi Toar <aranggi.josef@gmail.com>
 */
class IP_Tutor {

	/**
	 * @since    	0.3.0
	 * @access   	protected
	 * @var      	IP_Tutor_Loader    $loader
	 *					 	Maintains and registers all hooks for this plugin.
	 */
	protected $loader;

	/**
	 * @since    	0.3.0
	 * @access   	protected
	 * @var      	string    $ip_tutor
	 *					 	The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * @since    	0.3.0
	 * @access   	protected
	 * @var      	string    $version
	 *					 	The current version of this plugin.
	 */
	protected $version;

	/**
	 * @since    	0.1.0
	 * @access   	private
	 * @var      	string    $main_cpt_name
	 *						The main CPT name of this plugin.
	 */
	private $main_cpt_name;


	/**
	 * @since    	0.1.0
	 * @access   	private
	 * @var      	string    $main_cpt_slug
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
	 * Define the core functionality of IP Tutor.
	 *
	 * Set this plugin name and this plugin version that can be used
	 * throughout this plugin. Load the dependencies, define the locale,
	 * and set the hooks for the admin area and the public-facing side
	 * of the site.
	 *
	 * @since    0.3.0
	 */
	public function __construct()
	{

		if ( defined( 'IP_TUTOR_LOCATION' ) ) {
			$this->version = IP_TUTOR_LOCATION;
		} else {
			$this->version = plugin_dir_path( __FILE__ );
		}
		if ( defined( 'IP_TUTOR_LOCATION_URL' ) ) {
			$this->version = IP_TUTOR_LOCATION_URL;
		} else {
			$this->version = plugins_dir_url( __FILE__ );
		}

		if ( defined( 'IP_TUTOR_VERSION' ) ) {
			$this->version = IP_TUTOR_VERSION;
		} else {
			$this->version = '0.3.0';
		}
		$this->plugin_name = 'ip-tutor';
		$this->main_cpt_name = 'ip-tutor';
		$this->main_cpt_slug = 'instruktor';
		$this->tutor_courses_cpt_name = 'courses';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}


	/**
	 * Load the required dependencies for IP Tutor.
	 *
	 * Include the following files that make up IP Tutor:
	 *
	 * - IP_Tutor_Loader. Orchestrates the hooks for IP Tutor.
	 * - IP_Tutor_i18n. Defines internationalization functionality.
	 * - IP_Tutor_Admin. Defines all hooks for the admin area.
	 * - IP_Tutor_Public. Defines all hooks for the public side of the
	 *										site.
	 *  
	 * Create an instance of the loader which will be used to register
	 * the hooks with WordPress.
	 *
	 * @since    0.3.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters
		 * of IP Tutor's core.
		 */
		require_once IP_TUTOR_LOCATION . 'includes/class-ip-tutor-loader.php';

		/**
		 * The class responsible for defining internationalization
		 * functionality of IP Tutor's core.
		 */
		require_once IP_TUTOR_LOCATION . 'includes/class-ip-tutor-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in
		 * the admin area.
		 */
		require_once IP_TUTOR_LOCATION . 'admin/class-ip-tutor-admin.php';

		/**
		 * The class responsible for defining all actions that occur in
		 * the public-facing side of the site.
		 */
		require_once IP_TUTOR_LOCATION . 'public/class-ip-tutor-public.php';

		$this->loader = new IP_Tutor_Loader();

	}

	/**
	 * Define the locale for IP Tutor internationalization.
	 *
	 * Uses the IP_Tutor_i18n class in order to set the domain and
	 * to register the hook with WordPress.
	 *
	 * @since    0.3.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new IP_Tutor_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of IP Tutor.
	 *
	 * @since    0.3.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{

		$plugin_admin = new IP_Tutor_Admin(
			$this->get_plugin_name(),
			$this->get_version(),
			$this->get_main_cpt_name(),
			$this->get_main_cpt_slug(),
			$this->get_tutor_courses_cpt_name()
		);

		$this->loader->add_action(
			'admin_enqueue_scripts',
			$plugin_admin,
			'enqueue_styles'
		);
		$this->loader->add_action(
			'admin_enqueue_scripts',
			$plugin_admin,
			'enqueue_scripts'
		);

		$this->loader->add_action(
			'init',
			$plugin_admin,
			'register_ip_tutor_cpt'
		);

		$this->loader->add_action(
			'tutor_admin_register',
			$plugin_admin,
			'initialize_ip_tutor_submenu'
		);

		$this->loader->add_action(
			'add_meta_boxes',
			$plugin_admin,
			'register_metabox_for_tutor_submenu'
		);

		$this->loader->add_action(
			'save_post_',
			$plugin_admin,
			'save_instructor_page_meta'
		);

		add_filter( 'custom_menu_order', '__return_true' );
		$this->loader->add_filter(
			'menu_order',
			$plugin_admin,
			'tutor_submenu_reorder_for_ip_tutor'
		);

		$this->loader->add_action(
			'add_meta_boxes',
			$plugin_admin,
			'register_ip_metabox_for_tutor'
		);

		$this->loader->add_action(
			'tutor_course_builder_metabox_before',
			$plugin_admin,
			'load_ip_tutor_metabox_view_for_tutor'
		);

	}

	/**
	 * Register all of the hooks related to the public-facing
	 * functionality of IP Tutor.
	 *
	 * @since    0.3.0
	 * @access   private
	 */
	private function define_public_hooks()
	{

		$plugin_public = new IP_Tutor_Public(
			$this->get_plugin_name(),
			$this->get_version(),
			$this->get_main_cpt_name(),
			$this->get_main_cpt_slug(),
			$this->get_tutor_courses_cpt_name()
		);

		$this->loader->add_action(
			'wp_enqueue_scripts',
			$plugin_public,
			'enqueue_styles'
		);
		$this->loader->add_action(
			'wp_enqueue_scripts',
			$plugin_public,
			'enqueue_scripts'
		);

	}

	/*
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since			0.3.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of this plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.3.0
	 * @return    string		The name of this plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the
	 * plugin.
	 *
	 * @since     0.3.0
	 * @return		IP_Tutor_Loader
	 *						Orchestrates the hooks of this plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of this plugin.
	 *
	 * @since     0.3.0
	 * @return    string
	 *						The version number of this plugin.
	 */
	public function get_version()
	{
		return $this->version;
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
	 * Retrieve the courses CPT name of Tutor LMS.
	 *
	 * @since     0.3.0
	 * @return    string
	 *						The courses CPT name of Tutor LMS.
	 */
	public function get_tutor_courses_cpt_name()
	{
		return $this->tutor_courses_cpt_name;
	}
}

?>

