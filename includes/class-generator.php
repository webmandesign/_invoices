<?php
/**
 * Import XML Generator Class
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.2.0
 * @version  1.2.1
 *
 * Contents:
 *
 *   0) Init
 *  10) Generator
 *  20) Getters
 *  30) Page
 * 100) Helpers
 */
class Invoices_Generator {





	/**
	 * 0) Init
	 */

		private static $instance;

		public static $url_load_parameter = 'generator';



		/**
		 * Constructor
		 *
		 * @since    1.2.0
		 * @version  1.2.0
		 */
		private function __construct() {

			// Processing

				// Hooks

					// Actions

						add_action( 'generator_content', __CLASS__ . '::page_content_import' );

					// Filters

						add_filter( 'template_include', __CLASS__ . '::page_load', 99 );

		} // /__construct



		/**
		 * Initialization (get instance)
		 *
		 * @since    1.2.0
		 * @version  1.2.0
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
	 * 10) Generator
	 */

		/**
		 * XML generator
		 *
		 * @since    1.2.0
		 * @version  1.2.1
		 *
		 * @param  string $output_type
		 * @param  string $input_data
		 * @param  array $args  Helper arguments.
		 */
		public static function generate( $output_type = 'xml', $input_data = '', $args = array() ) {

			// Requirements check

				if ( empty( $input_data ) ) {
					return;
				}


			// Helper variables

				$output = '';

				$input_data = trim( $input_data );

				$args = wp_parse_args( $args, array(
					'cache'         => array(),
					'delimiter'     => ';',
					'setup_columns' => '',
					'start_row'     => 2,
				) );

				$args['setup_columns'] = array_filter( explode( $args['delimiter'], (string) $args['setup_columns'] ) );
				foreach ( $args['setup_columns'] as $key => $pair ) {
					$args['setup_columns'][ $key ] = explode( ':', $pair );
					if ( ! isset( $pair[1] ) ) {
						unset( $args['setup_columns'][ $key ] );
					}
				}


			// Processing

				if (
					'xml' === $output_type
					&& ! empty( $args['setup_columns'] )
				) {

					$items = array();
					$data  = str_getcsv( (string) $input_data, "\n" );

					foreach( $data as $row_key => $row ) {
					// Each row
						if ( absint( $args['start_row'] ) > $row_key + 1 ) {
							unset( $data[ $row_key ] );
						} else {

							$columns = str_getcsv( (string) $row, $args['delimiter'] );
							$date    = date( 'Y-m-t', strtotime( $columns[0] ) );

							foreach ( $columns as $column_key => $column ) {
							// Each column
								if ( 0 == $column_key ) {
									continue;
								}

								$column = explode( '/', (string) $column );

								if ( empty( $column[0] ) ) {
								// Do not create invoice if the total is zero
									continue;
								}

								if ( ! isset( $args['cache']['taxonomy']['client'][ $args['setup_columns'][ $column_key - 1 ][0] ] ) ) {
									if ( is_numeric( $args['setup_columns'][ $column_key - 1 ][0] ) ) {
										$client = get_term( absint( $args['setup_columns'][ $column_key - 1 ][0] ) );
									} else {
										$client = get_term_by( 'slug', (string) $args['setup_columns'][ $column_key - 1 ][0], 'client' );
									}
									$args['cache']['taxonomy']['client'][ $args['setup_columns'][ $column_key - 1 ][0] ] = $client;
								} else {
									$client = $args['cache']['taxonomy']['client'][ $args['setup_columns'][ $column_key - 1 ][0] ];
								}

								if ( ! isset( $args['cache']['post_type']['product'][ $args['setup_columns'][ $column_key - 1 ][1] ] ) ) {
									if ( is_numeric( $args['setup_columns'][ $column_key - 1 ][1] ) ) {
										$product = get_post( absint( $args['setup_columns'][ $column_key - 1 ][1] ) );
									} else {
										$product = get_page_by_path( (string) $args['setup_columns'][ $column_key - 1 ][1] );
									}
									$args['cache']['post_type']['product'][ $args['setup_columns'][ $column_key - 1 ][1] ] = $product;
								} else {
									$product = $args['cache']['post_type']['product'][ $args['setup_columns'][ $column_key - 1 ][1] ];
								}

								$replacements = array(

									'{{$title}}' => date( 'ymt', strtotime( $date ) ) . '0' . $column_key,
									'{{$date}}'  => $date . ' 00:0' . $column_key . ':00',
									'{{$total}}' => (float) $column[0],
									'{{$sales}}' => ( isset( $column[1] ) ) ? ( absint( $column[1] ) . ' sales' ) : ( '' ),

									'{{$client_id}}'   => $client->term_id,
									'{{$client_slug}}' => $client->slug,
									'{{$product}}'     => $product->ID,

									'{{$seller_id}}'   => absint( get_theme_mod( 'default_seller' ) ),
									'{{$seller_slug}}' => get_term( absint( get_theme_mod( 'default_seller' ) ) )->slug,

									'{{$payment_method_id}}'   => absint( get_theme_mod( 'default_payment_method' ) ),
									'{{$payment_method_slug}}' => get_term( absint( get_theme_mod( 'default_payment_method' ) ) )->slug,

								);

								ob_start();
									get_template_part( 'templates/parts/generator/xml', 'item' );
								$items[] = strtr( ob_get_clean(), $replacements );
							}

						}
					}

					if ( ! empty( $items ) ) {
						ob_start();
							get_template_part( 'templates/parts/generator/xml', 'header' );
							echo implode( "\n\n", (array) $items );
							get_template_part( 'templates/parts/generator/xml', 'footer' );
						$output = ob_get_clean();
					}

				}


			// Output

				return $output;

		} // /generate





