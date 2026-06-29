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
					array(
						'slug'   => 'stats',
						'label'  => __( 'Stats', 'mode' ),
						'icon'   => 'dashicons-chart-bar',
						'render' => 'mode_podcast_screen_stats',
					),
				),
			)
		);
	}
);

/**
 * Render the Podcast → Episodes screen.
 *
 * @return void
 */
function mode_podcast_screen_episodes() {
	mode_render_placeholder_screen( __( 'Podcast — Episodes', 'mode' ) );
}

/**
 * Render the Podcast → Recording screen.
 *
 * @return void
 */
function mode_podcast_screen_recording() {
	mode_render_placeholder_screen( __( 'Podcast — Recording', 'mode' ) );
}

/**
 * Render the Podcast → Distribution screen.
 *
 * @return void
 */
function mode_podcast_screen_distribution() {
	mode_render_placeholder_screen( __( 'Podcast — Distribution', 'mode' ) );
}

/**
 * Render the Podcast → Stats screen.
 *
 * @return void
 */
function mode_podcast_screen_stats() {
	mode_render_placeholder_screen( __( 'Podcast — Stats', 'mode' ) );
}
