<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Quick_View_For_Woocommerce
 * @subpackage Mwb_Quick_View_For_Woocommerce/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Mwb_Quick_View_For_Woocommerce
 * @subpackage Mwb_Quick_View_For_Woocommerce/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Mwb_Wqv_Quick_View {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Mwb_Wqv_Quick_View_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $mwqv_onboard    To initializsed the object of class onboard.
	 */
	protected $mwqv_onboard;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area,
	 * the public-facing side of the site and common side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'MWB_QUICK_VIEW_FOR_WOOCOMMERCE_VERSION' ) ) {

			$this->version = MWB_QUICK_VIEW_FOR_WOOCOMMERCE_VERSION;
		} else {

			$this->version = '1.0.0';
		}

		$this->plugin_name = 'mwb-quick-view-for-woocommerce';

		$this->mwb_wqv_quick_view_dependencies();
		$this->mwb_wqv_quick_view_locale();
		if ( is_admin() ) {
			$this->mwb_wqv_quick_view_admin_hooks();
		}
			$this->mwb_wqv_quick_view_public_hooks();

		$this->mwb_wqv_quick_view_common_hooks();

		$this->mwb_wqv_quick_view_api_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Mwb_Woocommerce_Quick_View_Loader. Orchestrates the hooks of the plugin.
	 * - Mwb_Woocommerce_Quick_View_i18n. Defines internationalization functionality.
	 * - Mwb_Woocommerce_Quick_View_Admin. Defines all hooks for the admin area.
	 * - Mwb_Woocommerce_Quick_View_Common. Defines all hooks for the common area.
	 * - Mwb_Woocommerce_Quick_View_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function mwb_wqv_quick_view_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mwb-wqv-quick-view-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mwb-wqv-quick-view-i18n.php';

		if ( is_admin() ) {

			// The class responsible for defining all actions that occur in the admin area.
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-mwb-wqv-quick-view-admin.php';

			// The class responsible for on-boarding steps for plugin.
			if ( is_dir( plugin_dir_path( dirname( __FILE__ ) ) . 'onboarding' ) && ! class_exists( 'Mwb_Wqv_Quick_View_Onboarding_Steps' ) ) {
				require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mwb-wqv-quick-view-onboarding-steps.php';
			}

			if ( class_exists( 'Mwb_Wqv_Quick_View_Onboarding_Steps' ) ) {
				$mwqv_onboard_steps = new Mwb_Wqv_Quick_View_Onboarding_Steps();
			}
		}
			// The class responsible for defining all actions that occur in the public-facing side of the site.
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-mwb-wqv-quick-view-public.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'package/rest-api/class-mwb-wqv-quick-view-rest-api.php';

		/**
		 * This class responsible for defining common functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'common/class-mwb-wqv-quick-view-common.php';

		$this->loader = new Mwb_Wqv_Quick_View_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Mwb_Woocommerce_Quick_View_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function mwb_wqv_quick_view_locale() {

		$plugin_i18n = new Mwb_Wqv_Quick_View_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function mwb_wqv_quick_view_admin_hooks() {

		$mwqv_plugin_admin = new Mwb_Wqv_Quick_View_Admin( $this->mwqv_get_plugin_name(), $this->mwqv_get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $mwqv_plugin_admin, 'mwqv_admin_enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $mwqv_plugin_admin, 'mwqv_admin_enqueue_scripts' );

		// Add settings menu for MWB Quick View for WooCommerce.
		$this->loader->add_action( 'admin_menu', $mwqv_plugin_admin, 'mwqv_options_page' );
		$this->loader->add_action( 'admin_menu', $mwqv_plugin_admin, 'mwb_mwqv_remove_default_submenu', 50 );

		// All admin actions and filters after License Validation goes here.
		$this->loader->add_filter( 'mwb_add_plugins_menus_array', $mwqv_plugin_admin, 'mwqv_admin_submenu_page', 15 );

		// preview modal hooks.
		$this->loader->add_filter( 'mwb_mwqv_after_general_settings_form', $mwqv_plugin_admin, 'mwb_wqv_options_settings_preview_modal' );

	}

	/**
	 * Register all of the hooks related to the common functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function mwb_wqv_quick_view_common_hooks() {

		$mwqv_plugin_common = new Mwb_Wqv_Quick_View_Common( $this->mwqv_get_plugin_name(), $this->mwqv_get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $mwqv_plugin_common, 'mwqv_common_enqueue_styles' );

		$this->loader->add_action( 'wp_enqueue_scripts', $mwqv_plugin_common, 'mwqv_common_enqueue_scripts' );

		// Saving general settings.
		$this->loader->add_filter( 'mwqv_general_settings_array', $mwqv_plugin_common, 'wqv_admin_general_settings_page', 10 );

		// Saving tab settings.
		$this->loader->add_action( 'mwb_wqv_save_settings_notice', $mwqv_plugin_common, 'wqv_admin_save_tab_settings' );

		// Making and saving Quick View for Woocommerce options settings.
		$this->loader->add_filter( 'wqv_options_array', $mwqv_plugin_common, 'wqv_admin_options_page', 10 );
		$this->loader->add_action( 'mwb_wqv_save_settings_notice', $mwqv_plugin_common, 'mwb_wqv_admin_save_options_tab_settings' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function mwb_wqv_quick_view_public_hooks() {

		$mwqv_plugin_public = new Mwb_Wqv_Quick_View_Public( $this->mwqv_get_plugin_name(), $this->mwqv_get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $mwqv_plugin_public, 'mwqv_public_enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $mwqv_plugin_public, 'mwqv_public_enqueue_scripts' );

		// hook to add quickview button.
		$this->loader->add_action( 'woocommerce_after_shop_loop_item', $mwqv_plugin_public, 'mwb_wqv_quickview_button_and_modal' );

		// modal on wp_footer.
		$this->loader->add_action( 'wp_footer', $mwqv_plugin_public, 'mwb_wqv_modal_html' );

		// ajax hooks for Quick View for Woocommerce popup model.
		$this->loader->add_action( 'wp_ajax_mwb_wqv_quickview_render_popup', $mwqv_plugin_public, 'mwb_wqv_quickview_render_popup' );
		$this->loader->add_action( 'wp_ajax_nopriv_mwb_wqv_quickview_render_popup', $mwqv_plugin_public, 'mwb_wqv_quickview_render_popup' );

		// ajax hooks for Quick View for Woocommerce popup model for variation.
		$this->loader->add_action( 'wp_ajax_mwb_wqv_quickview_render_popup_for_variable_product', $mwqv_plugin_public, 'mwb_wqv_quickview_render_popup_for_variable_product' );
		$this->loader->add_action( 'wp_ajax_nopriv_mwb_wqv_quickview_render_popup_for_variable_product', $mwqv_plugin_public, 'mwb_wqv_quickview_render_popup_for_variable_product' );

	}

	/**
	 * Register all of the hooks related to the api functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function mwb_wqv_quick_view_api_hooks() {

		$mwqv_plugin_api = new Mwb_Wqv_Quick_View_Rest_Api( $this->mwqv_get_plugin_name(), $this->mwqv_get_version() );

		$this->loader->add_action( 'rest_api_init', $mwqv_plugin_api, 'mwb_mwqv_add_endpoint' );

	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function mwqv_run() {
		$this->loader->mwqv_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function mwqv_get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Mwb_Wqv_Quick_View_Loader    Orchestrates the hooks of the plugin.
	 */
	public function mwqv_get_loader() {
		return $this->loader;
	}


	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Mwb_Wqv_Quick_View_Onboard    Orchestrates the hooks of the plugin.
	 */
	public function mwqv_get_onboard() {
		return $this->mwqv_onboard;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function mwqv_get_version() {
		return $this->version;
	}

	/**
	 * Predefined default mwb_mwqv_plug tabs.
	 *
	 * @return  Array       An key=>value pair of MWB Quick View for WooCommerce tabs.
	 */
	public function mwb_mwqv_plug_default_tabs() {

		$mwqv_default_tabs = array();

		$mwqv_default_tabs['mwb-wqv-quick-view-overview']      = array(
			'title'       => esc_html__( 'Overview', 'mwb-quick-view-for-woocommerce' ),
			'name'        => 'mwb-wqv-quick-view-overview',
			'file_path'   => MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/mwb-quick-view-for-woocommerce-overview.php',
		);
		$mwqv_default_tabs['mwb-wqv-quick-view-general']       = array(
			'title'       => esc_html__( 'General Settings', 'mwb-quick-view-for-woocommerce' ),
			'name'        => 'mwb-wqv-quick-view-general',
			'file_path'   => MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/mwb-quick-view-for-woocommerce-general.php',
		);
		$mwqv_default_tabs['wqv-quick-view-options']           = array(
			'title'       => esc_html__( 'QuickView Options', 'mwb-quick-view-for-woocommerce' ),
			'name'        => 'wqv-quick-view-options',
			'file_path'   => MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/wqv-quick-view-options.php',
		);
		$mwqv_default_tabs['mwb-wqv-quick-view-system-status'] = array(
			'title'       => esc_html__( 'System Status', 'mwb-quick-view-for-woocommerce' ),
			'name'        => 'mwb-wqv-quick-view-system-status',
			'file_path'   => MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/mwb-quick-view-for-woocommerce-system-status.php',
		);

		$mwqv_default_tabs = apply_filters( 'mwb_mwqv_plugin_standard_admin_settings_tabs', $mwqv_default_tabs );
		return $mwqv_default_tabs;
	}

	/**
	 * Locate and load appropriate tempate.
	 *
	 * @since   1.0.0
	 * @param string $path path file for inclusion.
	 * @param array  $params parameters to pass to the file for access.
	 */
	public function mwb_mwqv_plug_load_template( $path, $params = array() ) {

		$mwqv_file_path = $path;

		if ( file_exists( $mwqv_file_path ) ) {

			include $mwqv_file_path;
		} else {

			/* translators: %s: file path */
			$mwqv_notice = sprintf( esc_html__( 'Unable to locate file at location "%s". Some features may not work properly in this plugin. Please contact us!', 'mwb-quick-view-for-woocommerce' ), $mwqv_file_path );
			$this->mwb_mwqv_plug_admin_notice( $mwqv_notice, 'error' );
		}
	}

	/**
	 * Show admin notices.
	 *
	 * @param  string $mwqv_message    Message to display.
	 * @param  string $type       notice type, accepted values - error/update/update-nag.
	 * @since  1.0.0
	 */
	public static function mwb_mwqv_plug_admin_notice( $mwqv_message, $type = 'error' ) {

		$mwqv_classes = 'notice ';

		switch ( $type ) {

			case 'update':
				$mwqv_classes .= 'updated is-dismissible';
				break;

			case 'update-nag':
				$mwqv_classes .= 'update-nag is-dismissible';
				break;

			case 'success':
				$mwqv_classes .= 'notice-success is-dismissible';
				break;

			default:
				$mwqv_classes .= 'notice-error is-dismissible';
		}

		$mwqv_notice  = '<div class="' . esc_attr( $mwqv_classes ) . '">';
		$mwqv_notice .= '<p>' . esc_html( $mwqv_message ) . '</p>';
		$mwqv_notice .= '</div>';

		echo wp_kses_post( $mwqv_notice );
	}


	/**
	 * Show WordPress and server info.
	 *
	 * @return  Array $mwqv_system_data       returns array of all WordPress and server related information.
	 * @since  1.0.0
	 */
	public function mwb_mwqv_plug_system_status() {
		global $wpdb;
		$mwqv_system_status    = array();
		$mwqv_wordpress_status = array();
		$mwqv_system_data      = array();

		// Get the web server.
		$mwqv_system_status['web_server'] = isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '';

		// Get PHP version.
		$mwqv_system_status['php_version'] = function_exists( 'phpversion' ) ? phpversion() : __( 'N/A (phpversion function does not exist)', 'mwb-quick-view-for-woocommerce' );

		// Get the server's IP address.
		$mwqv_system_status['server_ip'] = isset( $_SERVER['SERVER_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_ADDR'] ) ) : '';

		// Get the server's port.
		$mwqv_system_status['server_port'] = isset( $_SERVER['SERVER_PORT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_PORT'] ) ) : '';

		// Get the server path.
		$mwqv_system_status['server_path'] = defined( 'ABSPATH' ) ? ABSPATH : __( 'N/A (ABSPATH constant not defined)', 'mwb-quick-view-for-woocommerce' );

		// Get the OS.
		$mwqv_system_status['os'] = function_exists( 'php_uname' ) ? php_uname( 's' ) : __( 'N/A (php_uname function does not exist)', 'mwb-quick-view-for-woocommerce' );

		// Get WordPress version.
		$mwqv_wordpress_status['wp_version'] = function_exists( 'get_bloginfo' ) ? get_bloginfo( 'version' ) : __( 'N/A (get_bloginfo function does not exist)', 'mwb-quick-view-for-woocommerce' );

		// Get and count active WordPress plugins.
		$mwqv_wordpress_status['wp_active_plugins'] = function_exists( 'get_option' ) ? count( get_option( 'active_plugins' ) ) : __( 'N/A (get_option function does not exist)', 'mwb-quick-view-for-woocommerce' );

		// See if this site is multisite or not.
		$mwqv_wordpress_status['wp_multisite'] = function_exists( 'is_multisite' ) && is_multisite() ? __( 'Yes', 'mwb-quick-view-for-woocommerce' ) : __( 'No', 'mwb-quick-view-for-woocommerce' );

		// See if WP Debug is enabled.
		$mwqv_wordpress_status['wp_debug_enabled'] = defined( 'WP_DEBUG' ) ? __( 'Yes', 'mwb-quick-view-for-woocommerce' ) : __( 'No', 'mwb-quick-view-for-woocommerce' );

		// See if WP Cache is enabled.
		$mwqv_wordpress_status['wp_cache_enabled'] = defined( 'WP_CACHE' ) ? __( 'Yes', 'mwb-quick-view-for-woocommerce' ) : __( 'No', 'mwb-quick-view-for-woocommerce' );

		// Get the total number of WordPress users on the site.
		$mwqv_wordpress_status['wp_users'] = function_exists( 'count_users' ) ? count_users() : __( 'N/A (count_users function does not exist)', 'mwb-quick-view-for-woocommerce' );

		// Get the number of published WordPress posts.
		$mwqv_wordpress_status['wp_posts'] = wp_count_posts()->publish >= 1 ? wp_count_posts()->publish : __( '0', 'mwb-quick-view-for-woocommerce' );

		// Get PHP memory limit.
		$mwqv_system_status['php_memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'mwb-quick-view-for-woocommerce' );

		// Get the PHP error log path.
		$mwqv_system_status['php_error_log_path'] = ! ini_get( 'error_log' ) ? __( 'N/A', 'mwb-quick-view-for-woocommerce' ) : ini_get( 'error_log' );

		// Get PHP max upload size.
		$mwqv_system_status['php_max_upload'] = function_exists( 'ini_get' ) ? (int) ini_get( 'upload_max_filesize' ) : __( 'N/A (ini_get function does not exist)', 'mwb-quick-view-for-woocommerce' );

		// Get PHP max post size.
		$mwqv_system_status['php_max_post'] = function_exists( 'ini_get' ) ? (int) ini_get( 'post_max_size' ) : __( 'N/A (ini_get function does not exist)', 'mwb-quick-view-for-woocommerce' );

		// Get the PHP architecture.
		if ( PHP_INT_SIZE === 4 ) {
			$mwqv_system_status['php_architecture'] = '32-bit';
		} elseif ( PHP_INT_SIZE === 8 ) {
			$mwqv_system_status['php_architecture'] = '64-bit';
		} else {
			$mwqv_system_status['php_architecture'] = 'N/A';
		}

		// Get server host name.
		$mwqv_system_status['server_hostname'] = function_exists( 'gethostname' ) ? gethostname() : __( 'N/A (gethostname function does not exist)', 'mwb-quick-view-for-woocommerce' );

		// Get the memory usage.
		$mwqv_system_status['memory_usage'] = function_exists( 'memory_get_peak_usage' ) ? round( memory_get_peak_usage( true ) / 1024 / 1024, 2 ) : 0;

		// Get CPU usage.
		// Check to see if system is Windows, if so then use an alternative since sys_getloadavg() won't work.
		if ( stristr( PHP_OS, 'win' ) ) {
			$mwqv_system_status['is_windows']        = true;
			$mwqv_system_status['windows_cpu_usage'] = function_exists( 'exec' ) ? @exec( 'wmic cpu get loadpercentage /all' ) : __( 'N/A (make sure exec is enabled)', 'mwb-quick-view-for-woocommerce' );
		}

		// Get the memory limit.
		$mwqv_system_status['memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'mwb-quick-view-for-woocommerce' );

		// Get the PHP maximum execution time.
		$mwqv_system_status['php_max_execution_time'] = function_exists( 'ini_get' ) ? ini_get( 'max_execution_time' ) : __( 'N/A (ini_get function does not exist)', 'mwb-quick-view-for-woocommerce' );
		global $wp_filesystem;
		// Get outgoing IP address.
		$mwqv_system_status['outgoing_ip'] = wp_remote_retrieve_body( wp_remote_get( 'http://ipecho.net/plain' ) );

		$mwqv_system_data['php'] = $mwqv_system_status;
		$mwqv_system_data['wp']  = $mwqv_wordpress_status;

		return $mwqv_system_data;
	}

	/**
	 * Generate html components.
	 *
	 * @param  string $mwqv_components    html to display.
	 * @since  1.0.0
	 */
	public function mwb_mwqv_plug_generate_html( $mwqv_components = array() ) {
		if ( is_array( $mwqv_components ) && ! empty( $mwqv_components ) ) {
			foreach ( $mwqv_components as $mwqv_component ) {
				if ( ! empty( $mwqv_component['type'] ) && ! empty( $mwqv_component['id'] ) ) {
					switch ( $mwqv_component['type'] ) {

						case 'hidden':
						case 'number':
						case 'email':
						case 'text':
							?>
							<div class="mwb-form-group mwb-mwqv-<?php echo esc_attr( $mwqv_component['type'] ); ?>">
								<div class="mwb-form-group__label">
									<label for="<?php echo esc_attr( $mwqv_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $mwqv_component['title'] ) ? esc_html( $mwqv_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
								</div>
								<div class="mwb-form-group__control">
									<label class="mdc-text-field mdc-text-field--outlined">
										<span class="mdc-notched-outline">
											<span class="mdc-notched-outline__leading"></span>
											<span class="mdc-notched-outline__notch">
												<?php if ( 'number' != $mwqv_component['type'] ) { ?>
													<span class="mdc-floating-label" id="my-label-id" style=""><?php echo ( isset( $mwqv_component['placeholder'] ) ? esc_attr( $mwqv_component['placeholder'] ) : '' ); ?></span>
												<?php } ?>
											</span>
											<span class="mdc-notched-outline__trailing"></span>
										</span>
										<input
										class="mdc-text-field__input <?php echo ( isset( $mwqv_component['class'] ) ? esc_attr( $mwqv_component['class'] ) : '' ); ?>" 
										name="<?php echo ( isset( $mwqv_component['name'] ) ? esc_html( $mwqv_component['name'] ) : esc_html( $mwqv_component['id'] ) ); ?>"
										id="<?php echo esc_attr( $mwqv_component['id'] ); ?>"
										type="<?php echo esc_attr( $mwqv_component['type'] ); ?>"
										value="<?php echo ( isset( $mwqv_component['value'] ) ? esc_attr( $mwqv_component['value'] ) : '' ); ?>"
										placeholder="<?php echo ( isset( $mwqv_component['placeholder'] ) ? esc_attr( $mwqv_component['placeholder'] ) : '' ); ?>"
										>
									</label>
									<div class="mdc-text-field-helper-line">
										<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset( $mwqv_component['description'] ) ? esc_attr( $mwqv_component['description'] ) : '' ); ?></div>
									</div>
								</div>
							</div>
							<?php
							break;

						case 'password':
							?>
							<div class="mwb-form-group">
								<div class="mwb-form-group__label">
									<label for="<?php echo esc_attr( $mwqv_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $mwqv_component['title'] ) ? esc_html( $mwqv_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
								</div>
								<div class="mwb-form-group__control">
									<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
										<span class="mdc-notched-outline">
											<span class="mdc-notched-outline__leading"></span>
											<span class="mdc-notched-outline__notch">
											</span>
											<span class="mdc-notched-outline__trailing"></span>
										</span>
										<input 
										class="mdc-text-field__input <?php echo ( isset( $mwqv_component['class'] ) ? esc_attr( $mwqv_component['class'] ) : '' ); ?> mwb-form__password" 
										name="<?php echo ( isset( $mwqv_component['name'] ) ? esc_html( $mwqv_component['name'] ) : esc_html( $mwqv_component['id'] ) ); ?>"
										id="<?php echo esc_attr( $mwqv_component['id'] ); ?>"
										type="<?php echo esc_attr( $mwqv_component['type'] ); ?>"
										value="<?php echo ( isset( $mwqv_component['value'] ) ? esc_attr( $mwqv_component['value'] ) : '' ); ?>"
										placeholder="<?php echo ( isset( $mwqv_component['placeholder'] ) ? esc_attr( $mwqv_component['placeholder'] ) : '' ); ?>"
										>
										<i class="material-icons mdc-text-field__icon mdc-text-field__icon--trailing mwb-password-hidden" tabindex="0" role="button">visibility</i>
									</label>
									<div class="mdc-text-field-helper-line">
										<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset( $mwqv_component['description'] ) ? esc_attr( $mwqv_component['description'] ) : '' ); ?></div>
									</div>
								</div>
							</div>
							<?php
							break;

						case 'textarea':
							?>
							<div class="mwb-form-group">
								<div class="mwb-form-group__label">
									<label class="mwb-form-label" for="<?php echo esc_attr( $mwqv_component['id'] ); ?>"><?php echo ( isset( $mwqv_component['title'] ) ? esc_html( $mwqv_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
								</div>
								<div class="mwb-form-group__control">
									<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea"  	for="text-field-hero-input">
										<span class="mdc-notched-outline">
											<span class="mdc-notched-outline__leading"></span>
											<span class="mdc-notched-outline__notch">
												<span class="mdc-floating-label"><?php echo ( isset( $mwqv_component['placeholder'] ) ? esc_attr( $mwqv_component['placeholder'] ) : '' ); ?></span>
											</span>
											<span class="mdc-notched-outline__trailing"></span>
										</span>
										<span class="mdc-text-field__resizer">
											<textarea class="mdc-text-field__input <?php echo ( isset( $mwqv_component['class'] ) ? esc_attr( $mwqv_component['class'] ) : '' ); ?>" rows="2" cols="25" aria-label="Label" name="<?php echo ( isset( $mwqv_component['name'] ) ? esc_html( $mwqv_component['name'] ) : esc_html( $mwqv_component['id'] ) ); ?>" id="<?php echo esc_attr( $mwqv_component['id'] ); ?>" placeholder="<?php echo ( isset( $mwqv_component['placeholder'] ) ? esc_attr( $mwqv_component['placeholder'] ) : '' ); ?>"><?php echo ( isset( $mwqv_component['value'] ) ? esc_textarea( $mwqv_component['value'] ) : '' ); // WPCS: XSS ok. ?></textarea>
										</span>
									</label>

								</div>
							</div>

							<?php
							break;

						case 'select':
						case 'multiselect':
							?>
							<div class="mwb-form-group">
								<div class="mwb-form-group__label">
									<label class="mwb-form-label" for="<?php echo esc_attr( $mwqv_component['id'] ); ?>"><?php echo ( isset( $mwqv_component['title'] ) ? esc_html( $mwqv_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
								</div>
								<div class="mwb-form-group__control">
									<div class="mwb-form-select">
										<select id="<?php echo esc_attr( $mwqv_component['id'] ); ?>" name="<?php echo ( isset( $mwqv_component['name'] ) ? esc_html( $mwqv_component['name'] ) : '' ); ?><?php echo ( 'multiselect' === $mwqv_component['type'] ) ? '[]' : ''; ?>" id="<?php echo esc_attr( $mwqv_component['id'] ); ?>" class="mdl-textfield__input <?php echo ( isset( $mwqv_component['class'] ) ? esc_attr( $mwqv_component['class'] ) : '' ); ?>" <?php echo 'multiselect' === $mwqv_component['type'] ? 'multiple="multiple"' : ''; ?> >
											<?php
											foreach ( $mwqv_component['options'] as $mwqv_key => $mwqv_val ) {
												?>
												<option value="<?php echo esc_attr( $mwqv_key ); ?>"
													<?php
													if ( is_array( $mwqv_component['value'] ) ) {
														selected( in_array( (string) $mwqv_key, $mwqv_component['value'], true ), true );
													} else {
														selected( $mwqv_component['value'], (string) $mwqv_key );
													}
													?>
													>
													<?php echo esc_html( $mwqv_val ); ?>
												</option>
												<?php
											}
											?>
										</select>
										<label class="mdl-textfield__label" for="octane"><?php echo ( isset( $mwqv_component['description'] ) ? esc_attr( $mwqv_component['description'] ) : '' ); ?></label>
									</div>
								</div>
							</div>

							<?php
							break;

						case 'checkbox':
							?>
							<div class="mwb-form-group">
								<div class="mwb-form-group__label">
									<label for="<?php echo esc_attr( $mwqv_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $mwqv_component['title'] ) ? esc_html( $mwqv_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
								</div>
								<div class="mwb-form-group__control mwb-pl-4">
									<div class="mdc-form-field">
										<div class="mdc-checkbox">
											<input 
											name="<?php echo ( isset( $mwqv_component['name'] ) ? esc_html( $mwqv_component['name'] ) : esc_html( $mwqv_component['id'] ) ); ?>"
											id="<?php echo esc_attr( $mwqv_component['id'] ); ?>"
											type="checkbox"
											class="mdc-checkbox__native-control <?php echo ( isset( $mwqv_component['class'] ) ? esc_attr( $mwqv_component['class'] ) : '' ); ?>"
											value="<?php echo ( isset( $mwqv_component['value'] ) ? esc_attr( $mwqv_component['value'] ) : '' ); ?>"
											<?php checked( $mwqv_component['value'], '1' ); ?>
											/>
											<div class="mdc-checkbox__background">
												<svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
													<path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
												</svg>
												<div class="mdc-checkbox__mixedmark"></div>
											</div>
											<div class="mdc-checkbox__ripple"></div>
										</div>
										<label for="checkbox-1"><?php echo ( isset( $mwqv_component['description'] ) ? esc_attr( $mwqv_component['description'] ) : '' ); ?></label>
									</div>
								</div>
							</div>
							<?php
							break;

						case 'radio':
							?>
							<div class="mwb-form-group">
								<div class="mwb-form-group__label">
									<label for="<?php echo esc_attr( $mwqv_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $mwqv_component['title'] ) ? esc_html( $mwqv_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
								</div>
								<div class="mwb-form-group__control mwb-pl-4">
									<div class="mwb-flex-col">
										<?php
										foreach ( $mwqv_component['options'] as $mwqv_radio_key => $mwqv_radio_val ) {
											?>
											<div class="mdc-form-field">
												<div class="mdc-radio">
													<input
													name="<?php echo ( isset( $mwqv_component['name'] ) ? esc_html( $mwqv_component['name'] ) : esc_html( $mwqv_component['id'] ) ); ?>"
													value="<?php echo esc_attr( $mwqv_radio_key ); ?>"
													type="radio"
													class="mdc-radio__native-control <?php echo ( isset( $mwqv_component['class'] ) ? esc_attr( $mwqv_component['class'] ) : '' ); ?>"
													<?php checked( $mwqv_radio_key, $mwqv_component['value'] ); ?>
													>
													<div class="mdc-radio__background">
														<div class="mdc-radio__outer-circle"></div>
														<div class="mdc-radio__inner-circle"></div>
													</div>
													<div class="mdc-radio__ripple"></div>
												</div>
												<label for="radio-1"><?php echo esc_html( $mwqv_radio_val ); ?></label>
											</div>	
											<?php
										}
										?>
									</div>
								</div>
							</div>
							<?php
							break;

						case 'radio-switch':
							?>

							<div class="mwb-form-group">
								<div class="mwb-form-group__label">
									<label for="" class="mwb-form-label"><?php echo ( isset( $mwqv_component['title'] ) ? esc_html( $mwqv_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
								</div>
								<div class="mwb-form-group__control">
									<div>
										<div class="mdc-switch">
											<div class="mdc-switch__track"></div>
											<div class="mdc-switch__thumb-underlay">
												<div class="mdc-switch__thumb"></div>
												<input name="<?php echo ( isset( $mwqv_component['name'] ) ? esc_html( $mwqv_component['name'] ) : esc_html( $mwqv_component['id'] ) ); ?>" type="checkbox" id="<?php echo esc_html( $mwqv_component['id'] ); ?>" value="on" class="mdc-switch__native-control <?php echo ( isset( $mwqv_component['class'] ) ? esc_attr( $mwqv_component['class'] ) : '' ); ?>" role="switch" aria-checked="
																		<?php
																		if ( 'on' == $mwqv_component['value'] ) {
																			echo 'true';
																		} else {
																			echo 'false';
																		}
																		?>
												"
												<?php checked( $mwqv_component['value'], 'on' ); ?>
												>
											</div>
										</div>
									</div>
									<label for="mwb-form-label"><?php echo ( isset( $mwqv_component['description'] ) ? esc_attr( $mwqv_component['description'] ) : '' ); ?></label>
								</div>
							</div>
							<?php
							break;

						case 'button':
							?>
							<div class="mwb-form-group">
								<div class="mwb-form-group__label"></div>
								<div class="mwb-form-group__control">
									<button class="mdc-button mdc-button--raised" name= "<?php echo ( isset( $mwqv_component['name'] ) ? esc_html( $mwqv_component['name'] ) : esc_html( $mwqv_component['id'] ) ); ?>"
										id="<?php echo esc_attr( $mwqv_component['id'] ); ?>"> <span class="mdc-button__ripple"></span>
										<span class="mdc-button__label <?php echo ( isset( $mwqv_component['class'] ) ? esc_attr( $mwqv_component['class'] ) : '' ); ?>"><?php echo ( isset( $mwqv_component['button_text'] ) ? esc_html( $mwqv_component['button_text'] ) : '' ); ?></span>
									</button>
								</div>
							</div>

							<?php
							break;

						case 'multi':
							?>
							<div class="mwb-form-group mwb-isfw-<?php echo esc_attr( $mwqv_component['type'] ); ?>">
								<div class="mwb-form-group__label">
									<label for="<?php echo esc_attr( $mwqv_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $mwqv_component['title'] ) ? esc_html( $mwqv_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
									</div>
									<div class="mwb-form-group__control">
									<?php
									foreach ( $mwqv_component['value'] as $component ) {
										?>
											<label class="mdc-text-field mdc-text-field--outlined">
												<span class="mdc-notched-outline">
													<span class="mdc-notched-outline__leading"></span>
													<span class="mdc-notched-outline__notch">
														<?php if ( 'number' != $component['type'] ) { ?>
															<span class="mdc-floating-label" id="my-label-id" style=""><?php echo ( isset( $mwqv_component['placeholder'] ) ? esc_attr( $mwqv_component['placeholder'] ) : '' ); ?></span>
														<?php } ?>
													</span>
													<span class="mdc-notched-outline__trailing"></span>
												</span>
												<input 
												class="mdc-text-field__input <?php echo ( isset( $mwqv_component['class'] ) ? esc_attr( $mwqv_component['class'] ) : '' ); ?>" 
												name="<?php echo ( isset( $mwqv_component['name'] ) ? esc_html( $mwqv_component['name'] ) : esc_html( $mwqv_component['id'] ) ); ?>"
												id="<?php echo esc_attr( $component['id'] ); ?>"
												type="<?php echo esc_attr( $component['type'] ); ?>"
												value="<?php echo ( isset( $mwqv_component['value'] ) ? esc_attr( $mwqv_component['value'] ) : '' ); ?>"
												placeholder="<?php echo ( isset( $mwqv_component['placeholder'] ) ? esc_attr( $mwqv_component['placeholder'] ) : '' ); ?>"
												<?php echo esc_attr( ( 'number' === $component['type'] ) ? 'max=10 min=0' : '' ); ?>
												>
											</label>
								<?php } ?>
									<div class="mdc-text-field-helper-line">
										<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset( $mwqv_component['description'] ) ? esc_attr( $mwqv_component['description'] ) : '' ); ?></div>
									</div>
								</div>
							</div>
								<?php
							break;
						case 'color':
						case 'date':
						case 'file':
							?>
							<div class="mwb-form-group mwb-isfw-<?php echo esc_attr( $mwqv_component['type'] ); ?>">
								<div class="mwb-form-group__label">
									<label for="<?php echo esc_attr( $mwqv_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $mwqv_component['title'] ) ? esc_html( $mwqv_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
								</div>
								<div class="mwb-form-group__control">
									<label>
										<input 
										class="<?php echo ( isset( $mwqv_component['class'] ) ? esc_attr( $mwqv_component['class'] ) : '' ); ?>" 
										name="<?php echo ( isset( $mwqv_component['name'] ) ? esc_html( $mwqv_component['name'] ) : esc_html( $mwqv_component['id'] ) ); ?>"
										id="<?php echo esc_attr( $mwqv_component['id'] ); ?>"
										type="<?php echo esc_attr( $mwqv_component['type'] ); ?>"
										value="<?php echo ( isset( $mwqv_component['value'] ) ? esc_attr( $mwqv_component['value'] ) : '' ); ?>"
										>
									</label>
									<div class="mdc-text-field-helper-line">
										<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset( $mwqv_component['description'] ) ? esc_attr( $mwqv_component['description'] ) : '' ); ?></div>
									</div>
								</div>
							</div>
							<?php
							break;

						case 'submit':
							?>
							<tr valign="top">
								<td scope="row">
									<input type="submit" class="button button-primary" 
									name="<?php echo ( isset( $mwqv_component['name'] ) ? esc_html( $mwqv_component['name'] ) : esc_html( $mwqv_component['id'] ) ); ?>"
									id="<?php echo esc_attr( $mwqv_component['id'] ); ?>"
									class="<?php echo ( isset( $mwqv_component['class'] ) ? esc_attr( $mwqv_component['class'] ) : '' ); ?>"
									value="<?php echo esc_attr( $mwqv_component['button_text'] ); ?>"
									/>
								</td>
							</tr>
							<?php
							break;

						default:
							break;
					}
				}
			}
		}
	}
}
