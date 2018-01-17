<?php
/**
 * Invoice meta: Seller info, Client/customer info
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 */





// Helper variables

	global $invoice_helper;

	$taxonomies = array(
		'category',
		'client',
	);


?>

<div class="invoice-meta-company-container invoice-meta-container">
<?php

foreach ( $taxonomies as $taxonomy ) :

	$terms = wp_get_post_terms( get_the_ID(), $taxonomy );

	if (
		is_wp_error( $terms )
		|| empty( $terms )
		|| ! isset( $terms[0]->description )
	) {
		continue;
	}

	$invoice_helper['company'][ $taxonomy ] = $terms[0];

	?>
	<div class="invoice-meta-company invoice-meta-item">
		<h2 class="invoice-meta-label">
			<span class="invoice-meta-label-taxonomy"><?php

			$labels = get_taxonomy_labels( get_taxonomy( $taxonomy ) );
			echo esc_html( $labels->singular_name );

			?></span>
			<?php if ( 'client' === $taxonomy ) : ?>
			<span class="invoice-meta-label-shipping"><?php esc_html_e( 'Shipping address', '_invoices' ); ?></span>
			<?php endif; ?>
		</h2>
		<div class="invoice-meta-value">
			<h3><?php echo esc_html( $terms[0]->name ); ?></h3>
			<?php echo apply_filters( 'the_excerpt', $terms[0]->description ); ?>
		</div>
	</div>
	<?php

	endforeach;

?>
</div>
