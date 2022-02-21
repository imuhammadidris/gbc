<?php

class WPBakeryShortCode_VC_mad_ico extends WPBakeryShortCode {

	public $atts = array();
	public $ico = '';
	public $loop = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'orderby' => 'date',
			'order' => 'DESC',
			'items' => 10,
			'paginate' => 'none'
		), $atts, 'vc_mad_ico' );

		$this->query_entries();
		$html = $this->html();

		return $html;
	}

	public function query_entries() {

		$params = $this->atts;

		$query = array(
			'post_type' => 'ico',
			'posts_per_page' => $params['items'],
			'orderby' => $params['orderby'],
			'order' => $params['order'],
			'post_status' => array( 'publish' )
		);

		$paged = get_query_var( 'page' ) ? get_query_var( 'page' ) : ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 );
		$query['paged'] = $paged;

		$this->ico = new WP_Query($query);
	}

	public function html() {

		if ( empty( $this->ico ) || empty( $this->ico->posts ) ) return;
		$entries = $this->ico;
		$atts = $this->atts;
		$wrapper_attributes = $data_attributes = array();

		extract( $atts );

		$css_classes = array( 'table-type-1', 'ico-calendar', 'entry-box' );

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );

		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
		$wrapper_attributes[] = implode( ' ', $data_attributes );

		ob_start(); ?>

		<?php if ( $entries->have_posts() ): ?>

			<?php
			echo Cryptex_Vc_Config::getParamTitle(
				array(
					'title' => $title,
				)
			);
			?>

			<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

				<table>
					<tr>
						<th><?php echo esc_html__('Name', 'cryptox') ?></th>
						<th><?php echo esc_html__('Start', 'cryptox') ?></th>
						<th><?php echo esc_html__('End', 'cryptox') ?></th>
					</tr>

					<?php while ( $entries->have_posts() ) : $entries->the_post(); ?>

						<?php
							$description = get_post_meta( get_the_ID(), 'cryptex_ico_description', true );
							$start_date = get_post_meta( get_the_ID(), 'cryptex_ico_start_date', true );
							$end_date = get_post_meta( get_the_ID(), 'cryptex_ico_end_date', true );
						?>

						<tr>
							<td>

								<div class="entry entry-ico">

									<?php if ( '' !== get_the_post_thumbnail() ) : ?>
										<div class="thumbnail-attachment">
											<a href="<?php the_permalink(); ?>">
												<?php the_post_thumbnail('thumbnail'); ?>
											</a>
										</div>
									<?php endif; ?>

									<div class="entry-body">

										<h5 class="entry-title">
											<a href="<?php the_permalink() ?>"><?php the_title() ?></a>
										</h5>

										<?php if ( !empty($description) ): ?>
											<?php echo apply_filters( 'the_content', $description ) ?>
										<?php endif; ?>

									</div>

								</div><!--/ .entry-->

							</td>

							<td>
								<?php if ( !empty($start_date) ): ?>
									<?php echo cryptex_format_date($start_date) ?>
								<?php endif; ?>
							</td>

							<td>
								<?php if ( !empty($end_date) ): ?>
									<?php echo cryptex_format_date($end_date) ?>
								<?php endif; ?>
							</td>

						</tr>

					<?php endwhile; wp_reset_postdata(); ?>

				</table>

			</div>

			<?php if ( $paginate == "pagination" && cryptex_pagination( $this->ico ) ) : ?>
				<?php echo cryptex_pagination( $this->ico ); ?>
			<?php endif; ?>

		<?php else: ?>

			<?php get_template_part( 'template-parts/post/content', 'none' ); ?>

		<?php endif; ?>

		<?php return ob_get_clean();
	}

}