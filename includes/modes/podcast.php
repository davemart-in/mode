<?php
/**
 * Built-in Podcast mode.
 *
 * Registered through the public `mode_register` action — the same extension
 * point third-party plugins use.
 *
 * @package Mode
 */

defined( 'ABSPATH' ) || exit;

// Static mock screens for this mode (the render callbacks below).
require_once __DIR__ . '/podcast-screens.php';

add_action(
	'mode_register',
	function () {
		mode_register_mode(
			array(
				'id'          => 'podcast',
				'label'       => __( 'Podcast', 'mode' ),
				'icon'        => 'dashicons-microphone',
				'description' => __( 'Publish episodes and reach listeners everywhere.', 'mode' ),
				'position'    => 20,
				'screens'     => array(
					array(
						'slug'   => 'dashboard',
						'label'  => __( 'Dashboard', 'mode' ),
						'icon'   => 'dashicons-dashboard',
						'render' => 'mode_podcast_screen_dashboard',
					),
					array(
						'slug'   => 'episodes',
						'label'  => __( 'Episodes', 'mode' ),
						'icon'   => 'dashicons-format-audio',
						'render' => 'mode_podcast_screen_episodes',
					),
					array(
						'slug'   => 'recording',
						'label'  => __( 'Recording', 'mode' ),
						'icon'   => 'dashicons-microphone',
						'render' => 'mode_podcast_screen_recording',
					),
					array(
						'slug'   => 'distribution',
						'label'  => __( 'Distribution', 'mode' ),
						'icon'   => 'dashicons-rss',
						'render' => 'mode_podcast_screen_distribution',
					),
				),
			)
		);
	}
);

