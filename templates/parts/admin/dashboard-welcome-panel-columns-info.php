<?php
/**
 * Dashboard welcome panel columns: Info
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  2.1.0
 */





?>

<div class="welcome-panel-column-container">



	<div class="welcome-panel-column welcome-panel-column-create">
		<h3>
			<?php esc_html_e( 'Creating an invoice', '_invoices' ); ?>
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



	<div class="welcome-panel-column welcome-panel-column-prices">
		<h3>
			<?php esc_html_e( 'Prices, VAT and exchange', '_invoices' ); ?>
		</h3>
		<p>
			<?php esc_html_e( 'All prices are VAT exclusive!', '_invoices' ); ?>
			<?php esc_html_e( 'Current version of theme does not include any VAT management.', '_invoices' ); ?>
		</p>
		<p>
			<?php esc_html_e( 'For dual currency invoice display select a different exchange currencies when editing the invoice.', '_invoices' ); ?>
		</p>
		<p>
			<?php esc_html_e( 'Theme will exchange invoice totals depending on exchange rate provided in the invoice option field.', '_invoices' ); ?>
		</p>
	</div>



	<div class="welcome-panel-column welcome-panel-column-print">
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



	<div class="welcome-panel-column welcome-panel-column-technical">
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
