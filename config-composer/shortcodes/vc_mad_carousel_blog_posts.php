<?php

class WPBakeryShortCode_VC_mad_carousel_blog_posts extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';
	public $loop = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'categories' => array(),
			'orderby' => 'date',
			'order' => 'DESC',
			'items' => 3,
			'autoplay' => '',
			'autoplaytimeout' => 5000
		), $atts, 'vc_mad_carousel_blog_posts');

		$this->query_entries();
		$html = $this->html();

		return $html;
	}

	public function query_entries() {

		$params = $this->atts;

		$query = array(
			'post_type' => 'post',
			'posts_per_page' => absint($params['items']) - 1,
			'orderby' => $params['orderby'],
			'order' => $params['order'],
			'post_status' => array('publish')
		);

		if ( !empty($params['categories']) ) {
			$categories = explode(',', $params['categories']);
			$query['category__in'] = $categories;
		}

		$query['paged'] = 1;

		$this->entries = new WP_Query($query);
	}

	public function create_data_string($data = array()) {
		$data_string = "";

		if (empty($data)) return;

		foreach ($data as $key => $value) {
			if (is_array($value)) $value = implode(", ", $value);
			$data_string .= " data-$key={$value} ";
		}

		return $data_string;
	}

	public function html() {

		if ( empty($this->entries) || empty($this->entries->posts) ) return;
		$entries = $this->entries;
		$atts = $this->atts;
		$wrapper_attributes = array();

		extract( $atts );

		$atts = array();

		$atts['autoplay'] = ($autoplay == 'yes') ? 'true' : 'false';
		$atts['autoplaytimeout'] = $autoplaytimeout;

		$css_classes = array( 'news-holder' );
		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		ob_start(); ?>

		<?php if ( $entries->have_posts() ): ?>

			<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

				<div class="blog-carousel owl-carousel" data-max-items="1" <?php echo esc_attr($this->create_data_string($atts)); ?>>

					<?php while ( $entries->have_posts() ) : $entries->the_post(); ?>

						<div class="entry__item">

							<?php if ( '' !== get_the_post_thumbnail() ) : ?>
								<?php
								$post_thumbnail_id = get_post_thumbnail_id();
								$image_src = Cryptex_Helper::get_post_attachment_image($post_thumbnail_id, 'cryptex-1120x520-center-center');
								?>

								<?php if ( $image_src ): ?>
									<img class="img-responsive" src="<?php echo esc_attr($image_src) ?>" alt="<?php echo esc_attr(get_the_title()) ?>">
								<?php endif; ?>
							<?php endif; ?>

							<div class="entry__overlay">

								<?php echo cryptex_blog_post_meta( get_the_ID(), array(
									'type' => 'carousel',
									'cats' => true
								)) ?>

								<h2 class="entry-title">
									<a href="<?php echo esc_url(get_the_permalink()) ?>"><?php echo esc_html(get_the_title()) ?></a>
								</h2>

							</div><!--/ .entry__overlay-->

						</div><!--/ .entry__item-->

					<?php endwhile; wp_reset_postdata(); ?>

				</div>

			</div><!--/ .news-holder-->

		<?php else: ?>

			<?php get_template_part( 'template-parts/post/content', 'none' ); ?>

		<?php endif; ?>

		<?php return ob_get_clean();
	}

}