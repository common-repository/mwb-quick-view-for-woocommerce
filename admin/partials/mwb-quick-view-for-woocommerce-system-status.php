<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html for system status.
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
// Template for showing information about system status.
global $mwqv_mwb_mwqv_obj;
$mwqv_default_status    = $mwqv_mwb_mwqv_obj->mwb_mwqv_plug_system_status();
$mwqv_wordpress_details = is_array( $mwqv_default_status['wp'] ) && ! empty( $mwqv_default_status['wp'] ) ? $mwqv_default_status['wp'] : array();
$mwqv_php_details       = is_array( $mwqv_default_status['php'] ) && ! empty( $mwqv_default_status['php'] ) ? $mwqv_default_status['php'] : array();
?>
<div class="mwb-mwqv-table-wrap">
	<div class="mwb-col-wrap">
		<div id="mwb-mwqv-table-inner-container" class="table-responsive mdc-data-table">
			<div class="mdc-data-table__table-container">
				<table class="mwb-mwqv-table mdc-data-table__table mwb-table" id="mwb-mwqv-wp">
					<thead>
						<tr>
							<th class="mdc-data-table__header-cell"><?php esc_html_e( 'WP Variables', 'mwb-quick-view-for-woocommerce' ); ?></th>
							<th class="mdc-data-table__header-cell"><?php esc_html_e( 'WP Values', 'mwb-quick-view-for-woocommerce' ); ?></th>
						</tr>
					</thead>
					<tbody class="mdc-data-table__content">
						<?php if ( is_array( $mwqv_wordpress_details ) && ! empty( $mwqv_wordpress_details ) ) { ?>
							<?php foreach ( $mwqv_wordpress_details as $wp_key => $wp_value ) { ?>
								<?php if ( isset( $wp_key ) && 'wp_users' !== $wp_key ) { ?>
									<tr class="mdc-data-table__row">
										<td class="mdc-data-table__cell"><?php echo esc_html( $wp_key ); ?></td>
										<td class="mdc-data-table__cell"><?php echo esc_html( $wp_value ); ?></td>
									</tr>
								<?php } ?>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="mwb-col-wrap">
		<div id="mwb-mwqv-table-inner-container" class="table-responsive mdc-data-table">
			<div class="mdc-data-table__table-container">
				<table class="mwb-mwqv-table mdc-data-table__table mwb-table" id="mwb-mwqv-sys">
					<thead>
						<tr>
							<th class="mdc-data-table__header-cell"><?php esc_html_e( 'System Variables', 'mwb-quick-view-for-woocommerce' ); ?></th>
							<th class="mdc-data-table__header-cell"><?php esc_html_e( 'System Values', 'mwb-quick-view-for-woocommerce' ); ?></th>
						</tr>
					</thead>
					<tbody class="mdc-data-table__content">
						<?php if ( is_array( $mwqv_php_details ) && ! empty( $mwqv_php_details ) ) { ?>
							<?php foreach ( $mwqv_php_details as $php_key => $php_value ) { ?>
								<tr class="mdc-data-table__row">
									<td class="mdc-data-table__cell"><?php echo esc_html( $php_key ); ?></td>
									<td class="mdc-data-table__cell"><?php echo esc_html( $php_value ); ?></td>
								</tr>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
