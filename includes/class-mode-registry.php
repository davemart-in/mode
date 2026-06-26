<?php
/**
 * The Mode registry.
 *
 * @package Mode
 */

defined( 'ABSPATH' ) || exit;

/**
 * Holds every registered mode and tracks which are active.
 *
 * Registration is open to any plugin via the `mode_register` action (see
 * mode_bootstrap()). Activation state is persisted in the `mode_active_modes`
 * option as an array of mode ids.
 */
class Mode_Registry {

	/**
	 * Option name storing the array of active mode ids.
	 */
	const OPTION = 'mode_active_modes';

	/**
	 * Singleton instance.
	 *
	 * @var Mode_Registry|null
	 */
	protected static $instance = null;

	/**
	 * Registered modes, keyed by id.
	 *
	 * @var Mode[]
	 */
	protected $modes = array();

	/**
	 * Get the shared registry instance.
	 *
	 * @return Mode_Registry
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Private constructor — use instance().
	 */
	protected function __construct() {}

	/**
	 * Register a mode.
	 *
	 * Accepts either a Mode object or an args array (which is wrapped in a Mode).
	 * A later registration with the same id overrides an earlier one, which lets
	 * a plugin replace a built-in mode.
	 *
	 * @param Mode|array $mode Mode object or definition args.
	 * @return Mode|null The registered Mode, or null if the definition was invalid.
	 */
	public function register( $mode ) {
		if ( is_array( $mode ) ) {
			$mode = new Mode( $mode );
		}

		if ( ! $mode instanceof Mode || '' === $mode->id || '' === $mode->label ) {
			return null;
		}

		$this->modes[ $mode->id ] = $mode;

		return $mode;
	}

	/**
	 * Get a registered mode by id.
	 *
	 * @param string $id Mode id.
	 * @return Mode|null
	 */
	public function get( $id ) {
		$id = sanitize_key( $id );

		return $this->modes[ $id ] ?? null;
	}

	/**
	 * Get all registered modes, sorted by position then label.
	 *
	 * @return Mode[] Modes keyed by id.
	 */
	public function all() {
		$modes = $this->modes;

		uasort(
			$modes,
			static function ( Mode $a, Mode $b ) {
				if ( $a->position === $b->position ) {
					return strcasecmp( $a->label, $b->label );
				}

				return $a->position <=> $b->position;
			}
		);

		return $modes;
	}

	/**
	 * Get the active mode ids from the stored option, filtered to ones still registered.
	 *
	 * @return string[] Active mode ids.
	 */
	public function active_ids() {
		$stored = get_option( self::OPTION, array() );

		if ( ! is_array( $stored ) ) {
			$stored = array();
		}

		return array_values( array_intersect( array_keys( $this->modes ), $stored ) );
	}

	/**
	 * Get the active, registered modes, sorted like all().
	 *
	 * @return Mode[] Active modes keyed by id.
	 */
	public function active() {
		$active_ids = $this->active_ids();

		return array_filter(
			$this->all(),
			static function ( Mode $mode ) use ( $active_ids ) {
				return in_array( $mode->id, $active_ids, true );
			}
		);
	}

	/**
	 * Whether a given mode id is currently active.
	 *
	 * @param string $id Mode id.
	 * @return bool
	 */
	public function is_active( $id ) {
		return in_array( sanitize_key( $id ), $this->active_ids(), true );
	}
}
