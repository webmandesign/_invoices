<?php
/**
 * Template part for displaying posts in simple way
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

	++$totals['invoice_count'];

	$invoice_helper = Invoices_Helper::reset_invoice_helper();


?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>



</article>
