<?php
/**
 * Plugin Name:       Mode
 * Plugin URI:        https://modewp.com
 * Description:       Activate focused "modes" — distraction-free spaces inside wp-admin for tasks like Newsletter, Podcast, and Social. Switch between modes from the toolbar.
 * Version:           0.1.0
 * Requires at least: 6.4
 * Requires PHP:      7.4
 * Author:            Mode
 * Author URI:        https://modewp.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mode
 *
 * @package Mode
 */

defined( 'ABSPATH' ) || exit;

define( 'MODE_VERSION', '0.1.0' );
define( 'MODE_FILE', __FILE__ );
define( 'MODE_PATH', plugin_dir_path( __FILE__ ) );
define( 'MODE_URL', plugin_dir_url( __FILE__ ) );

require_once MODE_PATH . 'includes/class-mode.php';
require_once MODE_PATH . 'includes/class-mode-registry.php';
require_once MODE_PATH . 'includes/functions.php';

/**
 * Bootstrap the plugin: give registered modes a chance to register themselves.
 *
 * Built-in modes and third-party plugins both hook the `mode_register` action and
 * call `$registry->register()` (or the `mode_register_mode()` helper). Firing this
 * on `init` means the registry is fully populated before `admin_menu` and
 * `admin_bar_menu` run.
 *
 * @return void
 */
function mode_bootstrap() {
	$registry = Mode_Registry::instance();

	/**
	 * Fires once so modes can register themselves.
	 *
	 * @param Mode_Registry $registry The shared mode registry.
	 */
	do_action( 'mode_register', $registry );
}
add_action( 'init', 'mode_bootstrap', 5 );
