<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Quick_View_For_Woocommerce
 * @subpackage Mwb_Quick_View_For_Woocommerce/public/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit(); // Exit if accessed directly.
}
$mwb_wqv_general_settings      = apply_filters( 'mwqv_general_settings_array', array() );
$mwb_wqv_general_setting_array = array();
if ( is_array( $mwb_wqv_general_settings ) && ! empty( $mwb_wqv_general_settings ) ) {
	foreach ( $mwb_wqv_general_settings as $mwb_wqv_general_setting ) {
		$mwb_wqv_general_setting_array[ $mwb_wqv_general_setting['id'] ] = get_option( $mwb_wqv_general_setting['id'], 'no_value' );
	}
}
?>
<div class="mwb-modal__quick-view-wrap">
	<div class="mwb-modal__quick-view-content">
		<button style="background-color: <?php echo ( '' !== $mwb_wqv_general_setting_array['mwb_wqv_color_closing_button'] && 'no_value' !== $mwb_wqv_general_setting_array['mwb_wqv_color_closing_button'] ) ? esc_attr( $mwb_wqv_general_setting_array['mwb_wqv_color_closing_button'] ) : ''; ?>;" type="button" class="mwb-modal-close"><span style="color:<?php echo ( '' !== $mwb_wqv_general_setting_array['mwb_wqv_color_cross_closing_button'] && 'no_value' !== $mwb_wqv_general_setting_array['mwb_wqv_color_cross_closing_button'] ) ? esc_attr( $mwb_wqv_general_setting_array['mwb_wqv_color_cross_closing_button'] ) : ''; ?>;">&times;</span></button>
		<div class="mwb-modal__quick-view" id="mwb-modal__quick-view">
			<div class="mwb-modal_content-wrapper">
				<span id="mwb_wqv_no_variation_notice"></div>
				<div class="mwb-modal__content-row">
					<div id="mwb_wqv_no_variation_notice"></div>
					<div class="mwb-modal__col-img">
						<img src="" alt="product-img">
					</div>
					<div class="mwb-modal__col-content">
						<div class="mwb_modal__col-content-wrap">
							<h1 class="mwb_modal__col-title">
								<?php esc_html_e( 'Product Title', 'mwb-quick-view-for-woocommerce' ); ?>
							</h1>
							<div class="mwb_modal__product-price-wrap">
								<h5 class="mwb_wqv_product_price"></h5>
								<h5 class="mwb_wqv_sale_price"></h5>
								<p class="mwb_wqv_sku"></p>
								<p class="mwb_wqv_category"></p>
								<p></p>
							</div>

							<div class="mwb_wqv_variation_dropdown">

							</div>

							<form action="">
								<div class="mwb_wqv_noticeofstock">
								
								</div>
								<div class="mwb-quantity">
									<label for="quantity"><?php esc_html_e( 'Quantity', 'mwb-quick-view-for-woocommerce' ); ?>:</label>
									<input type="number" id="quantity" value="1" name="quantity" min="1">
								</div>
								<div class="quantity_grouped">
									
								</div>
								<div class="mwb_modal__add-to-cart-wrap">
									<button type="submit" id="mwb_wqv_add_to_cart" name="add-to-cart" value="" class="single_add_to_cart_button"><?php esc_html_e( 'Add To Cart', 'mwb-quick-view-for-woocommerce' ); ?></button>
								</div>
							</form>
							<!-- single page view button -->
							<div class="mwb_wqv_view_more_details">
								<a id="mwb_wqv_view_detail" href=""><button class="mwb_view_more_detail_button"><?php esc_html_e( 'View More Details', 'mwb-quick-view-for-woocommerce' ); ?></button></a>
							</div>
							<!-- single page view button -->
						</div>
					</div>
				</div>
				<div class="mwb_modal__description-section">
					<p><?php esc_html_e( 'Description', 'mwb-quick-view-for-woocommerce' ); ?></p>
				</div>
			</div>
				
		</div>
	</div>
</div>
