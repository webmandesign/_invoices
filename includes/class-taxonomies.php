<?php
/**
 * Taxonomies Class
 *
 * Creates:
 * - "Seller" taxonomy from "Category" taxonomy,
 * - "Client" custom taxonomy,
 * - "Product Type" custom taxonomy,
 * - "Payment Method" custom taxonomy.
 *
 * Removes:
 * - post tags taxonomy.
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.1.0
 * @version  1.1.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Setup
 * 20) Sellers
 * 30) Clients
 * 40) Product Types
 * 50) Payment Methods
 */
class Invoices_Taxonomies {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    1.1.0
		 * @version  1.1.0
		 */
		private function __construct() {

			// Processing

				// Hooks

					// Actions

						add_action( 'init', __CLASS__ . '::unregister_taxonomies' );
						add_action( 'init', __CLASS__ . '::clients_setup' );
						add_action( 'init', __CLASS__ . '::product_types_setup' );
						add_action( 'init', __CLASS__ . '::payment_methods_setup' );

					// Filters

						add_filter( 'register_taxonomy_args', __CLASS__ . '::sellers_setup', 10, 2 );

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
	 * 10) Setup
	 */

		/**
		 * Unregister taxonomies
		 *
		 * @since    1.1.0
		 * @version  1.1.0
		 */
		public static function unregister_taxonomies() {

			// Processing

				unregister_taxonomy_for_object_type( 'post_tag', 'post' );

		} // /unregister_taxonomies






	/**
	 * 20) Sellers
	 */

		/**
		 * Rename "Categories" taxonomy to "Sellers"
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  array  $args      Array of arguments for registering a taxonomy.
     * @param  string $taxonomy  Taxonomy key.
		 */
		public static function sellers_setup( $args, $taxonomy ) {

			// Helper variables

				$labels = array(
					'name'                  => esc_html_x( 'Sellers', 'taxonomy general name', '_invoices' ),
					'singular_name'         => esc_html_x( 'Seller', 'taxonomy singular name', '_invoices' ),
					'search_items'          => esc_html__( 'Search Sellers', '_invoices' ),
					'all_items'             => esc_html__( 'All Sellers', '_invoices' ),
					'parent_item'           => esc_html__( 'Parent Seller', '_invoices' ),
					'parent_item_colon'     => esc_html__( 'Parent Seller:', '_invoices' ),
					'edit_item'             => esc_html__( 'Edit Seller', '_invoices' ),
					'view_item'             => esc_html__( 'View Seller', '_invoices' ),
					'update_item'           => esc_html__( 'Update Seller', '_invoices' ),
					'add_new_item'          => esc_html__( 'Add New Seller', '_invoices' ),
					'new_item_name'         => esc_html__( 'New Seller Name', '_invoices' ),
					'not_found'             => esc_html__( 'No Sellers found.', '_invoices' ),
					'no_terms'              => esc_html__( 'No Sellers', '_invoices' ),
					'items_list_navigation' => esc_html__( 'Sellers list navigation', '_invoices' ),
					'items_list'            => esc_html__( 'Sellers list', '_invoices' ),
				);


			// Processing

				// Labels

					if ( 'category' === $taxonomy ) {
						foreach ( $labels as $key => $value ) {
							$args['labels'][ $key ] = $value;
						}
					}

				// Description

					$args['description'] = esc_html__( 'Seller who is issuing the invoice.', '_invoices' );


			// Output

				return $args;

		} // /sellers_setup





	/**
	 * 30) Clients
	 */

		/**
		 * Register Clients taxonomy
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function clients_setup() {

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

				$args = array(
					'hierarchical'      => true,
					'labels'            => $labels,
					'show_admin_column' => true,
					'description'       => esc_html__( 'Client to whom the invoice is issued.', '_invoices' ),
				);


			// Processing

				register_taxonomy(
					'client',
					array( 'post' ),
					$args
				);

		} // /clients_setup





	/**
	 * 40) Product Types
	 */

		/**
		 * Register Product Types taxonomy
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function product_types_setup() {

			// Helper variables

				$labels = array(
					'name'                  => esc_html_x( 'Product Types', 'taxonomy general name', '_invoices' ),
					'singular_name'         => esc_html_x( 'Product Type', 'taxonomy singular name', '_invoices' ),
					'search_items'          => esc_html__( 'Search Product Types', '_invoices' ),
					'all_items'             => esc_html__( 'All Product Types', '_invoices' ),
					'parent_item'           => esc_html__( 'Parent Product Type', '_invoices' ),
					'parent_item_colon'     => esc_html__( 'Parent Product Type:', '_invoices' ),
					'edit_item'             => esc_html__( 'Edit Product Type', '_invoices' ),
					'view_item'             => esc_html__( 'View Product Type', '_invoices' ),
					'update_item'           => esc_html__( 'Update Product Type', '_invoices' ),
					'add_new_item'          => esc_html__( 'Add New Product Type', '_invoices' ),
					'new_item_name'         => esc_html__( 'New Product Type Name', '_invoices' ),
					'not_found'             => esc_html__( 'No Product Types found.', '_invoices' ),
					'no_terms'              => esc_html__( 'No Product Types', '_invoices' ),
					'items_list_navigation' => esc_html__( 'Product Types list navigation', '_invoices' ),
					'items_list'            => esc_html__( 'Product Types list', '_invoices' ),
				);

				$args = array(
					'hierarchical'      => true,
					'labels'            => $labels,
					'show_admin_column' => true,
					'description'       => esc_html__( 'Product types for better products organization.', '_invoices' ),
				);


			// Processing

				register_taxonomy(
					'product_type',
					array( 'page' ),
					$args
				);

		} // /product_types_setup





	/**
	 * 50) Payment Methods
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
					'show_admin_column' => true,
					'description'       => esc_html__( 'Payment methods information provided to pay the invoice.', '_invoices' ),
				);


			// Processing

				register_taxonomy(
					'payment_method',
					array( 'post' ),
					$args
				);

		} // /payment_methods_setup





} // /Invoices_Taxonomies

add_action( 'after_setup_theme', 'Invoices_Taxonomies::init' );
