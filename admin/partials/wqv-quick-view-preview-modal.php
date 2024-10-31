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
$mwb_wqv_modal_image_path = MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/mwb-men-s-hoddie.jpg';
?>
<div id="mwb_wqv_popup" class="layout-1">
	<div class="mwb-modal__wrap">
		<div class="mwb-modal__row">
			<div class="mwb-modal__left-col">
				<div class="mwb-product__img">
					<img src='<?php echo esc_attr( $mwb_wqv_modal_image_path ); ?>' alt="product image">
				</div>
			</div>
			<div class="mwb-modal__right-col">
				<h2 class="mwb-product__title"><?php esc_html_e( 'happy ninja', 'mwb-quick-view-for-woocommerce' ); ?></h2>
				<div class="mwb-product__rating">
					<span>&#9733;</span>
					<span>&#9733;</span>
					<span>&#9733;</span>
					<span>&#9733;</span>
					<span>&#9733;</span>
				</div>
				<div class="mwb-product__desc">
					<p><?php esc_html_e( 'A product description is the marketing copy that explains what a product is and why it’s worth purchasing. The purpose of a product description is to supply customers with important information about the features and benefits of the product so they’re compelled to buy.', 'mwb-quick-view-for-woocommerce' ); ?></p>
				</div>
				<div class="mwb-prod__btn-cart">
					<div class="counter-container">
						<span id="counter">1</span>
						<i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i>
					</div>
					<button id="add-animation"><?php esc_html_e( 'Add to cart', 'mwb-quick-view-for-woocommerce' ); ?></button>
				</div>
				<div class="mwb-product__categories">
					<span><?php esc_html_e( 'categories', 'mwb-quick-view-for-woocommerce' ); ?>:</span>
					<span><?php esc_html_e( 'T-shirts', 'mwb-quick-view-for-woocommerce' ); ?></span>
					<span><?php esc_html_e( 'clothing', 'mwb-quick-view-for-woocommerce' ); ?></span>
				</div>
			</div>
			<a href="#" id="close" class="mwb-modal__close">&#10005;</a>
		</div>

	</div>

</div>
