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

	$post_type = get_post_type_object( 'post' );
	$labels    = get_post_type_labels( $post_type );


?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> data-year="<?php echo esc_attr( get_the_date( 'Y' ) ); ?>">

	<div class="invoice-simple-date">
		<a href="<?php echo esc_url( get_year_link( get_the_date( 'Y' ) ) ); ?>" class="year"><?php echo esc_html( get_the_date( 'Y' ) ); ?></a>
		<span class="month"><?php echo esc_html( get_the_date( 'M' ) ); ?></span>
		<span class="day"><?php echo esc_html( get_the_date( 'j' ) ); ?></span>
	</div>

	<h2 class="invoice-simple-title">
		<a href="<?php echo esc_url( get_permalink() ); ?>">
			<?php

			echo str_replace(
				$labels->singular_name . ' ',
				'',
				esc_html( get_the_title() )
			);

			?>
		</a>
		<?php edit_post_link( esc_html__( 'Edit', '_invoices' ) ); ?>
	</h2>

	<div class="invoice-simple-company">
		<?php if ( isset( $invoice_helper['company']['category'] ) && isset( $invoice_helper['company']['category']->name ) ) : ?>
			<span class="invoice-simple-company-label">
				<?php echo esc_html_x( 'Supplier', 'Invoice company info label.', '_invoices' ); ?>
			</span>
			<a href="<?php echo esc_url( get_term_link( $invoice_helper['company']['category'] ) ); ?>">
				<?php echo esc_html( $invoice_helper['company']['category']->name ); ?>
			</a>
		<?php endif; ?>
		<br>
		<?php if ( isset( $invoice_helper['company']['client'] ) && isset( $invoice_helper['company']['client']->name ) ) : ?>
			<span class="invoice-simple-company-label">
				<?php echo esc_html_x( 'Client', 'Invoice company info label.', '_invoices' ); ?>
			</span>
			<a href="<?php echo esc_url( get_term_link( $invoice_helper['company']['client'] ) ); ?>">
				<?php echo esc_html( $invoice_helper['company']['client']->name ); ?>
			</a>
		<?php endif; ?>
	</div>

	<div class="invoice-simple-total">
		<?php

		$post_id    = get_the_ID();
		$post_title = get_the_title();

		if ( $invoice_helper['total'][ $invoice_helper['currency_from'] ] ) {
			$totals[ $invoice_helper['currency_from'] ]['amount'] += $invoice_helper['total'][ $invoice_helper['currency_from'] ];
			$totals[ $invoice_helper['currency_from'] ]['source'][ $post_id ] = $post_title;
		}

		if ( $invoice_helper['dual_currency'] ) {
			$total_exchanged = round( $invoice_helper['total'][ $invoice_helper['currency_from'] ] * $invoice_helper['exchange_rate'], 2 );
			$totals[ $invoice_helper['currency_to'] ]['amount'] += $total_exchanged;
			$totals[ $invoice_helper['currency_to'] ]['source'][ $post_id ] = $post_title;
		}

		?>
		<a href="<?php echo esc_url( get_permalink() ); ?>">
			<span class="price">
				<?php echo esc_html( sprintf( '%.2f', $invoice_helper['total'][ $invoice_helper['currency_from'] ] ) ); ?>
			</span>
			<span class="currency-code">
				<?php echo esc_html( $invoice_helper['currency_from'] ); ?>
			</span>

			<?php if ( $invoice_helper['dual_currency'] ) : ?>
				<small class="dual-currency" title="Exchange rate: <?php echo esc_attr( $invoice_helper['exchange_rate'] ); ?>">
					<span class="price">
						<?php echo esc_html( sprintf( '%.2f', $total_exchanged ) ); ?>
					</span>
					<span class="currency-code">
						<?php echo esc_html( $invoice_helper['currency_to'] ); ?>
					</span>
				</small>
			<?php endif; ?>
		</a>
	</div>

</article>
