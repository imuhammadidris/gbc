<?php

class WPBakeryShortCode_VC_mad_blog_posts extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';
	public $loop = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'heading' => 'h3',
			'align_title' => 'align-left',
			'layout' => 'entry-small',
			'columns' => 3,
			'categories' => array(),
			'orderby' => 'date',
			'order' => 'DESC',
			'items' => 6,
			'paginate' => 'none',
			'remove_border' => false,
			'link' => '',
		), $atts, 'vc_mad_blog_posts');

		$this->query_entries();
		$html = $this->html();

		return $html;
	}

	public function query_entries() {

		$params = $this->atts;

		$query = array(
			'post_type' => 'post',
			'posts_per_page' => $params['items'],
			'orderby' => $params['orderby'],
			'order' => $params['order'],
			'post_status' => array('publish')
		);

		if ( !empty($params['categories']) ) {
			$query['category_name'] = $params['categories'];
		}

		$paged = get_query_var( 'page' ) ? get_query_var( 'page' ) : ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 );
		$query['paged'] = $paged;

		$this->entries = new WP_Query($query);
	}

	public function html() {

		if ( empty($this->entries) || empty($this->entries->posts) ) return;
		$entries = $this->entries;
		$atts = $this->atts;
		$wrapper_attributes = $data_attributes = array();

		extract( $atts );

		$link = ( '||' === $link ) ? '' : $link;
		$link = vc_build_link( $link );
		$use_link = false;
		if ( strlen( $link['url'] ) > 0 ) {
			$use_link = true;
			$a_href = $link['url'];
			$a_title = $link['title'];
			$a_target = $link['target'];
		}

		$css_classes = array( 'entry-box', $layout );

		if ( $layout == 'entry-masonry' ) {
			$css_classes[] = 'cols-' . $columns;
			$data_attributes[] = 'data-isotope-options=\'{"itemSelector" : ".entry","layoutMode" : "masonry","transitionDuration":"0.7s","masonry" : {"columnWidth":".entry"}}\'';
		} elseif ( $layout == 'entry-grid' || $layout == 'entry-small' ) {
			$css_classes[] = 'cols-' . $columns;
		}

		if ( $remove_border ) {
			$css_classes[] = 'without-border';
		}

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );

		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
		$wrapper_attributes[] = implode( ' ', $data_attributes );

		ob_start(); ?>

		<?php if ( $entries->have_posts() ): ?>

			<?php
			echo Cryptex_Vc_Config::getParamTitle(
				array(
					'title' => $title,
					'heading' => $heading,
					'align_title' => $align_title
				)
			);
			?>

			<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

				<?php if ( $layout == 'entry-grid' ): ?>

					<?php while ( $entries->have_posts() ) : $entries->the_post(); ?>
						<?php get_template_part( 'template-parts/post/content', 'grid' ); ?>
					<?php endwhile; wp_reset_postdata(); ?>

				<?php elseif ( $layout == 'entry-masonry' ): ?>

					<?php while ( $entries->have_posts() ) : $entries->the_post(); ?>
						<?php get_template_part( 'template-parts/masonry/masonry', get_post_format() ); ?>
					<?php endwhile; wp_reset_postdata(); ?>

				<?php else: ?>

					<?php while ( $entries->have_posts() ) : $entries->the_post(); ?>
						<?php get_template_part( 'template-parts/post/content', get_post_format() ); ?>
					<?php endwhile; wp_reset_postdata(); ?>

				<?php endif; ?>

			</div><!--/ .entry-box-->

			<?php if ( $use_link ): ?>
				<div class="entry-box-pagination align-center">
					<a href="<?php echo esc_url($a_href) ?>" target="<?php echo esc_attr($a_target) ?>" class="btn"><?php echo esc_html($a_title) ?></a>
				</div>
			<?php endif; ?>

			<?php if ( $paginate == "pagination" && cryptex_pagination( $this->entries ) ) : ?>
				<?php echo cryptex_pagination( $this->entries ); ?>
			<?php endif; ?>

		<?php else: ?>

			<?php get_template_part( 'template-parts/post/content', 'none' ); ?>

		<?php endif; ?>

		<?php return ob_get_clean();
	}

}