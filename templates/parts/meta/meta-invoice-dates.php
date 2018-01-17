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
	$due_days     = 21;


?>

<div class="invoice-meta-date-container invoice-meta-container">

	<div class="invoice-meta-date invoice-meta-item">
		<h2 class="invoice-meta-label"><?php esc_html_e( 'Date of issue', '_invoices' ); ?></h2>
		<p class="invoice-meta-value"><?php echo $publish_date; ?></p>
	</div>

	<div class="invoice-meta-date invoice-meta-item">
		<h2 class="invoice-meta-label"><?php esc_html_e( 'Date of delivery', '_invoices' ); ?></h2>
		<p class="invoice-meta-value"><?php echo $publish_date; ?></p>
	</div>

	<div class="invoice-meta-date invoice-meta-item">
		<h2 class="invoice-meta-label"><?php esc_html_e( 'Due date', '_invoices' ); ?></h2>
		<p class="invoice-meta-value"><?php echo date( get_option( 'date_format' ), strtotime( '+' . $due_days . ' days', strtotime( get_the_date( 'd-m-Y' ) ) ) ); ?></p>
	</div>

</div>
