<?php
/**
 * Screen summary
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 */





// Helper variables

	global $totals;

	$i = 0;

	$post_type = get_post_type_object( 'post' );
	$labels    = get_post_type_labels( $post_type );


?>

<div class="screen-summary" id="screen-summary">

	<h2 class="screen-summary-title"><?php esc_html_e( 'Summary:', '_invoices' ); ?></h2>

	<table class="screen-summary-data">

		<thead>
			<tr>
			<?php

			foreach ( $totals as $currency => $atts ) :

				if ( ! $source_count = count( $atts['source'] ) ) {
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
					(<?php echo absint( $source_count ); ?>/<?php echo absint( $totals['invoice_count'] ); ?>)
				</th>
			<?php endforeach; ?>
			</tr>
		</thead>

		<tbody>
			<tr>
			<?php

			foreach ( $totals as $currency => $atts ) :

				if ( ! count( $atts['source'] ) ) {
					continue;
				}

				arsort( $atts['source'] );

			?>
				<td>
					<?php foreach ( $atts['source'] as $post_id => $post_title ) : ?>
						<h2 data-id="<?php echo esc_attr( $post_id ); ?>">
							<?php

							echo str_replace(
								$labels->singular_name . ' ',
								'',
								esc_html( $post_title )
							);

							?>
						</h2>
					<?php endforeach; ?>
				</td>
			<?php endforeach; ?>
			</tr>
		</tbody>

	</table>

	<ul class="screen-summary-list">
		<?php

		foreach ( $totals as $currency => $atts ) :

			if ( ! $source_count = count( $atts['source'] ) ) {
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
				<?php echo absint( $source_count ); ?>/<?php echo absint( $totals['invoice_count'] ); ?>
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
