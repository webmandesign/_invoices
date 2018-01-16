<?php
/**
 * Advanced Custom Fields Class
 *
 * IMPORTANT:
 * We are using a "repeater" field in our metaboxes,
 * which requires paid version of ACF plugin!
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

						add_action( 'init', __CLASS__ . '::invoice_disable_editor' );
						add_action( 'init', __CLASS__ . '::invoice_items' );
						add_action( 'init', __CLASS__ . '::invoice_setup' );
						add_action( 'init', __CLASS__ . '::invoice_exchange' );

						add_action( 'admin_menu', __CLASS__ . '::invoice_metabox_hide' );

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
		 * Disable post content editor for Invoices as we use ACF
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function invoice_disable_editor() {

			// Processing

				remove_post_type_support( 'post', 'editor' );

		} // /invoice_disable_editor



		/**
		 * Invoice items metabox
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function invoice_items() {

			// Helper variables

				$group_no = 0;


			// Processing

				register_field_group( (array) apply_filters( 'wmhook_invoices_acf_register_field_group', array(
					'id'     => 'invoice_items',
					'title'  => esc_html__( 'Invoice items', '_invoices' ),
					'fields' => array(

						100 => array(
							'key'          => 'invoice_items_repeater',
							'label'        => esc_html__( 'Invoice items', '_invoices' ),
							'name'         => 'items',
							'type'         => 'repeater',
							'required'     => 1,
							'collapsed'    => 'invoice_items_price',
							'min'          => 1,
							'max'          => 0,
							'layout'       => 'table',
							'button_label' => esc_html__( '+ Add invoice item', '_invoices' ),
							'sub_fields'   => array(

								100 => array(
									'key'      => 'invoice_items_price',
									'label'    => esc_html__( 'Price', '_invoices' ),
									'name'     => 'price',
									'type'     => 'number',
									'required' => 1,
									'wrapper'  => array(
										'width' => '15',
										'class' => '',
										'id'    => '',
									),
								),

								200 => array(
									'key'      => 'invoice_items_currency',
									'label'    => esc_html__( 'Currency', '_invoices' ),
									'name'     => 'currency',
									'type'     => 'select',
									'required' => 1,
									'wrapper'  => array(
										'width' => '10',
										'class' => '',
										'id'    => '',
									),
									'choices' => array(
										'USD' => 'USD',
										'EUR' => 'EUR',
									),
									'default_value' => array(
										0 => 'USD',
									),
									'return_format' => 'value',
								),

								300 => array(
									'key'      => 'invoice_items_quantity',
									'label'    => esc_html__( 'Qty', '_invoices' ),
									'name'     => 'quantity',
									'type'     => 'number',
									'required' => 1,
									'wrapper'  => array(
										'width' => '5',
										'class' => '',
										'id'    => '',
									),
									'default_value' => 1,
									'min'           => 1,
									'max'           => 100,
									'step'          => 1,
								),

								400 => array(
									'key'      => 'invoice_items_invoice_item',
									'label'    => esc_html__( 'Select item', '_invoices' ),
									'name'     => 'invoice_item',
									'type'     => 'post_object',
									'required' => 0,
									'wrapper'  => array(
										'width' => '20',
										'class' => '',
										'id'    => '',
									),
									'post_type' => array(
										0 => 'page',
									),
									'return_format' => 'object',
								),

								500 => array(
									'key'      => 'invoice_items_description',
									'label'    => esc_html__( 'Optional item description', '_invoices' ),
									'name'     => 'description',
									'type'     => 'wysiwyg',
									'required' => 0,
									'wrapper'  => array(
										'width' => '50',
										'class' => '',
										'id'    => '',
									),
									'default_value' => '',
									'tabs'          => 'all',
									'toolbar'       => 'basic',
									'media_upload'  => 0,
									'delay'         => 1,
								),

							),
						),

					),
					'location' => array(

						100 => array(

							100 => array(
								'param'    => 'post_type',
								'operator' => '==',
								'value'    => 'post',
								'order_no' => 0,
								'group_no' => $group_no++,
							),

						),

					),
					'menu_order' => 10,
					'position'   => 'acf_after_title',
					'style'      => 'seamless',
				), 'invoice_items', $group_no ) );

		} // /invoice_items



		/**
		 * Invoice setup options metabox
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function invoice_setup() {

			// Helper variables

				$group_no = 0;


			// Processing

				register_field_group( (array) apply_filters( 'wmhook_invoices_acf_register_field_group', array(
					'id'     => 'invoice_setup',
					'title'  => esc_html__( 'Invoice setup', '_invoices' ),
					'fields' => array(

						100 => array(
							'key'          => 'invoice_setup_seller',
							'label'        => esc_html__( 'Seller', '_invoices' ),
							'name'         => 'seller',
							'type'         => 'taxonomy',
							'instructions' => esc_html__( 'Company issuing the invoice.', '_invoices' ),
							'required'     => 1,
							'wrapper'      => array(
								'width' => '38',
								'class' => '',
								'id'    => '',
							),
							'taxonomy'      => 'category',
							'field_type'    => 'radio',
							'allow_null'    => 0,
							'add_term'      => 0,
							'save_terms'    => 1,
							'load_terms'    => 1,
							'return_format' => 'object',
							'multiple'      => 0,
						),

						200 => array(
							'key'          => 'invoice_setup_client',
							'label'        => esc_html__( 'Client', '_invoices' ),
							'name'         => 'client',
							'type'         => 'taxonomy',
							'instructions' => esc_html__( 'Customer receiving the invoice.', '_invoices' ),
							'required'     => 1,
							'wrapper'      => array(
								'width' => '38',
								'class' => '',
								'id'    => '',
							),
							'taxonomy'      => 'client',
							'field_type'    => 'select',
							'allow_null'    => 0,
							'add_term'      => 0,
							'save_terms'    => 1,
							'load_terms'    => 1,
							'return_format' => 'object',
							'multiple'      => 0,
						),

						300 => array(
							'key'          => 'invoice_setup_payment_method',
							'label'        => esc_html__( 'Payment method', '_invoices' ),
							'name'         => 'payment_method',
							'type'         => 'taxonomy',
							'instructions' => esc_html__( 'Preferred payment method to pay the invoice.', '_invoices' ),
							'required'     => 1,
							'wrapper'      => array(
								'width' => '38',
								'class' => '',
								'id'    => '',
							),
							'taxonomy'      => 'payment_method',
							'field_type'    => 'checkbox',
							'allow_null'    => 0,
							'add_term'      => 0,
							'save_terms'    => 1,
							'load_terms'    => 1,
							'return_format' => 'object',
							'multiple'      => 0,
						),

						400 => array(
							'key'          => 'invoice_setup_currency',
							'label'        => esc_html__( 'Currency', '_invoices' ),
							'name'         => 'currency',
							'type'         => 'select',
							'instructions' => esc_html__( 'Invoice currency for total pay amount calculation and display.', '_invoices' ),
							'required'     => 1,
							'choices'      => array(
								'USD' => 'USD',
								'EUR' => 'EUR',
							),
							'default_value' => array(
								0 => 'EUR',
							),
							'return_format' => 'value',
						),

						500 => array(
							'key'          => 'invoice_setup_notes',
							'label'        => esc_html__( 'Notes', '_invoices' ),
							'name'         => 'notes',
							'type'         => 'wysiwyg',
							'instructions' => esc_html__( 'Optional invoice notes, displayed before invoice items.', '_invoices' ),
							'required'     => 0,
							'wrapper'      => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value' => '',
							'tabs'          => 'all',
							'toolbar'       => 'basic',
							'media_upload'  => 0,
							'delay'         => 1,
						),

					),
					'location' => array(

						100 => array(

							100 => array(
								'param'    => 'post_type',
								'operator' => '==',
								'value'    => 'post',
								'order_no' => 0,
								'group_no' => $group_no++,
							),

						),

					),
					'menu_order'      => 20,
					'position'        => 'acf_after_title',
					'style'           => 'default',
					'label_placement' => 'left',
					'hide_on_screen'  => array(
						0 => 'permalink',
						1 => 'the_content',
						2 => 'excerpt',
						3 => 'discussion',
						4 => 'comments',
						5 => 'slug',
					),
				), 'invoice_setup', $group_no ) );

		} // /invoice_setup



		/**
		 * Invoice exchange options metabox
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function invoice_exchange() {

			// Helper variables

				$group_no = 0;


			// Processing

				register_field_group( (array) apply_filters( 'wmhook_invoices_acf_register_field_group', array(
					'id'     => 'invoice_exchange',
					'title'  => esc_html__( 'Exchange rate', '_invoices' ),
					'fields' => array(

						100 => array(
							'key'          => 'invoice_exchange_exchange_rate',
							'label'        => esc_html__( 'Exchange rate', '_invoices' ),
							'name'         => 'exchange_rate',
							'type'         => 'number',
							'instructions' => esc_html__( 'Optional currency exchange rate setup relevant to the invoice.', '_invoices' ) . ' <a href="' . esc_url( _x( 'https://www.nbs.sk/en/statistics/exchange-rates/monthly-cumulative-and-annual-exchange-rates', 'Exchange rate reference website URL.', '_invoices' ) ) . '" target="_blank">' . esc_html_x( 'www.nbs.sk', 'Exchange rate reference website title.', '_invoices' ) . '</a>',
						),

						200 => array(
							'key'     => 'invoice_exchange_exchange_from',
							'label'   => esc_html__( 'Currency to exchange FROM', '_invoices' ),
							'name'    => 'exchange_from',
							'type'    => 'select',
							'choices' => array(
								'USD' => 'USD',
								'EUR' => 'EUR',
							),
							'default_value' => array(
								0 => 'USD',
							),
							'return_format' => 'value',
						),

						300 => array(
							'key'     => 'invoice_exchange_exchange_to',
							'label'   => esc_html__( 'Currency to exchange TO', '_invoices' ),
							'name'    => 'exchange_to',
							'type'    => 'select',
							'choices' => array(
								'USD' => 'USD',
								'EUR' => 'EUR',
							),
							'default_value' => array(
								0 => 'EUR',
							),
							'return_format' => 'value',
						),

						400 => array(
							'key'            => 'invoice_exchange_exchange_date',
							'label'          => esc_html__( 'Date', '_invoices' ),
							'name'           => 'exchange_date',
							'type'           => 'date_picker',
							'instructions'   => esc_html__( 'Date of the exchange rate value for the record.', '_invoices' ),
							'display_format' => 'Y/m/d',
							'return_format'  => 'Ymd',
							'first_day'      => 1,
							'default_value'  => date( 'Ymt', strtotime( 'last month' ) ),
						),

					),
					'location' => array(

						100 => array(

							100 => array(
								'param'    => 'post_type',
								'operator' => '==',
								'value'    => 'post',
								'order_no' => 0,
								'group_no' => $group_no++,
							),

						),

					),
					'menu_order'      => 30,
					'position'        => 'side',
					'style'           => 'default',
				), 'invoice_exchange', $group_no ) );

		} // /invoice_exchange



		/**
		 * Hide obsolete Invoice metaboxes
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function invoice_metabox_hide() {

			// Processing

				remove_meta_box( 'categorydiv', 'post', 'side' );
				remove_meta_box( 'clientdiv', 'post', 'side' );
				remove_meta_box( 'payment_methoddiv', 'post', 'side' );

		} // /invoice_metabox_hide





} // /Invoices_Advanced_Custom_Fields

add_action( 'after_setup_theme', 'Invoices_Advanced_Custom_Fields::init' );
