<?php
/**
 * The Mode value object.
 *
 * @package Mode
 */

defined( 'ABSPATH' ) || exit;

/**
 * Represents a single registered mode and its screens.
 *
 * A mode is an immutable description: an id, presentation metadata, and the list
 * of screens it exposes. It holds no activation state — whether a mode is active
 * lives in the registry / options.
 */
class Mode {

	/**
	 * Unique mode identifier, e.g. "newsletter". Lowercase letters, numbers, dashes.
	 *
	 * @var string
	 */
	public $id;

	/**
	 * Human-readable label, e.g. "Newsletter".
	 *
	 * @var string
	 */
	public $label;

	/**
	 * Dashicon class used in the toolbar selector and focused nav, e.g. "dashicons-email".
	 *
	 * @var string
	 */
	public $icon;

	/**
	 * Short description shown on the Settings → Mode card.
	 *
	 * @var string
	 */
	public $description;

	/**
	 * Sort order within the Mode selector (lower comes first).
	 *
	 * @var int
	 */
	public $position;

	/**
	 * Normalized list of screens. Each entry:
	 * array{ slug:string, label:string, icon:string, render:callable }.
	 *
	 * @var array[]
	 */
	public $screens;

	/**
	 * Build a Mode from a loosely-shaped args array.
	 *
	 * @param array $args {
	 *     Mode definition.
	 *
	 *     @type string $id          Required. Unique identifier.
	 *     @type string $label       Required. Display label.
	 *     @type string $icon        Optional. Dashicon class. Default "dashicons-admin-generic".
	 *     @type string $description Optional. Card description. Default empty.
	 *     @type int    $position    Optional. Selector sort order. Default 10.
	 *     @type array  $screens     Optional. List of screen definitions.
	 * }
	 */
	public function __construct( array $args ) {
		$this->id          = sanitize_key( $args['id'] ?? '' );
		$this->label       = (string) ( $args['label'] ?? '' );
		$this->icon        = (string) ( $args['icon'] ?? 'dashicons-admin-generic' );
		$this->description = (string) ( $args['description'] ?? '' );
		$this->position    = (int) ( $args['position'] ?? 10 );
		$this->screens     = $this->normalize_screens( $args['screens'] ?? array() );
	}

	/**
	 * Normalize raw screen definitions into a consistent shape, dropping invalid ones.
	 *
	 * @param array $screens Raw screen definitions.
	 * @return array[] Normalized screens.
	 */
	protected function normalize_screens( array $screens ) {
		$normalized = array();

		foreach ( $screens as $screen ) {
			if ( empty( $screen['slug'] ) ) {
				continue;
			}

			$normalized[] = array(
				'slug'   => sanitize_key( $screen['slug'] ),
				'label'  => (string) ( $screen['label'] ?? '' ),
				'icon'   => (string) ( $screen['icon'] ?? 'dashicons-admin-generic' ),
				'render' => $screen['render'] ?? null,
			);
		}

		return $normalized;
	}

	/**
	 * Get a single screen by slug.
	 *
	 * @param string $slug Screen slug.
	 * @return array|null The screen definition, or null if not found.
	 */
	public function get_screen( $slug ) {
		$slug = sanitize_key( $slug );

		foreach ( $this->screens as $screen ) {
			if ( $screen['slug'] === $slug ) {
				return $screen;
			}
		}

		return null;
	}

	/**
	 * Get the default (first) screen for this mode.
	 *
	 * @return array|null The first screen, or null if the mode has none.
	 */
	public function get_default_screen() {
		return $this->screens[0] ?? null;
	}

	/**
	 * The admin page slug WordPress uses to route this mode, e.g. "mode-newsletter".
	 *
	 * @return string
	 */
	public function page_slug() {
		return 'mode-' . $this->id;
	}
}
