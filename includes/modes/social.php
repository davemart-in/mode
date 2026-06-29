<?php
/**
 * Built-in Social mode.
 *
 * Registered through the public `mode_register` action — the same extension
 * point third-party plugins use.
 *
 * @package Mode
 */

defined( 'ABSPATH' ) || exit;

// Static mock screens for this mode (the render callbacks below).
require_once __DIR__ . '/social-screens.php';

add_action(
	'mode_register',
	function () {
		mode_register_mode(
			array(
				'id'          => 'social',
				'label'       => __( 'Social', 'mode' ),
				'icon'        => 'dashicons-share',
				'description' => __( 'Plan, schedule, and track posts across networks.', 'mode' ),
				'position'    => 30,
				'screens'     => array(
					array(
						'slug'   => 'dashboard',
						'label'  => __( 'Dashboard', 'mode' ),
						'icon'   => 'dashicons-dashboard',
						'render' => 'mode_social_screen_dashboard',
					),
					array(
						'slug'   => 'composer',
						'label'  => __( 'Composer', 'mode' ),
						'icon'   => 'dashicons-edit',
						'render' => 'mode_social_screen_composer',
					),
					array(
						'slug'   => 'calendar',
						'label'  => __( 'Calendar', 'mode' ),
						'icon'   => 'dashicons-calendar-alt',
						'render' => 'mode_social_screen_calendar',
					),
					array(
						'slug'   => 'accounts',
						'label'  => __( 'Accounts', 'mode' ),
						'icon'   => 'dashicons-admin-users',
						'render' => 'mode_social_screen_accounts',
					),
				),
			)
		);
	}
);
