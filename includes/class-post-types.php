<?php
/**
 * Post Types Class
 *
 * Creates:
 * - "Invoice" post type from "Post" post type,
 * - "Product" post type from "Page" post type.
 *
 * Removes:
 * - support for comments and trackbacks.
 *
 * @see  https://wordpress.org/plugins/sliced-invoices/
 * @see  https://ps.w.org/invoicing/assets/screenshot-6.png
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.1.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Invoices
 * 20) Products
 */
class Invoices_Post_Types {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 * @version  1.1.0
		 */
		private function __construct() {

			// Processing

				// Hooks

					// Actions

						add_action( 'init', __CLASS__ . '::invoice_setup' );
						add_action( 'init', __CLASS__ . '::products_setup' );

						add_action( 'registered_post_type', __CLASS__ . '::invoice_post_type_object', 10, 2 );
						add_action( 'registered_post_type', __CLASS__ . '::products_post_type_object', 10, 2 );

						add_action( 'edit_form_top', __CLASS__ . '::invoice_predefined' );

						// Invoice header
						add_action( 'invoice_content', __CLASS__ . '::invoice_anchors', 105 );
						add_action( 'invoice_content', __CLASS__ . '::invoice_title', 110 );
						add_action( 'invoice_content', __CLASS__ . '::invoice_meta_companies', 120 );
						add_action( 'invoice_content', __CLASS__ . '::invoice_meta_dates', 130 );
						// Invoice content
						add_action( 'invoice_content', __CLASS__ . '::invoice_note', 210 );
						add_action( 'invoice_content', __CLASS__ . '::products', 220 );
						add_action( 'invoice_content', __CLASS__ . '::invoice_meta_total', 230 );
						// Invoice footer
						add_action( 'invoice_content', __CLASS__ . '::invoice_meta_symbols', 310 );
						add_action( 'invoice_content', __CLASS__ . '::invoice_meta_payment', 320 );

					// Filters

						add_filter( 'wp_insert_post_data', __CLASS__ . '::invoice_post_data', 10, 2 );

						add_filter( 'post_class', __CLASS__ . '::invoice_post_class' );

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
	 * 10) Invoices
	 */

		/**
		 * Setup Invoice CPT from "Posts"
		 *
		 * @since    1.0.0
		 * @version  1.1.0
		 */
		public static function invoice_setup() {

			// Processing

				remove_post_type_support( 'post', 'excerpt' );
				remove_post_type_support( 'post', 'comments' );
				remove_post_type_support( 'post', 'trackbacks' );
				/**
				 * We also remove content editor when ACF is active.
				 * @see  class-advanced-custom-fields.php
				 */

		} // /invoice_setup



		/**
		 * Modify Invoice post type object
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string       $post_type         Post type.
     * @param  WP_Post_Type $post_type_object  Arguments used to register the post type.
		 */
		public static function invoice_post_type_object( $post_type, $post_type_object ) {

			// Requirements check

				if ( 'post' !== $post_type ) {
					return;
				}


			// Helper variables

				$labels = array(
					'name'                  => esc_html_x( 'Invoices', 'post type general name', '_invoices' ),
					'singular_name'         => esc_html_x( 'Invoice', 'post type singular name', '_invoices' ),
					'add_new_item'          => esc_html__( 'Add New Invoice', '_invoices' ),
					'edit_item'             => esc_html__( 'Edit Invoice', '_invoices' ),
					'new_item'              => esc_html__( 'New Invoice', '_invoices' ),
					'view_item'             => esc_html__( 'View Invoice', '_invoices' ),
					'view_items'            => esc_html__( 'View Invoices', '_invoices' ),
					'search_items'          => esc_html__( 'Search Invoices', '_invoices' ),
					'not_found'             => esc_html__( 'No Invoices found.', '_invoices' ),
					'not_found_in_trash'    => esc_html__( 'No Invoices found in Trash.', '_invoices' ),
					'all_items'             => esc_html__( 'All Invoices', '_invoices' ),
					'archives'              => esc_html__( 'Invoice Archives', '_invoices' ),
					'attributes'            => esc_html__( 'Invoice Attributes', '_invoices' ),
					'insert_into_item'      => esc_html__( 'Insert into Invoice', '_invoices' ),
					'uploaded_to_this_item' => esc_html__( 'Uploaded to this Invoice', '_invoices' ),
					'filter_items_list'     => esc_html__( 'Filter Invoices list', '_invoices' ),
					'items_list_navigation' => esc_html__( 'Invoices list navigation', '_invoices' ),
					'items_list'            => esc_html__( 'Invoices list', '_invoices' ),
					'menu_name'             => esc_html__( 'Invoices', '_invoices' ),
					'name_admin_bar'        => esc_html__( 'Invoice', '_invoices' ),
				);


			// Processing

				// Change labels

					foreach ( $labels as $key => $value ) {
						$post_type_object->labels->$key = $value;
					}

				// Change admin menu icon

					$post_type_object->menu_icon = 'dashicons-media-document';

		} // /invoice_post_type_object



