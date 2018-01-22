<?php
/**
 * Dashboard welcome panel
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 */





?>

<div class="welcome-panel-content">

	<h2>
		<?php esc_html_e( 'Welcome to Invoices theme!', '_invoices' ); ?>
	</h2>

	<p class="about-description">
		<?php esc_html_e( 'Manage your business invoices easily, like a pro!', '_invoices' ); ?>
		<?php esc_html_e( 'Here is some information to get you started:', '_invoices' ); ?>
	</p>

	<div class="welcome-panel-column-container">

		<div class="welcome-panel-column welcome-panel-links">
			<h3>
				<?php esc_html_e( 'Manage your content', '_invoices' ); ?>
			</h3>
			<ul>
				<li>
					<?php

					printf(
						'<a href="%s" class="welcome-icon dashicons-before dashicons-media-document">' . esc_html__( 'Add an Invoice', '_invoices' ) . '</a>',
						admin_url( 'post-new.php' )
					);

					?>
				</li>
				<li>
					<?php

					printf(
						'<a href="%s" class="welcome-icon dashicons-before dashicons-products">' . esc_html__( 'Add a Product (or Service)', '_invoices' ) . '</a>',
						admin_url( 'post-new.php?post_type=page' )
					);

					?>
				</li>
				<li>
					<?php

					printf(
						'<a href="%s" class="welcome-icon dashicons-before dashicons-store">' . esc_html__( 'Manage Sellers', '_invoices' ) . '</a>',
						admin_url( 'edit-tags.php?taxonomy=category' )
					);

					?>
				</li>
				<li>
					<?php

					printf(
						'<a href="%s" class="welcome-icon dashicons-before dashicons-groups">' . esc_html__( 'Manage Clients', '_invoices' ) . '</a>',
						admin_url( 'edit-tags.php?taxonomy=client' )
					);

					?>
				</li>
				<li>
					<?php

					printf(
						'<a href="%s" class="welcome-icon dashicons-before dashicons-money">' . esc_html__( 'Manage Payment Methods', '_invoices' ) . '</a>',
						admin_url( 'edit-tags.php?taxonomy=payment_method' )
					);

					?>
				</li>
				<li>
					<?php

					printf(
						'<a href="%s" class="welcome-icon welcome-view-site">' . esc_html__( 'View your site', '_invoices' ) . '</a>',
						home_url( '/' )
					);

					?>
				</li>
			</ul>
		</div>

		<div class="welcome-panel-column welcome-panel-customize">
			<?php if ( current_user_can( 'customize' ) ) : ?>
				<h3>
					<?php esc_html_e( 'Set up your theme', '_invoices' ); ?>
				</h3>
				<p>
					<?php esc_html_e( 'Do not forget to set up your Invoices theme to your needs.', '_invoices' ); ?>
					<?php esc_html_e( 'You can find currency exchange options, accounting options, invoices display options in theme customizer.', '_invoices' ); ?>
				</p>
				<a class="button button-primary button-hero load-customize hide-if-no-customize" href="<?php echo wp_customize_url(); ?>">
					<?php esc_html_e( 'Set Theme Options &rarr;', '_invoices' ); ?>
				</a>
			<?php endif; ?>
			<a class="button button-primary button-hero hide-if-customize" href="<?php echo admin_url( 'themes.php' ); ?>">
				<?php esc_html_e( 'Set Theme Options &rarr;', '_invoices' ); ?>
			</a>
		</div>

		<?php // if ( ! function_exists( 'acf_add_local_field_group' ) || ! function_exists( 'get_sub_field' ) ) : ?>
		<div class="welcome-panel-column welcome-panel-requirements">
			<h3>
				<?php esc_html_e( 'Requirements', '_invoices' ); ?>
			</h3>
			<p>
				<?php esc_html_e( 'The theme is compatible with Advanced Custom Fields plugin.', '_invoices' ); ?>
				<?php esc_html_e( 'However, as the theme uses the repeater field of the ACF plugin, you need to install a paid, PRO version of the plugin.', '_invoices' ); ?>
			</p>
			<a href="https://www.advancedcustomfields.com/pro/" class="button button-hero">
				<?php esc_html_e( 'Get ACF PRO now &rarr;', '_invoices' ); ?>
			</a>
		</div>
		<?php // endif; ?>

	</div>

	<div class="welcome-panel-column-container">

		<div class="welcome-panel-column">
			<h3>
				<?php esc_html_e( 'Adding an invoice', '_invoices' ); ?>
			</h3>
			<p>
				<?php esc_html_e( 'To create an invoice you need to add a seller(s), clients and payment methods first, so you can simply select them later when adding a new invoice.', '_invoices' ); ?>
				<?php esc_html_e( 'You can find those under "Invoices" admin menu.', '_invoices' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'When adding a new invoice and invoice items (products/services), the totals amount will be calculated only after saving/publishing/updating the invoice!', '_invoices' ); ?>
			</p>
			<p>
				<strong><?php esc_html_e( 'Do not forget to set a proper invoice publish date!', '_invoices' ); ?></strong>
				<?php esc_html_e( 'Invoice publish date is being used as invoice issue date and invoice due date is going to be calculated from it.', '_invoices' ); ?>
			</p>
		</div>

		<div class="welcome-panel-column">
			<h3>
				<?php esc_html_e( 'Currency exchange', '_invoices' ); ?>
			</h3>
			<p>
				<?php esc_html_e( 'Invoices can be also displayed with dual currency, with properly calculated, exchanged totals.', '_invoices' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'To use dual currency display, just select a different exchange currencies when editing the invoice.', '_invoices' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'The theme will automatically exchange the total amounts depending on current exchange rate relevant to invoice publish date, taken from open-source fixer.io API.', '_invoices' ); ?>
			</p>
		</div>

		<div class="welcome-panel-column">
			<h3>
				<?php esc_html_e( 'Invoice display and printing', '_invoices' ); ?>
			</h3>
			<p>
				<?php esc_html_e( 'Homepage displays current year invoices in a simplified list.', '_invoices' ); ?>
				<?php esc_html_e( 'If you are previewing the homepage before or during a taxation month (can be set in customizer), also the previous year invoices are displayed in the list.', '_invoices' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'Yearly archives display full invoice previews, so you can easily print them out, all at once.', '_invoices' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'Both invoice lists and single invoices can be printed out.', '_invoices' ); ?>
				<?php esc_html_e( 'If you are printing invoice lists, the last page will contain a list summary, which totals all invoices in the list and separates amounts by currency.', '_invoices' ); ?>
				<?php esc_html_e( 'Summary is not printed with single invoices.', '_invoices' ); ?>
			</p>
		</div>

		<div class="welcome-panel-column">
			<h3>
				<?php esc_html_e( 'Technical info', '_invoices' ); ?>
			</h3>
			<ul>
				<li><?php esc_html_e( '"Invoice" post type is simply renamed WordPress "Post" post type.', '_invoices' ); ?></li>
				<li><?php esc_html_e( '"Product" post type is simply renamed WordPress "Page" post type.', '_invoices' ); ?></li>
				<li><?php esc_html_e( '"Seller" taxonomy is simply renamed WordPress "Category" taxonomy.', '_invoices' ); ?></li>
				<li><?php esc_html_e( '"Client", "Payment Method" and "Product Type" is a custom taxonomy created by the theme.', '_invoices' ); ?></li>
			</u2>
		</div>

	</div>

</div>

<style>
<?php get_template_part( 'templates/parts/admin/dashboard-welcome-panel', 'styles' ); ?>
</style>
