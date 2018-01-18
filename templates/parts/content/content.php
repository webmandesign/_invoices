<?php
/**
 * Template part for displaying posts
 *
 * @link  https://codex.wordpress.org/Template_Hierarchy
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 */





// Helper variables

	global $invoice_helper, $totals;

	$invoice_helper = array();

	++$totals['invoice_count'];


?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="invoice-anchors" id="post-item-<?php echo absint( $totals['invoice_count'] ); ?>">

		<a href="<?php echo esc_url( get_permalink() ); ?>" class="permalink">
			#<?php the_ID(); ?>
		</a>

		<a href="#post-item-<?php echo absint( $totals['invoice_count'] - 1 ); ?>" class="invoice-navigation previous">
			&uarr;
		</a>

		<a href="#post-item-<?php echo absint( $totals['invoice_count'] + 1 ); ?>" class="invoice-navigation next">
			&darr;
		</a>

	</div>

	<?php do_action( 'invoice_content' ); ?>

</article>
