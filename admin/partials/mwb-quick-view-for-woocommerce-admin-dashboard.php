<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Quick_View_For_Woocommerce
 * @subpackage Mwb_Quick_View_For_Woocommerce/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit(); // Exit if accessed directly.
}

global $mwqv_mwb_mwqv_obj;
$mwqv_active_tab   = isset( $_GET['mwqv_tab'] ) ? sanitize_key( $_GET['mwqv_tab'] ) : 'mwb-wqv-quick-view-general';
$mwqv_default_tabs = $mwqv_mwb_mwqv_obj->mwb_mwqv_plug_default_tabs();
?>
<header>
<?php do_action( 'mwb_wqv_save_settings_notice' ); ?>
	<div class="mwb-header-container mwb-bg-white mwb-r-8">
		<h1 class="mwb-header-title"><?php esc_html_e( 'MWB Quick View for WooCommerce', 'mwb-quick-view-for-woocommerce' ); ?></h1>
		<a href="https://docs.makewebbetter.com/mwb-quick-view-for-woocommerce/?utm_source=MWB-QuickView-org&utm_medium=MWB-org-backend&utm_campaign=MWB-QuickView-doc" target="_blank" class="mwb-link"><?php esc_html_e( 'Documentation', 'mwb-quick-view-for-woocommerce' ); ?></a>
		<span>|</span>
		<a href="https://makewebbetter.com/submit-query/?utm_source=MWB-QuickView-org&utm_medium=MWB-org-backend&utm_campaign=MWB-QuickView-support" target="_blank" class="mwb-link"><?php esc_html_e( 'Support', 'mwb-quick-view-for-woocommerce' ); ?></a>
	</div>
</header>

<main class="mwb-main mwb-bg-white mwb-r-8">
	<nav class="mwb-navbar">
		<ul class="mwb-navbar__items">
			<?php
			if ( is_array( $mwqv_default_tabs ) && ! empty( $mwqv_default_tabs ) ) {

				foreach ( $mwqv_default_tabs as $mwqv_tab_key => $mwqv_default_tabs ) {

					$mwqv_tab_classes = 'mwb-link ';

					if ( ! empty( $mwqv_active_tab ) && $mwqv_active_tab === $mwqv_tab_key ) {
						$mwqv_tab_classes .= 'active';
					}
					?>
					<li>
						<a id="<?php echo esc_attr( $mwqv_tab_key ); ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=mwb_wqv_quick_view_menu' ) . '&mwqv_tab=' . esc_attr( $mwqv_tab_key ) ); ?>" class="<?php echo esc_attr( $mwqv_tab_classes ); ?>"><?php echo esc_html( $mwqv_default_tabs['title'] ); ?></a>
					</li>
					<?php
				}
			}
			?>
		</ul>
	</nav>

	<section class="mwb-section">
		<div>
			<?php
				do_action( 'mwb_mwqv_before_general_settings_form' );
				// if submenu is directly clicked on woocommerce.
			if ( empty( $mwqv_active_tab ) ) {
				$mwqv_active_tab = 'mwb_mwqv_plug_general';
			}

				$mwqv_default_tabs     = $mwqv_mwb_mwqv_obj->mwb_mwqv_plug_default_tabs();
				$mwqv_tab_content_path = $mwqv_default_tabs[ $mwqv_active_tab ]['file_path'];
				$mwqv_mwb_mwqv_obj->mwb_mwqv_plug_load_template( $mwqv_tab_content_path );

				do_action( 'mwb_mwqv_after_general_settings_form' );
			?>
		</div>
	</section>
