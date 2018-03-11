<?php
/**
 * Primary menu template
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.3.0
 */





?>

<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', '_invoices' ); ?>">
	<ul>
		<?php wp_get_archives( 'type=yearly' ); ?>
		<li><a class="helper" href="#screen-summary"><?php esc_html_e( 'Summary &#9660;', '_invoices' ); ?></a></li>
		<li><a class="helper" href="#top"><?php esc_html_e( 'Top &#9650;', '_invoices' ); ?></a></li>
		<li><a class="helper print" href="javascript:window.print()"><?php esc_html_e( 'Print', '_invoices' ); ?></a></li>
	</ul>
</nav>
