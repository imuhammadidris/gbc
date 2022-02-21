<?php

class WPBakeryShortCode_VC_mad_testimonials extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'heading' => 'h3',
			'title_color' => '',
			'align_title' => 'align-left',
			'style' => 'style-1',
			'orderby' => 'date',
			'order' => 'DESC',
			'items' => 6,
		), $atts, 'vc_mad_testimonials');

		$this->query_entries();

		return $this->html();
	}

	public function query_entries() {
		$params = $this->atts;
		$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
		if ( !$page ) $page = 1;

		$tax_query = array();

		$query = array(
			'post_type' => 'testimonials',
			'orderby' => $params['orderby'],
			'order' => $params['order'],
			'paged' => $page,
			'posts_per_page' => $params['items']
		);

		if ( !empty($tax_query) ) {
			$query['tax_query'] = $tax_query;
		}

		$this->testimonials = new WP_Query($query);
	}

	public function html() {

		if ( empty($this->testimonials ) || empty($this->testimonials->posts)) return;

		extract( $this->atts );

		$css_classes = array( 'testimonial-holder', $style );

		$wrapper_attributes = array();

		if ( $style == 'style-1' ) {
			$wrapper_attributes[] = 'data-max-items="1"';
			$wrapper_attributes[] = 'data-autoplay="true"';
			$css_classes[] = 'owl-carousel';
		} elseif ( $style == 'style-2' ) {

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

		<?php if ( $style == 'style-1' ): ?>

			<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

				<?php foreach ( $this->testimonials->posts as $testimonial ):
					$id = $testimonial->ID;
					$name = get_the_title($id);
					$link = get_permalink($id);
					$photo_image_id = get_post_meta( $id, 'cryptex_testi_photo', true );
					?>

					<div class="item-carousel">

						<div class="testimonial">

							<div class="author-box">

								<a href="<?php echo esc_url($link) ?>" class="avatar">
									<?php
									$photo = '';
									if ( ! empty( $photo_image_id ) ) {
										$photo = wp_get_attachment_image_src( $photo_image_id, '' );
									}

									if ( ! empty( $photo ) && ( strstr( $photo[0], 'http' ) || file_exists( $photo[0] ) ) ) {
										$photo = $photo[0];
										echo '<img src="' . esc_attr( $photo ) . '" alt="' . esc_attr( get_the_title( $id ) ) . '" />';
									}
									?>
								</a>

							</div><!--/ .author-box-->

							<blockquote>
								<p><?php echo get_post_meta( $id, 'cryptex_testi_text', true ); ?></p>
								<div class="author"><?php echo get_post_meta( $id, 'cryptex_testi_name', true ); ?></div>
								<a href="<?php echo esc_url($link) ?>" class="author-position"><?php echo esc_html($name) ?></a>
							</blockquote>

						</div><!--/ .testimonial-->

					</div><!--/ .item-carousel-->

				<?php endforeach; ?>

			</div>

		<?php elseif ( $style == 'style-2' ): ?>

			<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

				<div class="tm-carousel" data-item-margin="30" data-max-items="1" data-autoplay="false">

					<?php foreach ( $this->testimonials->posts as $testimonial ):  ?>

						<div class="item-carousel">
							<div class="testimonial">
								<blockquote>
									<p><?php echo get_post_meta( $testimonial->ID, 'cryptex_testi_text', true ); ?></p>
								</blockquote>
							</div><!--/ .testimonial-->
						</div><!--/ .item-carousel-->

					<?php endforeach; ?>

				</div><!--/ .owl-carousel-->

				<div class="author-holder">

					<?php $i = 0; ?>

					<?php foreach ( $this->testimonials->posts as $testimonial ):
						$id = $testimonial->ID; $name = get_the_title($id);
						$photo_image_id = get_post_meta( $id, 'cryptex_testi_photo', true );
						?>

						<div class="author-item <?php if ( $i == 0 ): ?>active<?php endif; ?>">

							<a href="javascript:void(0)" class="author-link">

								<div class="author-box">

								<span class="avatar">
									<?php
									$photo = '';
									if ( ! empty( $photo_image_id ) ) {
										$photo = wp_get_attachment_image_src( $photo_image_id, 'thumbnail' );
									}

									if ( ! empty( $photo ) && ( strstr( $photo[0], 'http' ) || file_exists( $photo[0] ) ) ) {
										$photo = $photo[0];
										echo '<img src="' . esc_attr( $photo ) . '" alt="' . esc_attr( get_the_title( $id ) ) . '" />';
									}
									?>
								</span>

								</div><!--/ .author-box-->

								<div class="author-wrapper">
									<div class="author"><?php echo get_post_meta( $id, 'cryptex_testi_name', true ); ?></div>
									<div class="author-position"><?php echo esc_html($name) ?></div>
								</div>

							</a>

						</div><!--/ .author-item-->

						<?php $i++; ?>

					<?php endforeach; ?>

				</div><!--/ .author-holder-->

			</div>

		<?php elseif ( $style == 'style-3' ): ?>

			<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

				<?php foreach ( $this->testimonials->posts as $testimonial ):
					$id = $testimonial->ID;
					$name = get_the_title($id);
					$link = get_permalink($id);
					$photo_image_id = get_post_meta( $id, 'cryptex_testi_photo', true );
					?>

					<div class="item-carousel">

						<div class="testimonial">

							<blockquote>
								<p><?php echo get_post_meta( $id, 'cryptex_testi_text', true ); ?></p>
							</blockquote>

							<div class="author-holder">

								<div class="author-box">

									<a href="<?php echo esc_url($link) ?>" class="avatar">
										<?php
										$photo = '';
										if ( ! empty( $photo_image_id ) ) {
											$photo = wp_get_attachment_image_src( $photo_image_id, 'thumbnail' );
										}

										if ( ! empty( $photo ) && ( strstr( $photo[0], 'http' ) || file_exists( $photo[0] ) ) ) {
											$photo = $photo[0];
											echo '<img src="' . esc_attr( $photo ) . '" alt="' . esc_attr( get_the_title( $id ) ) . '" />';
										}
										?>
									</a>

								</div><!--/ .author-box-->

								<div class="author-wrapper">
									<div class="author"><?php echo get_post_meta( $id, 'cryptex_testi_name', true ); ?></div>
									<div class="author-position"><?php echo esc_html($name) ?></div>
								</div>

							</div>

						</div><!--/ .testimonial-->

					</div><!--/ .item-carousel-->

				<?php endforeach; ?>

			</div>

		<?php endif; ?>

		<?php return ob_get_clean();
	}

}