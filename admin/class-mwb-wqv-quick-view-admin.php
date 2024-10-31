<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Quick_View_For_Woocommerce
 * @subpackage Mwb_Quick_View_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mwb_Quick_View_For_Woocommerce
 * @subpackage Mwb_Quick_View_For_Woocommerce/admin
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Mwb_Wqv_Quick_View_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function mwqv_admin_enqueue_styles( $hook ) {
		$screen = get_current_screen();
		if ( isset( $screen->id ) && 'makewebbetter_page_mwb_wqv_quick_view_menu' === $screen->id ) {

			wp_enqueue_style( 'mwb-mwqv-select2-css', MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/select-2/mwb-wqv-quick-view-select2.css', array(), time(), 'all' );

			wp_enqueue_style( 'mwb-mwqv-meterial-css', MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-web.min.css', array(), time(), 'all' );
			wp_enqueue_style( 'mwb-mwqv-meterial-css2', MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.css', array(), time(), 'all' );
			wp_enqueue_style( 'mwb-mwqv-meterial-lite', MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-lite.min.css', array(), time(), 'all' );

			wp_enqueue_style( 'mwb-mwqv-meterial-icons-css', MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/icon.css', array(), time(), 'all' );

			wp_enqueue_style( $this->plugin_name . '-admin-global', MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/scss/mwb-wqv-quick-view-admin-global.css', array( 'mwb-mwqv-meterial-icons-css' ), time(), 'all' );

			wp_enqueue_style( $this->plugin_name, MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/scss/mwb-wqv-quick-view-admin.scss', array(), $this->version, 'all' );
			wp_enqueue_style( 'mwb-admin-min-css', MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'admin/css/mwb-admin.min.css', array(), $this->version, 'all' );
		}
		wp_enqueue_style( 'mwb-admin-modal-preview-css', MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'admin/css/mwb-admin-modal-preview.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function mwqv_admin_enqueue_scripts( $hook ) {

		$screen = get_current_screen();
		if ( isset( $screen->id ) && 'makewebbetter_page_mwb_wqv_quick_view_menu' === $screen->id ) {
			wp_enqueue_script( 'mwb-mwqv-select2', MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/select-2/mwb-wqv-quick-view-select2.js', array( 'jquery' ), time(), false );

			wp_enqueue_script( 'mwb-mwqv-metarial-js', MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-web.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-mwqv-metarial-js2', MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-mwqv-metarial-lite', MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-lite.min.js', array(), time(), false );

			wp_register_script( $this->plugin_name . 'admin-js', MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/js/mwb-wqv-quick-view-admin.js', array( 'jquery', 'mwb-mwqv-select2', 'mwb-mwqv-metarial-js', 'mwb-mwqv-metarial-js2', 'mwb-mwqv-metarial-lite' ), $this->version, false );

			wp_localize_script(
				$this->plugin_name . 'admin-js',
				'mwqv_admin_param',
				array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'reloadurl' => admin_url( 'admin.php?page=mwb_wqv_quick_view_menu' ),
					'mwqv_gen_tab_enable' => get_option( 'mwqv_radio_switch_demo' ),
				)
			);

			wp_enqueue_script( $this->plugin_name . 'admin-js' );
		}
		wp_enqueue_script( 'mwb-wqv-admin-script', MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'admin/js/mwb-admin.js', array( 'jquery' ), time(), false );
	}

	/**
	 * Adding settings menu for MWB Quick View for woocommerce.
	 *
	 * @since    1.0.0
	 */
	public function mwqv_options_page() {
		global $submenu;
		if ( empty( $GLOBALS['admin_page_hooks']['mwb-plugins'] ) ) {
			add_menu_page( __( 'MakeWebBetter', '' ), __( 'MakeWebBetter', '' ), 'manage_options', 'mwb-plugins', array( $this, 'mwb_plugins_listing_page' ), MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/MWB_Grey-01.svg', 15 );
			$mwqv_menus = apply_filters( 'mwb_add_plugins_menus_array', array() );
			if ( is_array( $mwqv_menus ) && ! empty( $mwqv_menus ) ) {
				foreach ( $mwqv_menus as $mwqv_key => $mwqv_value ) {
					add_submenu_page( 'mwb-plugins', $mwqv_value['name'], $mwqv_value['name'], 'manage_options', $mwqv_value['menu_link'], array( $mwqv_value['instance'], $mwqv_value['function'] ) );
				}
			}
		}
	}

	/**
	 * Removing default submenu of parent menu in backend dashboard
	 *
	 * @since   1.0.0
	 */
	public function mwb_mwqv_remove_default_submenu() {
		global $submenu;
		if ( is_array( $submenu ) && array_key_exists( 'mwb-plugins', $submenu ) ) {
			if ( isset( $submenu['mwb-plugins'][0] ) ) {
				unset( $submenu['mwb-plugins'][0] );
			}
		}
	}

	/**
	 * MWB Quick View for woocommerce mwqv_admin_submenu_page.
	 *
	 * @since 1.0.0
	 * @param array $menus Marketplace menus.
	 */
	public function mwqv_admin_submenu_page( $menus = array() ) {
		$menus[] = array(
			'name'            => __( 'MWB Quick View for WooCommerce', 'mwb-quick-view-for-woocommerce' ),
			'slug'            => 'mwb_wqv_quick_view_menu',
			'menu_link'       => 'mwb_wqv_quick_view_menu',
			'instance'        => $this,
			'function'        => 'mwqv_options_menu_html',
		);
		return $menus;
	}


	/**
	 * MWB Quick View for woocommerce mwb_plugins_listing_page.
	 *
	 * @since 1.0.0
	 */
	public function mwb_plugins_listing_page() {
		$active_marketplaces = apply_filters( 'mwb_add_plugins_menus_array', array() );
		if ( is_array( $active_marketplaces ) && ! empty( $active_marketplaces ) ) {
			require MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/welcome.php';
		}
	}

	/**
	 * MWB Quick View for woocommerce admin menu page.
	 *
	 * @since    1.0.0
	 */
	public function mwqv_options_menu_html() {

		include_once MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/mwb-quick-view-for-woocommerce-admin-dashboard.php';
	}

	/**
	 * Function for modal for preview.
	 *
	 * @return void
	 */
	public function mwb_wqv_options_settings_preview_modal() {
		if ( isset( $_GET['mwqv_tab'] ) && 'wqv-quick-view-options' === $_GET['mwqv_tab'] ) {
			require MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/wqv-quick-view-preview-modal.php';
		}
	}
}
