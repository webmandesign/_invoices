/**
 * ACF admin scripts
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 *
 * Contents:
 *
 * 10) ACF metaboxes
 */





( function( $ ) {





	/**
	 * 10) ACF metaboxes
	 */

		/**
		 * Make all repeater subfields expanded all the time
		 */

			$( '.acf-repeater' )
				.on( 'click a[data-event="collapse-row"]', function() {

					if (
						'undefined' !== typeof( acf )
						&& 'undefined' !== typeof( acf.add_action )
					) {

						acf.add_action( 'hide', function( $tr, $scope ) {
							if ( 'collapse' === $scope ) {

								$( $tr )
									.removeClass( '-collapsed' )
									.find( 'td' )
										.removeAttr( 'colspan' );

							}
						}, 99 );

					}

				} )
				.find( '.acf-row' )
					.removeClass( '-collapsed' )
					.find( 'td' )
						.removeAttr( 'colspan' );





} )( jQuery );
