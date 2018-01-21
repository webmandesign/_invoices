<?php
/**
 * Invoice meta: Total invoice amount
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 */





// Requirements check

	if ( ! function_exists( 'get_field' ) ) {
		return;
	}


// Helper variables

	global $invoice_helper, $totals;

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

<div class="invoice-meta-total-container invoice-meta-container">

	<div class="invoice-meta-total invoice-meta-stamp invoice-meta-item">

		<h2 class="invoice-meta-label">
			<?php esc_html_e( 'Administrator', '_invoices' ); ?>
		</h2>

		<div class="invoice-meta-value">
			<?php

			if (
				isset( $invoice_helper['company']['category'] )
				&& ! empty( $invoice_helper['company']['category'] )
			) {
				$image_stamp = get_field( 'image_stamp', $invoice_helper['company']['category'] );
				echo wp_get_attachment_image( absint( $image_stamp ), 'medium' );
			}

			?>
		</div>

	</div>

	<div class="invoice-meta-total invoice-meta-item">

		<h2 class="invoice-meta-label">
			<?php esc_html_e( 'Total payable amount', '_invoices' ); ?>
		</h2>

		<div class="invoice-meta-value">
			<span class="price">
				<?php echo esc_html( sprintf( '%.2f', $invoice_helper['total'][ $invoice_helper['currency_from'] ] ) ); ?>
			</span>
			<span class="currency-code">
				<?php echo esc_html( $invoice_helper['currency_from'] ); ?>
			</span>

			<?php if ( $invoice_helper['dual_currency'] ) : ?>
				<small class="dual-currency">
					<span class="price">
						<?php echo esc_html( sprintf( '%.2f', $total_exchanged ) ); ?>
					</span>
					<span class="currency-code">
						<?php echo esc_html( $invoice_helper['currency_to'] ); ?>
					</span>
				</small>
			<?php endif; ?>
		</div>

	</div>

</div>
