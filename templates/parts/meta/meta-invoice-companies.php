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


?>

<div class="invoice-meta-company-container invoice-meta-container">
<?php foreach ( $invoice_helper['company'] as $taxonomy => $term ) : ?>

	<div class="invoice-meta-company invoice-meta-item">
		<h2 class="invoice-meta-label">
			<?php if ( 'category' === $taxonomy ) : ?>
			<span class="invoice-meta-label-supplier">
				<?php echo esc_html_x( 'Supplier', 'Invoice company info label.', '_invoices' ); ?>
			</span>
			<?php else : ?>
			<span class="invoice-meta-label-customer">
				<?php echo esc_html_x( 'Client', 'Invoice company info label.', '_invoices' ); ?>
			</span>
			<?php endif; ?>
		</h2>
		<div class="invoice-meta-value">
			<h3>
				<a href="<?php echo esc_url( get_term_link( $term ) ); ?>">
					<?php echo esc_html( $term->name ); ?>
				</a>
			</h3>
			<?php echo apply_filters( 'the_excerpt', $term->description ); ?>
		</div>
	</div>

<?php endforeach; ?>
</div>
