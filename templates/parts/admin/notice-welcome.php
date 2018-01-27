<?php
/**
 * Admin notice: Welcome
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 */





// Helper variables

	$theme_name = wp_get_theme( '_invoices' )->display( 'Name' );


?>

<div class="updated notice is-dismissible theme-welcome-notice">
	<h2>
		<?php

		printf(
			esc_html_x( 'Thank you for installing %s theme!', '%s: Theme name.', '_invoices' ),
			'<strong>' . $theme_name . '</strong>'
		);

		?>
	</h2>
	<p>
		<?php esc_html_e( 'Please read info in dashboard page about the theme setup.', '_invoices' ); ?>
	</p>
	<p class="call-to-action">
		<a href="<?php echo esc_url( admin_url( 'index.php' ) ); ?>" class="button button-primary button-hero">
			<?php

			printf(
				esc_html_x( 'Get started with %s', '%s: Theme name.', '_invoices' ),
				$theme_name
			);

			?>
		</a>
	</p>
</div>

<style type="text/css" media="screen">

	.notice.theme-welcome-notice {
		padding: 2.62em;
		text-align: center;
		background: rgba(0,0,0,.01);
		border: 1em solid rgba(255,255,255,.85);
	}

	.theme-welcome-notice h2 {
		margin: .5em 0;
		font-weight: 400;
	}

	.theme-welcome-notice strong {
		font-weight: bolder;
	}

	.theme-welcome-notice .call-to-action {
		margin-top: 1.62em;
	}

</style>
