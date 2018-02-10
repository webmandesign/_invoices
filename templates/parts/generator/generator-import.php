<?php
/**
 * Generator page content: Import XML
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.2.0
 * @version  1.2.1
 */





// Helper variables

	$generated = Invoices_Generator::get_output( 'import' );

	$csv_example  = 'DATE;TF earnings/sales;CM earnings/sales;BB earnings' . "\r\n";
	$csv_example .= '2010-01-31;1111.11/111;111.11/11;11.11' . "\r\n";
	$csv_example .= '2010-02-28;2222.22/222;222.22/22;0';


?>

<section class="generator-section generator-import">

	<h2><?php esc_html_e( 'Import XML generator', '_invoices' ); ?></h2>

	<?php if ( false === $generated ) : ?>

		<p class="error">
			<?php esc_html_e( 'Sorry, something went wrong!', '_invoices' ); ?>
			<?php esc_html_e( 'Please check your input data.', '_invoices' ); ?>
		</p>

	<?php elseif ( empty( $generated ) ) : ?>

		<form action="" method="post">

			<p>
				<label for="import-csv"><?php esc_html_e( 'CSV data to convert to import XML data', '_invoices' ); ?></label>
				<textarea
					id="import-csv"
					name="csv"
					rows="13"
					placeholder="<?php esc_attr_e( 'Enter CSV data here&hellip;', '_invoices' ); ?>"
					onclick="this.select()"
					title="<?php esc_attr_e( 'Click inside to select the content.', '_invoices' ); ?>"
				><?php echo esc_textarea( $csv_example ); ?></textarea>
				<span class="description">
					<?php esc_html_e( 'First column is treated as an invoice issue date.', '_invoices' ); ?><br>
					<?php esc_html_e( 'Each subsequent column represents an invoice for the particular date and is related to a specific client, with value of "total/sales" (sales are optional).', '_invoices' ); ?>
					<?php esc_html_e( 'You have to set correct client:product pairs below, so this information can be used to parse CSV columns correctly.', '_invoices' ); ?><br>
					<?php esc_html_e( 'There is no control for multiple invoice items (products), nor seller, nor payment method (predefined values are used in those cases).', '_invoices' ); ?>
				</span>
			</p>

			<p class="column">
				<label for="import-delimiter"><?php esc_html_e( 'CSV delimiter', '_invoices' ); ?></label>
				<input
					id="import-delimiter"
					type="text"
					size="1"
					maxlength="1"
					name="delimiter"
					value=";" >
			</p>

			<p class="column">
				<label for="import-start_row"><?php esc_html_e( 'Start from row', '_invoices' ); ?></label>
				<input
					id="import-start_row"
					type="number"
					min="1"
					step="1"
					name="start_row"
					value="2" >
				<span class="description">
					<?php esc_html_e( 'Maybe you want to skip the first row of column headings?', '_invoices' ); ?>
				</span>
			</p>

			<p>
				<label for="import-csv"><?php esc_html_e( 'Client:Product (ID or slug) pairs for each CSV column (separated with delimiter)', '_invoices' ); ?></label>
				<input
					id="import-setup_columns"
					type="text"
					name="setup_columns"
					value="tf:withdrawal;cm:withdrawal;bb:affiliate" >
				<span class="description">
					<?php esc_html_e( 'This has to match the number of CSV columns minus 1 (the first column is treated as invoice date, remember?).', '_invoices' ); ?>
				</span>
			</p>

			<p>
				<input type="submit" value="<?php esc_attr_e( 'Convert to import XML format', '_invoices' ); ?>">
				<input type="hidden" name="generate" value="import">
			</p>

		</form>

	<?php else : ?>

		<p><?php esc_html_e( 'Generated results:', '_invoices' ); ?></p>
		<textarea
			rows="36"
			readonly="true"
			onclick="this.select()"
			title="<?php esc_attr_e( 'Click inside to select the content.', '_invoices' ); ?>"
		><?php echo esc_textarea( $generated ); ?></textarea>

	<?php endif; ?>

</section>
