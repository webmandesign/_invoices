<?php
/**
 * Dashboard welcome panel: Inline styles
 *
 * @package    Invoices
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  1.0.0
 */





?>

h1 {
	position: absolute !important;
	width: 1px;
	height: 1px;
	line-height: 1px;
	word-wrap: normal !important;
	clip-path: inset( 50% );
	clip: rect( 1px, 1px, 1px, 1px );
	overflow: hidden;
}

.welcome-panel {
	clear: both;
	padding: 4% 6%;
	font-size: 15px;
}

	.welcome-panel-close {
		display: none;
	}

	.welcome-panel h2,
	.welcome-panel h3 {
		margin-bottom: .62rem;
		font-size: 2.62em;
		font-weight: 700;
	}

	.welcome-panel h3 {
		margin-top: 0;
		margin-bottom: 1em;
		font-size: 1.38em;
	}

	.welcome-panel p,
	.welcome-panel li {
		font-size: 1em;
	}

	.welcome-panel-column:not(.welcome-panel-links) ul {
		margin-left: 1.62em;
	}

	.welcome-panel-column:not(.welcome-panel-links) li {
		list-style: disc;
		line-height: 1.5;
	}

.welcome-panel-content {
	margin: 0;
	max-width: 100%;
}

.welcome-panel-column-container {
	display: flex;
	justify-content: space-between;
	margin-top: 3.62em;
}

	.welcome-panel-column-container + .welcome-panel-column-container {
		padding-top: 3.62em;
		border-top: 1px solid #ddd;
	}

.welcome-panel .welcome-panel-column {
	width: auto;
	max-width: 70ch;
	margin-left: 2.62em;
}

	.welcome-panel .welcome-panel-column:first-child {
		width: auto;
		margin-left: 0;
	}

	.welcome-panel .welcome-panel-links:first-child {
		padding: 2.62em;
		width: 62%;
		border: 1px solid #ddd;
	}

	.welcome-panel .welcome-panel-customize {
		padding: 2.62em;
		border: 1px solid #ddd;
	}

	.welcome-panel-requirements {
		padding: 2.62em;
		background: #d04;
		color: #fff;
	}

		.welcome-panel-column.welcome-panel-requirements *:not(.button) {
			color: inherit;
		}

.metabox-holder .postbox-container .empty-container {
	border: 0;
}

#dashboard-widgets .meta-box-sortables {
	min-height: 1.62em;
}

.metabox-holder .postbox-container .empty-container {
	height: 1.62em;
}
