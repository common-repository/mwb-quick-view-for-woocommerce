<?php
/**
 * The common functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Quick_View_For_Woocommerce
 * @subpackage Mwb_Quick_View_For_Woocommerce/common
 */

/**
 * The common functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the common stylesheet and JavaScript.
 * namespace mwb_woocommerce_quick_view_common.
 *
 * @package    Mwb_Quick_View_For_Woocommerce
 * @subpackage Mwb_Quick_View_For_Woocommerce/common
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Mwb_Wqv_Quick_View_Common {
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
	 * Register the stylesheets for the common side of the site.
	 *
	 * @since    1.0.0
	 */
	public function mwqv_common_enqueue_styles() {
		wp_enqueue_style( $this->plugin_name . 'common', MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'common/src/scss/mwb-wqv-quick-view-common.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the common side of the site.
	 *
	 * @since    1.0.0
	 */
	public function mwqv_common_enqueue_scripts() {
		wp_register_script( $this->plugin_name . 'common', MWB_QUICK_VIEW_FOR_WOOCOMMERCE_DIR_URL . 'common/src/js/mwb-wqv-quick-view-common.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name . 'common', 'mwqv_common_param', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script( $this->plugin_name . 'common' );
	}

		/**
		 * Function to get all products array.
		 *
		 * @return array
		 */
	public function mwb_wqv_get_all_products() {
		$mwb_all_products_array = array();
		$args                   = array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		);
		$mwb_all_prod           = new WP_Query( $args );
		foreach ( $mwb_all_prod->posts as $key => $value ) {
			$mwb_all_products_array[ $value->ID ] = $value->post_title;
		}
		return $mwb_all_products_array;
	}

	/**
	 * Function to get all categories
	 *
	 * @return array
	 */
	public function mwb_wqv_get_all_categories() {
		$mwb_all_categories = array();
		$categories         = get_terms(
			'product_cat',
			array(
				'orderby'    => 'count',
				'hide_empty' => 0,
			)
		);
		foreach ( $categories as $key => $value ) {
			$mwb_all_categories[ $value->term_id ] = $value->name;
		}
		return $mwb_all_categories;
	}

	/**
	 * Quick View for Woocommerce admin menu page.
	 *
	 * @since    1.0.0
	 * @param array $wqv_settings_general Settings fields.
	 */
	public function wqv_admin_general_settings_page( $wqv_settings_general ) {

		$wqv_settings_general = array(
			array(
				'title' => __( 'Enable plugin', 'mwb-quick-view-for-woocommerce' ),
				'type'  => 'radio-switch',
				'description'  => __( 'Enable plugin to start the functionality.', 'mwb-quick-view-for-woocommerce' ),
				'id'    => 'mwb_wqv_functionality_enabled',
				'value' => get_option( 'mwb_wqv_functionality_enabled' ),
				'class' => 'wqv-radio-switch-class',
				'options' => array(
					'yes' => __( 'YES', 'mwb-quick-view-for-woocommerce' ),
					'no' => __( 'NO', 'mwb-quick-view-for-woocommerce' ),
				),
			),

			array(
				'title' => __( 'Text for QuickView button', 'mwb-quick-view-for-woocommerce' ),
				'type'  => 'text',
				'description'  => __( 'Enter the text you want to show on the QuickView button.', 'mwb-quick-view-for-woocommerce' ),
				'id'    => 'mwb_wqv_quickview_button_text',
				'value' => get_option( 'mwb_wqv_quickview_button_text' ),
				'class' => 'wqv-text-class',
				'placeholder' => __( 'Button Text', 'mwb-quick-view-for-woocommerce' ),
			),

			array(
				'title' => __( 'Disable QuickView for mobile view', 'mwb-quick-view-for-woocommerce' ),
				'type'  => 'checkbox',
				'description'  => __( 'This is a checkbox field to disable QuickView for mobile view.', 'mwb-quick-view-for-woocommerce' ),
				'id'    => 'mwb_wqv_checkbox_mobileview',
				'value' => ( '' === get_option( 'mwb_wqv_checkbox_mobileview' ) || false === get_option( 'mwb_wqv_checkbox_mobileview' ) ) ? 0 : 1,
				'class' => 'wqv-checkbox-class',
				'placeholder' => __( 'Checkbox', 'mwb-quick-view-for-woocommerce' ),
			),

			array(
				'title' => __( 'QuickView button background color', 'mwb-quick-view-for-woocommerce' ),
				'type'  => 'color',
				'description'  => __( 'This is the color field for QuickView button background color.', 'mwb-quick-view-for-woocommerce' ),
				'id'    => 'mwb_wqv_button_bg_color',
				'value' => get_option( 'mwb_wqv_button_bg_color' ),
				'class' => 'wqv-text-class',
			),

			array(
				'title' => __( 'Closing button color', 'mwb-quick-view-for-woocommerce' ),
				'type'  => 'color',
				'description'  => __( 'This is the color field for the closing button.', 'mwb-quick-view-for-woocommerce' ),
				'id'    => 'mwb_wqv_color_closing_button',
				'value' => get_option( 'mwb_wqv_color_closing_button' ),
				'class' => 'wqv-text-class',
			),

			array(
				'title' => __( 'QuickView button text color', 'mwb-quick-view-for-woocommerce' ),
				'type'  => 'color',
				'description'  => __( 'This is the color field for QuickView button text color.', 'mwb-quick-view-for-woocommerce' ),
				'id'    => 'mwb_wqv_text_color_quickview_button',
				'value' => get_option( 'mwb_wqv_text_color_quickview_button' ),
				'class' => 'wqv-text-class',
			),

			array(
				'title' => __( 'Closing button hover color', 'mwb-quick-view-for-woocommerce' ),
				'type'  => 'color',
				'description'  => __( 'This is the color field for the closing button on hover.', 'mwb-quick-view-for-woocommerce' ),
				'id'    => 'mwb_wqv_color_hover_closing_button',
				'value' => get_option( 'mwb_wqv_color_hover_closing_button' ),
				'class' => 'wqv-text-class',
			),

			array(
				'title' => __( 'Closing button cross color', 'mwb-quick-view-for-woocommerce' ),
				'type'  => 'color',
				'description'  => __( 'This is the color field for the closing button cross.', 'mwb-quick-view-for-woocommerce' ),
				'id'    => 'mwb_wqv_color_cross_closing_button',
				'value' => get_option( 'mwb_wqv_color_cross_closing_button' ),
				'class' => 'wqv-text-class',
			),

			array(
				'title' => __( 'QuickView button type', 'mwb-quick-view-for-woocommerce' ),
				'type'  => 'radio',
				'description'  => __( 'This is radio field for QuickView button type', 'mwb-quick-view-for-woocommerce' ),
				'id'    => 'mwb_wqv_button_type',
				'value' => get_option( 'mwb_wqv_button_type', 'button' ),
				'class' => 'wqv-radio-class',
				'placeholder' => '',
				'options' => array(
					'link' => __( 'Link', 'mwb-quick-view-for-woocommerce' ),
					'button' => __( 'Button', 'mwb-quick-view-for-woocommerce' ),
				),
			),

			array(
				'type'  => 'button',
				'id'    => 'mwb_wqv_save_general_button',
				'button_text' => __( 'Save Settings', 'mwb-quick-view-for-woocommerce' ),
				'class' => 'wqv-button-class',
			),
		);
		return apply_filters( 'mwb_wqv_general_settings_array_filter', $wqv_settings_general );
	}

	/**
	 * Quick View for Woocommerce admin menu page.
	 *
	 * @since    1.0.0
	 * @param array $wqv_settings_options quickview for Woocommerce Options fields.
	 */
	public function wqv_admin_options_page( $wqv_settings_options ) {

		$wqv_settings_options = array(
			array(
				'title' => __( 'Exclude products from QuickView', 'mwb-quick-view-for-woocommerce' ),
				'type'  => 'radio-switch',
				'description'  => __( 'Enable to exclude product.', 'mwb-quick-view-for-woocommerce' ),
				'id'    => 'mwb_wqv_exclude_product',
				'value' => get_option( 'mwb_wqv_exclude_product' ),
				'class' => 'wqv-radio-switch-class',
				'options' => array(
					'yes' => __( 'YES', 'mwb-quick-view-for-woocommerce' ),
					'no' => __( 'NO', 'mwb-quick-view-for-woocommerce' ),
				),
			),

			array(
				'title' => __( 'Exclude categories from QuickView', 'mwb-quick-view-for-woocommerce' ),
				'type'  => 'radio-switch',
				'description'  => __( 'Enable to exclude categories.', 'mwb-quick-view-for-woocommerce' ),
				'id'    => 'mwb_wqv_exclude_category',
				'value' => get_option( 'mwb_wqv_exclude_category' ),
				'class' => 'wqv-radio-switch-class',
				'options' => array(
					'yes' => __( 'YES', 'mwb-quick-view-for-woocommerce' ),
					'no' => __( 'NO', 'mwb-quick-view-for-woocommerce' ),
				),
			),

			array(
				'title' => __( 'Select products to be excluded', 'mwb-quick-view-for-woocommerce' ),
				'type'  => 'multiselect',
				'description'  => __( 'This is a multi-select field to select the products to be excluded.', 'mwb-quick-view-for-woocommerce' ),
				'id'    => 'wqv_excluded_products_array',
				'name'    => 'wqv_excluded_products_array',
				'value' => get_option( 'wqv_excluded_products_array' ),
				'class' => 'wqv-multiselect-class mwb-defaut-multiselect',
				'placeholder' => '',
				'options' => $this->mwb_wqv_get_all_products(),
			),

			array(
				'title' => __( 'Select categories to be excluded', 'mwb-quick-view-for-woocommerce' ),
				'type'  => 'multiselect',
				'description'  => __( 'This is a multi-select field to select the categories to be excluded.', 'mwb-quick-view-for-woocommerce' ),
				'id'    => 'wqv_excluded_categories_array',
				'name'    => 'wqv_excluded_categories_array',
				'value' => get_option( 'wqv_excluded_categories_array' ),
				'class' => 'wqv-multiselect-class mwb-defaut-multiselect',
				'placeholder' => '',
				'options' => $this->mwb_wqv_get_all_categories(),
			),

			array(
				'title' => __( 'Animation effects', 'mwb-quick-view-for-woocommerce' ),
				'type'  => 'radio',
				'description'  => __( 'This is radio field for Modal animation', 'mwb-quick-view-for-woocommerce' ),
				'id'    => 'mwb_wqv_animation',
				'value' => get_option( 'mwb_wqv_animation', 'mwb_wqv_anim_default' ),
				'class' => 'wqv-radio-class',
				'placeholder' => '',
				'options' => array(
					'mwb_wqv_anim_default' => __( 'Default animation', 'mwb-quick-view-for-woocommerce' ),
					'mwb_wqv_anim1'        => __( 'Animation 1', 'mwb-quick-view-for-woocommerce' ),
					'mwb_wqv_anim2'        => __( 'Animation 2', 'mwb-quick-view-for-woocommerce' ),
				),
			),

			array(
				'type'  => 'button',
				'id'    => 'mwb_wqv_animation_preview_button',
				'button_text' => __( 'Animation Preview', 'mwb-quick-view-for-woocommerce' ),
				'class' => 'wqv-button-class',
			),

			array(
				'type'  => 'button',
				'id'    => 'mwb_wqv_save_options_button',
				'button_text' => __( 'Save Settings', 'mwb-quick-view-for-woocommerce' ),
				'class' => 'wqv-button-class',
			),
		);
		return apply_filters( 'mwb_wqv_options_settings_array_filter', $wqv_settings_options );
	}

	/**
	 * Quick View for Woocommerce save tab settings.
	 *
	 * @since 1.0.0
	 */
	public function wqv_admin_save_tab_settings() {
		global $mwqv_mwb_mwqv_obj;
		if ( isset( $_POST['mwb_wqv_save_general_button'] ) && ( isset( $_POST['mwb_wqv_gen_tabs_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mwb_wqv_gen_tabs_nonce'] ) ), 'mwb_wqv_admin_general_data' ) ) ) {
			$mwb_wqv_gen_flag     = false;
			$wqv_genaral_settings = apply_filters( 'mwqv_general_settings_array', array() );
			$wqv_button_index     = array_search( 'submit', array_column( $wqv_genaral_settings, 'type' ), true );
			if ( isset( $wqv_button_index ) && ( '' == $wqv_button_index ) ) { // phpcs:ignore
				$wqv_button_index = array_search( 'button', array_column( $wqv_genaral_settings, 'type' ), true );
			}
			if ( isset( $wqv_button_index ) && '' !== $wqv_button_index ) {
				unset( $wqv_genaral_settings[ $wqv_button_index ] );
				if ( is_array( $wqv_genaral_settings ) && ! empty( $wqv_genaral_settings ) ) {
					foreach ( $wqv_genaral_settings as $wqv_genaral_setting ) {
						if ( isset( $wqv_genaral_setting['id'] ) && '' !== $wqv_genaral_setting['id'] ) {
							if ( isset( $_POST[ $wqv_genaral_setting['id'] ] ) ) {
								update_option( $wqv_genaral_setting['id'], is_array( $_POST[ $wqv_genaral_setting['id'] ] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST[ $wqv_genaral_setting['id'] ] ) ) : sanitize_text_field( wp_unslash( $_POST[ $wqv_genaral_setting['id'] ] ) ) );
							} else {
								update_option( $wqv_genaral_setting['id'], '' );
							}
						} else {
							$mwb_wqv_gen_flag = true;
						}
					}
				}
				if ( $mwb_wqv_gen_flag ) {
					$mwb_wqv_error_text = esc_html__( 'Id of some field is missing', 'mwb-quick-view-for-woocommerce' );
					$mwqv_mwb_mwqv_obj->mwb_mwqv_plug_admin_notice( $mwb_wqv_error_text, 'error' );
				} else {
					$mwb_wqv_error_text = esc_html__( 'Settings saved !', 'mwb-quick-view-for-woocommerce' );
					$mwqv_mwb_mwqv_obj->mwb_mwqv_plug_admin_notice( $mwb_wqv_error_text, 'success' );
				}
			}
		}
	}

	/**
	 * Quick View for Woocommerce save wqv options tab settings.
	 *
	 * @since 1.0.0
	 */
	public function mwb_wqv_admin_save_options_tab_settings() {
		global $mwqv_mwb_mwqv_obj;
		if ( isset( $_POST['mwb_wqv_save_options_button'] ) && ( isset( $_POST['mwb_wqv_op_tabs_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mwb_wqv_op_tabs_nonce'] ) ), 'mwb_wqv_admin_options_data' ) ) ) {
			$mwb_wqv_gen_flag    = false;
			$wqv_option_settings = apply_filters( 'wqv_options_array', array() );
			$wqv_button_index    = array_search( 'submit', array_column( $wqv_option_settings, 'type' ), true );
			if ( isset( $wqv_button_index ) && ( '' == $wqv_button_index ) ) { // phpcs:ignore
				$wqv_button_index = array_search( 'button', array_column( $wqv_option_settings, 'type' ), true );
			}
			if ( isset( $wqv_button_index ) && '' !== $wqv_button_index ) {
				unset( $wqv_option_settings[ $wqv_button_index ] );
				if ( is_array( $wqv_option_settings ) && ! empty( $wqv_option_settings ) ) {
					foreach ( $wqv_option_settings as $wqv_genaral_setting ) {
						if ( isset( $wqv_genaral_setting['id'] ) && '' !== $wqv_genaral_setting['id'] ) {
							if ( isset( $_POST[ $wqv_genaral_setting['id'] ] ) ) {
								update_option( $wqv_genaral_setting['id'], is_array( $_POST[ $wqv_genaral_setting['id'] ] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST[ $wqv_genaral_setting['id'] ] ) ) : sanitize_text_field( wp_unslash( $_POST[ $wqv_genaral_setting['id'] ] ) ) );
							} else {
								update_option( $wqv_genaral_setting['id'], '' );
							}
						} else {
							$mwb_wqv_gen_flag = true;
						}
					}
				}
				if ( $mwb_wqv_gen_flag ) {
					$mwb_wqv_error_text = esc_html__( 'Id of some field is missing', 'mwb-quick-view-for-woocommerce' );
					$mwqv_mwb_mwqv_obj->mwb_mwqv_plug_admin_notice( $mwb_wqv_error_text, 'error' );
				} else {
					$mwb_wqv_error_text = esc_html__( 'Settings saved !', 'mwb-quick-view-for-woocommerce' );
					$mwqv_mwb_mwqv_obj->mwb_mwqv_plug_admin_notice( $mwb_wqv_error_text, 'success' );
				}
			}
		}
	}
}
