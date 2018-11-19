<?php
/**
 * Anchors: Invoice
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.6.0
 */





// Helper variables

	global $summary, $invoice_helper;


?>

<div class="invoice-anchors" id="post-number-<?php echo absint( $summary['invoice_count'] ); ?>">

	<a href="<?php echo esc_url( get_permalink() ); ?>" class="permalink">
		#<?php the_ID(); ?>
	</a>

	<?php edit_post_link( esc_html__( 'Edit', '_invoices' ) ); ?>

	<a href="javascript:printAllCurrencies()" class="print" title="<?php esc_attr_e( 'Click the link in the menu to print main currency only.', '_invoices' ); ?>">
		<?php esc_html_e( 'Print', '_invoices' ); ?>
	</a>

	<span class="datelink">
		<a href="<?php echo esc_url( get_month_link(
			date( 'Y', strtotime( $invoice_helper['publish_date_raw'] ) ),
			date( 'm', strtotime( $invoice_helper['publish_date_raw'] ) )
		) ); ?>">
			<?php echo date( 'M', strtotime( $invoice_helper['publish_date_raw'] ) ); ?>
		</a>
		<span class="sep">/</span>
		<a href="<?php echo esc_url( get_year_link(
			date( 'Y', strtotime( $invoice_helper['publish_date_raw'] ) )
		) ); ?>">
			<?php echo date( 'Y', strtotime( $invoice_helper['publish_date_raw'] ) ); ?>
		</a>
	</span>

	<a href="#post-number-<?php echo absint( $summary['invoice_count'] - 1 ); ?>" class="invoice-navigation previous">
		&uarr;
	</a>

	<a href="#post-number-<?php echo absint( $summary['invoice_count'] + 1 ); ?>" class="invoice-navigation next">
		&darr;
	</a>

	<a href="#top" class="top">
		&#9650;
	</a>

	<a href="#screen-summary" class="summary">
		&#9660;
	</a>

</div>
