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
?>
<div class="mwb-overview__wrapper">
	<div class="mwb-overview__banner">
		<img src="<?php echo esc_html( MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL ); ?>admin/image/banner.png" alt="Overview banner image">
	</div>
	<div class="mwb-overview__content">
		<div class="mwb-overview__content-description">
			<h2><?php echo esc_html_e( 'What is Quick View for WooCommerce?', 'mwb-quick-view-for-woocommerce' ); ?></h2>
			<p>
				<?php
				esc_html_e(
					'MWB Quick View for WooCommerce is a WooCommerce extension to let your visitors view your products without having to go to the product page. As a merchant, you can choose to remove the quick view button for a product or category. The MWB Quick View for WooCommerce  extension also enables you to change the text of the preview button, change the background color of the modal window and change the closing button hover cover. 

					There are many other features that come with this Quick View for WooCommerce extension such as allowing you to customize product description display options. You can choose to animate the popup window as well from three given animations.
					',
					'mwb-quick-view-for-woocommerce'
				);
				?>
			</p>
			<h3><?php esc_html_e( 'As a store owner, you get to:', 'mwb-quick-view-for-woocommerce' ); ?></h3>
			<ul class="mwb-overview__features">
				<li><?php esc_html_e( 'Change the text for the quick view button.', 'mwb-quick-view-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Customize the background and text color for the quick view button.', 'mwb-quick-view-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Opt to disable quick view for mobile devices.', 'mwb-quick-view-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Include or exclude a product or category to display the quick view option.', 'mwb-quick-view-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Choose a color from the options for the closing button.', 'mwb-quick-view-for-woocommerce' ); ?></li>
			</ul>
		</div>
		<h2> <?php esc_html_e( 'The Free Plugin Benefits', 'mwb-quick-view-for-woocommerce' ); ?></h2>
		<div class="mwb-overview__keywords">
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Customize-Quick-View-Button.png' ); ?>" alt="Advanced-report image">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( ' Customize Quick View Button', 'mwb-quick-view-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							esc_html_e(
								'You can customize the quick view button to put up your desired text. The extension also allows you to change the background color and text color according to your choice for the quick view button.',
								'mwb-quick-view-for-woocommerce'
							);
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Animation-Effects-For-Quick-View-Modal.png' ); ?>" alt="Workflow image">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( 'Animation Effects For Quick View Modal', 'mwb-quick-view-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description"><?php echo esc_html_e( 'The extension provides animation effects for the quick view functionality in your online store. In the extension, you are provided to choose from three options for the animation of the quick view modal window. There is a default animation option besides 2 others.', 'mwb-quick-view-for-woocommerce' ); ?></p>
					</div>
				</div>
			</div>
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Customize-Modal-Window.png' ); ?>" alt="Variable product image">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( 'Customize Modal Window', 'mwb-quick-view-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							echo esc_html_e(
								'You also get the option to customize the closing button for the quick view modal window using this extension. Also, choose the options you want to display for your product details such as product image, SKU, title, price, and so on. ',
								'mwb-quick-view-for-woocommerce'
							);
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Add-To-Cart.png' ); ?>" alt="List-of-abandoned-users image">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( 'Add To Cart', 'mwb-quick-view-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							echo esc_html_e(
								'The extension allows you to enable the Add to Cart functionality in the quick view modal window. When the user clicks on the Add to Cart button, the default messages will be displayed as in the cart page and shop page in WooCommerce.',
								'mwb-quick-view-for-woocommerce'
							);
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card mwb-card-support">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/View-Details-button.png' ); ?>" alt="Support image">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( 'View Details button', 'mwb-quick-view-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							esc_html_e(
								'The extension allows you to display a ‘View Details’ button on the front end. The user will be redirected to the product page once they click the button. This allows the user to view the detailed product description.',
								'mwb-quick-view-for-woocommerce'
							);
							?>
						</p>
					</div>
					<a href="https://makewebbetter.com/contact-us/" title=""></a>
				</div>
			</div>
		</div>
	</div>
</div>
