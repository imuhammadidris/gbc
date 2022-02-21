<?php

class WPBakeryShortCode_VC_mad_portfolio extends WPBakeryShortCode {

	public $atts = array();
	public $portfolio = '';
	public $settings = array();

	protected function content( $atts, $content = null ) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'layout' => 'grid-standard',
			'sort' => false,
			'carousel' => 0,
			'categories' => array(),
			'orderby' => 'date',
			'order' => 'DESC',
			'hide_details' => false,
			'columns' 	=> 3,
			'paginate' => 'none',
			'items' 	=> 10
		), $atts, 'vc_mad_portfolio');

		$this->query_entries();

		$html = $this->html();

		return $html;
	}

	protected function sort_links( $entries, $params ) {

		$categories = get_categories( array(
			'taxonomy'	=> 'portfolio_categories',
			'hide_empty'=> 0
		) );
		$current_cats = array();
		$display_cats = is_array( $params['categories'] ) ? $params['categories'] : array_filter(explode(',', $params['categories']));

		foreach ( $entries as $entry ) {
			if ( $current_item_cats = get_the_terms( $entry->ID, 'portfolio_categories' ) ) {

				if ( !empty( $current_item_cats ) ) {
					foreach ( $current_item_cats as $current_item_cat ) {
						if ( in_array( $current_item_cat->slug, $display_cats ) ) {
							$current_cats[$current_item_cat->term_id] = $current_item_cat->term_id;
						}
					}
				}
			}
		}

		ob_start(); ?>

		<div id="options">

			<div id="filters" class="isotope-nav">

				<button class="is-checked" data-filter="*"><?php esc_html_e( 'All', 'cryptox' ) ?></button>

				<?php foreach ( $categories as $category ): ?>
					<?php if ( in_array($category->term_id, $current_cats) ): ?>
						<?php $nicename = str_replace( '%', '', $category->category_nicename ); ?>
						<button data-filter=".<?php echo esc_attr($nicename) ?>"><?php echo esc_html(trim($category->cat_name)); ?></button>
					<?php endif; ?>

				<?php endforeach ?>

			</div><!--/ #filters-->

		</div><!--/ #options-->

		<?php return ob_get_clean();
	}

	public function get_sort_class( $id ) {
		$classes = "";
		$item_categories = get_the_terms( $id, 'portfolio_categories' );
		if ( is_object($item_categories) || is_array($item_categories) ) {
			foreach ( $item_categories as $cat ) {
				$classes .= $cat->slug . ' ';
			}
		}
		return str_replace( '%', '', $classes );
	}

	public function query_entries($params = array()) {

		if ( empty($params) ) $params = $this->atts;

		$tax_query = array();

		$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
		if ( !$page || $params['paginate'] == 'none' ) $page = 1;

		if ( !empty($params['categories']) ) {
			$categories = explode(',', $params['categories']);
			$tax_query = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'portfolio_categories',
					'field' => 'id',
					'terms' => $categories
				)
			);
		}

		$query = array(
			'post_type' => 'portfolio',
			'post_status'  => 'publish',
			'posts_per_page' => $params['items'],
			'orderby' => $params['orderby'],
			'order' => $params['order'],
			'paged' => $page,
			'tax_query' => $tax_query
		);

		$this->portfolio = new WP_Query($query);
		$this->prepare_entries($params);
	}

	public function html() {

		if ( empty($this->loop) ) return;

		$atts = $this->atts;
		extract( $atts );

		$wrapper_attributes = array();
		$css_classes = array( 'portfolio-holder', $layout, 'cols-' . absint($columns) );

		if ( $sort ) {
			$css_classes[] = 'isotope';
			$wrapper_attributes[] = 'data-isotope-options=\'{"itemSelector" : ".item","layoutMode" : "fitRows","transitionDuration":"0.7s","fitRows" : {"columnWidth":".item"}}\'';
		}

		$wrapper_attributes[] = 'class="' . esc_attr( trim( implode( ' ', array_filter( $css_classes ) ) ) ) . '"';

		ob_start(); ?>

		<?php
		echo Cryptex_Vc_Config::getParamTitle(
			array(
				'title' => $title
			)
		);
		?>

		<?php if ( $layout == 'grid-standard' ): ?>

			<?php echo ''. ( $sort ) ? $this->sort_links( $this->portfolio->posts, $atts ) : ''; ?>

			<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

				<?php foreach ( $this->loop as $entry ): extract( array_merge(array(
					'id' => '',
					'link' => '',
					'title' => '',
					'sort_classes' => ''
				), $entry ) ); ?>

					<div class="item <?php echo sanitize_html_class($sort_classes) ?>">

						<div class="project">

							<?php if ( has_post_thumbnail( $id ) ): ?>

								<div class="project-image">

									<?php echo get_the_post_thumbnail( $id, 'cryptex-660x415-center-center' ); ?>
									<a href="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $id ), '' ) ?>" class="project-link" data-fancybox="group"></a>

								</div><!--/ .project-image-->

							<?php endif; ?>

							<div class="project-description">

								<?php echo get_the_term_list( $id, 'portfolio_categories', '<div class="project-cats">', '','</div>' ); ?>

								<h4 class="project-title"><a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a></h4>

							</div><!--/ .project-description-->

						</div><!--/ .project-->

					</div><!--/ .item-->

				<?php endforeach; wp_reset_postdata(); ?>

			</div><!--/ .portfolio-holder-->

		<?php elseif ( $layout == 'grid-classic' ) : ?>

			<?php echo ''. ( $sort ) ? $this->sort_links( $this->portfolio->posts, $atts ) : ''; ?>

			<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

				<?php foreach ( $this->loop as $entry ): extract( array_merge(array(
					'id' => '',
					'link' => '',
					'title' => '',
					'sort_classes' => ''
				), $entry ) ); ?>

					<div class="item <?php echo sanitize_html_class($sort_classes) ?>">

						<div class="project">

							<div class="project-image">

								<?php if ( has_post_thumbnail( $id ) ): ?>

									<?php echo get_the_post_thumbnail( $id, 'cryptex-660x415-center-center' ); ?>
									<a href="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( $id ), '' ) ?>" class="project-link" data-fancybox="group"></a>

								<?php endif; ?>

								<?php if ( !$hide_details ) : ?>

									<div class="project-description">

										<?php echo get_the_term_list( $id, 'portfolio_categories', '<div class="project-cats">', '','</div>' ); ?>

										<h4 class="project-title"><a href="<?php echo esc_url($link) ?>"><?php echo esc_html($title) ?></a></h4>

									</div><!--/ .project-description-->

								<?php endif; ?>

							</div><!--/ .project-image-->

						</div><!--/ .project-->

					</div><!--/ .item-->

				<?php endforeach; wp_reset_postdata(); ?>

			</div><!--/ .portfolio-holder-->

		<?php endif; ?>

		<?php if ( $paginate == "pagination" && cryptex_pagination( $this->portfolio ) ) : ?>
			<?php echo cryptex_pagination( $this->portfolio ); ?>
		<?php endif; ?>

		<?php return ob_get_clean();
	}

	public function prepare_entries($params) {

		$this->loop = array();

		if ( empty($params )) $params = $this->atts;
		if ( empty($this->portfolio) || empty($this->portfolio->posts) ) return;

		foreach ( $this->portfolio->posts as $key => $entry ) {

			$this->loop[$key]['id'] = $id = $entry->ID;
			$this->loop[$key]['link'] = get_permalink($id);
			$this->loop[$key]['title'] = get_the_title($id);
			$this->loop[$key]['sort_classes'] = $this->get_sort_class($id);
			$this->loop[$key]['post_content'] = has_excerpt( $id ) ? cryptex_string_truncate( $entry->post_excerpt, 94, ' ', "...", true, '' ) : '';

		}

	}

}