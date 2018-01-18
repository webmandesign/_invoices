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
 * 10) Frontend
 * 20) Admin
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

						add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_frontend' );

						add_action( 'admin_enqueue_scripts', __CLASS__ . '::enqueue_admin', 99 );

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
	 * 10) Frontend
	 */

		/**
		 * Enqueue assets on frontend
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function enqueue_frontend() {

			// Processing

				wp_enqueue_style(
					'invoices-stylesheet',
					get_theme_file_uri( 'assets/css/style.css' )
				);

		} // /enqueue_frontend





	/**
	 * 20) Admin
	 */

		/**
		 * Admin inline styles
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $scope  What admin hook/scope is being loaded.
		 */
		public static function enqueue_admin( $scope = '' ) {

			// Requirements check

				// Only on post edit screen
				if ( ! in_array( $scope, array( 'post-new.php', 'post.php' ) ) ) {
					return;
				}


			// Processing

				wp_enqueue_style(
					'invoices-admin-styles',
					get_theme_file_uri( 'assets/css/admin.css' )
				);

				if ( wp_script_is( 'acf-pro-input', 'enqueued' ) ) {
					wp_enqueue_script(
						'invoices-admin-scripts',
						get_theme_file_uri( 'assets/js/scripts-admin-acf.js' ),
						array( 'acf-pro-input' ),
						false,
						true
					);
				}

		} // /enqueue_admin





} // /Invoices_Assets

add_action( 'after_setup_theme', 'Invoices_Assets::init' );
