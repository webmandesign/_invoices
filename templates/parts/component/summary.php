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


?>

<div class="screen-summary" id="screen-summary">
	<h2 class="screen-summary-title"><?php esc_html_e( 'Screen summary:', '_invoices' ); ?></h2>
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
				<?php echo absint( $source_count ); ?>
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
