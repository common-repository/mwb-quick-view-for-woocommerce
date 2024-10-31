<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://makewebbetter.com/
 * @since             1.0.0
 * @package           Mwb_Quick_View_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       MWB Quick View for WooCommerce
 * Plugin URI:        https://wordpress.org/plugins/mwb-quick-view-for-woocommerce/
 * Description:       Quick view enables your customers to have a complete look at your products in a modal window on shop page without opening the single product pages.
 * Version:           1.0.0
 * Author:            MakeWebBetter
 * Author URI:        https://makewebbetter.com/?utm_source=MWB-QuickView-org&utm_medium=MWB-org-backend&utm_campaign=MWB-QuickView-demo
 * Text Domain:       mwb-quick-view-for-woocommerce
 * Domain Path:       /languages
 *
 * Requires at least: 4.6
 * Tested up to:      5.4.1
 *
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Define plugin constants.
 *
 * @since             1.0.0
 */
function define_mwb_wqv_quick_view_constants() {

	mwb_wqv_quick_view_constants( 'MWB_QUICK_VIEW_FOR_WOOCOMMERCE_VERSION', '1.0.0' );
	mwb_wqv_quick_view_constants( 'MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_PATH', plugin_dir_path( __FILE__ ) );
	mwb_wqv_quick_view_constants( 'MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL', plugin_dir_url( __FILE__ ) );
	mwb_wqv_quick_view_constants( 'MWB_QUICK_VIEW_FOR_WOOCOMMERCE_SERVER_URL', 'https://makewebbetter.com' );
	mwb_wqv_quick_view_constants( 'MWB_QUICK_VIEW_FOR_WOOCOMMERCE_ITEM_REFERENCE', 'MWB Quick View for WooCommerce' );
}

/**
 * Callable function for defining plugin constants.
 *
 * @param   String $key    Key for contant.
 * @param   String $value   value for contant.
 * @since             1.0.0
 */
function mwb_wqv_quick_view_constants( $key, $value ) {

	if ( ! defined( $key ) ) {

		define( $key, $value );
	}
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mwb-quick-view-for-woocommerce-activator.php
 */
function activate_mwb_wqv_quick_view() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwb-wqv-quick-view-activator.php';
	Mwb_Wqv_Quick_View_Activator::mwb_wqv_quick_view_activate();
	$mwb_mwqv_active_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_mwqv_active_plugin ) && ! empty( $mwb_mwqv_active_plugin ) ) {
		$mwb_mwqv_active_plugin['mwb-wqv-quick-view'] = array(
			'plugin_name' => __( 'MWB Quick View for WooCommerce', 'mwb-quick-view-for-woocommerce' ),
			'active' => '1',
		);
	} else {
		$mwb_mwqv_active_plugin                               = array();
		$mwb_mwqv_active_plugin['mwb-wqv-quick-view'] = array(
			'plugin_name' => __( 'MWB Quick View for WooCommerce', 'mwb-quick-view-for-woocommerce' ),
			'active' => '1',
		);
	}
	update_option( 'mwb_all_plugins_active', $mwb_mwqv_active_plugin );
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mwb-quick-view-for-woocommerce-deactivator.php
 */
function deactivate_mwb_wqv_quick_view() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwb-wqv-quick-view-deactivator.php';
	Mwb_Wqv_Quick_View_Deactivator::mwb_wqv_quick_view_deactivate();
	$mwb_mwqv_deactive_plugin = get_option( 'mwb_all_plugins_active', false );
	if ( is_array( $mwb_mwqv_deactive_plugin ) && ! empty( $mwb_mwqv_deactive_plugin ) ) {
		foreach ( $mwb_mwqv_deactive_plugin as $mwb_mwqv_deactive_key => $mwb_mwqv_deactive ) {
			if ( 'mwb-wqv-quick-view' === $mwb_mwqv_deactive_key ) {
				$mwb_mwqv_deactive_plugin[ $mwb_mwqv_deactive_key ]['active'] = '0';
			}
		}
	}
	update_option( 'mwb_all_plugins_active', $mwb_mwqv_deactive_plugin );
}

