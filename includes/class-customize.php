<?php
/**
 * Theme options, customization
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.9.1
 *
 * Contents:
 *
 *   0) Init
 *  10) Customizer
 *  20) Getters
 *  30) Assets
 * 100) Others
 */
class Invoices_Customize {





	/**
	 * 0) Init
	 */

		private static $instance;

		public static $default_appearance = array(
			'color_body_text'          => 'ffffff',
			'overlay_opacity_body'     => 50,
			'color_invoice_background' => 'ffffff',
			'color_invoice_text'       => '000000',
		);

		public static $default_value_fields = array(
			'category'       => 'seller',
			'client'         => 'client',
			'page'           => 'product',
			'payment_method' => 'payment_method',
		);



		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 * @version  1.9.1
		 */
		private function __construct() {

			// Processing

				// Hooks

					// Actions

						add_action( 'customize_register', __CLASS__ . '::theme_options' );

						add_action( 'customize_preview_init', __CLASS__ . '::assets_customize_preview' );

						add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_styles_customized' );

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
	 * 10) Customizer
	 */

		/**
		 * Theme customizer options
		 *
		 * @since    1.0.0
		 * @version  1.9.1
		 *
		 * @param  object $wp_customize  WP customizer object.
		 */
		public static function theme_options( $wp_customize ) {

			// Helper variables

				$priority  = 10;
				$transport = 'postMessage'; // Or 'refresh'


			// Processing

				// Modifying WP native options

					$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
					$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';



				// Colors

					$wp_customize->get_control( 'background_color' )->label = esc_html__( 'Body background & overlay color', '_invoices' );

					// Option: colors/color_body_text

						$option_id = 'color_body_text';

						$wp_customize->add_setting(
							$option_id,
							array(
								'default'              => maybe_hash_hex_color( self::$default_appearance[ $option_id ] ),
								'transport'            => 'postMessage',
								'sanitize_callback'    => 'sanitize_hex_color',
								'sanitize_js_callback' => 'maybe_hash_hex_color',
							)
						);

						$wp_customize->add_control( new WP_Customize_Color_Control(
							$wp_customize,
							$option_id,
							array(
								'label'   => esc_html__( 'Body text color', '_invoices' ),
								'section' => 'colors',
								'type'    => 'color',
							)
						) );

					// Option: colors/overlay_opacity_body

						$option_id = 'overlay_opacity_body';

						$wp_customize->add_setting(
							$option_id,
							array(
								'default'              => self::$default_appearance[ $option_id ],
								'transport'            => 'refresh', // jQuery can not access pseudo elements...
								'sanitize_callback'    => 'absint',
								'sanitize_js_callback' => 'absint',
							)
						);

						$wp_customize->add_control(
							$option_id,
							array(
								'label'       => esc_html__( 'Body overlay opacity', '_invoices' ),
								'section'     => 'colors',
								'type'        => 'range',
								'input_attrs' => array(
									'min'     => 0,
									'max'     => 95,
									'step'    => 5,
								),
							)
						);

					// Option: colors/color_invoice_background

						$option_id = 'color_invoice_background';

						$wp_customize->add_setting(
							$option_id,
							array(
								'default'              => maybe_hash_hex_color( self::$default_appearance[ $option_id ] ),
								'transport'            => 'postMessage',
								'sanitize_callback'    => 'sanitize_hex_color',
								'sanitize_js_callback' => 'maybe_hash_hex_color',
							)
						);

						$wp_customize->add_control( new WP_Customize_Color_Control(
							$wp_customize,
							$option_id,
							array(
								'label'   => esc_html__( 'Invoice background color', '_invoices' ),
								'section' => 'colors',
								'type'    => 'color',
							)
						) );

					// Option: colors/color_invoice_text

						$option_id = 'color_invoice_text';

						$wp_customize->add_setting(
							$option_id,
							array(
								'default'              => maybe_hash_hex_color( self::$default_appearance[ $option_id ] ),
								'transport'            => 'postMessage',
								'sanitize_callback'    => 'sanitize_hex_color',
								'sanitize_js_callback' => 'maybe_hash_hex_color',
							)
						);

						$wp_customize->add_control( new WP_Customize_Color_Control(
							$wp_customize,
							$option_id,
							array(
								'label'   => esc_html__( 'Invoice text color', '_invoices' ),
								'section' => 'colors',
								'type'    => 'color',
							)
						) );



				// Panel

					$wp_customize->add_panel(
						'theme_options',
						array(
							'title' => esc_html__( 'Theme Options', '_invoices' ),
						)
					);



				// Section: currency

					$wp_customize->add_section(
						'currency',
						array(
							'title' => esc_html__( 'Currency Exchange', '_invoices' ),
							'panel' => 'theme_options',
						)
					);

					// Option: currency/currencies

						$wp_customize->add_setting(
							'currencies',
							array(
								'default'           => 'USD,EUR',
								'transport'         => $transport,
								'sanitize_callback' => 'sanitize_text_field',
							)
						);

						$wp_customize->add_control(
							'currencies',
							array(
								'label'       => esc_html__( 'Currencies', '_invoices' ),
								'description' => esc_html__( 'List accountable currencies international codes, separated with comma (no empty spaces).', '_invoices' ),
								'section'     => 'currency',
								'type'        => 'textarea',
								'priority'    => ++$priority,
							)
						);

					// Option: currency/currency_exchange_from

						$wp_customize->add_setting(
							'currency_exchange_from',
							array(
								'default'           => 'USD',
								'transport'         => $transport,
								'sanitize_callback' => 'sanitize_text_field',
							)
						);

						$wp_customize->add_control(
							'currency_exchange_from',
							array(
								'label'       => esc_html__( 'Default exchange FROM currency', '_invoices' ),
								'description' => esc_html__( 'This becomes the default invoice currency selected.', '_invoices' ),
								'section'     => 'currency',
								'type'        => 'text',
								'priority'    => ++$priority,
							)
						);

					// Option: currency/currency_exchange_to

						$wp_customize->add_setting(
							'currency_exchange_to',
							array(
								'default'           => 'EUR',
								'transport'         => $transport,
								'sanitize_callback' => 'sanitize_text_field',
							)
						);

						$wp_customize->add_control(
							'currency_exchange_to',
							array(
								'label'       => esc_html__( 'Default exchange TO currency', '_invoices' ),
								'description' => esc_html__( 'Set this to your accounting currency - will be used for exchange calculation in dual currency invoices.', '_invoices' ),
								'section'     => 'currency',
								'type'        => 'text',
								'priority'    => ++$priority,
							)
						);

					// Option: currency/api_fixer_access_key

						$wp_customize->add_setting(
							'api_fixer_access_key',
							array(
								'default'           => '',
								'transport'         => $transport,
								'sanitize_callback' => 'sanitize_text_field',
							)
						);

						$wp_customize->add_control(
							'api_fixer_access_key',
							array(
								'label'       => esc_html__( 'Fixer.io API access key', '_invoices' ),
								'description' => esc_html__( 'Get free access key from https://fixer.io/', '_invoices' ),
								'section'     => 'currency',
								'type'        => 'text',
								'priority'    => ++$priority,
							)
						);



				// Section: accounting

					$wp_customize->add_section(
						'accounting',
						array(
							'title' => esc_html__( 'Accounting', '_invoices' ),
							'panel' => 'theme_options',
						)
					);

					// Option: accounting/month_tax_pay

						$wp_customize->add_setting(
							'month_tax_pay',
							array(
								'default'           => 3,
								'transport'         => $transport,
								'sanitize_callback' => 'absint',
							)
						);

						$wp_customize->add_control(
							'month_tax_pay',
							array(
								'label'       => esc_html__( 'Taxation month', '_invoices' ),
								'description' => esc_html__( 'Until this month passes, a previous year invoices will also be displayed on homepage.', '_invoices' ),
								'section'     => 'accounting',
								'type'        => 'select',
								'priority'    => ++$priority,
								'choices'     => array(
									 1 => esc_html( 'January', '_invoices' ),
									 2 => esc_html( 'February', '_invoices' ),
									 3 => esc_html( 'March', '_invoices' ),
									 4 => esc_html( 'April', '_invoices' ),
									 5 => esc_html( 'May', '_invoices' ),
									 6 => esc_html( 'June', '_invoices' ),
									 7 => esc_html( 'July', '_invoices' ),
									 8 => esc_html( 'August', '_invoices' ),
									 9 => esc_html( 'September', '_invoices' ),
									10 => esc_html( 'October', '_invoices' ),
									11 => esc_html( 'November', '_invoices' ),
									12 => esc_html( 'December', '_invoices' ),
								),
							)
						);

					// Option: accounting/invoice_due_period

						$wp_customize->add_setting(
							'invoice_due_period',
							array(
								'default'           => 21,
								'transport'         => $transport,
								'sanitize_callback' => 'absint',
							)
						);

						$wp_customize->add_control(
							'invoice_due_period',
							array(
								'label'       => esc_html__( 'Invoice due period in days', '_invoices' ),
								'section'     => 'accounting',
								'type'        => 'number',
								'priority'    => ++$priority,
								'input_attrs' => array(
									'min'  => 1,
									'max'  => 31,
									'step' => 1,
								),
							)
						);



				// Section: invoice

					$wp_customize->add_section(
						'invoice',
						array(
							'title' => esc_html__( 'Invoice', '_invoices' ),
							'panel' => 'theme_options',
						)
					);

					// Option: invoice/count_invoices_per_month

						$wp_customize->add_setting(
							'count_invoices_per_month',
							array(
								'default'           => 5,
								'transport'         => $transport,
								'sanitize_callback' => 'absint',
							)
						);

						$wp_customize->add_control(
							'count_invoices_per_month',
							array(
								'label'       => esc_html__( 'Max number of invoices created monthly', '_invoices' ),
								'section'     => 'invoice',
								'type'        => 'number',
								'priority'    => ++$priority,
								'input_attrs' => array(
									'min'  => 1,
									'max'  => 31,
									'step' => 1,
								),
							)
						);

					// Option: invoice/field_type_client

						$wp_customize->add_setting(
							'field_type_client',
							array(
								'default'           => 'radio',
								'transport'         => $transport,
								'sanitize_callback' => 'esc_attr',
							)
						);

						$wp_customize->add_control(
							'field_type_client',
							array(
								'label'    => esc_html__( 'Client selector field type', '_invoices' ),
								'section'  => 'invoice',
								'type'     => 'radio',
								'priority' => ++$priority,
								'choices'  => array(
									'select' => esc_html__( 'Dropdown (select)', '_invoices' ),
									'radio'  => esc_html__( 'Radio buttons', '_invoices' ),
								),
							)
						);

					// Option: invoice/default_{$field_name}

						foreach ( (array) self::$default_value_fields as $object_name => $field_name ) {

							$wp_customize->add_setting(
								'default_' . $field_name,
								array(
									'default'           => 0,
									'transport'         => $transport,
									'sanitize_callback' => 'absint',
								)
							);

							$label   = '-';
							$choices = array( 0 => '-' );

							if ( taxonomy_exists( $object_name ) ) {

								if ( '-' === $label ) {
									$label = get_taxonomy_labels( get_taxonomy( $object_name ) )->singular_name;
								}

								$terms = get_terms( array(
									'taxonomy'   => $object_name,
									'hide_empty' => false,
								) );

								if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
									foreach ( $terms as $term ) {
										$choices[ $term->term_id ] = $term->name;
									}
								}

							} elseif ( post_type_exists( $object_name ) ) {

								if ( '-' === $label ) {
									$label = get_post_type_labels( get_post_type_object( $object_name ) )->singular_name;
								}

								$posts = get_posts( array(
									'post_type'   => $object_name,
									'numberposts' => 100,
								) );

								if ( ! is_wp_error( $posts ) && ! empty( $posts ) ) {
									foreach ( $posts as $post ) {
										$choices[ $post->ID ] = $post->post_title;
									}
								}

							}

							$wp_customize->add_control(
								'default_' . $field_name,
								array(
									'label'    => sprintf( esc_html__( 'Preselected value for: %s', '_invoices' ), $label ),
									'section'  => 'invoice',
									'type'     => 'select',
									'priority' => ++$priority,
									'choices'  => (array) $choices,
								)
							);

						}

		} // /theme_options





	/**
	 * 20) Getters
	 */

		/**
		 * Get array of predefined currencies
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function get_currencies_array() {

			// Helper variables

				$currencies = explode( ',', (string) get_theme_mod( 'currencies', 'USD,EUR' ) );


			// Processing
				$currencies = array_map( __CLASS__ . '::currency_code', $currencies );
				$currencies = array_unique( $currencies );
				$currencies = array_filter( $currencies );
				$currencies = array_combine( $currencies, $currencies );


			// Output

				return (array) $currencies;

		} // /get_currencies_array



		/**
		 * Get currency: Exchange from
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function get_currency_exchange_from() {

			// Output

				return self::currency_code( (string) get_theme_mod( 'currency_exchange_from', 'USD' ) );

		} // /get_currency_exchange_from



		/**
		 * Get currency: Exchange to
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 */
		public static function get_currency_exchange_to() {

			// Output

				return self::currency_code( (string) get_theme_mod( 'currency_exchange_to', 'EUR' ) );

		} // /get_currency_exchange_to





	/**
	 * 30) Assets
	 */

		/**
		 * Customizer preview assets enqueue.
		 *
		 * @since    1.9.1
		 * @version  1.9.1
		 */
		public static function assets_customize_preview() {

			// Processing

				wp_enqueue_script(
					'invoices-customize-preview',
					get_theme_file_uri( 'assets/js/customize-preview.js' ),
					array( 'jquery', 'customize-preview' ),
					wp_get_theme( '_invoices' )->get( 'Version' ),
					true
				);

		} // /assets_customize_preview



		/**
		 * Enqueue customized styles.
		 *
		 * @since    1.9.1
		 * @version  1.9.1
		 */
		public static function enqueue_styles_customized() {

			// Processing

				wp_add_inline_style(
					'invoices-stylesheet',
					'
					body {
						color: ' . maybe_hash_hex_color(
							get_theme_mod(
								'color_body_text',
								self::$default_appearance[ 'color_body_text' ]
							)
						) . ';
					}

					body::before {
						opacity: ' . round(
							absint( get_theme_mod(
								'overlay_opacity_body',
								self::$default_appearance[ 'overlay_opacity_body' ]
							) ) / 100,
							2
						) . ';
					}

					.invoice,
					.generator-section,
					.invoice-simple {
						background-color: ' . maybe_hash_hex_color(
							get_theme_mod(
								'color_invoice_background',
								self::$default_appearance[ 'color_invoice_background' ]
							)
						) . ';
						color: ' . maybe_hash_hex_color(
							get_theme_mod(
								'color_invoice_text',
								self::$default_appearance[ 'color_invoice_text' ]
							)
						) . ';
					}
					'
				);

		} // /enqueue_styles_customized





	/**
	 * 100) Others
	 */

		/**
		 * Format currency to international code
		 *
		 * @link  https://en.wikipedia.org/wiki/ISO_4217
		 *
		 * @since    1.0.0
		 * @version  1.0.0
		 *
		 * @param  string $currency
		 */
		public static function currency_code( $currency ) {

			// Processing

				$currency = (string) $currency;
				$currency = preg_replace( '/[^A-Za-z]/', '', $currency );
				$currency = substr( $currency, 0, 3 );
				$currency = strtoupper( $currency );


			// Output

				return $currency;

		} // /currency_code





} // /Invoices_Customize

add_action( 'after_setup_theme', 'Invoices_Customize::init' );
