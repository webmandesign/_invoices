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

	$publish_date = get_the_date();
	$due_period   = absint( get_theme_mod( 'invoice_due_period', 21 ) );
	$due_date     = strtotime( '+' . $due_period . ' days', strtotime( get_the_date( 'd-m-Y' ) ) );
	$due_date     = date( get_option( 'date_format' ), $due_date );

	$publish_date = str_replace( '/', '<span class="sep">/</span>', $publish_date );
	$due_date     = str_replace( '/', '<span class="sep">/</span>', $due_date );

?>

<div class="invoice-meta-date-container invoice-meta-container">

	<div class="invoice-meta-date invoice-meta-item">
		<h2 class="invoice-meta-label"><?php esc_html_e( 'Date of issue (d/m/y)', '_invoices' ); ?></h2>
		<p class="invoice-meta-value"><?php echo $publish_date; ?></p>
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
