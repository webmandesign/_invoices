<?php
/**
 * The template for displaying all single posts
 *
 * @link  https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 */





get_header();

	while ( have_posts() ) : the_post();

		get_template_part( 'templates/parts/content/content', 'invoice' );

	endwhile;

get_footer();
