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





?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'invoice_content' ); ?>

</article>