		/**
		 * Setup predefined Invoice post attributes
		 *
		 * We presume, when a new invoice is being created,
		 * it is being issued for the previous month.
		 * So, we preset the invoice title as "Invoice YYMMDD01",
		 * where "YY" represents last two digits of the year,
		 * "MM" is a numeric representation of a month, with leading zeros,
		 * and "DD" represents the number of days in the given month.
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  WP_Post $post  Post object.
		 */
		public static function invoice_predefined( $post ) {

			// Requirements check

				if (
					'post' !== $post->post_type
					|| trim( $post->post_title )
				) {
					return;
				}


			// Processing

				// Title

					$GLOBALS['post']->post_title = date( 'ymt', strtotime( 'last month' ) ) . '0#';

				// Publish date

					$GLOBALS['post']->post_date = date( 'Y-m-t 01:00:00', strtotime( 'last month' ) );

		} // /invoice_predefined



		/**
		 * Modify invoice post data just before saving
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $data     An array of slashed post data.
		 * @param  array $postarr  An array of sanitized, but otherwise unmodified post data.
		 */
		public static function invoice_post_data( $data, $postarr ) {

			// Requirements check

				if (
					'post' !== $data['post_type']
					|| ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				) {
					return $data;
				}


			// Processing

				// Change publish date to set value

					if (
						isset( $_POST['aa'] )
						&& isset( $_POST['mm'] )
						&& isset( $_POST['jj'] )
						&& isset( $_POST['hh'] )
						&& isset( $_POST['mn'] )
						&& isset( $_POST['ss'] )
					) {
						$post_date  = $_POST['aa'] . '-' . $_POST['mm'] . '-' . $_POST['jj'];
						$post_date .= ' ' . $_POST['hh'] . ':' . $_POST['mn'] . ':' . $_POST['ss'];
						$data['post_date'] = $post_date;
					}


			// Output

				return $data;

		} // /invoice_post_data



		/**
		 * Invoice post classes
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array $classes
		 */
		public static function invoice_post_class( $classes ) {

			// Processing

				if ( 'post' === get_post_type() ) {
					if ( is_single() || is_archive() ) {
						// Full display on single and archive pages
						$classes[] = 'invoice';
					} else {
						// Simple display otherwise
						$classes[] = 'invoice-simple';
					}
				}


			// Output

				return $classes;

		} // /invoice_post_class



