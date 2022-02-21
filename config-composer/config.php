<?php

if ( !class_exists('Cryptex_Vc_Config') ) {
	class Cryptex_Vc_Config
	{

		public $paths = array();
		private static $_instance;

		function __construct()
		{

			$dir = get_theme_file_path('config-composer');

			$this->paths = array(
				'APP_ROOT' => $dir,
				'HELPERS_DIR' => $dir . '/helpers',
				'CONFIG_DIR' => $dir . '/config',
				'ASSETS_DIR_NAME' => 'assets',
				'BASE_URI' => get_theme_file_uri('config-composer/'),
				'PARTS_VIEWS_DIR' => $dir . '/shortcodes/views/',
				'TEMPLATES_DIR' => $dir . '/shortcodes/',
				'MODULES_DIR' => $dir . '/modules/'
			);

			require_once $this->path('HELPERS_DIR', 'helpers.php');

			// Load
			$this->autoloadLibraries($this->path('TEMPLATES_DIR'));
			$this->init();

			// Add New param
			$this->add_hooks();
			$this->ShortcodeParams();
		}

		/**
		 *
		 * @return self
		 */
		public static function getInstance()
		{
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init()
		{

			add_action('vc_build_admin_page', array($this, 'autoremoveElements'), 11);
			add_action('vc_load_shortcode', array($this, 'autoremoveElements'), 11);

			if (is_admin()) {
				add_action('load-post.php', array($this, 'admin_init'), 4);
				add_action('load-post-new.php', array($this, 'admin_init'), 4);
			} else {
				add_action('wp_enqueue_scripts', array($this, 'front_init'), 5);
			}

		}

		public function add_hooks()
		{
			add_action('vc_before_init', array($this, 'before_init'), 1);
			add_filter('vc_font_container_get_allowed_tags', array($this, 'font_container_get_allowed_tags'));
			add_action('init', array($this, 'ajax_hooks'));
		}

		public function before_init()
		{
			require_once($this->path('CONFIG_DIR', 'map.php'));
			$this->autoloadLibraries($this->path('MODULES_DIR'));
		}

		public $removeElements = array();
		public $removeParams = array();

		public function ajax_hooks()
		{

		}

		public function ShortcodeParams()
		{
			WpbakeryShortcodeParams::addField('choose_icons', array($this, 'param_icon_field'), $this->assetUrl('js/js_shortcode_param_icon.js'));
			WpbakeryShortcodeParams::addField('table_number', array($this, 'param_table_number_field'), $this->assetUrl('js/js_shortcode_tables.js'));
			WpbakeryShortcodeParams::addField('table_hidden', array($this, 'param_hidden_field'));
			WpbakeryShortcodeParams::addField('datetimepicker', array($this, 'param_datetimepicker'), $this->assetUrl('js/bootstrap-datetimepicker.min.js'));
			WpbakeryShortcodeParams::addField('number', array($this, 'param_number_field'));
			WpbakeryShortcodeParams::addField('get_terms', array($this, 'param_woocommerce_terms'), $this->assetUrl('js/js_shortcode_products.js'));
			WpbakeryShortcodeParams::addField('get_by_id', array($this, 'param_woocommerce_get_by_id'), $this->assetUrl('js/js_shortcode_products.js'));
			WpbakeryShortcodeParams::addField('dropdown_multi', array($this, 'dropdown_multi_settings_field'));

			vc_remove_param('vc_column', 'css_animation');

		}

		function dropdown_multi_settings_field( $param, $value ) {
			$param_line = '';
			$param_line .= '<select multiple name="'. esc_attr( $param['param_name'] ).'" class="wpb_vc_param_value wpb-input wpb-select '. esc_attr( $param['param_name'] ).' '. esc_attr($param['type']).'">';
			foreach ( $param['value'] as $text_val => $val ) {
				if ( is_numeric($text_val) && (is_string($val) || is_numeric($val)) ) {
					$text_val = $val;
				}
				$selected = '';

				if(!is_array($value)) {
					$param_value_arr = explode(',',$value);
				} else {
					$param_value_arr = $value;
				}

				if ($value!=='' && in_array($val, $param_value_arr)) {
					$selected = ' selected="selected"';
				}
				$param_line .= '<option value="'.$val.'"'.$selected.'>'.$text_val.'</option>';
			}
			$param_line .= '</select>';

			return  $param_line;
		}

		public function admin_init()
		{
			add_action('admin_enqueue_scripts', array($this, 'admin_extend_js_css'));
		}

		public function front_init()
		{
			$this->enqueue_styles();
			$this->enqueue_js();

		}

		public function admin_extend_js_css()
		{
			wp_enqueue_style('cryptex-extend-admin', $this->assetUrl('css/js_composer_backend_editor.css'), false, WPB_VC_VERSION);
			wp_enqueue_style('cryptex-admin-linear', get_theme_file_uri('css/linear-icons.css'), false, WPB_VC_VERSION);
			wp_enqueue_style('cryptex-bootstrap-datetimepicker', $this->assetUrl('css/bootstrap-datetimepicker-admin.css'), false, WPB_VC_VERSION);

			wp_localize_script('cryptex-extend-admin', 'cryptex_admin_global_vars', array(
				'template_base_uri' => get_template_directory_uri() . '/'
			));
		}

		public function path($name, $file = '')
		{
			$path = $this->paths[$name] . (strlen($file) > 0 ? '/' . preg_replace('/^\//', '', $file) : '');
			return $path;
		}

		public function enqueue_styles()
		{
			$front_css_file = $this->assetUrl('css/css_composer_front.css');
			wp_enqueue_style('cryptex-js-composer-front', $front_css_file, array('js_composer_front'), WPB_VC_VERSION, 'all');
		}

		public function enqueue_js()
		{

			if (is_page()) {

				global $post;

				if (!$post) return false;

				$post_content = $post->post_content;

				if (stripos($post_content, '[vc_mad_google_map')) {
					wp_enqueue_script('googleapis');
				}

			}

		}

		public function autoremoveElements()
		{
			foreach ($this->removeParams as $name => $element) {
				foreach ($element as $attribute_name) {
					vc_remove_param($name, $attribute_name);
				}
			}

//		foreach ( $this->removeElements as $element ) {
//			vc_remove_element($element);
//		}
		}

		protected function autoloadLibraries($path)
		{
			foreach (glob($path . '*.php') as $file) {
				require_once($file);
			}
		}

		public function assetUrl($file)
		{
			return preg_replace('/\s/', '%20', $this->paths['BASE_URI'] . $this->path('ASSETS_DIR_NAME', $file));
		}

		function fieldAttachedImages($att_ids = array())
		{
			$output = '';

			foreach ($att_ids as $th_id) {
				$thumb_src = wp_get_attachment_image_src($th_id, 'thumbnail');
				if ($thumb_src) {
					$thumb_src = $thumb_src[0];
					$output .= '
						<li class="added">
							<img rel="' . $th_id . '" src="' . $thumb_src . '" />
							<input type="text" name=""/>
							<a href="#" class="icon-remove"></a>
						</li>';
				}
			}
			if ($output != '') {
				return $output;
			}
		}

		public function param_icon_field($settings, $value)
		{
			$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
			$type = isset($settings['type']) ? $settings['type'] : '';
			$class = isset($settings['class']) ? $settings['class'] : '';
			$icons = apply_filters('cryptex_param_icons', array(' ', 'licon-checkmark-circle', 'licon-bubble-text', 'licon-vault', 'licon-document', 'licon-shield-check', 'licon-bag-dollar', 'licon-cart-exchange', 'licon-phone', 'licon-cart', 'licon-check', 'licon-plus-circle', 'licon-bandages', 'licon-tornado', 'licon-pointer-right', 'licon-cash-dollar', 'licon-map-marker-check', 'licon-balance', 'licon-bubble-user', 'licon-man', 'licon-briefcase', 'licon-factory2', 'licon-city', 'licon-shield', 'licon-hammer2', 'licon-car2', 'licon-home5', 'licon-happy', 'licon-group-work', 'licon-trophy2'));

			ob_start(); ?>

			<div id="mad-param-icon">
				<input type="hidden" name="<?php echo esc_attr($param_name) ?>"
					   class="wpb_vc_param_value <?php echo esc_attr($param_name) . ' ' . esc_attr($type) . ' ' . esc_attr($class) ?> "
					   value="<?php echo esc_attr($value) ?>" id="mad-trace"/>
				<div class="mad-icon-preview"><i class="<?php echo esc_attr($value) ?>"></i></div>
				<input class="mad-search" type="text" placeholder="<?php esc_attr_e('Search icon', 'cryptox') ?>"/>
				<div id="mad-icon-dropdown">
					<ul class="mad-icon-list">

						<?php foreach ($icons as $icon): ?>

							<?php if (!empty($icon)): ?>

								<?php $selected = ($icon == $value) ? 'class="selected"' : ''; ?>

								<li <?php echo sprintf('%s', $selected) ?> data-icon="<?php echo esc_attr($icon) ?>">

									<?php if (substr($icon, 0, 5) == 'licon'): ?>
										<span class="licon <?php echo esc_attr($icon) ?>"></span>
									<?php endif; ?>

								</li>

							<?php endif; ?>

						<?php endforeach; ?>

					</ul><!--/ .mad-icon-list-->

				</div><!--/ #mad-icon-dropdown-->

			</div>

			<?php return ob_get_clean();
		}

		function param_table_number_field($settings, $value)
		{
			ob_start(); ?>
			<div class="mad_number_block">
				<input id="<?php echo esc_attr($settings['param_name']) ?>"
					   name="<?php echo esc_attr($settings['param_name']) ?>"
					   class="wpb_vc_param_value wpb-number <?php echo esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field' ?>"
					   type="number" value="<?php echo esc_attr($value) ?>"/>
			</div><!--/ .mad_number_block-->
			<?php return ob_get_clean();
		}

		function param_hidden_field($settings, $value)
		{
			$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
			$type = isset($settings['type']) ? $settings['type'] : '';
			$class = isset($settings['class']) ? $settings['class'] : '';
			ob_start(); ?>
			<input type="hidden" name="<?php echo esc_attr($param_name) ?>"
				   class="wpb_vc_param_value wpb_el_type_table_hidden <?php echo sanitize_html_class($param_name) . ' ' . $type . ' ' . $class ?>"
				   value="<?php echo trim($value) ?>"/>
			<?php return ob_get_clean();
		}

		function param_datetimepicker($settings, $value)
		{
			$dependency = '';
			$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
			$type = isset($settings['type']) ? $settings['type'] : '';
			$class = isset($settings['class']) ? $settings['class'] : '';
			$uni = uniqid('datetimepicker-' . rand());
			$output = '<div id="ult-date-time' . $uni . '" class="ult-datetime"><input data-format="yyyy/MM/dd hh:mm:ss" readonly class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" style="width:258px;" value="' . $value . '" ' . $dependency . '/><div class="add-on"></div></div>';
			return $output;
		}

		function param_number_field($settings, $value)
		{
			ob_start(); ?>
			<div class="mad_number_block">
				<input id="<?php echo esc_attr($settings['param_name']) ?>"
					   name="<?php echo esc_attr($settings['param_name']) ?>"
					   class="wpb_vc_param_value wpb-number <?php echo esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field' ?>"
					   type="number" value="<?php echo esc_attr($value) ?>"/>
			</div><!--/ .mad_number_block-->
			<?php return ob_get_clean();
		}

		function get_product_terms($term_id, $tax, $inserted_vals)
		{
			$html = $selected = '';
			$args = array('taxonomy' => $tax, 'hide_empty' => 0, 'parent' => $term_id);
			$terms = get_terms($args);

			foreach ($terms as $term) {
				$html .= '<li><a ';

				if (in_array($term->slug, $inserted_vals)) {
					$html .= ' class="selected"';
				}

				$html .= 'data-val="' . $term->slug . '" title="' . $term->term_id . '" href="javascript:void(0);">' . $term->name . '</a>';

				if ($list = $this->get_product_terms($term->term_id, $tax, $inserted_vals)) {
					$html .= '<ul class="second_level">' . $list . '</ul>';
				}

				$html .= '</li>';
			}
			return $html;
		}

		function param_woocommerce_terms($settings, $value)
		{

			$html = '';
			$terms = get_terms(
				array(
					'taxonomy' => $settings['term'],
					'hide_empty' => 0,
					'parent' => 0
				)
			);
			$inserted_vals = explode(',', $value);

			ob_start(); ?>

			<input type="text" value="<?php echo esc_attr($value) ?>"
				   name="<?php echo esc_attr($settings['param_name']) ?>"
				   class="wpb_vc_param_value wpb-input mad-custom-val <?php echo esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) ?>"
				   id="<?php echo esc_attr($settings['param_name']); ?>">

			<div class="mad-custom-wrapper">

				<ul class="mad-custom">

					<?php

					foreach ($terms as $term) {
						$html .= '<li class="top_li">';

						$html .= '<a ';

						if (in_array($term->slug, $inserted_vals)) {
							$html .= ' class="selected"';
						}

						$html .= 'data-val="' . $term->slug . '" title="' . $term->term_id . '" href="javascript:void(0);">' . $term->name . '</a>';

						if ($list = $this->get_product_terms($term->term_id, $settings['term'], $inserted_vals)) {
							$html .= '<ul class="second_level">' . $list . '</ul>';
						}

						$html .= '</li>';
					}
					echo sprintf('%s', $html);
					?>

				</ul><!--/ .mad-custom-->

			</div><!--/ .mad-custom-wrapper-->

			<?php return ob_get_clean();
		}

		public function param_woocommerce_get_by_id($settings, $value)
		{

			$html = '';
			$inserted_vals = explode(',', $value);

			$args = array(
				'post_type' => $settings["post_type"],
				'numberposts' => -1
			);

			$posts = get_posts($args);

			ob_start(); ?>

			<input type="text" value="<?php echo esc_attr($value) ?>"
				   name="<?php echo esc_attr($settings['param_name']) ?>"
				   class="wpb_vc_param_value wpb-input mad-custom-val <?php echo esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) ?>"
				   id="<?php echo esc_attr($settings['param_name']); ?>">

			<div class="mad-custom-wrapper">

				<ul class="mad-custom">

					<?php

					foreach ($posts as $post) {
						$html .= '<li class="top_li">';

						$html .= '<a ';

						if (in_array($post->ID, $inserted_vals)) {
							$html .= ' class="selected"';
						}

						$html .= 'data-val="' . $post->ID . '" title="' . $post->ID . '" href="javascript:void(0);">' . $post->post_title . '</a>';

						$html .= '</li>';
					}

					if ($html != '') {
						echo sprintf('%s', $html);
					}
					?>

				</ul><!--/ .mad-custom-->

			</div><!--/ .mad-custom-wrapper-->

			<?php return ob_get_clean();
		}

		public static function getParamTitle($args = array())
		{

			$defaults = array(
				'heading' => 'h3',
				'title' => '',
				'subtitle' => '',
				'title_color' => '',
				'subtitle_color' => '',
				'align_title' => ''
			);

			$args = wp_parse_args($args, $defaults);
			$args = (object)$args;

			if (empty($args->title)) return;

			$with_subtitle = '';
			$css_classes = array('title');
			$heading = $args->heading;

			if (strlen($args->subtitle) > 0) {
				$with_subtitle = 'with-subtitle';
			}

			$css_class = implode(' ', array_filter($css_classes));

			echo '<div class="title-holder ' . $args->align_title . ' ' . $with_subtitle . '">';

			echo "<{$heading} class='" . esc_attr(trim($css_class)) . "'>" . esc_html($args->title) . "<span class=\"item-divider-3 style-3\"></span></{$heading}>";

			if (strlen($args->subtitle) > 0) {
				echo "<p class='text-size-medium'>" . wp_kses($args->subtitle, array('br' => array())) . "</p>";
			}

			echo "</div>";

		}

		public static function array_number($from = 0, $to = 50, $step = 1, $array = array())
		{
			for ($i = $from; $i <= $to; $i += $step) {
				$array[$i] = $i;
			}
			return $array;
		}

		public static function get_order_sort_array()
		{
			return array('ID' => 'ID', 'date' => 'date', 'post_date' => 'post_date', 'title' => 'title',
				'post_title' => 'post_title', 'name' => 'name', 'post_name' => 'post_name', 'modified' => 'modified',
				'post_modified' => 'post_modified', 'modified_gmt' => 'modified_gmt', 'post_modified_gmt' => 'post_modified_gmt',
				'menu_order' => 'menu_order', 'parent' => 'parent', 'post_parent' => 'post_parent',
				'rand' => 'rand', 'comment_count' => 'comment_count', 'author' => 'author', 'post_author' => 'post_author');
		}

		public function font_container_get_allowed_tags($allowed_tags)
		{
			array_unshift($allowed_tags, 'h1');
			return $allowed_tags;
		}

		public static function create_data_string($data = array())
		{
			$data_string = "";

			if (empty($data)) return;

			foreach ($data as $key => $value) {
				if (is_array($value)) $value = implode(", ", $value);
				$data_string .= " data-$key={$value} ";
			}
			return $data_string;
		}

	}

}

/**
 * Main Visual composer manager config.
 * @var Cryptex_Vc_Config $cryptex_vc_config - instance of composer management.
 */
global $cryptex_vc_config;
if ( ! $cryptex_vc_config ) {
	$cryptex_vc_config = Cryptex_Vc_Config::getInstance();
}

