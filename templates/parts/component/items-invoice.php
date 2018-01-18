<?php
/**
 * Invoice: Items list
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 */





// Helper variables

	global $invoice_helper;

	$invoice_helper['total'] = Invoices_Customize::get_currencies_array();
	foreach ( $invoice_helper['total'] as $key => $value ) {
		$invoice_helper['total'][ $key ] = 0;
	}

	$invoice_helper['symbol_constant'] = '';
	$invoice_helper['currency_from']   = '';
	$invoice_helper['currency_to']     = '';
	$invoice_helper['exchange_rate']   = '';
	$invoice_helper['dual_currency']   = false;


// Processing

	if ( function_exists( 'get_field' ) ) {
		$invoice_helper['symbol_constant'] = (string) get_field( 'symbol_constant' );
		$invoice_helper['currency_from']   = (string) get_field( 'exchange_from' );
		$invoice_helper['currency_to']     = (string) get_field( 'exchange_to' );
		$invoice_helper['exchange_rate']   = (string) get_field( 'exchange_rate' );
		$invoice_helper['dual_currency']   = (bool) ( $invoice_helper['currency_from'] !== $invoice_helper['currency_to'] ) && $invoice_helper['exchange_rate'];
	}


?>

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

		if (
			function_exists( 'have_rows' )
			&& have_rows( 'items' )
		) :

			$i = 0;
			while ( have_rows( 'items' ) ) :
				the_row();

				$price    = round( (float) get_sub_field( 'price' ), 2 );
				$quantity = absint( get_sub_field( 'quantity' ) );

				?>

				<tr>

					<td class="invoice-items-column-order">
						<?php echo ++$i; ?>
					</td>

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

					<td class="invoice-items-column-quantity">
						<?php echo esc_html( $quantity ); ?>
					</td>

					<td class="invoice-items-column-price">
						<span class="price"><?php echo esc_html( sprintf( '%.2f', $price ) ); ?></span>
						<span class="currency"><?php echo esc_html( $invoice_helper['currency_from'] ); ?></span>
						<?php if ( $invoice_helper['dual_currency'] ) : ?>
						<small class="dual-currency">
							<span class="price"><?php echo esc_html( sprintf( '%.2f', round( $price * $invoice_helper['exchange_rate'], 2 ) ) ); ?></span>
							<span class="currency"><?php echo esc_html( $invoice_helper['currency_to'] ); ?></span>
						</small>
						<?php endif; ?>
					</td>

					<td class="invoice-items-column-total">
						<?php

						$total_row = $quantity * $price;
						$invoice_helper['total'][ $invoice_helper['currency_from'] ] += (float) $total_row;

						?>
						<span class="price"><?php echo esc_html( sprintf( '%.2f', $total_row ) ); ?></span>
						<span class="currency"><?php echo esc_html( $invoice_helper['currency_from'] ); ?></span>
						<?php if ( $invoice_helper['dual_currency'] ) : ?>
						<small class="dual-currency">
							<?php

							$total_row = round( $total_row * $invoice_helper['exchange_rate'], 2 );
							$invoice_helper['total'][ $invoice_helper['currency_to'] ] += (float) $total_row;

							?>
							<span class="price"><?php echo esc_html( sprintf( '%.2f', $total_row ) ); ?></span>
							<span class="currency"><?php echo esc_html( $invoice_helper['currency_to'] ); ?></span>
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
					<code><?php esc_html_e( 'Sorry, something went wrong! Please check your code!', '_includes' ); ?></code>
				</td>
			</tr>

			<?php

		endif;

		?>
	</tbody>

</table>
