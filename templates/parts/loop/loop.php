<?php
/**
 * Main loop
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.8.0
 */





// Variables

	$month = $last_month = '';


?>

<div class="posts posts-list invoice-simple-list">

	<?php

	while ( have_posts() ) : the_post();

		$month = get_the_date( 'F Y' );

		if ( $last_month !== $month ) {
			echo '<div class="separator-month">';
			echo '<a href="' . esc_url( get_month_link( date( 'Y', strtotime( $month ) ), date( 'm', strtotime( $month ) ) ) ) . '">';
			echo '<span>' . implode( '</span> <span>', explode( ' ', $month ) ) . '</span>';
			echo '</a>';
			echo '</div>';
			$last_month = $month;
		}

		get_template_part( 'templates/parts/content/content', 'simple' );

	endwhile;

	?>

</div>
