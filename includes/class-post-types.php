<?php
/**
 * Post Types Class
 *
 * Creates:
 * - "Invoice" post type from "Post" post type,
 * - "Invoice Item" post type from "Page" post type,
 * - "Client" taxonomy from "Category" taxonomy,
 * - "Payment Method" custom taxonomy.
 *
 * Removes:
 * - post tags taxonomy,
 * - support for comments and trackbacks.
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
 * 10) Invoices
 * 20) Invoice Items
 * 30) Clients
 * 40) Payment Methods
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
		 * @version  1.0.0
		 */
		private function __construct() {

			// Processing

				// Hooks

					// Actions

						add_action( 'init', __CLASS__ . '::invoice_setup' );
						add_action( 'init', __CLASS__ . '::invoice_item_setup' );
						add_action( 'init', __CLASS__ . '::payment_methods_setup' );

						add_action( 'registered_post_type', __CLASS__ . '::invoice_post_type_object', 10, 2 );
						add_action( 'registered_post_type', __CLASS__ . '::invoice_item_post_type_object', 10, 2 );

					// Filters

						add_filter( 'register_taxonomy_args', __CLASS__ . '::clients_setup', 10, 2 );

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
		 * @version  1.0.0
		 */
		public static function invoice_setup() {

			// Processing

				// https://wordpress.org/plugins/sliced-invoices/
				// https://ps.w.org/invoicing/assets/screenshot-6.png

				// Post type support

					remove_post_type_support( 'post', 'comments' );
					remove_post_type_support( 'post', 'trackbacks' );

				// Post type taxonomies

					unregister_taxonomy_for_object_type( 'post_tag', 'post' );

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
					'parent_item_colon'     => esc_html__( 'Parent Invoice:', '_invoices' ),
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
	 * 20) Invoice Items
	 */

		/**
		 * Setup Invoice Items CPT from "Pages"
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function invoice_item_setup() {

			// Processing

				// Post type support

					remove_post_type_support( 'page', 'comments' );
					remove_post_type_support( 'page', 'trackbacks' );

		} // /invoice_item_setup



		/**
		 * Modify Invoice Items post type object
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string       $post_type         Post type.
     * @param  WP_Post_Type $post_type_object  Arguments used to register the post type.
		 */
		public static function invoice_item_post_type_object( $post_type, $post_type_object ) {

			// Requirements check

				if ( 'page' !== $post_type ) {
					return;
				}


			// Helper variables

				$labels = array(
					'name'                  => esc_html_x( 'Invoice Items', 'post type general name', '_invoices' ),
					'singular_name'         => esc_html_x( 'Invoice Item', 'post type singular name', '_invoices' ),
					'add_new_item'          => esc_html__( 'Add New Invoice Item', '_invoices' ),
					'edit_item'             => esc_html__( 'Edit Invoice Item', '_invoices' ),
					'new_item'              => esc_html__( 'New Invoice Item', '_invoices' ),
					'view_item'             => esc_html__( 'View Invoice Item', '_invoices' ),
					'view_items'            => esc_html__( 'View Invoice Items', '_invoices' ),
					'search_items'          => esc_html__( 'Search Invoice Items', '_invoices' ),
					'not_found'             => esc_html__( 'No Invoice Items found.', '_invoices' ),
					'not_found_in_trash'    => esc_html__( 'No Invoice Items found in Trash.', '_invoices' ),
					'parent_item_colon'     => esc_html__( 'Parent Invoice Item:', '_invoices' ),
					'all_items'             => esc_html__( 'All Invoice Items', '_invoices' ),
					'archives'              => esc_html__( 'Invoice Item Archives', '_invoices' ),
					'attributes'            => esc_html__( 'Invoice Item Attributes', '_invoices' ),
					'insert_into_item'      => esc_html__( 'Insert into Invoice Item', '_invoices' ),
					'uploaded_to_this_item' => esc_html__( 'Uploaded to this Invoice Item', '_invoices' ),
					'filter_items_list'     => esc_html__( 'Filter Invoice Items list', '_invoices' ),
					'items_list_navigation' => esc_html__( 'Invoice Items list navigation', '_invoices' ),
					'items_list'            => esc_html__( 'Invoice Items list', '_invoices' ),
					'menu_name'             => esc_html__( 'Invoice Items', '_invoices' ),
					'name_admin_bar'        => esc_html__( 'Invoice Item', '_invoices' ),
				);


			// Processing

				// Change labels

					foreach ( $labels as $key => $value ) {
						$post_type_object->labels->$key = $value;
					}

				// Change admin menu icon

					$post_type_object->menu_icon = 'dashicons-editor-ul';

		} // /invoice_item_post_type_object





	/**
	 * 30) Clients
	 */

		/**
		 * Rename "Categories" taxonomy to "Clients"
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array  $args      Array of arguments for registering a taxonomy.
     * @param  string $taxonomy  Taxonomy key.
		 */
		public static function clients_setup( $args, $taxonomy ) {

			// Helper variables

				$labels = array(
					'name'                  => esc_html_x( 'Clients', 'taxonomy general name', '_invoices' ),
					'singular_name'         => esc_html_x( 'Client', 'taxonomy singular name', '_invoices' ),
					'search_items'          => esc_html__( 'Search Clients', '_invoices' ),
					'all_items'             => esc_html__( 'All Clients', '_invoices' ),
					'parent_item'           => esc_html__( 'Parent Client', '_invoices' ),
					'parent_item_colon'     => esc_html__( 'Parent Client:', '_invoices' ),
					'edit_item'             => esc_html__( 'Edit Client', '_invoices' ),
					'view_item'             => esc_html__( 'View Client', '_invoices' ),
					'update_item'           => esc_html__( 'Update Client', '_invoices' ),
					'add_new_item'          => esc_html__( 'Add New Client', '_invoices' ),
					'new_item_name'         => esc_html__( 'New Client Name', '_invoices' ),
					'not_found'             => esc_html__( 'No Clients found.', '_invoices' ),
					'no_terms'              => esc_html__( 'No Clients', '_invoices' ),
					'items_list_navigation' => esc_html__( 'Clients list navigation', '_invoices' ),
					'items_list'            => esc_html__( 'Clients list', '_invoices' ),
				);


			// Processing

				if ( 'category' === $taxonomy ) {
					foreach ( $labels as $key => $value ) {
						$args['labels'][ $key ] = $value;
					}
				}


			// Output

				return $args;

		} // /clients_setup





	/**
	 * 40) Payment Methods
	 */

		/**
		 * Register Payment Methods taxonomy
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function payment_methods_setup() {

			// Helper variables

				$labels = array(
					'name'                  => esc_html_x( 'Payment Methods', 'taxonomy general name', '_invoices' ),
					'singular_name'         => esc_html_x( 'Payment Method', 'taxonomy singular name', '_invoices' ),
					'search_items'          => esc_html__( 'Search Payment Methods', '_invoices' ),
					'all_items'             => esc_html__( 'All Payment Methods', '_invoices' ),
					'parent_item'           => esc_html__( 'Parent Payment Method', '_invoices' ),
					'parent_item_colon'     => esc_html__( 'Parent Payment Method:', '_invoices' ),
					'edit_item'             => esc_html__( 'Edit Payment Method', '_invoices' ),
					'view_item'             => esc_html__( 'View Payment Method', '_invoices' ),
					'update_item'           => esc_html__( 'Update Payment Method', '_invoices' ),
					'add_new_item'          => esc_html__( 'Add New Payment Method', '_invoices' ),
					'new_item_name'         => esc_html__( 'New Payment Method Name', '_invoices' ),
					'not_found'             => esc_html__( 'No Payment Methods found.', '_invoices' ),
					'no_terms'              => esc_html__( 'No Payment Methods', '_invoices' ),
					'items_list_navigation' => esc_html__( 'Payment Methods list navigation', '_invoices' ),
					'items_list'            => esc_html__( 'Payment Methods list', '_invoices' ),
				);

				$args = array(
					'hierarchical'      => true,
					'labels'            => $labels,
					'query_var'         => true,
					'public'            => true,
					'show_ui'           => true,
					'show_admin_column' => true,
					'rewrite'           => array( 'slug' => 'payment-method' ),
				);


			// Processing

				register_taxonomy(
					'payment_method',
					array( 'post' ),
					$args
				);

		} // /payment_methods_setup





} // /Invoices_Post_Types

add_action( 'after_setup_theme', 'Invoices_Post_Types::init' );
