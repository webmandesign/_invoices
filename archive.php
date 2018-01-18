<?php
/**
 * The template for displaying archive pages
 *
 * @link  https://codex.wordpress.org/Template_Hierarchy
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 */





get_header();

	if ( have_posts() ) :

		?>

		<header class="page-header">
			<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
		</header>

		<?php

		get_template_part( 'templates/parts/loop/loop', 'archive' );

	else :

		get_template_part( 'templates/parts/content/content', 'none' );

	endif;

get_footer();
