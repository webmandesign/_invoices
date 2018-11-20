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
 * @version  1.7.0
 */





?>

	</div><!-- /.site-content -->

	<footer class="site-footer">

		<?php get_template_part( 'templates/parts/component/summary', 'screen' ); ?>

		<?php get_template_part( 'templates/parts/menu/menu', 'primary' ); ?>

		<div class="site-info">
			<?php esc_html_e( '&copy; WebMan Design', '_invoices' ); ?>
			| <a href="?<?php echo esc_attr( Invoices_Generator::$url_load_parameter ); ?>"><?php esc_html_e( 'Generator &rarr;', '_invoices' ); ?></a>
		</div>

	</footer>

</div><!-- /.site -->

<script>

	var $page = document.getElementById( 'page' );

	function printMainCurrencyOnly() {
		$page.classList.remove( 'print-all-currencies' );
		$page.classList.add( 'print-main-currency-only' );
		window.print();
	}

	function printAllCurrencies() {
		$page.classList.remove( 'print-main-currency-only' );
		$page.classList.add( 'print-all-currencies' );
		window.print();
	}

</script>

<?php wp_footer(); ?>

</body>

</html>
