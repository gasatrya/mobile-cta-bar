<?php
/**
 * Frontend Renderer
 *
 * @package MobileCtaBar
 */

namespace MobileCtaBar\Frontend;

/**
 * Frontend Renderer
 */
class Renderer
{
  /**
   * Constructor.
   */
  public function __construct()
  {
    add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    add_action('wp_footer', [$this, 'render_cta_bar']);
  }

  /**
   * Enqueue frontend assets.
   */
  public function enqueue_assets()
  {
    if (!$this->should_render()) {
      return;
    }

    wp_enqueue_style(
      'mobile-cta-bar',
      MCTA_PLUGIN_URL . 'assets/css/mobile-cta-bar.css',
      [],
      MCTA_VERSION,
    );
    wp_enqueue_script(
      'mobile-cta-bar',
      MCTA_PLUGIN_URL . 'assets/js/mobile-cta-bar.js',
      [],
      MCTA_VERSION,
      true,
    );

    // Dynamic styles.
    $options = get_option('mobile_cta_bar_options', []);
    $button_color = isset($options['button_color']) ? $options['button_color'] : '#C9A96E';
    $text_color = isset($options['text_color']) ? $options['text_color'] : '#FFFFFF';

    $custom_css = "
			.mcta-button { background-color: {$button_color}; color: {$text_color}; }
			.mcta-icon svg { stroke: {$text_color}; }
			.mcta-bar { color: {$text_color}; }
		";
    wp_add_inline_style('mobile-cta-bar', $custom_css);

    // Pass delay to JS.
    $delay = isset($options['show_delay']) ? (int) $options['show_delay'] : 3;
    wp_localize_script('mobile-cta-bar', 'mctaSettings', [
      'delay' => $delay * 1000,
    ]);
  }

  /**
   * Render the CTA bar HTML in footer.
   */
  public function render_cta_bar()
  {
    if (!$this->should_render()) {
      return;
    }

    $options = get_option('mobile_cta_bar_options', []);
    $label = isset($options['button_label'])
      ? $options['button_label']
      : __('Book Now', 'mobile-cta-bar');
    $type = isset($options['action_type']) ? $options['action_type'] : 'url';
    $value = isset($options['action_value']) ? $options['action_value'] : '#';
    $icon = isset($options['button_icon']) ? $options['button_icon'] : 'none';

    $link = $this->get_cta_link($type, $value, $options);
    $svg = $this->get_icon_svg($icon);
    $size = isset($options['button_size']) ? $options['button_size'] : 'medium';
    // Basic HTML structure.
    ?>
		<div id="mcta-bar" class="mcta-bar mcta-size-<?php echo esc_attr($size); ?>">
			<a href="<?php echo esc_url($link); ?>" class="mcta-button">
				<?php if ($svg): ?>
					<span class="mcta-icon">
						<?php echo $svg;
      // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                ?>
      					</span>
      				<?php endif; ?>
              <span class="mcta-label"><?php echo esc_html($label); ?></span>
            </a>
          </div>
          <?php
        }  /**
   * Check if the CTA bar should render on the current page.
   *
   * @return bool
   */
  private function should_render()
  {
    $options = get_option('mobile_cta_bar_options', []);
    $hide_on_pages = isset($options['hide_on_pages']) ? $options['hide_on_pages'] : '';

    if (empty($hide_on_pages)) {
      return true;
    }

    $hide_list = array_map('trim', explode(',', $hide_on_pages));
    $current_id = get_the_ID();

    // Check by ID or Slug.
    foreach ($hide_list as $item) {
      if (is_numeric($item) && (int) $item === $current_id) {
        return false;
      }
      if (is_page($item) || is_single($item)) {
        return false;
      }
    }

    return true;
  }

  /**
   * Get the CTA link based on type.
   *
   * @param string $type    Action type.
   * @param string $value   Action value.
   * @param array  $options Plugin options.
   * @return string
   */
  private function get_cta_link($type, $value, $options)
  {
    switch ($type) {
      case 'phone':
        return 'tel:' . preg_replace('/[^0-9+]/', '', $value);
      case 'whatsapp':
        $message = isset($options['whatsapp_message']) ? $options['whatsapp_message'] : '';
        $phone = preg_replace('/[^0-9]/', '', $value);
        return 'https://wa.me/' . $phone . ($message ? '?text=' . rawurlencode($message) : '');
      case 'scroll':
        return '#' . ltrim($value, '#');
      case 'url':
      default:
        return $value;
    }
  }

  /**
   * Get SVG for an icon.
   *
   * @param string $icon Icon name.
   * @return string|false
   */
  private function get_icon_svg($icon)
  {
    $icons = [
      'phone' =>
        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>',
      'calendar' =>
        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>',
      'whatsapp' =>
        '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><!-- Icon from CoreUI Brands by creativeLabs Łukasz Holeczek - https://creativecommons.org/publicdomain/zero/1.0/ --><path fill="currentColor" d="M23.328 19.177c-.401-.203-2.354-1.156-2.719-1.292c-.365-.13-.63-.198-.896.203c-.26.391-1.026 1.286-1.26 1.547s-.464.281-.859.104c-.401-.203-1.682-.62-3.203-1.984c-1.188-1.057-1.979-2.359-2.214-2.76c-.234-.396-.026-.62.172-.818c.182-.182.401-.458.604-.698c.193-.24.255-.401.396-.661c.13-.281.063-.5-.036-.698s-.896-2.161-1.229-2.943c-.318-.776-.651-.677-.896-.677c-.229-.021-.495-.021-.76-.021s-.698.099-1.063.479c-.365.401-1.396 1.359-1.396 3.297c0 1.943 1.427 3.823 1.625 4.104c.203.26 2.807 4.26 6.802 5.979c.953.401 1.693.641 2.271.839c.953.302 1.823.26 2.51.161c.76-.125 2.354-.964 2.688-1.901c.339-.943.339-1.724.24-1.901c-.099-.182-.359-.281-.76-.458zM16.083 29h-.021c-2.365 0-4.703-.641-6.745-1.839l-.479-.286l-5 1.302l1.344-4.865l-.323-.5a13.17 13.17 0 0 1-2.021-7.01c0-7.26 5.943-13.182 13.255-13.182c3.542 0 6.865 1.38 9.365 3.88a13.06 13.06 0 0 1 3.88 9.323C29.328 23.078 23.39 29 16.088 29zM27.359 4.599C24.317 1.661 20.317 0 16.062 0C7.286 0 .14 7.115.135 15.859c0 2.792.729 5.516 2.125 7.927L0 32l8.448-2.203a16.1 16.1 0 0 0 7.615 1.932h.005c8.781 0 15.927-7.115 15.932-15.865c0-4.234-1.651-8.219-4.661-11.214z"/></svg>',
      'message' =>
        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>',
    ];

    return isset($icons[$icon]) ? $icons[$icon] : false;
  }
}
