<?php
/**
 * Public API and helpers for the Mode plugin.
 *
 * These wrap the registry so plugins (and the rest of this plugin) don't touch
 * the singleton directly.
 *
 * @package Mode
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register a mode.
 *
 * Intended to be called from a `mode_register` action callback:
 *
 *     add_action( 'mode_register', function () {
 *         mode_register_mode( array(
 *             'id'      => 'newsletter',
 *             'label'   => 'Newsletter',
 *             'icon'    => 'dashicons-email',
 *             'screens' => array( ... ),
 *         ) );
 *     } );
 *
 * @param array $args Mode definition. See Mode::__construct().
 * @return Mode|null The registered Mode, or null on invalid input.
 */
function mode_register_mode( array $args ) {
	return Mode_Registry::instance()->register( $args );
}

/**
 * Get all registered modes, sorted for display.
 *
 * @return Mode[] Modes keyed by id.
 */
function mode_get_all() {
	return Mode_Registry::instance()->all();
}

/**
 * Get the active modes, sorted for display.
 *
 * @return Mode[] Active modes keyed by id.
 */
function mode_get_active() {
	return Mode_Registry::instance()->active();
}

/**
 * Get a registered mode by id.
 *
 * @param string $id Mode id.
 * @return Mode|null
 */
function mode_get( $id ) {
	return Mode_Registry::instance()->get( $id );
}

/**
 * Determine the mode for the current admin request, if any.
 *
 * A request is "in a mode" when its `page` query var matches an active mode's
 * page slug (e.g. `?page=mode-newsletter`).
 *
 * @return Mode|null The current Mode, or null when not inside a mode.
 */
function mode_current() {
	if ( ! is_admin() ) {
		return null;
	}

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only routing check.
	$page = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';

	if ( '' === $page || 0 !== strpos( $page, 'mode-' ) ) {
		return null;
	}

	$id       = substr( $page, strlen( 'mode-' ) );
	$registry = Mode_Registry::instance();

	if ( ! $registry->is_active( $id ) ) {
		return null;
	}

	return $registry->get( $id );
}
