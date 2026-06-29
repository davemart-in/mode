<?php
/**
 * Settings → Modes admin page.
 *
 * Lists every registered mode as a row and lets an administrator toggle each
 * one on or off. Activation state is stored in the `mode_active_modes` option.
 *
 * Layout reuses core admin styles rather than reinventing them: `.wrap` + `<h1>`
 * for the header, `.description` for the subtitle, `.card` for each row box, and
 * core `.button` / `.button-primary` for the actions. The only custom CSS is the
 * flex layout for a row (icon tile · title + description · action), which core
 * has no ready-made class for. The visual result mirrors the core Connectors
 * screen (Settings → Connectors), which is itself a React app and so can't be
 * referenced directly from a plain PHP page.
 *
 * @package Mode
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders and handles the Settings → Modes screen.
 */
class Mode_Settings {

	/**
	 * Menu/page slug. The Mode selector deep-links here.
	 */
	const SLUG = 'mode-settings';

	/**
	 * admin-post.php action used by the toggle forms.
	 */
	const ACTION = 'mode_toggle_mode';

	/**
	 * The page hook suffix returned by add_options_page(), used to scope assets.
	 *
	 * @var string
	 */
	protected $hook_suffix = '';

	/**
	 * Wire up the admin hooks. Safe to call on every request — the hooks only
	 * fire in admin context.
	 *
	 * @return void
	 */
	public static function init() {
		$self = new self();

		add_action( 'admin_menu', array( $self, 'register_page' ) );
		add_action( 'admin_enqueue_scripts', array( $self, 'enqueue_assets' ) );
		add_action( 'admin_post_' . self::ACTION, array( $self, 'handle_toggle' ) );
	}

	/**
	 * Register the page under Settings.
	 *
	 * @return void
	 */
	public function register_page() {
		$this->hook_suffix = add_options_page(
			__( 'Modes', 'mode' ),
			__( 'Modes', 'mode' ),
			'manage_options',
			self::SLUG,
			array( $this, 'render_page' )
		);
	}

	/**
	 * Enqueue the stylesheet, only on the Modes screen.
	 *
	 * @param string $hook_suffix Current admin page hook suffix.
	 * @return void
	 */
	public function enqueue_assets( $hook_suffix ) {
		if ( $hook_suffix !== $this->hook_suffix ) {
			return;
		}

		wp_enqueue_style(
			'mode-admin',
			MODE_URL . 'assets/css/mode-admin.css',
			array(),
			MODE_VERSION
		);
	}

	/**
	 * The URL of this settings page.
	 *
	 * @return string
	 */
	public static function url() {
		return admin_url( 'options-general.php?page=' . self::SLUG );
	}

	/**
	 * Render the settings page.
	 *
	 * @return void
	 */
	public function render_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$registry = Mode_Registry::instance();
		$modes    = $registry->all();
		?>
		<div class="wrap mode-modes" id="mode-settings">
			<div class="mode-modes__header">
				<h1><?php esc_html_e( 'Modes', 'mode' ); ?></h1>
				<p class="description">
					<?php esc_html_e( 'Activate a mode to add it to the Mode menu in the toolbar. Each mode is a focused space for one kind of work.', 'mode' ); ?>
				</p>
			</div>
			<hr />
			<div class="mode-modes__inner">
				<div class="mode-modes__content">
					<?php $this->maybe_render_notice( $registry ); ?>

