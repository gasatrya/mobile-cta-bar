<?php
/**
 * Core Plugin Class
 *
 * @package MobileCtaBar
 */

namespace MobileCtaBar;

/**
 * Core Plugin Class
 */
class Core {

	/**
	 * Instance of this class.
	 *
	 * @var Core
	 */
	private static $instance = null;

	/**
	 * Get instance of this class.
	 *
	 * @return Core
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		$this->define_constants();
		$this->init();
	}

	/**
	 * Define plugin constants.
	 */
	private function define_constants() {
		define( 'MCTA_VERSION', '1.0.0' );
		define( 'MCTA_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
		define( 'MCTA_PLUGIN_URL', plugin_dir_url( __DIR__ ) );
	}

	/**
	 * Initialize plugin components.
	 */
	private function init() {
		// Initialize Admin Settings.
		if ( is_admin() ) {
			new Admin\Settings();
		}

		// Initialize Frontend Renderer.
		if ( ! is_admin() ) {
			new Frontend\Renderer();
		}
	}
}