register_activation_hook( __FILE__, 'activate_mwb_wqv_quick_view' );
register_deactivation_hook( __FILE__, 'deactivate_mwb_wqv_quick_view' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mwb-wqv-quick-view.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mwb_wqv_quick_view() {
	define_mwb_wqv_quick_view_constants();

	$mwqv_plugin_standard = new Mwb_Wqv_Quick_View();
	$mwqv_plugin_standard->mwqv_run();
	$GLOBALS['mwqv_mwb_mwqv_obj'] = $mwqv_plugin_standard;

}
run_mwb_wqv_quick_view();


// Add settings link on plugin page.
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'mwb_wqv_quick_view_settings_link' );

/**
 * Settings link.
 *
 * @since    1.0.0
 * @param   Array $links    Settings link array.
 */
function mwb_wqv_quick_view_settings_link( $links ) {

	$my_link = array(
		'<a href="' . admin_url( 'admin.php?page=mwb_wqv_quick_view_menu' ) . '">' . __( 'Settings', 'mwb-quick-view-for-woocommerce' ) . '</a>',
	);
	return array_merge( $my_link, $links );
}

/**
 * Adding custom setting links at the plugin activation list.
 *
 * @param array  $links_array array containing the links to plugin.
 * @param string $plugin_file_name plugin file name.
 * @return array
 */
function mwb_wqv_quick_view_custom_settings_at_plugin_tab( $links_array, $plugin_file_name ) {
	if ( strpos( $plugin_file_name, basename( __FILE__ ) ) ) {
		$links_array[] = '<a href="https://demo.makewebbetter.com/mwb-quick-view-for-woocommerce/?utm_source=MWB-QuickView-org&utm_medium=MWB-org-backend&utm_campaign=MWB-QuickView-demo" target="_blank"><img src="' . esc_html( MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL ) . 'admin/image/Demo.svg" class="mwb-info-img" alt="Demo image">' . __( 'Demo', 'mwb-quick-view-for-woocommerce' ) . '</a>';
		$links_array[] = '<a href="https://docs.makewebbetter.com/mwb-quick-view-for-woocommerce/?utm_source=MWB-QuickView-org&utm_medium=MWB-org-backend&utm_campaign=MWB-QuickView-doc" target="_blank"><img src="' . esc_html( MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL ) . 'admin/image/Documentation.svg" class="mwb-info-img" alt="documentation image">' . __( 'Documentation', 'mwb-quick-view-for-woocommerce' ) . '</a>';
		$links_array[] = '<a href="https://makewebbetter.com/submit-query/?utm_source=MWB-QuickView-org&utm_medium=MWB-org-backend&utm_campaign=MWB-QuickView-support" target="_blank"><img src="' . esc_html( MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL ) . 'admin/image/Support.svg" class="mwb-info-img" alt="support image">' . __( 'Support', 'mwb-quick-view-for-woocommerce' ) . '</a>';
	}
	return $links_array;
}
add_filter( 'plugin_row_meta', 'mwb_wqv_quick_view_custom_settings_at_plugin_tab', 10, 2 );


add_action( 'admin_init', 'mwb_wqv_has_parent_plugin' );

/**
 * Function is to make quickview plugin dependent on woocommerce.
 *
 * @return void
 */
function mwb_wqv_has_parent_plugin() {
	if ( is_admin() && current_user_can( 'activate_plugins' ) && ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
		add_action( 'admin_notices', 'mwb_wqv_child_plugin_notice' );

		deactivate_plugins( plugin_basename( __FILE__ ) );

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
	}
}

/**
 * Function print admin notices on deactivation.
 *
 * @return void
 */
function mwb_wqv_child_plugin_notice() {
	?>
	<div class="error">
		<p><?php esc_html_e( 'Sorry, but MWB quick view for woocommerce Plugin requires the Woocommerce plugin to be installed and active', 'mwb-quick-view-for-woocommerce' ); ?>.</p>
	</div>
	<?php
}