		/**
		 * Display invoice links/anchors
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function invoice_anchors() {

			// Output

				get_template_part( 'templates/parts/component/anchors', 'invoice' );

		} // /invoice_anchors



		/**
		 * Display invoice title
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function invoice_title() {

			// Output

				get_template_part( 'templates/parts/component/title', 'invoice' );

		} // /invoice_title



		/**
		 * Display invoice note
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function invoice_note() {

			// Output

				get_template_part( 'templates/parts/component/note', 'invoice' );

		} // /invoice_note



		/**
		 * Display invoiced products
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function products() {

			// Output

				get_template_part( 'templates/parts/loop/loop', 'products' );

		} // /products



		/**
		 * Display invoice meta: Total amount
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function invoice_meta_total() {

			// Output

				get_template_part( 'templates/parts/meta/meta-invoice', 'total' );

		} // /invoice_meta_total



		/**
		 * Display invoice meta: Companies info
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function invoice_meta_companies() {

			// Output

				get_template_part( 'templates/parts/meta/meta-invoice', 'companies' );

		} // /invoice_meta_companies



		/**
		 * Display invoice meta: Dates info
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function invoice_meta_dates() {

			// Output

				get_template_part( 'templates/parts/meta/meta-invoice', 'dates' );

		} // /invoice_meta_dates



		/**
		 * Display invoice meta: Symbols info
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function invoice_meta_symbols() {

			// Output

				get_template_part( 'templates/parts/meta/meta-invoice', 'symbols' );

		} // /invoice_meta_symbols



		/**
		 * Display invoice meta: Payment info
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function invoice_meta_payment() {

			// Output

				get_template_part( 'templates/parts/meta/meta-invoice', 'payment' );

		} // /invoice_meta_payment



		/**
		 * Get invoice title
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $post_title
		 */
		public static function get_the_title_invoice( $post_title = '' ) {

			// Helper variables

				$post_type = get_post_type_object( 'post' );
				$labels    = get_post_type_labels( $post_type );

				if ( empty( $post_title ) ) {
					$post_title = get_the_title();
				}


			// Output

				return str_replace(
					$labels->singular_name . ' ',
					'',
					$post_title
				);

		} // /get_the_title_invoice





	/**
	 * 20) Products
	 */

		/**
		 * Setup Product CPT from "Pages"
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function products_setup() {

			// Processing

				// Post type support

					remove_post_type_support( 'page', 'comments' );
					remove_post_type_support( 'page', 'trackbacks' );
					remove_post_type_support( 'page', 'page-attributes' );

		} // /products_setup



		/**
		 * Modify Product post type object
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string       $post_type         Post type.
     * @param  WP_Post_Type $post_type_object  Arguments used to register the post type.
		 */
		public static function products_post_type_object( $post_type, $post_type_object ) {

			// Requirements check

				if ( 'page' !== $post_type ) {
					return;
				}


			// Helper variables

				$labels = array(
					'name'                  => esc_html_x( 'Products', 'post type general name', '_invoices' ),
					'singular_name'         => esc_html_x( 'Product', 'post type singular name', '_invoices' ),
					'add_new_item'          => esc_html__( 'Add New Product', '_invoices' ),
					'edit_item'             => esc_html__( 'Edit Product', '_invoices' ),
					'new_item'              => esc_html__( 'New Product', '_invoices' ),
					'view_item'             => esc_html__( 'View Product', '_invoices' ),
					'view_items'            => esc_html__( 'View Products', '_invoices' ),
					'search_items'          => esc_html__( 'Search Products', '_invoices' ),
					'not_found'             => esc_html__( 'No Products found.', '_invoices' ),
					'not_found_in_trash'    => esc_html__( 'No Products found in Trash.', '_invoices' ),
					'parent_item_colon'     => esc_html__( 'Parent Product:', '_invoices' ),
					'all_items'             => esc_html__( 'All Products', '_invoices' ),
					'archives'              => esc_html__( 'Product Archives', '_invoices' ),
					'attributes'            => esc_html__( 'Product Attributes', '_invoices' ),
					'insert_into_item'      => esc_html__( 'Insert into Product', '_invoices' ),
					'uploaded_to_this_item' => esc_html__( 'Uploaded to this Product', '_invoices' ),
					'filter_items_list'     => esc_html__( 'Filter Products list', '_invoices' ),
					'items_list_navigation' => esc_html__( 'Products list navigation', '_invoices' ),
					'items_list'            => esc_html__( 'Products list', '_invoices' ),
					'menu_name'             => esc_html__( 'Products', '_invoices' ),
					'name_admin_bar'        => esc_html__( 'Product', '_invoices' ),
				);


			// Processing

				// Change labels

					foreach ( $labels as $key => $value ) {
						$post_type_object->labels->$key = $value;
					}

				// Change admin menu icon

					$post_type_object->menu_icon = 'dashicons-products';

		} // /products_post_type_object





} // /Invoices_Post_Types

add_action( 'after_setup_theme', 'Invoices_Post_Types::init' );
