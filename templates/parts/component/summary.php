<?php
/**
 * Screen summary
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.5.1
 */





// Helper variables

	global $summary;

	$i = 0;


?>

<div class="screen-summary" id="screen-summary">

	<h2 class="screen-summary-title"><?php esc_html_e( 'Summary:', '_invoices' ); ?></h2>

	<table class="screen-summary-data">

		<thead>
			<tr>
			<?php

			foreach ( $summary as $currency => $atts ) :

				if (
					! isset( $atts['source'] )
					|| ! $source_count = count( (array) $atts['source'] ) ) {
					continue;
				}

				?>
				<th>
					<?php

					printf(
						esc_html_x( 'Invoces %s', '%s = currency international code.', '_invoices' ),
						esc_html( $currency )
					);

					?>
					(<?php echo absint( $source_count ); ?>/<?php echo absint( $summary['invoice_count'] ); ?>)
				</th>
				<?php

			endforeach;

			?>
			</tr>
		</thead>

		<tbody>
			<tr>
			<?php

			foreach ( $summary as $currency => $atts ) :

				if (
					! isset( $atts['source'] )
					|| ! count( $atts['source'] )
				) {
					continue;
				}

				arsort( $atts['source'] );

				?>
				<td>
					<?php foreach ( $atts['source'] as $post_id => $post_title ) : ?>
						<h2 data-id="<?php echo esc_attr( $post_id ); ?>">
							<?php echo Invoices_Post_Types::get_the_title_invoice( $post_title ); ?>
						</h2>
					<?php endforeach; ?>
				</td>
				<?php

			endforeach;

			?>
			</tr>
		</tbody>

	</table>

	<ul class="screen-summary-list">
		<?php

		foreach ( $summary as $currency => $atts ) :

			if (
				! isset( $atts['source'] )
				|| ! $source_count = count( $atts['source'] )
			) {
				continue;
			}

			++$i;

			?>
			<li class="screen-summary-item summary-currency-<?php echo sanitize_html_class( $currency ); ?>" title="<?php printf( esc_html__( 'Number of invoices calculated from: %d', '_invoices' ), absint( $source_count ) ); ?>">

				<span class="screen-summary-amount">
					<?php echo esc_html( sprintf( '%.2f', $atts['amount'] ) ); ?>
				</span>

				<span class="screen-summary-currency">
					<?php echo esc_html( $currency ); ?>
				</span>

				<span class="screen-summary-source-count">
					<?php echo absint( $source_count ); ?>/<?php echo absint( $summary['invoice_count'] ); ?>
				</span>

				<span class="screen-summary-expected-payment">
					<strong><?php esc_html_e( 'Expected payment:', '_invoices' ); ?></strong>
					<?php echo esc_html( $atts['expected_payment'] ); ?>
					<?php echo esc_html( $currency ); ?>
					<span class="income-net" title="<?php
						echo esc_html__( 'Approximate net income:', '_invoices' )
						   . ' '
						   . round( .66 * esc_attr( $atts['expected_payment'] ) )
						   . ' '
						   . esc_html( $currency );
						?>"><?php echo esc_html_x( '(Net)', 'Income, wage.', '_invoices' ); ?></span>
				</span>

			</li>
			<?php

		endforeach;

		?>
	</ul>

</div>

<?php if ( ! $i ) : ?>
<style> .screen-summary { display: none; }</style>
<?php endif; ?>
