<?php
/**
 * Theme options, customization
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 *
 * Contents:
 *
 *   0) Init
 *  10) Customizer
 *  20) Getters
 * 100) Others
 */
class Invoices_Customize {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		private function __construct() {

			// Processing

				// Hooks

					// Actions

						// add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_styles' );

		} // /__construct



		/**
		 * Initialization (get instance)
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function init() {

			// Processing

				if ( null === self::$instance ) {
					self::$instance = new self;
				}


			// Output

				return self::$instance;

		} // /init





	/**
	 * 10) Customizer
	 */

		/**
		 * Theme customizer options
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function customize() {

			// Processing

				// @todo

		} // /customize





	/**
	 * 20) Getters
	 */

		/**
		 * Get array of predefined currencies
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function get_currencies_array() {

			// Helper variables

				$currencies = explode( ',', (string) get_theme_mod( 'currencies', 'USD,EUR' ) );


			// Processing
				$currencies = array_map( __CLASS__ . '::currency_code', $currencies );
				$currencies = array_unique( $currencies );
				$currencies = array_filter( $currencies );
				$currencies = array_combine( $currencies, $currencies );


			// Output

				return (array) $currencies;

		} // /get_currencies_array



		/**
		 * Get currency: Exchange from
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function get_currency_exchange_from() {

			// Output

				return self::currency_code( (string) get_theme_mod( 'currency_exchange_from', 'USD' ) );

		} // /get_currency_exchange_from



		/**
		 * Get currency: Exchange to
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function get_currency_exchange_to() {

			// Output

				return self::currency_code( (string) get_theme_mod( 'currency_exchange_to', 'EUR' ) );

		} // /get_currency_exchange_to





	/**
	 * 100) Others
	 */

		/**
		 * Format currency to international code
		 *
		 * @link  https://en.wikipedia.org/wiki/ISO_4217
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $currency
		 */
		public static function currency_code( $currency ) {

			// Processing

				$currency = (string) $currency;
				$currency = preg_replace( '/[^A-Za-z]/', '', $currency );
				$currency = substr( $currency, 0, 3 );
				$currency = strtoupper( $currency );


			// Output

				return $currency;

		} // /currency_code





} // /Invoices_Customize

add_action( 'after_setup_theme', 'Invoices_Customize::init' );
