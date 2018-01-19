<?php
/**
 * Loop Class
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 *
 * Contents:
 *
 *   0) Init
 *  10) Archives
 * 100) Others
 */
class Invoices_Loop {





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

						add_action( 'pre_get_posts', __CLASS__ . '::pre_get_posts' );

					// Filters

						add_filter( 'get_the_archive_title', __CLASS__ . '::archive_title' );

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
	 * 10) Archives
	 */

		/**
		 * Archive title prefix
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $title
		 */
		public static function archive_title( $title = '' ) {

			// Processing

				if ( is_category() ) {
					$labels = get_taxonomy_labels( get_taxonomy( 'category' ) );
					$title  = sprintf( $labels->singular_name . ': %s', single_cat_title( '', false ) );
				}

				$title    = explode( ':', $title );
				$title[0] = '<span class="archive-title-label">' . $title[0] . ':</span> ' . $title[1];
				unset( $title[1] );
				$title    = implode( '', $title );


			// Output

				return $title;

		} // /archive_title





	/**
	 * 100) Others
	 */

		/**
		 * Loop modifications
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  obj $query
		 */
		public static function pre_get_posts( $query ) {

			// Helper variables

				$count_invoices_per_month = absint( get_theme_mod( 'count_invoices_per_month', 5 ) );

				$month_tax_pay = absint( get_theme_mod( 'month_tax_pay', 3 ) );


			// Processing

				$query->set( 'ignore_sticky_posts', 1 );
				$query->set( 'posts_per_page', $count_invoices_per_month * 12 );

				if ( $query->is_home() ) {
					if ( $month_tax_pay >= date( 'm' ) ) {
						$query->set( 'posts_per_page', $count_invoices_per_month * ( 12 + $month_tax_pay ) );
						$query->set( 'date_query', array(
							'after' => array(
								'year' => date( 'Y' ) - 2,
							),
						) );
					} else {
						$query->set( 'year', date( 'Y' ) );
					}
				}

		} // /pre_get_posts





} // /Invoices_Loop

add_action( 'after_setup_theme', 'Invoices_Loop::init' );
