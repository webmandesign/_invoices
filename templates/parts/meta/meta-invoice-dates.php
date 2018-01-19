<?php
/**
 * Invoice meta: Issue date, Delivery date, Due date
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 */





// Helper variables

	global $invoice_helper;

	$due_period   = absint( get_theme_mod( 'invoice_due_period', 21 ) );
	$due_date     = strtotime( '+' . $due_period . ' days', strtotime( $invoice_helper['publish_date_raw'] ) );
	$due_date     = date( get_option( 'date_format' ), $due_date );

	$publish_date = str_replace( '/', '<span class="sep">/</span>', esc_html( $invoice_helper['publish_date_display'] ) );
	$due_date     = str_replace( '/', '<span class="sep">/</span>', esc_html( $due_date ) );

?>

<div class="invoice-meta-date-container invoice-meta-container">

	<div class="invoice-meta-date invoice-meta-item">
		<h2 class="invoice-meta-label"><?php esc_html_e( 'Date of issue (d/m/y)', '_invoices' ); ?></h2>
		<p class="invoice-meta-value">
			<a href="<?php echo esc_url( get_day_link(
				date( 'Y', strtotime( $invoice_helper['publish_date_raw'] ) ),
				date( 'm', strtotime( $invoice_helper['publish_date_raw'] ) ),
				date( 'd', strtotime( $invoice_helper['publish_date_raw'] ) )
			) ); ?>">
				<?php echo $publish_date; ?>
			</a>
		</p>
	</div>

	<div class="invoice-meta-date invoice-meta-item">
		<h2 class="invoice-meta-label"><?php esc_html_e( 'Date of delivery (d/m/y)', '_invoices' ); ?></h2>
		<p class="invoice-meta-value"><?php echo $publish_date; ?></p>
	</div>

	<div class="invoice-meta-date invoice-meta-item">
		<h2 class="invoice-meta-label"><?php esc_html_e( 'Due date (d/m/y)', '_invoices' ); ?></h2>
		<p class="invoice-meta-value"><?php echo $due_date; ?></p>
	</div>

</div>
