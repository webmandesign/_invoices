<?php
/**
 * Assets Class
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Enqueue
 */
class Invoices_Assets {





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

						add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_styles' );

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
	 * 10) Enqueue
	 */

		/**
		 * Frontend styles enqueue
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function enqueue_styles() {

			// Processing

				wp_enqueue_style(
					'invoices-stylesheet',
					get_theme_file_uri( 'assets/css/style.css' )
				);

		} // /enqueue_styles





} // /Invoices_Assets

add_action( 'after_setup_theme', 'Invoices_Assets::init' );
