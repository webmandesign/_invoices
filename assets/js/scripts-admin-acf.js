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
 * 10) Repeater row expanded
 * 20) Realtime total counting
 */





( function( $ ) {





	/**
	 * 10) Repeater row expanded
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





	/**
	 * 20) Realtime total counting
	 */

		$( '.acf-row .acf-field[data-name="total"] input[type="number"]' )
			.attr( 'readonly', 'true' );

		$( '.acf-row .acf-field[data-name="price"], .acf-row .acf-field[data-name="quantity"]' )
			.on( 'change keyup', 'input[type="number"]', function() {

				var
					$this     = $( this ),
					$row      = $this.closest( '.acf-row' ),
					$price    = $row.find( '.acf-field[data-name="price"] input[type="number"]' ).val(),
					$quantity = $row.find( '.acf-field[data-name="quantity"] input[type="number"]' ).val();

				$row
					.find( '.acf-field[data-name="total"] input[type="number"]' )
						.val( ( $price * $quantity ).toFixed( 2 ) );

			} );

		// @todo Make it work also when adding new rows.





} )( jQuery );
