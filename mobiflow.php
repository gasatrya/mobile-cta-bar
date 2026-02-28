<?php
/**
 * MobiFlow - Sticky Floating Mobile Button for Call, Messaging & Booking
 *
 * @package           MobiFlow
 * @author            Ga Satrya
 * @copyright         2026 Ga Satrya
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       MobiFlow - Sticky Floating Mobile Button for Call, Messaging & Booking
 * Plugin URI:        https://www.ctaflow.com/plugins/mobiflow
 * Description:       Add a permanent floating CTA button to your site on mobile. One tap to call, book, or message. Zero code required.
 * Version:           1.0.0
 * Requires at least: 6.5
 * Requires PHP:      8.0
 * Author:            Ga Satrya
 * Author URI:        https://www.ctaflow.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mobiflow
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Manual PSR-4 Autoloader
 */
spl_autoload_register(
	function ( $class_name ) {
		$prefix   = 'MobiFlow\\';
		$base_dir = __DIR__ . '/includes/';

		$len = strlen( $prefix );
		if ( 0 !== strncmp( $prefix, $class_name, $len ) ) {
			return;
		}

		$relative_class = substr( $class_name, $len );
		$file           = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

		if ( file_exists( $file ) ) {
			require $file;
		}
	}
);

/**
 * Initialize the plugin.
 */
function mobiflow_init() {
	// Initialize the main plugin class.
	\MobiFlow\Core::get_instance();
}
add_action( 'plugins_loaded', 'mobiflow_init' );
