<?php
/**
 * Secondary menu template
 *
 * Will display actual WordPress custom menu.
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.0.0
 */





// Requirements check

	if ( ! has_nav_menu( 'secondary' ) ) {
		return;
	}


?>

<nav id="secondary-navigation" class="secondary-navigation" aria-label="<?php esc_attr_e( 'Secondary Menu', '_invoices' ); ?>">

	<?php

	wp_nav_menu( array(
		'theme_location' => 'secondary',
		'container'      => 'false',
		'depth'          => 1,
		'fallback_cb'    => false,
	) );

	?>

</nav>
