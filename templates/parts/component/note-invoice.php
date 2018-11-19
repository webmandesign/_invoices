<?php
/**
 * Invoice: Note
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.6.0
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
	<a href="<?php echo esc_url( Invoices_Helper::get_fixer_api_url(
		$invoice_helper['publish_date_raw'],
		$invoice_helper['currency_from'],
		$invoice_helper['currency_to']
	) ); ?>">
		<?php

		printf(
			/* translators: 1: currency to exchange from, 2: currency to exchange to, 3: exchange rate, 4: invoice publish date, 5: date format. */
			esc_html__( '%1$s to %2$s exchange rate of %3$f valid on %4$s (%5$s)', '_invoices' ),
			$invoice_helper['currency_from'],
			$invoice_helper['currency_to'],
			$invoice_helper['exchange_rate'],
			$invoice_helper['publish_date_display'],
			Invoices_Helper::get_readable_date_format()
		);

		?>
	</a>
</div>

<?php

endif;
