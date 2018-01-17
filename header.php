<?php
/**
 * The header for our theme
 *
 * @link  https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 */





// Helper variables

	/**
	 * Create $totals global variable so we can display
	 * total amount of all displayed invoices on the screen
	 * in the website footer.
	 * This is just for informational purposes and will not
	 * be print.
	 */
	global $totals;
	$totals = Invoices_Customize::get_currencies_array();
	foreach ( $totals as $key => $value ) {
		$totals[ $key ] = 0;
	}

	/**
	 * Create helper global variable so we can store and pass
	 * values of variable for a specific invoice between its
	 * partial content template files.
	 */
	global $invoice_helper;
	$invoice_helper = array();


?><!doctype html>

<html <?php language_attributes(); ?>>

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>


<body <?php body_class(); ?>>
