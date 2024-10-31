<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Quick_View_For_Woocommerce
 * @subpackage Mwb_Quick_View_For_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 * namespace mwb_quick_view_for_woocommerce_public.
 *
 * @package    Mwb_Quick_View_For_Woocommerce
 * @subpackage Mwb_Quick_View_For_Woocommerce/public
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Mwb_Wqv_Quick_View_Public {

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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function mwqv_public_enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'public/src/scss/mwb-wqv-quick-view-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function mwqv_public_enqueue_scripts() {

		wp_register_script( $this->plugin_name, MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'public/src/js/mwb-wqv-quick-view-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(
			$this->plugin_name,
			'wqv_public_param',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'mwb-wqv-popup-nonce' ),
				'mwb_wqv_localize_strings'        => array(
					'mwb_wqv_prod_price'          => __( 'Product price', 'mwb-quick-view-for-woocommerce' ),
					'mwb_wqv_sale_price'          => __( 'Sale Price', 'mwb-quick-view-for-woocommerce' ),
					'mwb_wqv_sku'                 => __( 'SKU', 'mwb-quick-view-for-woocommerce' ),
					'mwb_wqv_prod_category'       => __( 'Category', 'mwb-quick-view-for-woocommerce' ),
					'mwb_wqv_choose_option'       => __( 'Choose an option', 'mwb-quick-view-for-woocommerce' ),
					'mwb_wqv_no_variation_notice' => __( 'No variation exists of these attributes.', 'mwb-quick-view-for-woocommerce' ),
				),
				'mwb_wqv_on_mouse_hover_color' => get_option( 'mwb_wqv_color_hover_closing_button', '' ),
				'mwb_wqv_on_mouse_out_color'   => get_option( 'mwb_wqv_color_closing_button', '' ),
				'mwb_wqv_mobile_view_setting'  => get_option( 'mwb_wqv_checkbox_mobileview', '' ),
				'mwb_wqv_animation_setting'    => get_option( 'mwb_wqv_animation', 'mwb_wqv_anim_default' ),
			)
		);
		wp_enqueue_script( $this->plugin_name );

	}


	/**
	 * Function to check category excluded or not.
	 *
	 * @param int $mwb_wqv_current_prod_id contains current product id.
	 * @return boolean
	 */
	public function mwb_wqv_is_category_excluded( $mwb_wqv_current_prod_id ) {
		$mwb_wqv_flag                             = 0;
		$mwb_wqv_current_product_categories_array = wp_get_post_terms( $mwb_wqv_current_prod_id, 'product_cat', array( 'fields' => 'ids' ) );
		$mwb_wqv_option_settings                  = apply_filters( 'wqv_options_array', array() );
		$mwb_wqv_option_setting_array             = array();
		if ( is_array( $mwb_wqv_option_settings ) && ! empty( $mwb_wqv_option_settings ) ) {
			foreach ( $mwb_wqv_option_settings as $mwb_wqv_option_setting ) {
				$mwb_wqv_option_setting_array[ $mwb_wqv_option_setting['id'] ] = get_option( $mwb_wqv_option_setting['id'], 'no_value' );
			}
		}

		if ( is_array( $mwb_wqv_option_setting_array['wqv_excluded_categories_array'] ) ) {
			foreach ( $mwb_wqv_option_setting_array['wqv_excluded_categories_array'] as $wqv_excluded_categories_arraykey => $wqv_excluded_categories_array_value ) {
				if ( in_array( (int) $wqv_excluded_categories_array_value, $mwb_wqv_current_product_categories_array, true ) ) {
					$mwb_wqv_flag++;
				}
			}
		}
		if ( 0 < $mwb_wqv_flag ) {
			return true;
		} elseif ( 0 === $mwb_wqv_flag ) {
			return false;
		}
	}

	/**
	 * Function contains button and modal.
	 *
	 * @return void
	 */
	public function mwb_wqv_quickview_button_and_modal() {
		$mwb_wqv_plugin_functionality_enabled = get_option( 'mwb_wqv_functionality_enabled' );
		$mwb_wqv_option_settings              = apply_filters( 'wqv_options_array', array() );
		$mwb_wqv_option_setting_array         = array();
		if ( is_array( $mwb_wqv_option_settings ) && ! empty( $mwb_wqv_option_settings ) ) {
			foreach ( $mwb_wqv_option_settings as $mwb_wqv_option_setting ) {
				$mwb_wqv_option_setting_array[ $mwb_wqv_option_setting['id'] ] = get_option( $mwb_wqv_option_setting['id'], 'no_value' );
			}
		}
		if ( ( 'on' !== $mwb_wqv_plugin_functionality_enabled ) || ( ( ( 'on' === $mwb_wqv_option_setting_array['mwb_wqv_exclude_product'] ) && ( in_array( strval( get_the_ID() ), (array) $mwb_wqv_option_setting_array['wqv_excluded_products_array'], true ) ) ) || ( ( 'on' === $mwb_wqv_option_setting_array['mwb_wqv_exclude_category'] ) && ( $this->mwb_wqv_is_category_excluded( get_the_ID() ) ) ) ) ) {
			return;
		} elseif ( is_shop() ) {
			$mwb_wqv_general_settings      = apply_filters( 'mwqv_general_settings_array', array() );
			$mwb_wqv_general_setting_array = array();
			if ( is_array( $mwb_wqv_general_settings ) && ! empty( $mwb_wqv_general_settings ) ) {
				foreach ( $mwb_wqv_general_settings as $mwb_wqv_general_setting ) {
					$mwb_wqv_general_setting_array[ $mwb_wqv_general_setting['id'] ] = get_option( $mwb_wqv_general_setting['id'], 'no_value' );
				}
			}

			if ( 'link' === $mwb_wqv_general_setting_array['mwb_wqv_button_type'] ) {
				?>
				<a data-mwb_wqv_prod_id="<?php echo esc_attr( get_the_ID() ); ?>" class="mwb_wqv_quickview_modal_link mwb_wqv_quickview_modal_button" href="#"><?php esc_html_e( 'Quick View', 'mwb-quick-view-for-woocommerce' ); ?></a>
				<?php
			} elseif ( 'button' === $mwb_wqv_general_setting_array['mwb_wqv_button_type'] ) {
				?>
				<button data-mwb_wqv_prod_id="<?php echo esc_attr( get_the_ID() ); ?>" class="mwb_wqv_quickview_modal_button" type="button" style="color:<?php echo ( '' !== $mwb_wqv_general_setting_array['mwb_wqv_text_color_quickview_button'] && 'no_value' !== $mwb_wqv_general_setting_array['mwb_wqv_text_color_quickview_button'] ) ? esc_attr( $mwb_wqv_general_setting_array['mwb_wqv_text_color_quickview_button'] ) : ''; ?>;background-color: <?php echo ( '' !== $mwb_wqv_general_setting_array['mwb_wqv_button_bg_color'] && 'no_value' !== $mwb_wqv_general_setting_array['mwb_wqv_button_bg_color'] ) ? esc_attr( $mwb_wqv_general_setting_array['mwb_wqv_button_bg_color'] ) : ''; ?>;"><?php echo ( ( '' !== $mwb_wqv_general_setting_array['mwb_wqv_quickview_button_text'] ) ? esc_html( $mwb_wqv_general_setting_array['mwb_wqv_quickview_button_text'] ) : esc_html__( 'Quick View', 'mwb-quick-view-for-woocommerce' ) ); ?></button>
				<?php
			}
		}
	}

	/**
	 * Function to render popup modal
	 *
	 * @return void
	 */
	public function mwb_wqv_modal_html() {
		require MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_PATH . 'public/partials/mwb-wqv-quick-view-public-display-animation.php';
	}

	/**
	 * Ajax function to render quick view for woocommerce popup
	 *
	 * @return void
	 */
	public function mwb_wqv_quickview_render_popup() {
		check_ajax_referer( 'mwb-wqv-popup-nonce', 'ajax_nonce' );
		$mwb_wqv_current_prod_id = isset( $_POST['mwb_wqv_product_id'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_wqv_product_id'] ) ) : '';

		if ( isset( $_POST['mwb_wqv_product_id'] ) ) {
			$mwb_wqv_product                   = wc_get_product( $mwb_wqv_current_prod_id );
			$mwb_wqv_variation_price_array     = array();
			$mwb_wqv_all_attributes_variations = array();
			$mwb_wqv_all_varitions             = array();
			$mwb_wqv_all_varitions_array       = array();
			$mwb_wqv_grouped_prod_array        = array();
			$mwb_wqv_grouped_price_range_arr   = array();
			$mwb_wqv_grouped_prod_html         = '';
			$mwb_wqv_grouped_price_range       = '';
			$mwb_wqv_stock_notice              = '';
			$mwb_wqv_stock_action              = '';
			$mwb_wqv_stock_quantity            = '';
			if ( 'variable' === $mwb_wqv_product->get_type() ) {
				$mwb_variant_ptoduct               = new WC_Product_Variable( $mwb_wqv_current_prod_id );
				$mwb_wqv_all_attributes_variations = $mwb_variant_ptoduct->get_variation_attributes();
				$mwb_wqv_all_varitions             = $mwb_variant_ptoduct->get_available_variations();
				$mwb_wqv_i                         = 0;
				foreach ( $mwb_wqv_all_varitions as $mwb_wqv_all_varition_key => $mwb_wqv_all_varition_value ) {
					foreach ( $mwb_wqv_all_varition_value as $mwb_wqv_all_varition_value_key => $mwb_variations_value ) {
						if ( ( 'attributes' === $mwb_wqv_all_varition_value_key ) || ( 'image' === $mwb_wqv_all_varition_value_key ) || ( 'price_html' === $mwb_wqv_all_varition_value_key ) || ( 'sku' === $mwb_wqv_all_varition_value_key ) || ( 'variation_id' === $mwb_wqv_all_varition_value_key ) || ( 'variation_is_active' === $mwb_wqv_all_varition_value_key ) || ( 'variation_is_visible' === $mwb_wqv_all_varition_value_key ) ) {
							if ( 'image' === $mwb_wqv_all_varition_value_key ) {
								$mwb_wqv_all_varitions_array[ $mwb_wqv_i ][ $mwb_wqv_all_varition_value_key ] = $mwb_variations_value['url'];
							} else {
								$mwb_wqv_all_varitions_array[ $mwb_wqv_i ][ $mwb_wqv_all_varition_value_key ] = $mwb_variations_value;
							}
						}
						if ( 'display_price' === $mwb_wqv_all_varition_value_key ) {
							array_push( $mwb_wqv_variation_price_array, $mwb_variations_value );
						}
					}
					$mwb_wqv_i++;
				}
				$mwb_max_variation_price = wc_price( max( $mwb_wqv_variation_price_array ) );
				$mwb_min_variation_price = wc_price( min( $mwb_wqv_variation_price_array ) );

				if ( $mwb_max_variation_price !== $mwb_min_variation_price ) {
					$mwb_wqv_price_range_string = $mwb_min_variation_price . ' - ' . $mwb_max_variation_price;
				} else {
					$mwb_wqv_price_range_string = $mwb_min_variation_price;
				}
			} elseif ( 'grouped' === $mwb_wqv_product->get_type() ) {
				$mwb_wqv_children = $mwb_wqv_product->get_children();
				foreach ( $mwb_wqv_children as $mwb_wqv_children_key => $mwb_wqv_children_id ) {
					$mwb_wqv_grouped_prod_array[ $mwb_wqv_children_id ]['mwb_wqv_permalink'] = get_permalink( $mwb_wqv_children_id );
					$mwb_wqv_grouped_prod_array[ $mwb_wqv_children_id ]['mwb_wqv_name']      = esc_html( wc_get_product( $mwb_wqv_children_id )->get_name() );
					$mwb_wqv_grouped_prod_array[ $mwb_wqv_children_id ]['mwb_wqv_price']     = wc_price( wc_get_product( $mwb_wqv_children_id )->get_price() );
					array_push( $mwb_wqv_grouped_price_range_arr, wc_get_product( $mwb_wqv_children_id )->get_price() );
				}
				$mwb_wqv_grouped_prod_html = '<table>';
				foreach ( $mwb_wqv_grouped_prod_array as $mwb_wqv_grouped_prod_array_key => $mwb_wqv_grouped_prod_array_value ) {
					$mwb_wqv_grouped_prod_html .= '<tr class="mwb_wqv_grouped_tr"><td class="mwb_wqv_td"><div class="quantity"><input class="mwb_wqv_grouped_id_qty" type="number" id="' . $mwb_wqv_grouped_prod_array_key . '" step="1" min="0" max="" value="0" title="Qty" size="4" placeholder="0" inputmode="numeric"></div></td><td class="mwb_wqv_td"><label for="product-' . $mwb_wqv_grouped_prod_array_key . '"><a href="' . $mwb_wqv_grouped_prod_array_value['mwb_wqv_permalink'] . '">' . $mwb_wqv_grouped_prod_array_value['mwb_wqv_name'] . '</a></label></td><td class="mwb_wqv_td"><span class="mwb_wqv_price">' . $mwb_wqv_grouped_prod_array_value['mwb_wqv_price'] . '</span></td></tr>';
				}
				$mwb_wqv_grouped_prod_html  .= '</table>';
				$mwb_wqv_grouped_price_range = wc_price( min( $mwb_wqv_grouped_price_range_arr ) ) . ' - ' . wc_price( max( $mwb_wqv_grouped_price_range_arr ) );
			}
			if ( 'yes' === get_post_meta( $mwb_wqv_current_prod_id, '_manage_stock', true ) ) {
				if ( 0 >= $mwb_wqv_product->get_stock_quantity() && 'no' === get_post_meta( $mwb_wqv_current_prod_id, '_backorders', true ) ) {
					$mwb_wqv_stock_notice = __( 'Out of stock', 'mwb-quick-view-for-woocommerce' );
					$mwb_wqv_stock_notice = '<p class="mwb_wqv_outofstock">' . $mwb_wqv_stock_notice . '</p>';
					$mwb_wqv_stock_action = 'outofstock';
				} elseif ( 0 >= $mwb_wqv_product->get_stock_quantity() && 'notify' === get_post_meta( $mwb_wqv_current_prod_id, '_backorders', true ) ) {
					$mwb_wqv_stock_notice = __( 'Available on backorder', 'mwb-quick-view-for-woocommerce' );
				} elseif ( 0 >= $mwb_wqv_product->get_stock_quantity() && 'yes' === get_post_meta( $mwb_wqv_current_prod_id, '_backorders', true ) ) {
					$mwb_wqv_stock_notice = '';
				} elseif ( 1 <= $mwb_wqv_product->get_stock_quantity() && 'no' === get_post_meta( $mwb_wqv_current_prod_id, '_backorders', true ) ) {
					$mwb_wqv_stock_notice   = __( 'in stock', 'mwb-quick-view-for-woocommerce' );
					$mwb_wqv_stock_notice   = '<p class="mwb_wqv_instock">' . $mwb_wqv_product->get_stock_quantity() . ' ' . $mwb_wqv_stock_notice . '</p>';
					$mwb_wqv_stock_quantity = $mwb_wqv_product->get_stock_quantity();
				} elseif ( 1 <= $mwb_wqv_product->get_stock_quantity() && 'notify' === get_post_meta( $mwb_wqv_current_prod_id, '_backorders', true ) ) {
					$mwb_wqv_stock_notice = __( 'in stock(can be back-ordered)', 'mwb-quick-view-for-woocommerce' );
					$mwb_wqv_stock_notice = '<p class="mwb_wqv_instock">' . $mwb_wqv_product->get_stock_quantity() . ' ' . $mwb_wqv_stock_notice . '</p>';
				} elseif ( 1 <= $mwb_wqv_product->get_stock_quantity() && 'yes' === get_post_meta( $mwb_wqv_current_prod_id, '_backorders', true ) ) {
					$mwb_wqv_stock_notice = __( 'in stock', 'mwb-quick-view-for-woocommerce' );
					$mwb_wqv_stock_notice = '<p class="mwb_wqv_instock">' . $mwb_wqv_product->get_stock_quantity() . ' ' . $mwb_wqv_stock_notice . '</p>';
				}
			} elseif ( 'no' === get_post_meta( $mwb_wqv_current_prod_id, '_manage_stock', true ) ) {
				if ( 'outofstock' === get_post_meta( $mwb_wqv_current_prod_id, '_stock_status', true ) ) {
					$mwb_wqv_stock_notice = __( 'Out of stock', 'mwb-quick-view-for-woocommerce' );
					$mwb_wqv_stock_notice = '<p class="mwb_wqv_outofstock">' . $mwb_wqv_stock_notice . '</p>';
					$mwb_wqv_stock_action = 'outofstock';
				} elseif ( 'instock' === get_post_meta( $mwb_wqv_current_prod_id, '_stock_status', true ) ) {
					$mwb_wqv_stock_notice = '';
				} elseif ( 'onbackorder' === get_post_meta( $mwb_wqv_current_prod_id, '_stock_status', true ) ) {
					$mwb_wqv_stock_notice = __( 'Available on backorder', 'mwb-quick-view-for-woocommerce' );
					$mwb_wqv_stock_notice = '<p>' . $mwb_wqv_stock_notice . '</p>';
				}
			}
			$mwb_wqv_image                 = wp_get_attachment_image_src( get_post_thumbnail_id( $mwb_wqv_current_prod_id ), 'single-post-thumbnail' );
			$mwb_wqv_product_details_array = array(
				'mwb_wqv_prod_id'                      => $mwb_wqv_current_prod_id,
				'mwb_wqv_prod_type'                    => $mwb_wqv_product->get_type(),
				'mwb_wqv_prod_name'                    => esc_html( $mwb_wqv_product->get_name() ),
				'mwb_wqv_prod_regular_price'           => ( '' === $mwb_wqv_product->get_regular_price() ) ? '' : wc_price( $mwb_wqv_product->get_regular_price() ),
				'mwb_wqv_prod_sale_price'              => ( '' === $mwb_wqv_product->get_sale_price() ) ? '' : wc_price( $mwb_wqv_product->get_sale_price() ),
				'mwb_wqv_prod_price'                   => wc_price( $mwb_wqv_product->get_price() ),
				'mwb_wqv_prod_image_src'               => $mwb_wqv_image[0],
				'mwb_wqv_prod_sku'                     => $mwb_wqv_product->get_sku(),
				'mwb_wqv_prod_category'                => implode( ', ', wp_get_post_terms( $mwb_wqv_current_prod_id, 'product_cat', array( 'fields' => 'names' ) ) ),
				'mwb_wqv_prod_excerpt'                 => esc_html( get_the_excerpt( $mwb_wqv_current_prod_id ) ),
				'mwb_wqv_attributes_array'             => $mwb_wqv_all_attributes_variations,
				'mwb_wqv_variation_products'           => $mwb_wqv_all_varitions_array,
				'mwb_wqv_variation_price_range_string' => $mwb_wqv_price_range_string,
				'mwb_wqv_product_permalink'            => get_permalink( $mwb_wqv_current_prod_id ),
				'mwb_wqv_grouped_prod_html'            => $mwb_wqv_grouped_prod_html,
				'mwb_wqv_grouped_price_range'          => $mwb_wqv_grouped_price_range,
				'mwb_wqv_sold_individually'            => ( 'yes' === get_post_meta( $mwb_wqv_current_prod_id, '_sold_individually', true ) ) ? 'yes' : 'no',
				'mwb_wqv_stock_notice'                 => $mwb_wqv_stock_notice,
				'mwb_wqv_stock_action'                 => $mwb_wqv_stock_action,
				'mwb_wqv_stock_quantity'               => $mwb_wqv_stock_quantity,
			);
			wp_send_json( $mwb_wqv_product_details_array );
		} else {
			esc_html_e( 'Error', 'mwb-quick-view-for-woocommerce' );
		}
			wp_die();
	}

	/**
	 * Function to change variable product.
	 *
	 * @return void
	 */
	public function mwb_wqv_quickview_render_popup_for_variable_product() {
		check_ajax_referer( 'mwb-wqv-popup-nonce', 'ajax_nonce' );
		$mwb_wqv_parent_product_id             = isset( $_POST['mwb_wqv_parent_product_id'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_wqv_parent_product_id'] ) ) : '';
		$mwb_wqv_selected_options_array        = isset( $_POST['mwb_wqv_selected_options_array'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['mwb_wqv_selected_options_array'] ) ) : '';
			$mwb_variant_ptoduct               = new WC_Product_Variable( $mwb_wqv_parent_product_id );
			$mwb_wqv_all_attributes_variations = $mwb_variant_ptoduct->get_variation_attributes();
			$mwb_wqv_all_varitions             = $mwb_variant_ptoduct->get_available_variations();
		if ( isset( $_POST['mwb_wqv_selected_options_array'] ) ) {
			$mwb_wqv_variations_detail    = array();
			$mwb_wqv_variation_data_index = 'no_var';
			foreach ( $mwb_wqv_all_varitions as $mwb_wqv_all_varitionskey => $mwb_wqv_all_varitionsvalue ) {
				$mwb_flag_i = 0;
				$mwb_flag_j = 0;
				foreach ( $mwb_wqv_all_varitionsvalue as $mwb_wqv_all_varitionsvaluekey => $mwb_wqv_all_varitionsvalue_value ) {
					if ( 'attributes' === $mwb_wqv_all_varitionsvaluekey ) {
						foreach ( $mwb_wqv_all_varitionsvalue_value as $mwbkey_variations => $mwbvalue_variations ) {
							if ( $mwb_wqv_all_varitionsvalue_value[ $mwbkey_variations ] === $mwb_wqv_selected_options_array[ str_replace( 'attribute_', '', $mwbkey_variations ) ] || ( '' === $mwb_wqv_all_varitionsvalue_value[ $mwbkey_variations ] ) ) {
								$mwb_flag_j++;
							}
							$mwb_flag_i++;
						}
						if ( $mwb_flag_i === $mwb_flag_j ) {
							$mwb_wqv_variation_data_index = $mwb_wqv_all_varitionskey;
						} else {
							if ( 'no_var' === $mwb_wqv_variation_data_index ) {
								$mwb_wqv_variation_data_index = -1;
							}
						}
					}
				}
			}
		}
		$mwb_wqv_variations_detail = $mwb_wqv_all_varitions[ $mwb_wqv_variation_data_index ];
		wp_send_json( $mwb_wqv_variations_detail );
		wp_die();
	}
}
