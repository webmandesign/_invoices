/**
 * Customize preview scripts.
 *
 * WordPress customizer uses jQuery, so, go for it!
 *
 * @requires  jQuery
 *
 * @subpackage  Customize
 * @subpackage  Customize Options
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.9.1
 * @version  1.9.1
 */

( function( $ ) {

	'use strict';

	wp.customize( 'blogname', function( value ) {

		// Processing

			value
				.bind( function( to ) {

					$( '.site-title' )
						.text( to );

				} );

	} ); // /blogname

	wp.customize( 'blogdescription', function( value ) {

		// Processing

			value
				.bind( function( to ) {

					$( '.site-description' )
						.text( to );

				} );

	} ); // /blogdescription

	wp.customize( 'background_color', function( value ) {

		// Processing

			value
				.bind( function( to ) {

					$( 'body' )
						.css( {
							'background-color' : to,
						} );

				} );

	} ); // /background_color

	wp.customize( 'color_body_text', function( value ) {

		// Processing

			value
				.bind( function( to ) {

					$( 'body' )
						.css( {
							'color' : to,
						} );

				} );

	} ); // /color_body_text

	wp.customize( 'color_invoice_background', function( value ) {

		// Processing

			value
				.bind( function( to ) {

					$( '.invoice, .generator-section, .invoice-simple' )
						.css( {
							'background-color' : to,
						} );

				} );

	} ); // /color_invoice_background

	wp.customize( 'color_invoice_text', function( value ) {

		// Processing

			value
				.bind( function( to ) {

					$( '.invoice, .generator-section, .invoice-simple' )
						.css( {
							'color' : to,
						} );

				} );

	} ); // /color_invoice_text

} )( jQuery );
