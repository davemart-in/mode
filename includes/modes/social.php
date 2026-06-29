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
						'slug'   => 'composer',
						'label'  => __( 'Composer', 'mode' ),
						'render' => 'mode_social_screen_composer',
					),
					array(
						'slug'   => 'calendar',
						'label'  => __( 'Calendar', 'mode' ),
						'render' => 'mode_social_screen_calendar',
					),
					array(
						'slug'   => 'accounts',
						'label'  => __( 'Accounts', 'mode' ),
						'render' => 'mode_social_screen_accounts',
					),
					array(
						'slug'   => 'analytics',
						'label'  => __( 'Analytics', 'mode' ),
						'render' => 'mode_social_screen_analytics',
					),
				),
			)
		);
	}
);

/**
 * Render the Social → Composer screen.
 *
 * @return void
 */
function mode_social_screen_composer() {
	mode_render_placeholder_screen( __( 'Social — Composer', 'mode' ) );
}

/**
 * Render the Social → Calendar screen.
 *
 * @return void
 */
function mode_social_screen_calendar() {
	mode_render_placeholder_screen( __( 'Social — Calendar', 'mode' ) );
}

/**
 * Render the Social → Accounts screen.
 *
 * @return void
 */
function mode_social_screen_accounts() {
	mode_render_placeholder_screen( __( 'Social — Accounts', 'mode' ) );
}

/**
 * Render the Social → Analytics screen.
 *
 * @return void
 */
function mode_social_screen_analytics() {
	mode_render_placeholder_screen( __( 'Social — Analytics', 'mode' ) );
}
