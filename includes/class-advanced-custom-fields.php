<?php
/**
 * Advanced Custom Fields Class
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
 * 10) Invoice
 */
class Invoices_Advanced_Custom_Fields {





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

			// Requirements check

				if ( ! is_admin() ) {
					return;
				}


			// Processing

				// Hooks

					// Actions

						add_action( 'init', __CLASS__ . '::invoice' );

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
	 * 10) Invoice
	 */

		/**
		 * Invoice metaboxes
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function invoice() {

			// Helper variables

				$group_no = 0;


			// Processing

				register_field_group( (array) apply_filters( 'wmhook_invoices_acf_register_field_group', array(
					'id'     => '{%= prefix_var %}_intro_options',
					'title'  => esc_html__( 'Intro options', '{%= text_domain %}' ),
					'fields' => array(

						// @todo

					),
					'location' => array(

						// @todo

					),
					'options' => array(
						'position'       => 'normal',
						'layout'         => 'default',
						'hide_on_screen' => array(),
					),
					'menu_order' => 20,
				), 'invoice', $group_no ) );

		} // /invoice





} // /Invoices_Advanced_Custom_Fields

add_action( 'after_setup_theme', 'Invoices_Advanced_Custom_Fields::init' );
