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

	$post_type   = get_post_type_object( 'post' );
	$labels      = get_post_type_labels( $post_type );
	$heading_tag = ( is_singular() ) ? ( 'h1' ) : ( 'h2' );


?>

<div class="invoice-title">
	<<?php echo tag_escape( $heading_tag ); ?>>
		<a href="<?php echo esc_url( get_permalink() ); ?>">

			<span class="invoice-title-label">
				<?php echo esc_html( $labels->singular_name ); ?>
			</span>

			<span class="invoice-title-number">
				<?php echo esc_html( Invoices_Post_Types::get_the_title_invoice() ); ?>
			</span>

		</a>
	</<?php echo tag_escape( $heading_tag ); ?>>
</div>
