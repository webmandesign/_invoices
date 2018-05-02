<?php
/**
 * Template Name: Generator
 *
 * Generates various features, such as import XML.
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.2.0
 * @version  1.4.0
 */

/* translators: Custom page template name. */
__( 'Generator', '_invoices' );





get_header();

?>

<section class="generator">

	<h1><?php esc_html_e( 'Generator', '_invoices' ); ?></h1>

	<?php do_action( 'generator_content' ); ?>

	<a href="" class="reload"><?php esc_html_e( 'Reload this page &#8629;', '_invoices' ); ?></a>

</section>

<?php

get_footer();
