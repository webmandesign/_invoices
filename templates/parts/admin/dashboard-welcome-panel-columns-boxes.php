<?php
/**
 * Dashboard welcome panel columns: Boxes
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 */





?>

<div class="welcome-panel-column-container">



	<div class="welcome-panel-column welcome-panel-column-links">
		<h3>
			<?php esc_html_e( 'Manage your content', '_invoices' ); ?>
		</h3>
		<ul>
			<li><?php printf(
				'<a href="%s" class="welcome-icon dashicons-before dashicons-media-document">' . esc_html__( 'Add an Invoice', '_invoices' ) . '</a>',
				admin_url( 'post-new.php' )
			); ?></li>
			<li><?php printf(
				'<a href="%s" class="welcome-icon dashicons-before dashicons-products">' . esc_html__( 'Add a Product (or Service)', '_invoices' ) . '</a>',
				admin_url( 'post-new.php?post_type=page' )
			); ?></li>
			<li><?php printf(
				'<a href="%s" class="welcome-icon dashicons-before dashicons-store">' . esc_html__( 'Manage Sellers', '_invoices' ) . '</a>',
				admin_url( 'edit-tags.php?taxonomy=category' )
			); ?></li>
			<li><?php printf(
				'<a href="%s" class="welcome-icon dashicons-before dashicons-groups">' . esc_html__( 'Manage Clients', '_invoices' ) . '</a>',
				admin_url( 'edit-tags.php?taxonomy=client' )
			); ?></li>
			<li><?php printf(
				'<a href="%s" class="welcome-icon dashicons-before dashicons-money">' . esc_html__( 'Manage Payment Methods', '_invoices' ) . '</a>',
				admin_url( 'edit-tags.php?taxonomy=payment_method' )
			); ?></li>
			<li><?php printf(
				'<a href="%s" class="welcome-icon welcome-view-site">' . esc_html__( 'View your site', '_invoices' ) . '</a>',
				home_url( '/' )
			); ?></li>
		</ul>
	</div>



	<div class="welcome-panel-column welcome-panel-column-customize">
		<h3>
			<?php esc_html_e( 'Theme Options', '_invoices' ); ?>
		</h3>
		<p>
			<?php esc_html_e( 'Set currency exchange, accounting and invoices display options in theme customizer.', '_invoices' ); ?>
		</p>
		<?php if ( current_user_can( 'customize' ) ) : ?>
			<a class="button button-primary button-hero load-customize hide-if-no-customize" href="<?php echo wp_customize_url(); ?>">
				<?php esc_html_e( 'Set Theme Options &rarr;', '_invoices' ); ?>
			</a>
		<?php else : ?>
			<a class="button button-primary button-hero hide-if-customize" href="<?php echo admin_url( 'themes.php' ); ?>">
				<?php esc_html_e( 'Set Theme Options &rarr;', '_invoices' ); ?>
			</a>
		<?php endif; ?>
	</div>



	<?php if ( ! function_exists( 'acf_add_local_field_group' ) || ! function_exists( 'get_sub_field' ) ) : ?>
	<div class="welcome-panel-column welcome-panel-column-requirements">
		<h3>
			<?php esc_html_e( 'Requirements', '_invoices' ); ?>
		</h3>
		<p>
			<?php esc_html_e( 'As the theme uses the repeater field, Advanced Custom Field PRO plugin is required.', '_invoices' ); ?>
		</p>
		<a href="https://www.advancedcustomfields.com/pro/" class="button button-hero">
			<?php esc_html_e( 'Get ACF PRO now &rarr;', '_invoices' ); ?>
		</a>
	</div>
	<?php endif; ?>



</div>
