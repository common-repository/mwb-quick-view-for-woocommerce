<?php
/**
 * Fired during plugin activation
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Quick_View_For_Woocommerce
 * @subpackage Mwb_Quick_View_For_Woocommerce/includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Mwb_Wqv_Quick_View_Api_Process' ) ) {

	/**
	 * The plugin API class.
	 *
	 * This is used to define the functions and data manipulation for custom endpoints.
	 *
	 * @since      1.0.0
	 * @package    Mwb_Quick_View_For_Woocommerce
	 * @subpackage Mwb_Quick_View_For_Woocommerce/includes
	 * @author     MakeWebBetter <makewebbetter.com>
	 */
	class Mwb_Wqv_Quick_View_Api_Process {

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {

		}

		/**
		 * Define the function to process data for custom endpoint.
		 *
		 * @since    1.0.0
		 * @param   Array $mwqv_request  data of requesting headers and other information.
		 * @return  Array $mwb_mwqv_rest_response    returns processed data and status of operations.
		 */
		public function mwb_mwqv_default_process( $mwqv_request ) {
			$mwb_mwqv_rest_response = array();

			// Write your custom code here.

			$mwb_mwqv_rest_response['status'] = 200;
			$mwb_mwqv_rest_response['data'] = $mwqv_request->get_headers();
			return $mwb_mwqv_rest_response;
		}
	}
}
