<?php
/**
 * Mobile CTA Bar – Sticky Floating Button for Call, Messaging & Booking
 *
 * @package           MobileCtaBar
 * @author            ctaflow
 * @copyright         2026 ctaflow
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Mobile CTA Bar – Sticky Floating Button for Call, Messaging & Booking
 * Plugin URI:        https://www.ctaflow.com/mobile-cta-bar
 * Description:       Add a permanent floating CTA button to your site on mobile. One tap to call, book, or message. Zero code required.
 * Version:           1.0.0
 * Requires at least: 5.9
 * Requires PHP:      7.4
 * Author:            ctaflow
 * Author URI:        https://www.ctaflow.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mobile-cta-bar
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Manual PSR-4 Autoloader
 */
spl_autoload_register(
	function ( $class_name ) {
		$prefix   = 'MobileCtaBar\\';
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
function mobile_cta_bar_init() {
	// Initialize the main plugin class.
	\MobileCtaBar\Core::get_instance();
}
add_action( 'plugins_loaded', 'mobile_cta_bar_init' );
