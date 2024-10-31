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
$mwqv_genaral_settings = apply_filters( 'mwqv_general_settings_array', array() );
?>
<!--  template file for admin settings. -->
<form action="" method="POST" class="mwb-mwqv-gen-section-form">
	<div class="mwqv-secion-wrap">
		<?php
		$mwqv_general_html = $mwqv_mwb_mwqv_obj->mwb_mwqv_plug_generate_html( $mwqv_genaral_settings );
		echo esc_html( $mwqv_general_html );
		wp_nonce_field( 'mwb_wqv_admin_general_data', 'mwb_wqv_gen_tabs_nonce' );
		?>
	</div>
</form>
