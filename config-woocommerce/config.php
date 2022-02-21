<?php

if ( !class_exists('Cryptex_WooCommerce_Config') ) {

	class Cryptex_WooCommerce_Config {

		public $action_quick_view = 'cryptex_action_add_product_popup';
		public $paths = array();
		public static $pathes = array();

		public function path($name, $file = '') {
			return $this->paths[$name] . (strlen($file) > 0 ? '/' . preg_replace('/^\//', '', $file) : '');
		}

		public function assetUrl($file) {
			return $this->paths['BASE_URI'] . $this->path('ASSETS_DIR_NAME', $file);
		}

		function __construct() {

			// Woocommerce support
			add_theme_support('woocommerce');

			add_theme_support('wc-product-gallery-slider');
			add_theme_support('wc-product-gallery-lightbox');
			add_theme_support('wc-product-gallery-zoom');

			$dir = get_theme_file_path('config-woocommerce/');

			define( 'Cryptex_Woo_Config', true );

			$this->paths = array(
				'PHP' => $dir . '/php/',
				'TEMPLATES' => $dir . '/templates/',
				'ASSETS_DIR_NAME' => 'assets',
				'WIDGETS_DIR' => $dir . '/widgets/',
				'BASE_URI' => get_theme_file_uri('config-woocommerce/')
			);

			self::$pathes = $this->paths;

			include( $this->paths['PHP'] . 'functions.php' );
			include( $this->paths['PHP'] . 'ordering.class.php' );
			include( $this->paths['PHP'] . 'new-badge.class.php' );
			include( $this->paths['PHP'] . 'dropdown-shopcart.class.php' );

			add_action( 'woocommerce_init', array( $this, 'woocommerce_init' ) );
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'add_enqueue_scripts' ) );
		}

		public function admin_init() {
			add_filter( 'manage_product_posts_columns', array( $this, 'manage_columns' ) );
		}

		public function woocommerce_init() {
			$this->remove_actions();
			$this->add_actions();
			$this->add_filters();
		}

		public function add_filters() {

			if ( defined( 'WOOCOMMERCE_VERSION' ) ) {
				if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
					add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
				} else {
					define( 'WOOCOMMERCE_USE_CSS', false );
				}
			}

			add_filter( 'woocommerce_general_settings', array( $this, 'woocommerce_general_settings_filter') );
			add_filter( 'woocommerce_page_settings', array( $this, 'woocommerce_general_settings_filter') );
			add_filter( 'woocommerce_catalog_settings', array( $this, 'woocommerce_general_settings_filter') );
			add_filter( 'woocommerce_inventory_settings', array( $this, 'woocommerce_general_settings_filter') );
			add_filter( 'woocommerce_shipping_settings', array( $this, 'woocommerce_general_settings_filter') );
			add_filter( 'woocommerce_tax_settings', array( $this, 'woocommerce_general_settings_filter') );
			add_filter( 'woocommerce_product_settings', array( $this, 'woocommerce_general_settings_filter') );

			add_filter( 'woocommerce_related_products_columns', array( $this, 'related_products_columns' ) );
			add_filter( 'woocommerce_upsell_display_args', array( $this, 'upsell_display_args' ) );
			add_filter( 'woocommerce_cross_sells_total', array( $this, 'cross_sells_total' ) );
			add_filter( 'woocommerce_cross_sells_columns', array( $this, 'cross_sells_columns' ) );

		}

		public function remove_actions() {

			remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

			remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

			remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open');
			remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail');
			remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title');
			remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
			remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
			remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
			remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

			remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
			remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

			remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
			remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');

		}

		public function add_actions() {

			/**
			 * @see woocommerce_breadcrumb()
			 */

			global $cryptex_settings;

			/* Archive Hooks */
			add_action( 'woocommerce_archive_description', array( $this, 'woocommerce_ordering_products' ) );

			/* Content Product Hooks */
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'template_loop_product_thumbnail' ) );
			add_action( 'woocommerce_shop_loop_item_title', array( $this, 'template_loop_product_title' ) );
			add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'template_after_shop_loop_item_title' ) );

			if ( $cryptex_settings['product-crosssell'] ) {
				add_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
			}

			/* Single Product Hooks */
			if ( function_exists('cryptex_social_product_share') ) {
				add_action( 'woocommerce_share', 'cryptex_social_product_share' );
			}
		}

		public function review_order_before_payment() {
			echo '<h4>' . esc_html__('Payment Method', 'cryptox') . '</h4>';
		}

		public function template_loop_product_thumbnail() {
			$this->get_product_thumbnail();
		}

		public function get_product_thumbnail() { ?>

			<figure class="product-image">
				<a href="<?php echo esc_url(get_the_permalink()) ?>">
					<?php echo woocommerce_get_product_thumbnail( 'shop_catalog' ); ?>
				</a>
				<?php woocommerce_template_loop_add_to_cart(); ?>
			</figure>

			<?php
		}

		public function template_loop_product_title() {
			global $product;

			echo wc_get_product_category_list( $product->get_id(), ', ', '<div class="product-cats">', '</div>' );

			echo '<h5 class="product-name"><a href="'. esc_url(get_the_permalink()) .'">' . get_the_title() . '</a></h5>';
		}

		public function template_after_shop_loop_item_title() {
			$this->loop_price_output();
		}

		public function loop_price_output() {
			echo '<div class="pricing-area flex-row flex-justify">';
				woocommerce_template_loop_price();
				woocommerce_template_loop_rating();
			echo '</div>';
		}

		function product_excerpt_output() {
			global $product;
			$post_content = !empty($product->post_excerpt) ? $product->post_excerpt : '';
			$post_content = apply_filters('the_excerpt', $post_content);
			$post_content = str_replace(']]>', ']]&gt;', $post_content);
			$post_content = cryptex_get_excerpt( $post_content, apply_filters('cryptex_excerpt_limit', 150) );
			?>
			<?php if ( !empty($post_content) ): ?>
				<div class="product-excerpt"><?php echo sprintf('%s', $post_content); ?></div>
			<?php endif; ?>
			<?php
		}

		public function manage_columns($columns) {
			unset($columns['wpseo-title']);
			unset($columns['wpseo-metadesc']);
			unset($columns['wpseo-focuskw']);

			return $columns;
		}

		public function related_products_columns( $columns ) {

			global $cryptex_settings;

			$columns = $cryptex_settings['product-related-cols'];

			return $columns;

		}

		public function upsell_display_args($args) {
			global $cryptex_settings;

			$args['posts_per_page'] = $cryptex_settings['product-upsells-count'];

			return $args;
		}

		public function cross_sells_total($limit) {
			global $cryptex_settings;

			$count_limit = $cryptex_settings['product-crosssell-count'];

			if ( $count_limit > 0 )
				return $count_limit;

			return $limit;
		}

		public function cross_sells_columns($columns) {
			global $cryptex_settings;

			$count_columns = $cryptex_settings['product-crosssell-columns'];

			if ( $count_columns > 0 )
				return $count_columns;

			return $columns;
		}

		public function add_enqueue_scripts() {

			$woo_mod_file = $this->assetUrl( 'js/woocommerce-mod' . (WP_DEBUG ? '' : '.min') . '.js' );
			wp_enqueue_script( 'cryptex-woocommerce-mod', $woo_mod_file, array( 'jquery', 'cryptex-core' ), 1, true );
			wp_localize_script('cryptex-woocommerce-mod', 'cryptex_woocommerce_mod', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce_cart_item_remove' => wp_create_nonce( 'cryptex_cart_item_remove' )
			));

		}

		public function woocommerce_ordering_products() {
			$ordering = new Cryptex_Catalog_Ordering();
			echo sprintf('%s', $ordering->output());
		}

		function woocommerce_general_settings_filter($options) {
			$delete = array('woocommerce_enable_lightbox');

			foreach ( $options as $key => $option ) {
				if (isset($option['id']) && in_array($option['id'], $delete)) {
					unset($options[$key]);
				}
			}
			return $options;
		}

		public static function content_truncate($string, $limit, $break = ".", $pad = "...") {
			if (strlen($string) <= $limit) { return $string; }

			if (false !== ($breakpoint = strpos($string, $break, $limit))) {
				if ($breakpoint < strlen($string) - 1) {
					$string = substr($string, 0, $breakpoint) . $pad;
				}
			}
			if (!$breakpoint && strlen(strip_tags($string)) == strlen($string)) {
				$string = substr($string, 0, $limit) . $pad;
			}
			return $string;
		}

		public static function create_data_string($data = array()) {
			$data_string = "";

			foreach($data as $key => $value) {
				if (is_array($value)) $value = implode(", ", $value);
				$data_string .= " data-$key={$value} ";
			}
			return $data_string;
		}

	}

	new Cryptex_WooCommerce_Config();

}