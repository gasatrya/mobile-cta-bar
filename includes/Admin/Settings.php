<?php
/**
 * Admin Settings Handler
 *
 * @package MobileCtaBar
 */

namespace MobileCtaBar\Admin;

/**
 * Admin Settings Handler
 */
class Settings {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_init', array( $this, 'handle_reset' ) );
		add_action( 'admin_notices', array( $this, 'reset_notice' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	/**
	 * Enqueue admin assets.
	 *
	 * @param string $hook The current admin page hook.
	 */
	public function enqueue_assets( $hook ) {
		if ( 'settings_page_mobile-cta-bar' !== $hook ) {
			return;
		}

		wp_enqueue_script(
			'mcta-admin-settings',
			MCTA_PLUGIN_URL . 'assets/js/admin-settings.js',
			array(),
			MCTA_VERSION,
			true
		);

		wp_enqueue_style(
			'mcta-admin-settings',
			MCTA_PLUGIN_URL . 'assets/css/admin-settings.css',
			array(),
			MCTA_VERSION
		);
	}

	/**
	 * Handle reset action.
	 */
	public function handle_reset() {
		if ( ! isset( $_POST['mcta_reset'] ) || ! isset( $_POST['_wpnonce'] ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( ! check_admin_referer( 'mobile_cta_bar_settings-options' ) ) {
			return;
		}

		delete_option( 'mobile_cta_bar_options' );

		wp_safe_redirect(
			add_query_arg(
				array(
					'page'             => 'mobile-cta-bar',
					'settings-updated' => 'reset',
				),
				admin_url( 'options-general.php' )
			)
		);
		exit;
	}

	/**
	 * Display reset notice.
	 */
	public function reset_notice() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['settings-updated'] ) && 'reset' === $_GET['settings-updated'] ) {
			?>
			<div class="updated notice is-dismissible">
				<p><?php esc_html_e( 'Settings have been reset to defaults.', 'mobile-cta-bar' ); ?></p>
			</div>
			<?php
		}
	}

	/**
	 * Add settings page to the menu.
	 */
	public function add_settings_page() {
		add_options_page(
			__( 'Mobile CTA Bar Settings', 'mobile-cta-bar' ),
			__( 'Mobile CTA Bar', 'mobile-cta-bar' ),
			'manage_options',
			'mobile-cta-bar',
			array( $this, 'render_settings_page' )
		);
	}

	/**
	 * Register settings.
	 */
	public function register_settings() {
		register_setting(
			'mobile_cta_bar_settings',
			'mobile_cta_bar_options',
			array( $this, 'sanitize_options' )
		);

		add_settings_section(
			'mcta_main_section',
			__( 'Button Configuration', 'mobile-cta-bar' ),
			null,
			'mobile-cta-bar'
		);

		add_settings_field(
			'button_label',
			__( 'Button Label', 'mobile-cta-bar' ),
			array( $this, 'render_text_field' ),
			'mobile-cta-bar',
			'mcta_main_section',
			array(
				'label_for'   => 'button_label',
				'placeholder' => __( 'e.g. Book Now', 'mobile-cta-bar' ),
				'description' => __( 'The text that appears on your floating button.', 'mobile-cta-bar' ),
			)
		);

		add_settings_field(
			'button_icon',
			__( 'Button Icon', 'mobile-cta-bar' ),
			array( $this, 'render_select_field' ),
			'mobile-cta-bar',
			'mcta_main_section',
			array(
				'label_for'   => 'button_icon',
				'options'     => array(
					'none'     => __( 'No Icon', 'mobile-cta-bar' ),
					'phone'    => __( 'Phone', 'mobile-cta-bar' ),
					'calendar' => __( 'Calendar', 'mobile-cta-bar' ),
					'whatsapp' => __( 'WhatsApp', 'mobile-cta-bar' ),
					'message'  => __( 'Message', 'mobile-cta-bar' ),
				),
				'description' => __( 'Choose an icon to display next to your button label.', 'mobile-cta-bar' ),
			)
		);

		add_settings_field(
			'action_type',
			__( 'Action Type', 'mobile-cta-bar' ),
			array( $this, 'render_select_field' ),
			'mobile-cta-bar',
			'mcta_main_section',
			array(
				'label_for'   => 'action_type',
				'options'     => array(
					'phone'    => __( 'Phone Call', 'mobile-cta-bar' ),
					'url'      => __( 'Open URL', 'mobile-cta-bar' ),
					'whatsapp' => __( 'WhatsApp Chat', 'mobile-cta-bar' ),
					'scroll'   => __( 'Smooth Scroll (#id)', 'mobile-cta-bar' ),
				),
				'description' => __( 'What should happen when the user taps the button?', 'mobile-cta-bar' ),
			)
		);

		add_settings_field(
			'action_value',
			__( 'Action Value', 'mobile-cta-bar' ),
			array( $this, 'render_text_field' ),
			'mobile-cta-bar',
			'mcta_main_section',
			array(
				'label_for'   => 'action_value',
				'placeholder' => __( 'Phone number, URL, or #element-id', 'mobile-cta-bar' ),
				'description' => __( 'Enter the phone number (with country code), the destination URL, or the #element-id to scroll to.', 'mobile-cta-bar' ),
			)
		);

		add_settings_field(
			'whatsapp_message',
			__( 'WhatsApp Message', 'mobile-cta-bar' ),
			array( $this, 'render_text_field' ),
			'mobile-cta-bar',
			'mcta_main_section',
			array(
				'label_for'   => 'whatsapp_message',
				'placeholder' => __( 'Hi, I\'m interested...', 'mobile-cta-bar' ),
				'description' => __( 'The pre-filled message that will appear when the user starts the WhatsApp chat.', 'mobile-cta-bar' ),
			)
		);

		add_settings_section(
			'mcta_style_section',
			__( 'Appearance & Behavior', 'mobile-cta-bar' ),
			null,
			'mobile-cta-bar'
		);

		add_settings_field(
			'button_color',
			__( 'Button Color', 'mobile-cta-bar' ),
			array( $this, 'render_color_field' ),
			'mobile-cta-bar',
			'mcta_style_section',
			array(
				'label_for'   => 'button_color',
				'default'     => '#C9A96E',
				'description' => __( 'The background color of your floating button.', 'mobile-cta-bar' ),
			)
		);

		add_settings_field(
			'text_color',
			__( 'Text Color', 'mobile-cta-bar' ),
			array( $this, 'render_color_field' ),
			'mobile-cta-bar',
			'mcta_style_section',
			array(
				'label_for'   => 'text_color',
				'default'     => '#FFFFFF',
				'description' => __( 'The color of the label and icon on the button.', 'mobile-cta-bar' ),
			)
		);

		add_settings_field(
			'button_size',
			__( 'Button Size', 'mobile-cta-bar' ),
			array( $this, 'render_select_field' ),
			'mobile-cta-bar',
			'mcta_style_section',
			array(
				'label_for'   => 'button_size',
				'options'     => array(
					'small'  => __( 'Small', 'mobile-cta-bar' ),
					'medium' => __( 'Medium (Default)', 'mobile-cta-bar' ),
					'large'  => __( 'Large', 'mobile-cta-bar' ),
				),
				'default'     => 'medium',
				'description' => __( 'Adjust the overall size of the floating button.', 'mobile-cta-bar' ),
			)
		);

		add_settings_field(
			'show_delay',
			__( 'Show After (seconds)', 'mobile-cta-bar' ),
			array( $this, 'render_number_field' ),
			'mobile-cta-bar',
			'mcta_style_section',
			array(
				'label_for'   => 'show_delay',
				'default'     => 3,
				'description' => __( 'How many seconds to wait after the page loads before showing the button.', 'mobile-cta-bar' ),
			)
		);

		add_settings_field(
			'hide_on_pages',
			__( 'Hide on Pages', 'mobile-cta-bar' ),
			array( $this, 'render_text_field' ),
			'mobile-cta-bar',
			'mcta_style_section',
			array(
				'label_for'   => 'hide_on_pages',
				'placeholder' => __( 'e.g. contact, checkout (slugs or IDs)', 'mobile-cta-bar' ),
				'description' => __( 'Comma-separated list of page slugs or IDs where the button should NOT be displayed.', 'mobile-cta-bar' ),
			)
		);
	}

	/**
	 * Sanitize options.
	 *
	 * @param array $input Input data.
	 * @return array Sanitized data.
	 */
	public function sanitize_options( $input ) {
		$sanitized = array();

		if ( isset( $input['button_label'] ) ) {
			$sanitized['button_label'] = sanitize_text_field( $input['button_label'] );
		}

		if ( isset( $input['button_icon'] ) ) {
			$sanitized['button_icon'] = sanitize_key( $input['button_icon'] );
		}

		if ( isset( $input['action_type'] ) ) {
			$sanitized['action_type'] = sanitize_key( $input['action_type'] );
		}

		if ( isset( $input['action_value'] ) ) {
			if ( 'url' === $sanitized['action_type'] ) {
				$sanitized['action_value'] = esc_url_raw( $input['action_value'] );
			} else {
				$sanitized['action_value'] = sanitize_text_field( $input['action_value'] );
			}
		}

		if ( isset( $input['whatsapp_message'] ) ) {
			$sanitized['whatsapp_message'] = sanitize_text_field( $input['whatsapp_message'] );
		}

		if ( isset( $input['button_color'] ) ) {
			$sanitized['button_color'] = sanitize_hex_color( $input['button_color'] );
		}

		if ( isset( $input['text_color'] ) ) {
			$sanitized['text_color'] = sanitize_hex_color( $input['text_color'] );
		}

		if ( isset( $input['button_size'] ) ) {
			$sanitized['button_size'] = sanitize_key( $input['button_size'] );
		}

		if ( isset( $input['show_delay'] ) ) {
			$sanitized['show_delay'] = absint( $input['show_delay'] );
		}

		if ( isset( $input['hide_on_pages'] ) ) {
			$sanitized['hide_on_pages'] = sanitize_text_field( $input['hide_on_pages'] );
		}

		return $sanitized;
	}

	/**
	 * Render text field.
	 *
	 * @param array $args Field arguments.
	 */
	public function render_text_field( $args ) {
		$options     = get_option( 'mobile_cta_bar_options', array() );
		$value       = isset( $options[ $args['label_for'] ] ) ? $options[ $args['label_for'] ] : '';
		$placeholder = isset( $args['placeholder'] ) ? $args['placeholder'] : '';
		?>
		<input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="mobile_cta_bar_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo esc_attr( $value ); ?>" class="regular-text" placeholder="<?php echo esc_attr( $placeholder ); ?>">
		<?php if ( isset( $args['description'] ) ) : ?>
			<p class="description"><?php echo esc_html( $args['description'] ); ?></p>
		<?php endif; ?>
		<?php
	}

	/**
	 * Render select field.
	 *
	 * @param array $args Field arguments.
	 */
	public function render_select_field( $args ) {
		$options = get_option( 'mobile_cta_bar_options', array() );
		$default = isset( $args['default'] ) ? $args['default'] : '';
		$value   = isset( $options[ $args['label_for'] ] ) ? $options[ $args['label_for'] ] : $default;
		?>
		<select id="<?php echo esc_attr( $args['label_for'] ); ?>" name="mobile_cta_bar_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
			<?php foreach ( $args['options'] as $key => $label ) : ?>
				<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $value, $key ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>
		</select>
		<?php if ( isset( $args['description'] ) ) : ?>
			<p class="description"><?php echo esc_html( $args['description'] ); ?></p>
		<?php endif; ?>
		<?php
	}

	/**
	 * Render color field.
	 *
	 * @param array $args Field arguments.
	 */
	public function render_color_field( $args ) {
		$options = get_option( 'mobile_cta_bar_options', array() );
		$value   = ! empty( $options[ $args['label_for'] ] ) ? $options[ $args['label_for'] ] : $args['default'];
		?>
		<input type="color" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="mobile_cta_bar_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo esc_attr( $value ); ?>">
		<?php if ( isset( $args['description'] ) ) : ?>
			<p class="description"><?php echo esc_html( $args['description'] ); ?></p>
		<?php endif; ?>
		<?php
	}

	/**
	 * Render number field.
	 *
	 * @param array $args Field arguments.
	 */
	public function render_number_field( $args ) {
		$options = get_option( 'mobile_cta_bar_options', array() );
		$value   = isset( $options[ $args['label_for'] ] ) ? $options[ $args['label_for'] ] : $args['default'];
		?>
		<input type="number" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="mobile_cta_bar_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo esc_attr( $value ); ?>" class="small-text" min="0">
		<?php if ( isset( $args['description'] ) ) : ?>
			<p class="description"><?php echo esc_html( $args['description'] ); ?></p>
		<?php endif; ?>
		<?php
	}

	/**
	 * Render the settings page.
	 */
	public function render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

			<div class="mcta-settings-wrapper">
				<div class="mcta-settings-form">
					<form action="options.php" method="post">
						<?php
						settings_fields( 'mobile_cta_bar_settings' );
						do_settings_sections( 'mobile-cta-bar' );
						?>
						<div class="mcta-settings-actions" style="margin-top: 20px;">
							<?php submit_button( __( 'Save Changes', 'mobile-cta-bar' ), 'primary', 'submit', false ); ?>
							<?php
							submit_button(
								__( 'Reset to Defaults', 'mobile-cta-bar' ),
								'secondary',
								'mcta_reset',
								false,
								array(
									'onclick' => 'return confirm("' . esc_js( __( 'Are you sure you want to reset all settings to defaults?', 'mobile-cta-bar' ) ) . '");',
								)
							);
							?>
						</div>
					</form>
				</div>

				<div class="mcta-settings-preview">
					<div class="mcta-sidebar-box" style="margin-bottom: 20px; background: #fff; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04); padding: 20px; border-radius: 4px;">
						<h2 style="margin-top: 0; font-size: 14px; border-bottom: 1px solid #eee; padding-bottom: 10px;"><?php esc_html_e( 'Is Your Site Leaking Revenue?', 'mobile-cta-bar' ); ?></h2>
						<p><?php esc_html_e( 'Take the 2-minute audit to identify the hidden conversion leaks costing you customers.', 'mobile-cta-bar' ); ?></p>
						<p>
							<a href="https://www.ctaflow.com/tools/website-health-audit/?utm_source=plugin&utm_medium=mcta-sidebar" target="_blank" class="button button-primary" style="width: 100%; text-align: center; box-sizing: border-box;">
								<?php esc_html_e( 'Get Your Free Audit', 'mobile-cta-bar' ); ?>
							</a>
						</p>
						<hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
						<p style="margin-bottom: 0;">
							<span class="dashicons dashicons-star-filled" style="color: #ffb900; vertical-align: middle;"></span>
							<a href="https://wordpress.org/support/plugin/mobile-cta-bar/reviews/#new-post" target="_blank" style="text-decoration: none; vertical-align: middle;">
								<?php esc_html_e( 'Rate this plugin', 'mobile-cta-bar' ); ?>
							</a>
						</p>
					</div>

					<div class="mcta-preview-container">
						<h2><?php esc_html_e( 'Live Preview', 'mobile-cta-bar' ); ?></h2>
						<div class="mcta-preview-window">
							<div id="mcta-preview-button" class="mcta-preview-button">
								<span class="mcta-preview-icon"></span>
								<span class="mcta-preview-label"></span>
							</div>
						</div>
						<p class="description"><?php esc_html_e( 'Note: This is a preview of how the button looks. Positioning and animation only apply on the live site.', 'mobile-cta-bar' ); ?></p>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
