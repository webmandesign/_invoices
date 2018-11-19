<?php
/**
 * Invoice meta: Issue date, Delivery date, Due date
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.6.0
 */





// Helper variables

	global $invoice_helper;

	$date_format         = get_option( 'date_format' );
	$date_format_display = Invoices_Helper::get_readable_date_format( $date_format );

	$due_period = absint( $invoice_helper['due_period'] );
	$due_date   = strtotime( '+' . $due_period . ' days', strtotime( $invoice_helper['publish_date_raw'] ) );
	$due_date   = date( $date_format, $due_date );

?>

<div class="invoice-meta-date-container invoice-meta-container">

	<div class="invoice-meta-date invoice-meta-item">
		<h2 class="invoice-meta-label"><?php printf( esc_html_x( 'Date of issue (%s)', '%s: date format', '_invoices' ), $date_format_display ); ?></h2>
		<p class="invoice-meta-value">
			<a href="<?php echo esc_url( get_day_link(
				date( 'Y', strtotime( $invoice_helper['publish_date_raw'] ) ),
				date( 'm', strtotime( $invoice_helper['publish_date_raw'] ) ),
				date( 'd', strtotime( $invoice_helper['publish_date_raw'] ) )
			) ); ?>">
				<?php echo Invoices_Helper::get_output_date( esc_html( $invoice_helper['publish_date_display'] ) ); ?>
			</a>
		</p>
	</div>

	<div class="invoice-meta-date invoice-meta-item">
		<h2 class="invoice-meta-label"><?php printf( esc_html_x( 'Date of delivery (%s)', '%s: date format', '_invoices' ), $date_format_display ); ?></h2>
		<p class="invoice-meta-value"><?php echo Invoices_Helper::get_output_date( esc_html( $invoice_helper['publish_date_display'] ) ); ?></p>
	</div>

	<div class="invoice-meta-date invoice-meta-item" title="<?php printf( esc_html( 'Due period: %d days', '_invoices' ), $due_period ); ?>">
		<h2 class="invoice-meta-label"><?php printf( esc_html_x( 'Due date (%s)', '%s: date format', '_invoices' ), $date_format_display ); ?></h2>
		<p class="invoice-meta-value"><?php echo Invoices_Helper::get_output_date( esc_html( $due_date ) ); ?></p>
	</div>

</div>
