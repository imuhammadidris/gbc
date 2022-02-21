<?php

if ( !class_exists('Cryptex_Catalog_Ordering') ) {

	class Cryptex_Catalog_Ordering {

		function __construct() {

		}

		public function woo_build_query_string ($params = array(), $key, $value) {
			$params[$key] = $value;
			return "?" . http_build_query($params);
		}

		public function woo_active_class($key1, $key2) {
			if ( $key1 == $key2 ) return " class='active'";
		}

		public function output() {

			global $cryptex_config, $query_string;

			parse_str( $query_string, $params );

			$product_order = array();
			$product_order['default'] 	= esc_html__("Default",'cryptox');
			$product_order['title'] 	= esc_html__("Name",'cryptox');
			$product_order['price'] 	= esc_html__("Price",'cryptox');
			$product_order['date'] 		= esc_html__("Date",'cryptox');
			$product_order['popularity'] = esc_html__("Popularity",'cryptox');

			$product_order_key = !empty($cryptex_config['woocommerce']['product_order']) ? $cryptex_config['woocommerce']['product_order'] : 'default';
			?>

			<div class="product-sort-section flex-row flex-justify flex-center">

				<?php woocommerce_result_count() ?>

				<div class="custom-select">

					<div class="select-title var2"><?php echo esc_html( $product_order[$product_order_key] ) ?></div>

					<ul id="menu-type" class="select-list">
						<li><a <?php echo sprintf('%s', $this->woo_active_class($product_order_key, 'default')); ?> href="<?php echo esc_url($this->woo_build_query_string($params, 'product_order', 'default')) ?>"><?php echo esc_html($product_order['default']) ?></a></li>
						<li><a <?php echo sprintf('%s', $this->woo_active_class($product_order_key, 'title')); ?> href="<?php echo esc_url($this->woo_build_query_string($params, 'product_order', 'title')) ?>"><?php echo esc_html($product_order['title']) ?></a></li>
						<li><a <?php echo sprintf('%s', $this->woo_active_class($product_order_key, 'price')); ?> href="<?php echo esc_url($this->woo_build_query_string($params, 'product_order', 'price')) ?>"><?php echo esc_html($product_order['price']) ?></a></li>
						<li><a <?php echo sprintf('%s', $this->woo_active_class($product_order_key, 'date')); ?> href="<?php echo esc_url($this->woo_build_query_string($params, 'product_order', 'date')) ?>"><?php echo esc_html($product_order['date']) ?></a></li>
						<li><a <?php echo sprintf('%s', $this->woo_active_class($product_order_key, 'popularity')); ?> href="<?php echo esc_url($this->woo_build_query_string($params, 'product_order', 'popularity')) ?>"><?php echo esc_html($product_order['popularity']) ?></a></li>
					</ul>

				</div>

			</div><!--/ .product-sort-section-->

			<?php
		}

	}
}

?>
