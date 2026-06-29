<?php
/**
 * The focused space content router.
 *
 * Every active mode registers a single admin page whose callback is
 * Mode_Space::render(). The specific screen is selected with a `screen` query
 * arg (e.g. `admin.php?page=mode-newsletter&screen=subscribers`); with none, the
 * mode's first screen is shown.
 *
 * @package Mode
 */

defined( 'ABSPATH' ) || exit;

/**
 * Routes and renders a mode's screens.
 */
class Mode_Space {

	/**
	 * Render the current screen for the current mode.
	 *
	 * Registered as the page callback for every mode page.
	 *
	 * @return void
	 */
	public static function render() {
		$mode = mode_current();

		if ( ! $mode ) {
			return;
		}

		$screen = self::current_screen( $mode );

		if ( $screen && is_callable( $screen['render'] ) ) {
			call_user_func( $screen['render'] );
			return;
		}

		// Mode with no (renderable) screens — show a minimal placeholder.
		echo '<div class="wrap"><h1>' . esc_html( $mode->label ) . '</h1></div>';
	}

	/**
	 * Resolve the screen for the current request.
	 *
	 * Falls back to the mode's first screen when the `screen` arg is missing or
	 * doesn't match one of the mode's screens.
	 *
	 * @param Mode $mode The current mode.
	 * @return array|null The resolved screen, or null if the mode has none.
	 */
	public static function current_screen( Mode $mode ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only routing.
		$slug   = isset( $_GET['screen'] ) ? sanitize_key( wp_unslash( $_GET['screen'] ) ) : '';
		$screen = $slug ? $mode->get_screen( $slug ) : null;

		return $screen ? $screen : $mode->get_default_screen();
	}

	/**
	 * Build the admin URL for a given screen of a mode.
	 *
	 * @param Mode   $mode        The mode.
	 * @param string $screen_slug The screen slug.
	 * @return string Admin URL.
	 */
	public static function screen_url( Mode $mode, $screen_slug ) {
		return admin_url( 'admin.php?page=' . $mode->page_slug() . '&screen=' . $screen_slug );
	}
}
