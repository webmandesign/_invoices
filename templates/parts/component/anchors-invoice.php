<?php
/**
 * Anchors: Invoice
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.5.0
 */





// Helper variables

	global $summary;


?>

<div class="invoice-anchors" id="post-number-<?php echo absint( $summary['invoice_count'] ); ?>">

	<a href="<?php echo esc_url( get_permalink() ); ?>" class="permalink">
		#<?php the_ID(); ?>
	</a>

	<?php edit_post_link( esc_html__( 'Edit', '_invoices' ) ); ?>

	<a href="javascript:printAllCurrencies()" class="print" title="<?php esc_attr_e( 'Click the link in the menu to print main currency only.', '_invoices' ); ?>">
		<?php esc_html_e( 'Print', '_invoices' ); ?>
	</a>

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
