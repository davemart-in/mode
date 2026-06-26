<?php
/**
 * Uninstall cleanup for the Mode plugin.
 *
 * Removes the option tracking which modes are active.
 *
 * @package Mode
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

delete_option( 'mode_active_modes' );
