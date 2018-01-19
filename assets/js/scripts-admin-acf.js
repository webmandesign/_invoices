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
 * 10) Read-only fields
 * 20) Repeater row expanded
 * 30) Realtime total counting
 */





( function( $ ) {





	/**
	 * 10) Read-only fields
	 */

		$( '.acf-field-key-invoice-items-total input[type="number"], #acf-key_invoice_total' )
			.attr( 'readonly', 'true' );





	/**
	 * 20) Repeater row expanded
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
					}, 10 );

				}

			} )
			.find( '.acf-row' )
				.removeClass( '-collapsed' )
				.find( 'td' )
					.removeAttr( 'colspan' );





	/**
	 * 30) Realtime total counting
	 */

		$( document )
			.on( 'change keyup', '.acf-field-key-invoice-items-price input[type="number"], .acf-field-key-invoice-items-quantity input[type="number"]', function() {

				var
					$this     = $( this ),
					$row      = $this.closest( '.acf-row' ),
					$price    = $row.find( '.acf-field[data-name="price"] input[type="number"]' ).val(),
					$quantity = $row.find( '.acf-field[data-name="quantity"] input[type="number"]' ).val();

				$row
					.find( '.acf-field[data-name="total"] input[type="number"]' )
						.val( ( $price * $quantity ).toFixed( 2 ) );

				$( '.acf-field-key-invoice-total' )
					.slideUp();

			} );





} )( jQuery );
