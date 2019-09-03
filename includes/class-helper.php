<?php
/**
 * Helper Class
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  2.1.0
 *
 * Contents:
 *
 *  10) Reset
 *  20) Invoice companies
 * 100) Others
 */
class Invoices_Helper {





	/**
	 * 10) Reset
	 */

		/**
		 * Reset $invoice_helper array
		 *
		 * @since    1.0.0
		 * @version  2.1.0
		 */
		public static function reset_invoice_helper() {

			// Variables

				$post_id = get_the_ID();

				$due_period = get_post_meta( $post_id, 'due_period', true );

				$output = array(

					'company' => self::get_invoice_companies(),

					'publish_date_raw'     => get_the_date( 'Y-m-d' ),
					'publish_date_display' => get_the_date(),

					'total' => Invoices_Customize::get_currencies_array(),

					'currency_from' => (string) get_post_meta( $post_id, 'exchange_from', true ),
					'currency_to'   => (string) get_post_meta( $post_id, 'exchange_to', true ),
					'exchange_rate' => floatval( get_post_meta( $post_id, 'exchange_rate', true ) ),
					'dual_currency' => false,

					'symbol_constant' => (string) get_post_meta( $post_id, 'symbol_constant', true ),

					'soft_deduct' => Invoices_Customize::get_currencies_array(),

					'due_period' => ( $due_period ) ? ( absint( $due_period ) ) : ( absint( get_theme_mod( 'invoice_due_period', 21 ) ) ),

				);


			// Processing

				foreach ( $output['total'] as $key => $value ) {
					$output['total'][ $key ] = 0;
				}
				$output['total'][ $output['currency_from'] ] = (float) get_post_meta( $post_id, 'invoice_total', true );

				$output['dual_currency'] = (bool) ( $output['currency_from'] !== $output['currency_to'] );

				foreach ( $output['soft_deduct'] as $key => $value ) {
					$output['soft_deduct'][ $key ] = 0;
				}


			// Output

				return $output;

		} // /reset_invoice_helper





	/**
	 * 20) Invoice companies
	 */

		/**
		 * Get invoice companies
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  absint $post_id
		 */
		public static function get_invoice_companies( $post_id = 0 ) {

			// Helper variables

				$post_id = absint( $post_id );

				if ( empty( $post_id ) ) {
					$post_id = get_the_ID();
				}

				$taxonomies = array(
					'category',
					'client',
				);

				$output = array();


			// Processing

				foreach ( $taxonomies as $taxonomy ) {
					$terms = wp_get_post_terms( $post_id, $taxonomy );

					if (
						is_wp_error( $terms )
						|| empty( $terms )
						|| ! isset( $terms[0]->description )
					) {
						continue;
					}

					$output[ $taxonomy ] = $terms[0];
				}


			// Output

				return (array) $output;

		} // /get_invoice_companies





	/**
	 * 100) Others
	 */

		/**
		 * Get date for output with separators.
		 *
		 * @since    1.6.0
		 * @version  1.6.0
		 *
		 * @param  string $date
		 */
		public static function get_output_date( $date = '' ) {

			// Output

				return str_replace(
					array(
						'-',
						'/',
					),
					array(
						'<span class="sep">-</span>',
						'<span class="sep">/</span>',
					),
					$date
				);

		} // /get_output_date



		/**
		 * Get date format readable.
		 *
		 * @link  http://php.net/manual/en/function.date.php
		 *
		 * @since    1.6.0
		 * @version  1.6.0
		 *
		 * @param  string $date_format
		 */
		public static function get_readable_date_format( $date_format = '' ) {

			// Variables

				if ( empty( $date_format ) ) {
					$date_format = get_option( 'date_format' );
				}


			// Output

				return strtoupper( str_replace(
					array(
						'o',
						'F', 'n',
						'j',
						'S',
					),
					array(
						'Y',
						'M', 'M',
						'D',
						'',
					),
					$date_format
				) );

		} // /get_readable_date_format





} // /Invoices_Helper
