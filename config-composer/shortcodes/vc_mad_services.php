<?php

class WPBakeryShortCode_vc_mad_services extends WPBakeryShortCode {

	public $atts = array();
	public $services = '';

	protected function content( $atts, $content = null ) {

		$this->atts = shortcode_atts( array(
			'title' => '',
			'style' => 'style-1',
			'columns' => 3,
			'orderby' => 'date',
			'order' => 'DESC',
			'items' => 6,
			'link' => ''
		), $atts, 'vc_mad_services' );

		$this->query_entries();
		$html = $this->html();

		return $html;
	}

	public function query_entries($params = array()) {

		if ( empty($params) ) $params = $this->atts;

		$tax_query = array();

		$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
		if ( !$page || $params['paginate'] == 'none' ) $page = 1;

		$query = array(
			'post_type' => 'services',
			'post_status'  => 'publish',
			'posts_per_page' => $params['items'],
			'orderby' => $params['orderby'],
			'order' => $params['order'],
			'paged' => $page,
			'tax_query' => $tax_query
		);

		$this->services = new WP_Query($query);
	}

	public function html() {

		if ( empty($this->services) || empty($this->services->posts) ) return;

		$services = $this->services;
		$atts = $this->atts;
		extract( $atts );
		$styles = '';

		$css_classes = array(
			'icons-box', $style, 'cols-' . $columns
		);

		$wrapper_attributes = array();
		$wrapper_attributes[] = 'class="' . esc_attr( trim( implode( ' ', array_filter( $css_classes ) ) ) ) . '"';

		ob_start(); ?>

		<?php if ( $services->have_posts() ): ?>

			<div <?php echo implode( ' ', $wrapper_attributes ); ?>>

				<?php while ( $services->have_posts() ) : $services->the_post(); ?>

					<?php
					$icon = mad_meta( 'cryptex_s_icon', '', get_the_ID() );
					$icon = str_replace( array( 'licon-', 'icon-' ), '', $icon );

					if ( $style == 'style-3' ) {
						if ( has_post_thumbnail(get_the_ID()) ) {
							$styles = 'data-bg="'. wp_get_attachment_image_url(get_post_thumbnail_id(get_the_ID())).'"';
						}
					}
					?>

					<div class="icons-wrap" <?php echo "{$styles}" ?>>

						<div class="icons-item">

							<div class="item-box">

								<?php if ( $icon): ?>
									<i class="licon licon-<?php echo sanitize_html_class($icon) ?>"></i>
								<?php endif; ?>

								<h5 class="icons-box-title">
									<a href="<?php echo esc_url(get_the_permalink()) ?>"><?php echo get_the_title() ?></a>
								</h5>

								<?php if ( $style == 'style-3'): ?>

									<div class="hidden-area">

										<?php if ( has_excerpt() ): ?>
											<p><?php echo get_the_excerpt(); ?></p>
										<?php endif; ?>

										<a href="<?php echo esc_url(get_the_permalink()) ?>" class="btn">
											<?php echo esc_html__('Read More', 'cryptox') ?>
										</a>

									</div>

								<?php else: ?>

									<?php if ( has_excerpt() ): ?>
										<p><?php echo get_the_excerpt(); ?></p>
									<?php endif; ?>

								<?php endif; ?>

							</div><!--/ .item-box-->

						</div><!--/ .icons-item-->

					</div><!--/ .icons-wrap-->

				<?php endwhile; wp_reset_postdata(); ?>

			</div>

		<?php endif; ?>

		<?php return ob_get_clean();

	}

}