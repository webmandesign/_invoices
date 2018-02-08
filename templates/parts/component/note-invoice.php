<?php
/**
 * Invoice: Note
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.1.0
 */





// Helper variables

	global $invoice_helper;

	$content = get_post_meta( get_the_ID(), 'notes', true );


// Requirements check

	if ( empty( $content ) ) {
		return;
	}


?>

<div class="invoice-note">
	<?php echo apply_filters( 'the_content', $content ); ?>
</div>

<?php if ( $invoice_helper['dual_currency'] ) : ?>
<div class="invoice-note invoice-note-exchange">
	<a href="<?php echo esc_url( add_query_arg( array(
		'base'    => $invoice_helper['currency_from'],
		'symbols' => $invoice_helper['currency_to'],
	), Invoices_Helper::$base_url_exchange_rates . $invoice_helper['publish_date_raw'] ) ); ?>">
		<?php

		printf(
			/* translators: 1: currency to exchange from, 2: currency to exchange to, 3: exchange rate, 4: invoice publish date. */
			esc_html__( '%1$s to %2$s exchange rate of %3$f valid on %4$s (D/M/Y)', '_invoices' ),
			$invoice_helper['currency_from'],
			$invoice_helper['currency_to'],
			$invoice_helper['exchange_rate'],
			$invoice_helper['publish_date_display']
		);

		?>
	</a>
</div>
<?php endif; ?>
