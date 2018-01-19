<?php
/**
 * Main loop
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 */





?>

<div class="posts posts-list">

	<?php

	while ( have_posts() ) : the_post();

		get_template_part( 'templates/parts/content/content', 'simple' );

	endwhile;

	?>

</div>
