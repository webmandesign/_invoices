<?php
/**
 * Invoice: Products list
 *
 * CURRENCY EXCHANGE CALCULATION
 *
 * Exchange rate value is relevant to invoice (post) publish date.
 * An informational note will be displayed above invoice products list.
 *
 * @see  Invoices_Helper::get_exchange_rate()
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 */





// Requirements check

	if (
		! function_exists( 'have_rows' )
		|| ! function_exists( 'the_row' )
		|| ! function_exists( 'get_sub_field' )
	) {
		return;
	}


// Helper variables

	global $invoice_helper;


?>

<?php if ( $invoice_helper['dual_currency'] ) : ?>
<div class="invoice-note invoice-note-exchange">
	<?php

	printf(
		/* translators: 1: currency to exchange from, 2: currency to exchange to, 3: exchange rate, 4: invoice publish date. */
		esc_html__( '%1$s to %2$s exchange rate of %3$f valid on %4$s (D/M/Y)', '_invoices' ),
		$invoice_helper['currency_from'],
		$invoice_helper['currency_to'],
		$invoice_helper['exchange_rate'],
		$invoice_helper['publish_date_display']
	);

	?>
</div>
<?php endif; ?>

<table class="invoice-products">

	<thead>
		<tr>
			<th class="invoice-products-column-order"><?php esc_html_e( '#', '_invoices' ); ?></th>
			<th class="invoice-products-column-description"><?php esc_html_e( 'Product/Service description', '_invoices' ); ?></th>
			<th class="invoice-products-column-quantity"><?php esc_html_e( 'Qty', '_invoices' ); ?></th>
			<th class="invoice-products-column-price"><?php esc_html_e( 'Unit price', '_invoices' ); ?></th>
			<th class="invoice-products-column-total"><?php esc_html_e( 'Total', '_invoices' ); ?></th>
		</tr>
	</thead>

	<tbody>
		<?php

		if ( have_rows( 'products' ) ) :
			$i = 0;

			while ( have_rows( 'products' ) ) :
				the_row();

				?>

				<tr>

					<?php

					/**
					 * Product number
					 */

						?>
						<td class="invoice-products-column-order">
							<?php echo ++$i; ?>
						</td>

					<?php

					/**
					 * Product description
					 */

						?>
						<td class="invoice-products-column-description">

							<?php if ( $product = get_sub_field( 'product' ) ) : ?>
								<h3 class="product-title">
									<?php echo esc_html( $product->post_title ); ?>
								</h3>
								<div class="product-content product-description">
									<?php echo apply_filters( 'the_content', $product->post_content ); ?>
								</div>
							<?php endif; ?>

							<?php if ( $description = get_sub_field( 'description' ) ) : ?>
								<div class="product-description">
									<?php echo apply_filters( 'the_content', $description ); ?>
								</div>
							<?php endif; ?>

						</td>

					<?php

					/**
					 * Quantity
					 */

						?>
						<td class="invoice-products-column-quantity">
							<?php echo absint( get_sub_field( 'quantity' ) ); ?>
						</td>

					<?php

					/**
					 * Unit price
					 */

						$price = round( (float) get_sub_field( 'price' ), 2 );

						?>
						<td class="invoice-products-column-price">
							<span class="price"><?php echo esc_html( sprintf( '%.2f', $price ) ); ?></span>
							<span class="currency-code"><?php echo esc_html( $invoice_helper['currency_from'] ); ?></span>

							<?php if ( $invoice_helper['dual_currency'] ) : ?>
								<small class="dual-currency">
									<span class="price"><?php echo esc_html( sprintf( '%.2f', round( $price * $invoice_helper['exchange_rate'], 2 ) ) ); ?></span>
									<span class="currency-code"><?php echo esc_html( $invoice_helper['currency_to'] ); ?></span>
								</small>
							<?php endif; ?>
						</td>

					<?php

					/**
					 * Row total
					 */

						?>
						<td class="invoice-products-column-total">
							<?php $total_row = round( (float) get_sub_field( 'total' ), 2 ); ?>
							<span class="price"><?php echo esc_html( sprintf( '%.2f', $total_row ) ); ?></span>
							<span class="currency-code"><?php echo esc_html( $invoice_helper['currency_from'] ); ?></span>

							<?php if ( $invoice_helper['dual_currency'] ) : ?>
								<small class="dual-currency">
									<?php $total_exchanged = round( $total_row * $invoice_helper['exchange_rate'], 2 ); ?>
									<span class="price"><?php echo esc_html( sprintf( '%.2f', $total_exchanged ) ); ?></span>
									<span class="currency-code"><?php echo esc_html( $invoice_helper['currency_to'] ); ?></span>
								</small>
							<?php endif; ?>
						</td>

				</tr>

				<?php

			endwhile;

		else :

			?>

			<tr>
				<td colspan="5">
					<code><?php esc_html_e( 'Sorry, something went wrong! Please check your data and/or code!', '_includes' ); ?></code>
				</td>
			</tr>

			<?php

		endif;

		?>
	</tbody>

</table>
