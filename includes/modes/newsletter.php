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

// Static mock screens for this mode (the render callbacks below).
require_once __DIR__ . '/newsletter-screens.php';

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
						'icon'   => 'dashicons-dashboard',
						'render' => 'mode_newsletter_screen_dashboard',
					),
					array(
						'slug'   => 'subscribers',
						'label'  => __( 'Subscribers', 'mode' ),
						'icon'   => 'dashicons-groups',
						'render' => 'mode_newsletter_screen_subscribers',
					),
					array(
						'slug'   => 'broadcasts',
						'label'  => __( 'Broadcasts', 'mode' ),
						'icon'   => 'dashicons-email-alt',
						'render' => 'mode_newsletter_screen_broadcasts',
					),
					array(
						'slug'   => 'templates',
						'label'  => __( 'Templates', 'mode' ),
						'icon'   => 'dashicons-layout',
						'render' => 'mode_newsletter_screen_templates',
					),
				),
			)
		);
	}
);

