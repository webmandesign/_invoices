<?php
/**
 * Helper Class
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.5.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Reset
 * 20) Invoice companies
 * 30) Exchange rate
 */
class Invoices_Helper {





	/**
	 * 0) Init
	 */

		public static $transient_exchange_rates = 'invoices_exchange_rates';





	/**
	 * 10) Reset
	 */

		/**
		 * Reset $invoice_helper array
		 *
		 * @since    1.0.0
		 * @version  1.4.0
		 */
		public static function reset_invoice_helper() {

			// Helper variables

				$post_id = get_the_ID();

				$output = array(

					'company' => self::get_invoice_companies(),

					'publish_date_raw'     => get_the_date( 'Y-m-d' ),
					'publish_date_display' => get_the_date(),

					'total' => Invoices_Customize::get_currencies_array(),

					'currency_from'   => (string) get_post_meta( $post_id, 'exchange_from', true ),
					'currency_to'     => (string) get_post_meta( $post_id, 'exchange_to', true ),
					'dual_currency'   => false,
					'exchange_rate'   => 0,

					'symbol_constant' => (string) get_post_meta( $post_id, 'symbol_constant', true ),

					'soft_deduct' => Invoices_Customize::get_currencies_array(),

				);


			// Processing

				foreach ( $output['total'] as $key => $value ) {
					$output['total'][ $key ] = 0;
				}
				$output['total'][ $output['currency_from'] ] = (float) get_post_meta( $post_id, 'invoice_total', true );

				$output['dual_currency'] = (bool) ( $output['currency_from'] !== $output['currency_to'] );

				$output['exchange_rate'] = (float) self::get_exchange_rate( $output );

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
	 * 30) Exchange rate
	 */

		/**
		 * Get exchange rate from remote API and cache it
		 *
		 * If the invoice is displayed in dual currency mode, the exchange rate
		 * is taken from cache first, then (if not found in the cache) remotely
		 * taken using an API.
		 *
		 * Exchange rate value is relevant to invoice (post) publish date.
		 *
		 * Each exchange rate value is properly cached into single transient
		 * record to prevent any future remote calls.
		 * Cached, multi-dimensional array is structured by dates and currency
		 * exchange requests:
		 *
		 * @example
		 *   array(
		 *     'YYYY-MM-DD' => array(
		 *       'USD to EUR' => 0.9876,
		 *       'EUR to USD' => 1.0125,
		 *       ...
		 *     ),
		 *     ...
		 *   );
		 *
		 * @since    1.0.0
		 * @version  1.5.0
		 *
		 * @param  array $invoice_helper
		 */
		public static function get_exchange_rate( $invoice_helper ) {

			// Requirements check

				if (
					! isset( $invoice_helper['publish_date_raw'] )
					|| ! isset( $invoice_helper['currency_from'] )
					|| ! isset( $invoice_helper['currency_to'] )
					|| ! isset( $invoice_helper['dual_currency'] )
					|| ! $invoice_helper['dual_currency']
				) {
					return 0;
				}


			// Helper variables

				$output = 0;

				$cache = (array) get_transient( self::$transient_exchange_rates );

				$key_date     = $invoice_helper['publish_date_raw'];
				$key_currency = $invoice_helper['currency_from'] . ' to ' . $invoice_helper['currency_to'];


			// Processing

				if ( isset( $cache[ $key_date ][ $key_currency ] ) ) {
				// Get cache first

					$output = (float) $cache[ $key_date ][ $key_currency ];

				} else {
				// No cache? Get the value from remote API.

					$response = wp_remote_get(
						esc_url_raw(
							self::get_fixer_api_url(
								$invoice_helper['publish_date_raw'],
								$invoice_helper['currency_from'],
								$invoice_helper['currency_to']
							)
						),
						array(
							'timeout' => 10,
						)
					);

					if (
						! is_wp_error( $response )
						&& isset( $response['body'] )
					) {
						$data = (array) json_decode( $response['body'], true );

						if ( isset( $data['rates'][ $invoice_helper['currency_to'] ] ) ) {

							if ( $invoice_helper['currency_to'] === $data['base'] ) {
								$output = round( (float) 1 / $data['rates'][ $invoice_helper['currency_from'] ], 6 );
							} else {
								$output = (float) $data['rates'][ $invoice_helper['currency_to'] ];
							}

							// Cache it!

								$cache[ $key_date ][ $key_currency ] = $output;
								set_transient( self::$transient_exchange_rates, array_filter( $cache ) );

						}
					}

				}


			// Output

				return (float) $output;

		} // /get_exchange_rate



		/**
		 * Get Fixer.io API request URL
		 *
		 * @see  https://fixer.io
		 * @api  https://api.fixer.io/2015-12-31?base=USD&symbols=EUR
		 *
		 * @since    1.5.0
		 * @version  1.5.0
		 *
		 * @param  string $date
		 * @param  string $currency_from
		 * @param  string $currency_to
		 */
		public static function get_fixer_api_url( $date, $currency_from, $currency_to ) {

			// Helper variables

				$output  = '';
				$api_url = esc_url_raw( 'http://data.fixer.io/api/' . date( 'Y-m-d', strtotime( (string) $date ) ) );

				$access_key = get_theme_mod( 'api_fixer_access_key' );


			// Processing

				if ( $access_key ) {
					$output = add_query_arg(
						array(
							// 'base'       => (string) $currency_from, // This is not supported in Fixer.io free plan...
							'symbols'    => trim( (string) $currency_from ) . ',' . trim( (string) $currency_to ),
							'access_key' => (string) $access_key,
						),
						$api_url
					);
				}


			// Output

				return $output;

		} // /get_fixer_api_url





} // /Invoices_Helper
