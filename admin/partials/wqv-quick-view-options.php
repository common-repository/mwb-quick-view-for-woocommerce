<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html field for general tab.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Quick_View_For_Woocommerce
 * @subpackage Mwb_Quick_View_For_Woocommerce/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $mwqv_mwb_mwqv_obj;
$wqv_option_settings = apply_filters( 'wqv_options_array', array() );
?>
<!--  template file for admin settings. -->
<form action="" method="POST" class="mwb-wqv-gen-section-form">
	<div class="wqv-secion-wrap">
		<?php
		$wqv_general_html = $mwqv_mwb_mwqv_obj->mwb_mwqv_plug_generate_html( $wqv_option_settings );
		echo esc_html( $wqv_general_html );
		wp_nonce_field( 'mwb_wqv_admin_options_data', 'mwb_wqv_op_tabs_nonce' );
		?>
	</div>
</form>