					<?php if ( empty( $modes ) ) : ?>
						<div class="notice notice-info inline"><p><?php esc_html_e( 'No modes are available yet.', 'mode' ); ?></p></div>
					<?php else : ?>
						<?php
						foreach ( $modes as $mode ) {
							$this->render_row( $mode, $registry->is_active( $mode->id ) );
						}
						?>
						<p class="description mode-modes__footer">
							<?php esc_html_e( 'Looking for more? Other plugins can add their own modes.', 'mode' ); ?>
						</p>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render a single mode row with its toggle form.
	 *
	 * @param Mode $mode      The mode to render.
	 * @param bool $is_active Whether the mode is currently active.
	 * @return void
	 */
	protected function render_row( Mode $mode, $is_active ) {
		$next_state   = $is_active ? 'deactivate' : 'activate';
		$button_text  = $is_active ? __( 'Deactivate', 'mode' ) : __( 'Activate', 'mode' );
		$button_class = $is_active ? 'button' : 'button button-primary';
		?>
		<div class="card mode-row">
			<span class="mode-row__icon"><span class="dashicons <?php echo esc_attr( $mode->icon ); ?>"></span></span>
			<div class="mode-row__text">
				<h2 class="mode-row__title"><?php echo esc_html( $mode->label ); ?></h2>
				<p class="mode-row__desc"><?php echo esc_html( $mode->description ); ?></p>
			</div>
			<div class="mode-row__action">
				<?php if ( $is_active ) : ?>
					<span class="mode-row__status"><?php esc_html_e( 'Active', 'mode' ); ?></span>
				<?php endif; ?>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="<?php echo esc_attr( self::ACTION ); ?>" />
					<input type="hidden" name="mode_id" value="<?php echo esc_attr( $mode->id ); ?>" />
					<input type="hidden" name="mode_state" value="<?php echo esc_attr( $next_state ); ?>" />
					<?php wp_nonce_field( self::ACTION . '_' . $mode->id ); ?>
					<button type="submit" class="<?php echo esc_attr( $button_class ); ?> is-compact"><?php echo esc_html( $button_text ); ?></button>
				</form>
			</div>
		</div>
		<?php
	}

	/**
	 * Handle a toggle form submission, then redirect back to the settings page.
	 *
	 * @return void
	 */
	public function handle_toggle() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have permission to manage modes.', 'mode' ) );
		}

		$mode_id = isset( $_POST['mode_id'] ) ? sanitize_key( wp_unslash( $_POST['mode_id'] ) ) : '';

		check_admin_referer( self::ACTION . '_' . $mode_id );

		$state    = ( isset( $_POST['mode_state'] ) && 'activate' === $_POST['mode_state'] ) ? 'activate' : 'deactivate';
		$registry = Mode_Registry::instance();

		// Only act on a real, registered mode.
		if ( $registry->get( $mode_id ) ) {
			$active = $registry->active_ids();

			if ( 'activate' === $state ) {
				$active[] = $mode_id;
			} else {
				$active = array_diff( $active, array( $mode_id ) );
			}

			update_option( Mode_Registry::OPTION, array_values( array_unique( $active ) ) );
		}

		wp_safe_redirect(
			add_query_arg(
				array(
					'page'    => self::SLUG,
					'toggled' => $mode_id,
					'state'   => $state,
				),
				admin_url( 'options-general.php' )
			)
		);
		exit;
	}

	/**
	 * Render a success notice after a toggle, if one just happened.
	 *
	 * @param Mode_Registry $registry The registry, for looking up the mode label.
	 * @return void
	 */
	protected function maybe_render_notice( Mode_Registry $registry ) {
		// phpcs:disable WordPress.Security.NonceVerification.Recommended -- read-only display of post-redirect state.
		$toggled = isset( $_GET['toggled'] ) ? sanitize_key( wp_unslash( $_GET['toggled'] ) ) : '';
		$state   = isset( $_GET['state'] ) ? sanitize_key( wp_unslash( $_GET['state'] ) ) : '';
		// phpcs:enable WordPress.Security.NonceVerification.Recommended

		$mode = $toggled ? $registry->get( $toggled ) : null;

		if ( ! $mode ) {
			return;
		}

		$message = 'activate' === $state
			/* translators: %s: mode label. */
			? sprintf( __( '%s mode activated.', 'mode' ), $mode->label )
			/* translators: %s: mode label. */
			: sprintf( __( '%s mode deactivated.', 'mode' ), $mode->label );
		?>
		<div class="notice notice-success is-dismissible"><p><?php echo esc_html( $message ); ?></p></div>
		<?php
	}
}
