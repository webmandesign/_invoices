<?php
/**
 * Invoice meta: Payment info
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.5.0
 */





// Helper variables

	$taxonomy = 'payment_method';
	$terms    = wp_get_post_terms( get_the_ID(), $taxonomy );


// Requirements check

	if (
		is_wp_error( $terms )
		|| empty( $terms )
	) {
		return;
	}


?>

<div class="invoice-meta-payment-container invoice-meta-container">

	<div class="invoice-meta-payment invoice-meta-item">
		<h2 class="invoice-meta-label"><?php

		$labels = get_taxonomy_labels( get_taxonomy( $taxonomy ) );

		echo esc_html( $labels->singular_name );

		?></h2>
		<?php

		$i = 0;
		foreach ( $terms as $term ) :

			if ( ! isset( $term->description ) ) {
				continue;
			}

			?>

			<div class="invoice-meta-value">
				<?php if ( $i ) : ?><span class="invoice-meta-value-label"><?php esc_html_e( 'Or: ', '_invoices' ); ?></span><?php endif; ?>
				<a href="<?php echo esc_url( get_term_link( $term ) ); ?>">
					<?php echo apply_filters( 'the_excerpt', $term->description ); ?>
				</a>
			</div>

			<?php

			$i++;

		endforeach;

		?>
	</div>
</div>
