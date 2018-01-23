<?php
/**
 * Dashboard welcome panel
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 */





?>

<div class="welcome-panel-content">

	<h2><?php

	$theme = wp_get_theme( '_invoices' );

	printf(
		esc_html__( 'Welcome to %s theme!', '_invoices' ),
		'<strong>' . $theme->get( 'Name' ) . ' <small>' . $theme->get( 'Version' ) . '</small></strong>'
	);

	?></h2>

	<p class="about-description">
		<?php esc_html_e( 'Manage your business invoices easily, like a pro!', '_invoices' ); ?>
		<?php esc_html_e( 'Here is some information to get you started:', '_invoices' ); ?>
	</p>

	<?php

	get_template_part( 'templates/parts/admin/dashboard-welcome-panel-columns', 'boxes' );

	get_template_part( 'templates/parts/admin/dashboard-welcome-panel-columns', 'info' );

	?>


	<footer class="welcome-panel-footer">
		&copy; <?php echo date( 'Y' ); ?> WebMan Design, <a href="https://www.webmandesign.eu">webmandesign.eu</a>
	</footer>

</div>
