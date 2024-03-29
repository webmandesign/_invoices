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
 * @version  2.3.0
 *
 * Contents:
 *
 *   0) Init
 *  10) Invoice
 *  20) Product
 *  30) Expense
 *  40) Taxonomies
 * 100) Helpers
 */
class Invoices_Advanced_Custom_Fields {





	/**
	 * 0) Init
	 */

		private static $instance;

		/**
		 * ACF metabox location keys must be numeric, not string!
		 * We are setting up some predefined ones for our use cases:
		 */
		public static $ands = 100;



		/**
		 * Constructor
		 *
		 * IMPORTANT:
		 * Do not bail if not in admin! We need this code to be included
		 * in front-end, as repeater type field needs it to properly
		 * register and retrieve values from related subfields.
		 *
		 * @since    1.0.0
		 * @version  1.6.0
		 */
		private function __construct() {

			// Processing

				// Hooks

					// Actions

						add_action( 'init', __CLASS__ . '::invoice_disable_editor' );

						$priority = 100; // Late enough for all post types to be registered.

						add_action( 'init', __CLASS__ . '::invoice_products', $priority );
						add_action( 'init', __CLASS__ . '::invoice_setup', $priority );
						add_action( 'init', __CLASS__ . '::invoice_exchange', $priority );
						add_action( 'init', __CLASS__ . '::invoice_attachments', $priority );
						add_action( 'init', __CLASS__ . '::product_setup', $priority );
						add_action( 'init', __CLASS__ . '::expense_setup', $priority );
						add_action( 'init', __CLASS__ . '::seller_stamp', $priority );

						add_action( 'admin_menu', __CLASS__ . '::invoice_metabox_hide' );

						add_action( 'save_post', __CLASS__ . '::invoice_save', 5, 3 );

					// Filters

						foreach ( (array) Invoices_Customize::$default_value_fields as $field_name ) {
							add_filter( 'acf/prepare_field/name=' . $field_name, __CLASS__ . '::default_field_value', 20 );
						}

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
		 * Invoice products metabox
		 *
		 * @since    1.0.0
		 * @version  2.3.0
		 */
		public static function invoice_products() {

			// Processing

				acf_add_local_field_group( (array) apply_filters( 'wmhook_invoices_acf_field_group', array(
					'id'     => 'group_invoice_products',
					'title'  => esc_html__( 'Invoiced items', '_invoices' ),
					'fields' => array(

						100 => array(
							'key'           => 'key_invoice_total',
							'name'          => 'invoice_total',
							'type'          => 'number',
							'label'         => esc_html__( 'Invoice total', '_invoices' ),
							'instructions'  => esc_html__( 'Save/update the invoice to recalculate the value.', '_invoices' ),
							'default_value' => 0,
						),

						200 => array(
							'key'          => 'key_invoice_products',
							'name'         => 'products',
							'type'         => 'repeater',
							'label'        => esc_html__( 'Invoiced items', '_invoices' ),
							'button_label' => esc_html__( '+ Add Invoiced Item', '_invoices' ),
							'required'     => 1,
							'collapsed'    => 'key_invoice_products_price',
							'min'          => 1,
							'layout'       => 'table',
							'sub_fields'   => array(

								100 => array(
									'key'      => 'key_invoice_products_quantity',
									'name'     => 'quantity',
									'type'     => 'number',
									'label'    => esc_html__( 'Qty', '_invoices' ),
									'required' => 1,
									'wrapper'  => array(
										'class' => 'has-width-60px',
									),
									'default_value' => 1,
									'min'           => 1,
									'max'           => 100,
									'step'          => 1,
								),

								200 => array(
									'key'      => 'key_invoice_products_product',
									'name'     => 'product',
									'type'     => 'post_object',
									'label'    => esc_html__( 'Item', '_invoices' ),
									'wrapper'  => array(
										'width' => '20',
									),
									'post_type' => array(
										0 => 'page',
									),
									'allow_null'    => 1,
									'return_format' => 'id',
								),

								300 => array(
									'key'      => 'key_invoice_products_description',
									'name'     => 'description',
									'type'     => 'textarea',
									'label'    => esc_html__( 'Optional additional item info', '_invoices' ),
									'wrapper'  => array(
										'width' => '60',
									),
									'rows'      => 1,
									'new_lines' => 'br',
								),

								400 => array(
									'key'      => 'key_invoice_products_price',
									'name'     => 'price',
									'type'     => 'number',
									'label'    => esc_html__( 'Price', '_invoices' ),
									'required' => 1,
									'wrapper'  => array(
										'class' => 'has-width-90px',
									),
								),

								900 => array(
									'key'      => 'key_invoice_products_total',
									'name'     => 'total',
									'type'     => 'number',
									'label'    => esc_html__( 'Total', '_invoices' ),
									'wrapper'  => array(
										'class' => 'has-width-120px',
									),
									'default_value' => 0,
								),

							),
						),

					),
					'location' => array(

						self::$ands => array(

							'is_post_type_post' => array(
								'param'    => 'post_type',
								'operator' => '==',
								'value'    => 'post',
							),

						),

					),
					'menu_order'      => 10,
					'position'        => 'acf_after_title',
					'style'           => 'seamless',
					'label_placement' => 'left',
				), 'invoice_products' ) );

		} // /invoice_products



		/**
		 * Invoice setup options metabox
		 *
		 * @since    1.0.0
		 * @version  1.9.2
		 */
		public static function invoice_setup() {

			// Processing

				acf_add_local_field_group( (array) apply_filters( 'wmhook_invoices_acf_field_group', array(
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
							'return_format' => 'id',
						),

						200 => array(
							'key'           => 'key_invoice_setup_client',
							'name'          => 'client',
							'type'          => 'taxonomy',
							'label'         => esc_html__( 'Client', '_invoices' ),
							'instructions'  => esc_html__( 'Customer receiving the invoice.', '_invoices' ),
							'required'      => 1,
							'taxonomy'      => 'client',
							'field_type'    => get_theme_mod( 'field_type_client', 'radio' ),
							'add_term'      => 0,
							'save_terms'    => 1,
							'load_terms'    => 1,
							'return_format' => 'id',
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
							'return_format' => 'id',
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
							'type'         => 'textarea',
							'label'        => esc_html__( 'Notes', '_invoices' ),
							'instructions' => esc_html__( 'Optional invoice notes, displayed before invoiced items list.', '_invoices' ),
							'rows'         => 3,
							'new_lines'    => 'br',
						),

						600 => array(
							'key'          => 'key_invoice_setup_due_period',
							'name'         => 'due_period',
							'type'         => 'number',
							'label'        => esc_html__( 'Due period (days)', '_invoices' ),
							'instructions' => esc_html__( 'Optional due period override.', '_invoices' ),
							'placeholder'  => absint( get_theme_mod( 'invoice_due_period', 21 ) ),
							'min'          => 0,
							'max'          => 182
						),

					),
					'location' => array(

						self::$ands => array(

							'is_post_type_post' => array(
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
		 * @version  2.1.0
		 */
		public static function invoice_exchange() {

			// Processing

				acf_add_local_field_group( (array) apply_filters( 'wmhook_invoices_acf_field_group', array(
					'id'     => 'group_invoice_exchange',
					'title'  => esc_html__( 'Dual currency display', '_invoices' ),
					'fields' => array(

						50 => array(
							'key'     => 'key_invoice_exchange_message',
							'type'    => 'message',
							'message' => esc_html__( 'Dual currency display of the invoice amounts will take place only if currencies differs.', '_invoices' ),
						),

						100 => array(
							'key'           => 'key_invoice_exchange_exchange_from',
							'name'          => 'exchange_from',
							'type'          => 'select',
							'label'         => esc_html__( 'Client (invoice) currency (FROM)', '_invoices' ),
							'instructions'  => esc_html__( 'This becomes the main invoice currency.', '_invoices' ),
							'choices'       => Invoices_Customize::get_currencies_array(),
							'default_value' => Invoices_Customize::get_currency_exchange_from(),
							'return_format' => 'value',
							'required'      => 1,
						),

						200 => array(
							'key'           => 'key_invoice_exchange_exchange_to',
							'name'          => 'exchange_to',
							'type'          => 'select',
							'label'         => esc_html__( 'Seller currency (TO)', '_invoices' ),
							'instructions'  => esc_html__( 'For seller accounting purposes.', '_invoices' ),
							'choices'       => Invoices_Customize::get_currencies_array(),
							'default_value' => Invoices_Customize::get_currency_exchange_to(),
							'return_format' => 'value',
							'required'      => 1,
						),

						300 => array(
							'key'           => 'key_invoice_exchange_exchange_rate',
							'name'          => 'exchange_rate',
							'type'          => 'text',
							'label'         => esc_html__( 'Exchange rate', '_invoices' ),
							'default_value' => '1.0000',
							// Requires https://wordpress.org/plugins/acf-quickedit-fields/ plugin.
							'allow_quickedit' => 1,
							'allow_bulkedit'  => 1,
						),

					),
					'location' => array(

						self::$ands => array(

							'is_post_type_post' => array(
								'param'    => 'post_type',
								'operator' => '==',
								'value'    => 'post',
							),

						),

					),
					'menu_order' => 30,
					'position'   => 'side',
					'style'      => 'default',
				), 'invoice_exchange' ) );

		} // /invoice_exchange



		/**
		 * Invoice attachments metabox
		 *
		 * @since    1.3.0
		 * @version  1.3.0
		 */
		public static function invoice_attachments() {

			// Processing

				acf_add_local_field_group( (array) apply_filters( 'wmhook_invoices_acf_field_group', array(
					'id'     => 'group_invoice_attachments',
					'title'  => esc_html__( 'Invoice attachments', '_invoices' ),
					'fields' => array(

						10 => array(
							'key'          => 'key_invoice_attachments',
							'name'         => 'attachments',
							'type'         => 'repeater',
							'label'        => esc_html__( 'Attachments', '_invoices' ),
							'button_label' => esc_html__( '+ Add Attachment', '_invoices' ),
							'layout'       => 'table',
							'sub_fields'   => array(

								100 => array(
									'key'           => 'key_invoice_attachments_attachment',
									'name'          => 'attachment',
									'type'          => 'file',
									'label'         => esc_html__( 'Attachment', '_invoices' ),
									'return_format' => 'array',
								),

							),
						),

					),
					'location' => array(

						self::$ands => array(

							'is_post_type_post' => array(
								'param'    => 'post_type',
								'operator' => '==',
								'value'    => 'post',
							),

						),

					),
					'menu_order' => 30,
					'position'   => 'side',
					'style'      => 'default',
				), 'invoice_attachments' ) );

		} // /invoice_attachments



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
		 * Count rows totals before saving the post
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  int     $post_id  Post ID.
		 * @param  WP_Post $post     Post object.
		 * @param  bool    $update   Whether this is an existing post being updated or not.
		 */
		public static function invoice_save( $post_id, $post, $update ) {

			// Requirements check

				if (
					! isset( $_POST['acf']['key_invoice_products'] )
					|| ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				) {
					return $post_id;
				}


			// Helper variables

				$total_invoice = 0;


			// Processing

				foreach ( (array) $_POST['acf']['key_invoice_products'] as $key => $subfields ) {
					if (
						isset( $subfields['key_invoice_products_price'] )
						&& isset( $subfields['key_invoice_products_quantity'] )
					) {

						$total_row = (float) $subfields['key_invoice_products_price'] * absint( $subfields['key_invoice_products_quantity'] );

						$_POST['acf']['key_invoice_products'][ $key ]['key_invoice_products_total'] = sprintf( '%.2f', $total_row );
						$_POST['_acf_changed'] = 1;

						$total_invoice += $total_row;

					}
				}

				if ( $total_invoice ) {
					$_POST['acf']['key_invoice_total'] = sprintf( '%.2f', $total_invoice );
				}

		} // /invoice_save





	/**
	 * 20) Product
	 */

		/**
		 * Product setup options metabox
		 *
		 * @since    1.4.0
		 * @version  1.4.1
		 */
		public static function product_setup() {

			// Processing

				acf_add_local_field_group( (array) apply_filters( 'wmhook_invoices_acf_field_group', array(
					'id'     => 'group_product_setup',
					'title'  => esc_html__( 'Product setup', '_invoices' ),
					'fields' => array(

						100 => array(
							'key'          => 'key_product_setup_action',
							'name'         => 'action',
							'type'         => 'select',
							'label'        => esc_html__( 'Action, behavior', '_invoices' ),
							'instructions' => esc_html__( 'Choose how this product affects invoice total.', '_invoices' ),
							'default'      => '',
							'choices'      => array(
								''            => esc_html__( 'Add to invoice total', '_invoices' ),
								'deduct'      => esc_html__( 'Deduct from invoice total', '_invoices' ),
								'deduct_soft' => esc_html__( 'Soft deduct (Only an informative additional invoice total display. Will not affect actual invoice total!)', '_invoices' ),
							),
						),

					),
					'location' => array(

						self::$ands => array(

							'is_post_type_post' => array(
								'param'    => 'post_type',
								'operator' => '==',
								'value'    => 'page',
							),

						),

					),
					'menu_order'      => 20,
					'style'           => 'default',
					'label_placement' => 'left',
				), 'product_setup' ) );

		} // /product_setup





	/**
	 * 30) Expense
	 */

		/**
		 * Expense setup options metabox.
		 *
		 * @since    1.6.0
		 * @version  1.6.0
		 */
		public static function expense_setup() {

			// Processing

				acf_add_local_field_group( (array) apply_filters( 'wmhook_invoices_acf_field_group', array(
					'id'     => 'group_expense_setup',
					'title'  => esc_html__( 'Expense setup', '_invoices' ),
					'fields' => array(

						100 => array(
							'key'      => 'key_expense_setup_amount',
							'name'     => 'amount',
							'type'     => 'number',
							'label'    => esc_html__( 'Amount', '_invoices' ),
							'required' => 1,
							'wrapper'  => array(
								'width' => '15',
							),
						),

						200 => array(
							'key'           => 'key_expense_setup_currency',
							'name'          => 'currency',
							'type'          => 'select',
							'label'         => esc_html__( 'Currency', '_invoices' ),
							'choices'       => Invoices_Customize::get_currencies_array(),
							'default_value' => Invoices_Customize::get_currency_exchange_from(),
							'return_format' => 'value',
							'required'      => 1,
						),

						300 => array(
							'key'   => 'key_expense_setup_description',
							'name'  => 'description',
							'type'  => 'wysiwyg',
							'label' => esc_html__( 'Description', '_invoices' ),
							'rows'  => 3,
						),

					),
					'location' => array(

						self::$ands => array(

							'is_post_type_post' => array(
								'param'    => 'post_type',
								'operator' => '==',
								'value'    => 'expense',
							),

						),

					),
					'menu_order'      => 20,
					'style'           => 'default',
					'label_placement' => 'left',
				), 'expense_setup' ) );

		} // /expense_setup





	/**
	 * 40) Taxonomies
	 */

		/**
		 * Invoice seller stamp image
		 *
		 * @since    1.0.0
		 * @version  1.3.0
		 */
		public static function seller_stamp() {

			// Processing

				acf_add_local_field_group( (array) apply_filters( 'wmhook_invoices_acf_field_group', array(
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

						self::$ands => array(

							'is_taxonomy_category' => array(
								'param'    => 'taxonomy',
								'operator' => '==',
								'value'    => 'category',
							),

						),

					),
					'style' => 'seamless',
				), 'seller_stamp' ) );

		} // /seller_stamp





	/**
	 * 100) Helpers
	 */

		/**
		 * Load default field value
		 *
		 * @link  https://support.advancedcustomfields.com/forums/topic/default-value-for-the-taxonomy-field-type/
		 *
		 * @since    1.1.0
		 * @version  1.1.0
		 */
		public static function default_field_value( $field ) {

			// Processing

				if ( empty( $field['value'] ) ) {
					$field['value'] = get_theme_mod( 'default_' . $field['_name'] );
				}


			// Output

		  	return $field;

		} // /default_field_value





} // /Invoices_Advanced_Custom_Fields

add_action( 'after_setup_theme', 'Invoices_Advanced_Custom_Fields::init' );
