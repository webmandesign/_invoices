<?php
/**
 * Loading theme functionality
 *
 * @link  https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 *
 * Contents:
 *
 *   0) Paths
 *  10) Theme setup
 *  20) Frontend
 *  30) Features
 * 999) Plugins integration
 */





/**
 * 0) Paths
 */

	// Theme directory path

		define( 'INVOICES_PATH', trailingslashit( get_template_directory() ) );

	// Includes path

		define( 'INVOICES_PATH_INCLUDES', trailingslashit( INVOICES_PATH . 'includes' ) );





/**
 * 10) Theme setup
 */

	require INVOICES_PATH_INCLUDES . 'class-setup.php';





/**
 * 20) Frontend
 */

	// Assets (styles and scripts)

		require INVOICES_PATH_INCLUDES . 'class-assets.php';

	// Post types

		require INVOICES_PATH_INCLUDES . 'class-post-types.php';





/**
 * 30) Features
 */

	// Theme Customization

		require INVOICES_PATH_INCLUDES . 'class-customize.php';





/**
 * 999) Plugins integration
 */

	// Advanced Custom Fields

		if ( function_exists( 'register_field_group' ) && is_admin() ) {
			require INVOICES_PATH_INCLUDES . 'class-advanced-custom-fields.php';
		}
