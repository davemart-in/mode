<?php
/**
 * Mode pages and the focused-space left nav.
 *
 * Each active mode gets a routable admin page (so `admin.php?page=mode-{id}`
 * renders) that is kept out of the normal left nav. When the current request is
 * a mode page, the left-nav globals are rewritten so the menu shows only a back
 * row (‹ Mode → Dashboard) followed by that mode's screens — a focused space
 * built entirely from core's own menu markup, so it matches wp-admin exactly.
 *
 * @package Mode
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers mode pages and swaps in the focused menu.
 */
class Mode_Admin_Menu {

	/**
	 * Capability required to open a mode.
	 */
	const CAP = 'read';

	/**
	 * Wire up the admin hooks.
	 *
	 * @return void
	 */
	public static function init() {
		$self = new self();

		// Register the routable pages early…
		add_action( 'admin_menu', array( $self, 'register_pages' ), 10 );
		// …then, very late, hide them or replace the menu with the focused one.
		add_action( 'admin_menu', array( $self, 'focus_menu' ), 9999 );
		add_action( 'admin_enqueue_scripts', array( $self, 'enqueue_assets' ) );
		add_filter( 'admin_title', array( $self, 'filter_admin_title' ), 10, 2 );
	}

	/**
	 * Give mode pages a meaningful browser-tab title.
	 *
	 * The rewritten menu means WordPress can't derive a page title on its own
	 * (it comes out empty), so set one as "Mode · Screen ‹ …" to match core's
	 * title style.
	 *
	 * @param string $admin_title The full <title> text WordPress built.
	 * @param string $title       The page-title portion (empty for mode pages).
	 * @return string
	 */
	public function filter_admin_title( $admin_title, $title ) {
		$mode = mode_current();

		if ( ! $mode ) {
			return $admin_title;
		}

		$screen = Mode_Space::current_screen( $mode );
		$page   = $screen ? $mode->label . ' · ' . $screen['label'] : $mode->label;

		// WordPress left the page portion blank; prepend ours.
		if ( '' === trim( (string) $title ) ) {
			return $page . $admin_title;
		}

		return $admin_title;
	}

	/**
	 * Register a routable admin page for each active mode.
	 *
	 * add_menu_page() registers the route (and page callback) we need; the menu
	 * entry it also creates is removed/replaced later in focus_menu().
	 *
	 * @return void
	 */
	public function register_pages() {
		foreach ( mode_get_active() as $mode ) {
			add_menu_page(
				$mode->label,
				$mode->label,
				self::CAP,
				$mode->page_slug(),
				array( 'Mode_Space', 'render' ),
				$mode->icon
			);
		}
	}

	/**
	 * Either hide the mode pages from the normal nav, or — when inside a mode —
	 * replace the whole left nav with the focused menu.
	 *
	 * @return void
	 */
	public function focus_menu() {
		$current = mode_current();

		if ( ! $current ) {
			// Not in a mode: keep the normal nav clean.
			foreach ( mode_get_active() as $mode ) {
				remove_menu_page( $mode->page_slug() );
			}
			return;
		}

		$this->build_focused_menu( $current );
	}

	/**
	 * Replace the left-nav globals with the focused menu for a mode.
	 *
	 * @param Mode $mode The current mode.
	 * @return void
	 */
	protected function build_focused_menu( Mode $mode ) {
		global $menu, $submenu;

		$active  = Mode_Space::current_screen( $mode );
		$active  = $active ? $active['slug'] : '';
		$menu    = array();
		$submenu = array();

		// Back / header row: chevron + mode name, links to the Dashboard.
		$menu[0] = array(
			esc_html( $mode->label ),
			self::CAP,
			'index.php',
			$mode->label,
			'menu-top mode-space__back',
			'menu-mode-back',
			'dashicons-arrow-left-alt2',
		);

		// One row per screen.
		$position = 5;

		foreach ( $mode->screens as $screen ) {
			$classes = 'menu-top mode-space__screen';

			if ( $screen['slug'] === $active ) {
				$classes .= ' current';
			}

			$menu[ $position ] = array(
				esc_html( $screen['label'] ),
				self::CAP,
				Mode_Space::screen_url( $mode, $screen['slug'] ),
				$screen['label'],
				$classes,
				'menu-mode-' . $mode->id . '-' . $screen['slug'],
				$screen['icon'],
			);

			++$position;
		}

		ksort( $menu );
	}

	/**
	 * Enqueue the stylesheet on mode pages (focused-space chrome).
	 *
	 * @return void
	 */
	public function enqueue_assets() {
		if ( ! mode_current() ) {
			return;
		}

		wp_enqueue_style(
			'mode-admin',
			MODE_URL . 'assets/css/mode-admin.css',
			array(),
			MODE_VERSION
		);
	}
}
