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
		<?php

		printf(
			esc_html__( 'Welcome to %s theme!', '_invoices' ),
			'<strong>' . wp_get_theme( '_invoices' )->get( 'Name' ) . ' <small>' . wp_get_theme( '_invoices' )->get( 'Version' ) . '</small></strong>'
		);

		?>
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
					<?php esc_html_e( 'Set currency exchange, accounting and invoices display options in theme customizer.', '_invoices' ); ?>
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
				<?php esc_html_e( 'As the theme uses the repeater field, Advanced Custom Field PRO plugin is required.', '_invoices' ); ?>
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
				<?php esc_html_e( 'Add a seller(s), clients and payment methods first, so they can be used in invoices.', '_invoices' ); ?>
				<?php esc_html_e( 'Find those under "Invoices" admin menu.', '_invoices' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'When creating or editing an invoice, totals are calculated only after saving/publishing the invoice!', '_invoices' ); ?>
			</p>
			<p>
				<strong><?php esc_html_e( 'Do not forget to set a proper invoice publish date!', '_invoices' ); ?></strong>
				<?php esc_html_e( 'Publish date is being used as invoice issue date and due date is calculated from it.', '_invoices' ); ?>
			</p>
		</div>

		<div class="welcome-panel-column">
			<h3>
				<?php esc_html_e( 'Currency exchange', '_invoices' ); ?>
			</h3>
			<p>
				<?php esc_html_e( 'To use dual currency invoice display, just select a different exchange currencies when editing the invoice.', '_invoices' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'The theme will automatically exchange the totals depending on current exchange rate relevant to invoice publish date, taken from open-source Fixer.io API.', '_invoices' ); ?>
			</p>
		</div>

		<div class="welcome-panel-column">
			<h3>
				<?php esc_html_e( 'Display and printing', '_invoices' ); ?>
			</h3>
			<p>
				<?php esc_html_e( 'Homepage displays current year invoices in a simplified list.', '_invoices' ); ?>
				<?php esc_html_e( 'If previewing homepage before the end of taxation month (set in customizer), the previous year invoices are also displayed.', '_invoices' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'Yearly archives display full invoice previews, so you can easily print them out, all at once.', '_invoices' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'When printing invoice lists, the last page contains a summary of invoices totals by currency.', '_invoices' ); ?>
			</p>
		</div>

		<div class="welcome-panel-column">
			<h3>
				<?php esc_html_e( 'Technical info', '_invoices' ); ?>
			</h3>
			<ul>
				<li><?php esc_html_e( '"Posts" were renamed to "Invoices"', '_invoices' ); ?>,</li>
				<li><?php esc_html_e( '"Pages" were renamed to Products"', '_invoices' ); ?>,</li>
				<li><?php esc_html_e( '"Categories" were renamed to "Sellers"', '_invoices' ); ?>,</li>
				<li><?php esc_html_e( '"Clients", "Payment Methods", "Product Types" are custom taxonomies', '_invoices' ); ?>,</li>
				<li><?php esc_html_e( '"Post Tags" taxonomy was removed', '_invoices' ); ?>.</li>
			</u2>
		</div>

	</div>

	<footer>&copy; <?php echo date( 'Y' ); ?> WebMan Design, <a href="https://www.webmandesign.eu">webmandesign.eu</a></footer>

</div>

<style>
<?php get_template_part( 'templates/parts/admin/dashboard-welcome-panel', 'styles' ); ?>
</style>
