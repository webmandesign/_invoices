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
		 * IMPORTANT:
		 * Do not bail if not in admin! We need this code to be included
		 * in front-end, as repeater type field needs it to properly
		 * register and retrieve values from related subfields.
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		private function __construct() {

			// Processing

				// Hooks

					// Actions

						add_action( 'init', __CLASS__ . '::invoice_disable_editor' );

						add_action( 'acf/init', __CLASS__ . '::invoice_items' );
						add_action( 'acf/init', __CLASS__ . '::invoice_setup' );
						add_action( 'acf/init', __CLASS__ . '::invoice_exchange' );
						add_action( 'acf/init', __CLASS__ . '::seller_stamp' );

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

			// Processing

				acf_add_local_field_group( (array) apply_filters( 'wmhook_invoices_acf_add_local_field_group', array(
					'id'     => 'group_invoice_items',
					'title'  => esc_html__( 'Invoice items', '_invoices' ),
					'fields' => array(

						100 => array(
							'key'          => 'key_invoice_items',
							'name'         => 'items',
							'type'         => 'repeater',
							'label'        => esc_html__( 'Invoice items', '_invoices' ),
							'button_label' => esc_html__( '+ Add invoice item', '_invoices' ),
							'required'     => 1,
							'collapsed'    => 'key_invoice_items_price',
							'min'          => 1,
							'layout'       => 'table',
							'sub_fields'   => array(

								100 => array(
									'key'      => 'key_invoice_items_price',
									'name'     => 'price',
									'type'     => 'number',
									'label'    => esc_html__( 'Price', '_invoices' ),
									'required' => 1,
									'wrapper'  => array(
										'width' => '20',
									),
								),

								200 => array(
									'key'      => 'key_invoice_items_quantity',
									'name'     => 'quantity',
									'type'     => 'number',
									'label'    => esc_html__( 'Qty', '_invoices' ),
									'required' => 1,
									'wrapper'  => array(
										'width' => '5',
									),
									'default_value' => 1,
									'min'           => 1,
									'max'           => 100,
									'step'          => 1,
								),

								300 => array(
									'key'      => 'key_invoice_items_item',
									'name'     => 'item',
									'type'     => 'post_object',
									'label'    => esc_html__( 'Item', '_invoices' ),
									'wrapper'  => array(
										'width' => '25',
									),
									'post_type' => array(
										0 => 'page',
									),
									'allow_null'    => 1,
									'return_format' => 'object',
								),

								400 => array(
									'key'      => 'key_invoice_items_description',
									'name'     => 'description',
									'type'     => 'wysiwyg',
									'label'    => esc_html__( 'Optional (additional) item info', '_invoices' ),
									'wrapper'  => array(
										'width' => '50',
									),
									'media_upload' => 0,
									'delay'        => 1,
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
							),

						),

					),
					'menu_order' => 10,
					'position'   => 'acf_after_title',
					'style'      => 'seamless',
				), 'invoice_items' ) );

		} // /invoice_items



		/**
		 * Invoice setup options metabox
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function invoice_setup() {

			// Processing

				acf_add_local_field_group( (array) apply_filters( 'wmhook_invoices_acf_add_local_field_group', array(
					'id'     => 'group_invoice_setup',
					'title'  => esc_html__( 'Invoice setup', '_invoices' ),
					'fields' => array(

						100 => array(
							'key'           => 'key_invoice_setup_seller',
							'name'          => 'seller',
							'type'          => 'taxonomy',
							'label'         => esc_html__( 'Seller', '_invoices' ),
							'instructions'  => esc_html__( 'Company issuing the invoice.', '_invoices' ),
							'required'      => 1,
							'taxonomy'      => 'category',
							'field_type'    => 'radio',
							'add_term'      => 0,
							'save_terms'    => 1,
							'load_terms'    => 1,
							'return_format' => 'object',
						),

						200 => array(
							'key'           => 'key_invoice_setup_client',
							'name'          => 'client',
							'type'          => 'taxonomy',
							'label'         => esc_html__( 'Client', '_invoices' ),
							'instructions'  => esc_html__( 'Customer receiving the invoice.', '_invoices' ),
							'required'      => 1,
							'taxonomy'      => 'client',
							'field_type'    => 'select',
							'add_term'      => 0,
							'save_terms'    => 1,
							'load_terms'    => 1,
							'return_format' => 'object',
						),

						300 => array(
							'key'           => 'key_invoice_setup_payment_method',
							'name'          => 'payment_method',
							'type'          => 'taxonomy',
							'label'         => esc_html__( 'Payment method', '_invoices' ),
							'instructions'  => esc_html__( 'Preferred payment method to pay the invoice.', '_invoices' ),
							'required'      => 1,
							'taxonomy'      => 'payment_method',
							'field_type'    => 'checkbox',
							'add_term'      => 0,
							'save_terms'    => 1,
							'load_terms'    => 1,
							'return_format' => 'object',
						),

						400 => array(
							'key'           => 'key_invoice_setup_symbol_constant',
							'name'          => 'symbol_constant',
							'type'          => 'text',
							'label'         => esc_html__( 'Constant symbol', '_invoices' ),
							'instructions'  => esc_html__( 'Optional invoice constant symbol.', '_invoices' ),
							'default_value' => esc_html_x( '308', 'Invoice default constant symbol.', '_invoices' ),
						),

						500 => array(
							'key'          => 'key_invoice_setup_notes',
							'name'         => 'notes',
							'type'         => 'wysiwyg',
							'label'        => esc_html__( 'Notes', '_invoices' ),
							'instructions' => esc_html__( 'Optional invoice notes, displayed before invoice items.', '_invoices' ),
							'media_upload' => 0,
							'delay'        => 1,
						),

					),
					'location' => array(

						100 => array(

							100 => array(
								'param'    => 'post_type',
								'operator' => '==',
								'value'    => 'post',
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
				), 'invoice_setup' ) );

		} // /invoice_setup



		/**
		 * Invoice exchange options metabox
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function invoice_exchange() {

			// Processing

				acf_add_local_field_group( (array) apply_filters( 'wmhook_invoices_acf_add_local_field_group', array(
					'id'     => 'group_invoice_exchange',
					'title'  => esc_html__( 'Dual currency display', '_invoices' ),
					'fields' => array(

						100 => array(
							'key'           => 'key_invoice_exchange_exchange_rate',
							'name'          => 'exchange_rate',
							'type'          => 'number',
							'label'         => esc_html__( 'Exchange rate', '_invoices' ),
							'instructions'  => '<a href="' . esc_url( _x( 'https://www.nbs.sk/en/statistics/exchange-rates/monthly-cumulative-and-annual-exchange-rates', 'Exchange rate reference website URL.', '_invoices' ) ) . '" target="_blank">' . esc_html_x( 'www.nbs.sk', 'Exchange rate reference website title.', '_invoices' ) . '</a>',
							'default_value' => 0,
							'required'      => 1,
						),

						200 => array(
							'key'           => 'key_invoice_exchange_exchange_from',
							'name'          => 'exchange_from',
							'type'          => 'select',
							'label'         => esc_html__( 'Client (invoice) currency', '_invoices' ),
							'instructions'  => esc_html__( 'Currency to exchange FROM.', '_invoices' ) . ' ' . esc_html__( 'This becomes the main invoice currency.', '_invoices' ),
							'choices'       => Invoices_Customize::get_currencies_array(),
							'default_value' => Invoices_Customize::get_currency_exchange_from(),
							'return_format' => 'value',
							'required'      => 1,
						),

						300 => array(
							'key'           => 'key_invoice_exchange_exchange_to',
							'name'          => 'exchange_to',
							'type'          => 'select',
							'label'         => esc_html__( 'Seller currency', '_invoices' ),
							'instructions'  => esc_html__( 'Currency to exchange TO.', '_invoices' ) . ' ' . esc_html__( 'If it differs from client currency, exchanged amount will be calculated automatically from provided rate.', '_invoices' ) . ' ' . esc_html__( 'For seller accounting purposes.', '_invoices' ),
							'choices'       => Invoices_Customize::get_currencies_array(),
							'default_value' => Invoices_Customize::get_currency_exchange_to(),
							'return_format' => 'value',
							'required'      => 1,
						),

						400 => array(
							'key'            => 'key_invoice_exchange_exchange_date',
							'name'           => 'exchange_date',
							'type'           => 'date_picker',
							'label'          => esc_html__( 'Date', '_invoices' ),
							'instructions'   => esc_html__( 'Date of the exchange rate value for the record.', '_invoices' ),
							'display_format' => 'Y/m/d',
							'return_format'  => 'Ymd',
							'first_day'      => 1,
							'default_value'  => date( 'Ymt', strtotime( 'last month' ) ),
						),

						500 => array(
							'key'     => 'key_invoice_exchange_message',
							'type'    => 'message',
							'label'   => esc_html__( 'Info', '_invoices' ),
							'message' => esc_html__( 'Automatic exchange calculation and dual currency display of invoice amounts will take place only if exchange rate is higher than zero and currencies differs.', '_invoices' ),
						),

					),
					'location' => array(

						100 => array(

							100 => array(
								'param'    => 'post_type',
								'operator' => '==',
								'value'    => 'post',
							),

						),

					),
					'menu_order'      => 30,
					'position'        => 'side',
					'style'           => 'default',
				), 'invoice_exchange' ) );

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



		/**
		 * Invoice seller stamp image
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function seller_stamp() {

			// Processing

				acf_add_local_field_group( (array) apply_filters( 'wmhook_invoices_acf_add_local_field_group', array(
					'key'    => 'group_seller_stamp',
					'title'  => esc_html__( 'Seller options', '_invoices' ),
					'fields' => array(

						100 => array(
							'key'           => 'key_seller_stamp_image_stamp',
							'label'         => esc_html__( 'Stamp image', '_invoices' ),
							'name'          => 'image_stamp',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'medium',
						),

					),
					'location' => array(

						100 => array(

							100 => array(
								'param'    => 'taxonomy',
								'operator' => '==',
								'value'    => 'category',
							),

						),

					),
					'style' => 'seamless',
				), 'seller_stamp' ) );

		} // /seller_stamp





} // /Invoices_Advanced_Custom_Fields

add_action( 'after_setup_theme', 'Invoices_Advanced_Custom_Fields::init' );
