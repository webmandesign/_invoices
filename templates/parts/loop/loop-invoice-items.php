<?php
/**
 * Invoice: Items list
 *
 * CURRENCY EXCHANGE CALCULATION
 *
 * Exchange rate value is relevant to invoice (post) publish date.
 * An informational note will be displayed above invoice items list.
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
		! function_exists( 'get_field' )
		|| ! function_exists( 'have_rows' )
		|| ! function_exists( 'the_row' )
		|| ! function_exists( 'get_sub_field' )
	) {
		return;
	}


// Helper variables

	global $invoice_helper;

	$invoice_helper['currency_from']   = (string) get_field( 'exchange_from' );
	$invoice_helper['currency_to']     = (string) get_field( 'exchange_to' );
	$invoice_helper['dual_currency']   = (bool) ( $invoice_helper['currency_from'] !== $invoice_helper['currency_to'] );
	$invoice_helper['symbol_constant'] = (string) get_field( 'symbol_constant' );
	$invoice_helper['exchange_rate']   = (float) Invoices_Helper::get_exchange_rate( $invoice_helper );


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

<table class="invoice-items">

	<thead>
		<tr>
			<th class="invoice-items-column-order"><?php esc_html_e( '#', '_invoices' ); ?></th>
			<th class="invoice-items-column-description"><?php esc_html_e( 'Item name and description', '_invoices' ); ?></th>
			<th class="invoice-items-column-quantity"><?php esc_html_e( 'Qty', '_invoices' ); ?></th>
			<th class="invoice-items-column-price"><?php esc_html_e( 'Unit price', '_invoices' ); ?></th>
			<th class="invoice-items-column-total"><?php esc_html_e( 'Total', '_invoices' ); ?></th>
		</tr>
	</thead>

	<tbody>
		<?php

		if ( have_rows( 'items' ) ) :

			$i = 0;
			while ( have_rows( 'items' ) ) :
				the_row();

				?>

				<tr>

					<?php

					/**
					 * Item number
					 */

						?>
						<td class="invoice-items-column-order">
							<?php echo ++$i; ?>
						</td>

					<?php

					/**
					 * Item description
					 */

						?>
						<td class="invoice-items-column-description">

							<?php if ( $item_selected = get_sub_field( 'item' ) ) : ?>
								<h3 class="item-selected-title item-title">
									<?php echo esc_html( $item_selected->post_title ); ?>
								</h3>
								<div class="item-selected-content item-description">
									<?php echo apply_filters( 'the_content', $item_selected->post_content ); ?>
								</div>
							<?php endif; ?>

							<?php if ( $item_description = get_sub_field( 'description' ) ) : ?>
								<div class="item-description">
									<?php echo apply_filters( 'the_content', $item_description ); ?>
								</div>
							<?php endif; ?>

						</td>

					<?php

					/**
					 * Quantity
					 */

						?>
						<td class="invoice-items-column-quantity">
							<?php echo absint( get_sub_field( 'quantity' ) ); ?>
						</td>

					<?php

					/**
					 * Unit price
					 */

						$price = round( (float) get_sub_field( 'price' ), 2 );

						?>
						<td class="invoice-items-column-price">
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
						<td class="invoice-items-column-total">
							<?php

							$total_row = round( (float) get_sub_field( 'total' ), 2 );
							$invoice_helper['total'][ $invoice_helper['currency_from'] ] += (float) $total_row;

							?>
							<span class="price"><?php echo esc_html( sprintf( '%.2f', $total_row ) ); ?></span>
							<span class="currency-code"><?php echo esc_html( $invoice_helper['currency_from'] ); ?></span>
							<?php if ( $invoice_helper['dual_currency'] ) : ?>
							<small class="dual-currency">
								<?php

								$total_row = round( $total_row * $invoice_helper['exchange_rate'], 2 );
								$invoice_helper['total'][ $invoice_helper['currency_to'] ] += (float) $total_row;

								?>
								<span class="price"><?php echo esc_html( sprintf( '%.2f', $total_row ) ); ?></span>
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
