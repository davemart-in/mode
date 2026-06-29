<?php
/**
 * Built-in Newsletter mode.
 *
 * Registered through the public `mode_register` action — the same extension
 * point third-party plugins use.
 *
 * @package Mode
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'mode_register',
	function () {
		mode_register_mode(
			array(
				'id'          => 'newsletter',
				'label'       => __( 'Newsletter', 'mode' ),
				'icon'        => 'dashicons-email',
				'description' => __( 'Compose, send, and grow your list.', 'mode' ),
				'position'    => 10,
				'screens'     => array(
					array(
						'slug'   => 'dashboard',
						'label'  => __( 'Dashboard', 'mode' ),
						'render' => 'mode_newsletter_screen_dashboard',
					),
					array(
						'slug'   => 'subscribers',
						'label'  => __( 'Subscribers', 'mode' ),
						'render' => 'mode_newsletter_screen_subscribers',
					),
					array(
						'slug'   => 'broadcasts',
						'label'  => __( 'Broadcasts', 'mode' ),
						'render' => 'mode_newsletter_screen_broadcasts',
					),
					array(
						'slug'   => 'templates',
						'label'  => __( 'Templates', 'mode' ),
						'render' => 'mode_newsletter_screen_templates',
					),
				),
			)
		);
	}
);

/**
 * Render the Newsletter → Dashboard screen.
 *
 * @return void
 */
function mode_newsletter_screen_dashboard() {
	mode_render_placeholder_screen( __( 'Newsletter — Dashboard', 'mode' ) );
}

/**
 * Render the Newsletter → Subscribers screen.
 *
 * @return void
 */
function mode_newsletter_screen_subscribers() {
	mode_render_placeholder_screen( __( 'Newsletter — Subscribers', 'mode' ) );
}

/**
 * Render the Newsletter → Broadcasts screen.
 *
 * @return void
 */
function mode_newsletter_screen_broadcasts() {
	mode_render_placeholder_screen( __( 'Newsletter — Broadcasts', 'mode' ) );
}

/**
 * Render the Newsletter → Templates screen.
 *
 * @return void
 */
function mode_newsletter_screen_templates() {
	mode_render_placeholder_screen( __( 'Newsletter — Templates', 'mode' ) );
}
