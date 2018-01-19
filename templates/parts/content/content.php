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

	++$totals['invoice_count'];

	// Invoice helper variable reset

		$invoice_helper = array(

			'company' => array(
				'category' => null,
				'client'   => null,
			),

			'publish_date_raw'     => get_the_date( 'Y-m-d' ),
			'publish_date_display' => get_the_date(),

			'total' => Invoices_Customize::get_currencies_array(),

			'currency_from'   => '',
			'currency_to'     => '',
			'dual_currency'   => false,
			'exchange_rate'   => 0,

			'symbol_constant' => '',

		);

		foreach ( $invoice_helper['total'] as $key => $value ) {
			$invoice_helper['total'][ $key ] = 0;
		}


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