	/**
	 * 20) Getters
	 */

		/**
		 * XML generator
		 *
		 * @since    1.2.0
		 * @version  1.2.0
		 *
		 * @param  string $scope
		 */
		public static function get_output( $scope = 'import' ) {

			// Helper variables

				$output = '';

				$action = ( isset( $_POST['generate'] ) ) ? ( $_POST['generate'] ) : ( '' );


			// Processing

				if ( 'import' === $action ) {

					$output = false;
					$args   = array();

					if ( isset( $_POST['csv'] ) && $_POST['csv'] ) {

						if ( isset( $_POST['delimiter'] ) ) {
							$args['delimiter'] = trim( $_POST['delimiter'] );
						}
						if ( isset( $_POST['start_row'] ) ) {
							$args['start_row'] = absint( $_POST['start_row'] );
						}
						if ( isset( $_POST['setup_columns'] ) ) {
							$args['setup_columns'] = trim( $_POST['setup_columns'] );
						}

						$output = self::generate(
							'xml',
							(string) $_POST['csv'],
							$args
						);

					}

				}


			// Output

				return $output;

		} // /get_output





	/**
	 * 30) Page
	 */

		/**
		 * Loads generator page template whenever a specific URL parameter is set
		 *
		 * @since    1.2.0
		 * @version  1.2.0
		 *
		 * @param  string $template
		 */
		public static function page_load( $template ) {

			// Processing

				if (
					is_user_logged_in()
					&& isset( $_GET[ self::$url_load_parameter ] )
				) {
					return locate_template( 'templates/generator.php' ) ;
				}


			// Output

				return $template;

		} // /page_load



		/**
		 * Generator page content: Import XML
		 *
		 * @since    1.2.0
		 * @version  1.2.0
		 */
		public static function page_content_import() {

			// Output

				get_template_part( 'templates/parts/generator/generator', 'import' );

		} // /page_content_import





} // /Invoices_Generator

add_action( 'after_setup_theme', 'Invoices_Generator::init' );
