<?php
/**
 * The Mode selector in the admin toolbar.
 *
 * Adds a "Mode" dropdown to the far right of the toolbar (just left of the
 * account menu) listing the active modes plus a deep link to Settings → Modes.
 * Because the dropdown renders on every screen, you can switch from one mode to
 * another without first returning to wp-admin.
 *
 * @package Mode
 */

defined( 'ABSPATH' ) || exit;

/**
 * Builds and styles the toolbar Mode selector.
 */
class Mode_Admin_Bar {

	/**
	 * Top-level node id.
	 */
	const NODE = 'mode-selector';

	/**
	 * Dashicon shown on the selector when not inside a mode.
	 */
	const DEFAULT_ICON = 'dashicons-screenoptions';

	/**
	 * Wire up the toolbar hooks.
	 *
	 * Within `top-secondary` the `<li>` items float left, so source order reads
	 * left-to-right. The account menu is added at priority 9991, so adding ours
	 * at 9990 places it immediately to the left of "Howdy, …".
	 *
	 * @return void
	 */
	public static function init() {
		$self = new self();

		add_action( 'admin_bar_menu', array( $self, 'add_menu' ), 9990 );
		add_action( 'admin_enqueue_scripts', array( $self, 'enqueue_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $self, 'enqueue_assets' ) );
	}

	/**
	 * Add the Mode selector and its children to the toolbar.
	 *
	 * @param WP_Admin_Bar $bar The toolbar instance.
	 * @return void
	 */
	public function add_menu( $bar ) {
		$active     = mode_get_active();
		$can_manage = current_user_can( 'manage_options' );

		// Nothing useful to show — skip the node entirely.
		if ( empty( $active ) && ! $can_manage ) {
			return;
		}

		$current = mode_current();

		// Top-level node: reflects the current mode when inside one.
		$icon  = $current ? $current->icon : self::DEFAULT_ICON;
		$label = $current ? $current->label : __( 'Mode', 'mode' );

		$bar->add_node(
			array(
				'id'     => self::NODE,
				'parent' => 'top-secondary',
				'title'  => sprintf(
					'<span class="ab-icon dashicons %s" aria-hidden="true"></span><span class="ab-label">%s</span>',
					esc_attr( $icon ),
					esc_html( $label )
				),
				'href'   => $can_manage ? Mode_Settings::url() : false,
				'meta'   => array( 'title' => __( 'Switch mode', 'mode' ) ),
			)
		);

		// One child per active mode.
		foreach ( $active as $mode ) {
			$is_current = $current && $current->id === $mode->id;

			$bar->add_node(
				array(
					'id'     => self::NODE . '-' . $mode->id,
					'parent' => self::NODE,
					'title'  => esc_html( $mode->label ),
					'href'   => admin_url( 'admin.php?page=' . $mode->page_slug() ),
					'meta'   => $is_current ? array( 'class' => 'mode-current' ) : array(),
				)
			);
		}

		// Settings deep link, in its own group so it gets a divider.
		if ( $can_manage ) {
			$bar->add_group(
				array(
					'id'     => self::NODE . '-actions',
					'parent' => self::NODE,
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			$bar->add_node(
				array(
					'id'     => self::NODE . '-manage',
					'parent' => self::NODE . '-actions',
					'title'  => __( 'Manage modes…', 'mode' ),
					'href'   => Mode_Settings::url(),
				)
			);
		}
	}

	/**
	 * Enqueue the toolbar stylesheet wherever the toolbar is showing.
	 *
	 * @return void
	 */
	public function enqueue_assets() {
		if ( ! is_admin_bar_showing() ) {
			return;
		}

		wp_enqueue_style(
			'mode-admin-bar',
			MODE_URL . 'assets/css/mode-admin-bar.css',
			array( 'admin-bar', 'dashicons' ),
			MODE_VERSION
		);
	}
}
