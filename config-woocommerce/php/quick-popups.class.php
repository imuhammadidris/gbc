<?php

if ( !class_exists('Gatsby_Quick_Popups') ) {

	class Gatsby_Quick_Popups {

		protected $id;

		function __construct($id) {
			$this->id = $id;
			$this->add_hooks();
		}

		public function add_hooks() {
			remove_action('woocommerce_before_single_product', 'wc_print_notices', 10);
			remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
			remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
			remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		}

		public function output_quick_view_html() {
			$query = array(
				'post_type' => 'product',
				'post__in' => array($this->id)
			);
			$the_query = new WP_Query( $query );
			?>

			<div class="quick-view-popup">

				<a href="javascript:void(0)" class="gt-close arcticmodal-close"></a>

				<?php while ( $the_query->have_posts() ): $the_query->the_post(); ?>
					<?php wc_get_template_part( 'content', 'single-product' ); ?>
				<?php endwhile; ?>

			</div><!--/ .quick-view-popup-->

			<?php

		}

	}

}
