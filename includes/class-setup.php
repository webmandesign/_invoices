<?php
/**
 * Theme Setup Class
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  2.0.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Installation
 * 20) Setup
 * 30) Admin
 * 40) Login required
 */
class Invoices_Setup {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		private function __construct() {

			// Processing

				// Setup

					self::content_width();

				// Hooks

					// Actions

						add_action( 'load-themes.php', __CLASS__ . '::admin_notice_welcome_activation' );

						add_action( 'after_setup_theme', __CLASS__ . '::setup' );

						add_action( 'admin_init', __CLASS__ . '::dashboard_widgets' );

						add_action( 'admin_menu', __CLASS__ . '::admin_menu' );

						add_action( 'template_redirect', __CLASS__ . '::login_required' );

						remove_action( 'welcome_panel', 'wp_welcome_panel' );
						   add_action( 'welcome_panel', __CLASS__ . '::dashboard_welcome_panel' );

		} // /__construct



		/**
		 * Initialization (get instance)
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function init() {

			// Processing

				if ( null === self::$instance ) {
					self::$instance = new self;
				}


			// Output

				return self::$instance;

		} // /init





	/**
	 * 10) Installation
	 */

		/**
		 * Initiate "Welcome" admin notice
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function admin_notice_welcome_activation() {

			// Processing

				global $pagenow;

				if (
					is_admin()
					&& 'themes.php' == $pagenow
					&& isset( $_GET['activated'] )
				) {

					add_action( 'admin_notices', __CLASS__ . '::admin_notice_welcome', 99 );

				}

		} // /admin_notice_welcome_activation



		/**
		 * Display "Welcome" admin notice
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function admin_notice_welcome() {

			// Processing

				get_template_part( 'templates/parts/admin/notice', 'welcome' );

		} // /admin_notice_welcome





	/**
	 * 20) Setup
	 */

		/**
		 * Theme setup
		 *
		 * @since    1.0.0
		 * @version  2.0.0
		 */
		public static function setup() {

			// Processing

				// Localization

					/**
					 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
					 */

					// wp-content/languages/themes/_invoices/en_GB.mo

						load_theme_textdomain( '_invoices', trailingslashit( WP_LANG_DIR ) . 'themes/' . get_template() );

					// wp-content/themes/child-theme/languages/en_GB.mo

						load_theme_textdomain( '_invoices', get_stylesheet_directory() . '/languages' );

					// wp-content/themes/_invoices/languages/en_GB.mo

						load_theme_textdomain( '_invoices', get_template_directory() . '/languages' );

				// Title tag

					/**
					 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
					 */
					add_theme_support( 'title-tag' );

				// Site logo

					/**
					 * @link  https://codex.wordpress.org/Theme_Logo
					 */
					add_theme_support( 'custom-logo' );

				// Custom background

					/**
					 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Custom_Background
					 */
					add_theme_support( 'custom-background', (array) apply_filters( 'wmhook_invoices_setup_custom_background_args', array(
						'default-image'      => get_theme_file_uri( '/assets/images/dmitri-popov-226894-unsplash.jpg' ),
						'default-preset'     => 'fill', // 'default', 'fill', 'fit', 'repeat', 'custom'
						'default-position-x' => 'center', // 'left', 'center', 'right'
						'default-position-y' => 'center', // 'top', 'center', 'bottom'
						'default-size'       => 'cover', // 'auto', 'contain', 'cover'
						'default-repeat'     => 'no-repeat', // 'repeat-x', 'repeat-y', 'repeat', 'no-repeat'
						'default-attachment' => 'fixed', // 'scroll', 'fixed'
						'default-color'      => '000000',
					) ) );

				// Menus

					register_nav_menus( array(
						'secondary' => esc_html_x( 'Secondary', 'Navigational menu location', '_invoices' ),
					) );

		} // /setup



		/**
		 * Set the content width in pixels
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @global  int $content_width
		 */
		public static function content_width() {

			// Processing

				$GLOBALS['content_width'] = 1200;

		} // /content_width





	/**
	 * 30) Admin
	 */

		/**
		 * Dashboard widgets
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function dashboard_widgets() {

			// Processing

				remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); // "At a Glance"
				remove_meta_box( 'dashboard_activity', 'dashboard', 'normal'); // "Activity"
				remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); // "Quick Draft"
				remove_meta_box( 'dashboard_primary', 'dashboard', 'side' ); // "WordPress Events and News"

		} // /dashboard_widgets



		/**
		 * Admin menu
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function admin_menu() {

			// Helper variables

				global $menu;


			// Processing

				// Remove admin menus

					remove_menu_page( 'edit-comments.php' );

					remove_submenu_page( 'options-general.php', 'options-discussion.php' );

				// Modify order

					// Moving "Media" menu item
					$menu[30] = $menu[10];
					unset( $menu[10] );

		} // /admin_menu



		/**
		 * Dashboard welcome panel
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function dashboard_welcome_panel() {

			// Processing

				get_template_part( 'templates/parts/admin/dashboard', 'welcome-panel' );

		} // /dashboard_welcome_panel





	/**
	 * 40) Login required
	 */

		/**
		 * No page is displayed unless a visitor is logged in
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function login_required() {

			// Processing

				if ( ! is_user_logged_in() ) {
					wp_redirect( wp_login_url( get_permalink() ) );
					die;
				}

		} // /login_required





} // /Invoices_Setup

add_action( 'after_setup_theme', 'Invoices_Setup::init', 0 );
