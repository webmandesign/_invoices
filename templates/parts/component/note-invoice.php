<?php
/**
 * Invoice: Note
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 */





// Helper variables

	$content = get_post_meta( get_the_ID(), 'notes', true );


// Requirements check

	if ( empty( $content ) ) {
		return;
	}


?>

<div class="invoice-note">
	<?php echo apply_filters( 'the_content', $content ); ?>
</div>
