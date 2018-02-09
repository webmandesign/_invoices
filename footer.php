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
 * @version  1.2.0
 */





?>

	<footer class="site-footer">

		<?php get_template_part( 'templates/parts/component/summary', 'screen' ); ?>

		<?php get_template_part( 'templates/parts/menu/menu', 'primary' ); ?>

		<div class="site-info">
			<?php esc_html_e( '&copy; WebMan Design', '_invoices' ); ?>
			| <a href="?<?php echo esc_attr( Invoices_Generator::$url_load_parameter ); ?>"><?php esc_html_e( 'Generator &rarr;', '_invoices' ); ?></a>
		</div>

	</footer>

</div><!-- /.site -->

<?php wp_footer(); ?>

</body>

</html>
