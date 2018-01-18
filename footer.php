<?php
/**
 * The template for displaying the footer
 *
 * @link  https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 */





// Helper variables

	global $totals;


?>

<footer class="site-footer">

	<div class="screen-summary" id="screen-summary">
		<h2 class="screen-summary-title"><?php esc_html_e( 'Screen summary:', '_invoices' ); ?></h2>
		<ul class="screen-summary-list">
			<?php

			foreach ( $totals as $currency => $atts ) :

				if ( ! $source_count = count( $atts['source'] ) ) {
					continue;
				}

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
			<?php endforeach; ?>
		</ul>
	</div>

	<ul class="site-footer-menu">
		<?php wp_get_archives( 'type=yearly' ); ?>
	</ul>

	<div class="site-info">
		<?php esc_html_e( '&copy; WebMan Design', '_invoices' ); ?>
	</div>

</footer>

<?php wp_footer(); ?>

</body>

</html>
