<?php
/**
 * Invoice meta: Variable symbol, Constant symbol
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 */





// Helper variables

	global $invoice_helper;

	$post_type = get_post_type_object( 'post' );
	$labels    = get_post_type_labels( $post_type );


?>

<div class="invoice-meta-symbol-container invoice-meta-container">

	<div class="invoice-meta-symbol invoice-meta-item">
		<h2 class="invoice-meta-label"><?php esc_html_e( 'Variable symbol', '_invoices' ); ?></h2>
		<p class="invoice-meta-value"><?php

		echo esc_html( str_replace(
			$labels->singular_name . ' ',
			'',
			get_the_title()
		) );

		?></p>
	</div>
	<?php if ( $invoice_helper['symbol_constant'] ) : ?>

	<div class="invoice-meta-symbol invoice-meta-item">
		<h2 class="invoice-meta-label"><?php esc_html_e( 'Constant symbol', '_invoices' ); ?></h2>
		<p class="invoice-meta-value"><?php echo esc_html( $invoice_helper['symbol_constant'] ); ?></p>
	</div>
	<?php endif; ?>

</div>
