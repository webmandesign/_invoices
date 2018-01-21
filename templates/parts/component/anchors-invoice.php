<?php
/**
 * Anchors: Invoice
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 */





// Helper variables

	global $totals;


?>

<div class="invoice-anchors" id="post-item-<?php echo absint( $totals['invoice_count'] ); ?>">

	<a href="<?php echo esc_url( get_permalink() ); ?>" class="permalink">
		#<?php the_ID(); ?>
	</a>

	<?php edit_post_link( esc_html__( 'Edit', '_invoices' ) ); ?>

	<a href="javascript:window.print()" class="print">
		<?php esc_html_e( 'Print', '_invoices' ); ?>
	</a>

	<a href="#post-item-<?php echo absint( $totals['invoice_count'] - 1 ); ?>" class="invoice-navigation previous">
		&uarr;
	</a>

	<a href="#post-item-<?php echo absint( $totals['invoice_count'] + 1 ); ?>" class="invoice-navigation next">
		&darr;
	</a>

</div>
