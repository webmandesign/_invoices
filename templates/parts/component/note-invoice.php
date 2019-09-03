<?php
/**
 * Invoice: Note
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  2.1.0
 */





// Helper variables

	global $invoice_helper;

	$content = get_post_meta( get_the_ID(), 'notes', true );


if ( ! empty( $content ) ) :

?>

<div class="invoice-note">
	<?php echo apply_filters( 'the_content', $content ); ?>
</div>

<?php

endif;

if ( $invoice_helper['dual_currency'] ) :

?>

<div class="invoice-note invoice-note-exchange">
	<?php

	edit_post_link(
		sprintf(
			/* translators: 1: currency to exchange from, 2: currency to exchange to, 3: exchange rate. */
			esc_html__( '%1$s to %2$s exchange rate of %3$f', '_invoices' ),
			$invoice_helper['currency_from'],
			$invoice_helper['currency_to'],
			$invoice_helper['exchange_rate']
		),
		'', '', null, 'exchange-rate-link'
	);

	?>
</div>

<?php

endif;
