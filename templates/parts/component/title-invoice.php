<?php
/**
 * Invoice: Title
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 */





// Helper variables

	$post_type = get_post_type_object( 'post' );
	$labels    = get_post_type_labels( $post_type );


?>

<div class="invoice-title">
	<h1>
		<span class="invoice-title-label"><?php echo esc_html( $labels->singular_name ); ?></span>
		<span class="invoice-title-number"><?php

		echo esc_html( str_replace(
			$labels->singular_name . ' ',
			'',
			get_the_title()
		) );

		?></span>
	</h1>
</div>
