<?php

class WPBakeryShortCode_VC_mad_team_members extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts( array(
			'title' => '',
			'heading' => 'h3',
			'title_color' => '',
			'align_title' => 'align-left',
			'description' => '',
			'style' => 'style-1',
			'columns' => 3,
			'items' => 3,
			'carousel' => false,
			'categories' => array(),
			'orderby' => 'date',
			'order' => 'DESC'
		), $atts, 'vc_mad_team_members' );

		$this->query_entries();
		$html = $this->html();

		return $html;
	}

	public function query_entries() {

		$params = $this->atts;

		$tax_query = array();

		$query = array(
			'post_type' => 'team-members',
			'posts_per_page' => $params['items'],
			'orderby' => $params['orderby'],
			'order' => $params['order'],
			'tax_query' => $tax_query
		);

		$this->entries = new WP_Query($query);
	}

	public function html() {

		if ( empty($this->entries) || empty($this->entries->posts) ) return;

		$title = $subtitle = $description = $style = $columns = '';
		$wrapper_attributes = array();

		extract( $this->atts );

		$css_classes = array(
			'team-holder', $style, 'cols-' . absint($columns)
		);

//		if ( $carousel ) {
//			$css_classes[] = 'owl-carousel';
//
//			if ( $style == 'style-1' || $style == 'style-3' ) {
//				$wrapper_attributes[] = 'data-item-margin="30"';
//			}
//
//			$wrapper_attributes[] = 'data-max-items="'. esc_attr($columns) .'"';
//		}

		$wrapper_attributes[] = 'class="' . esc_attr( trim( implode( ' ', array_filter( $css_classes ) ) ) ) . '"';

		ob_start() ?>

		<?php
		echo Cryptex_Vc_Config::getParamTitle(
			array(
				'title' => $title,
//				'subtitle' => $subtitle,
//				'heading' => $heading,
//				'title_color' => $title_color,
//				'subtitle_color' => $subtitle_color,
//				'align_title' => $align_title,
//				'description' => $description
			)
		);
		?>

		<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

			<?php if ( $style == 'style-1' ): ?>

				<?php foreach ( $this->entries->posts as $entry ): ?>

					<?php
					$id = $entry->ID;
					$name = get_the_title($id);
					$link  = get_permalink($id);
					$position = mad_meta('cryptex_tm_position', '', $id);
					$content = has_excerpt($id) ? $entry->post_excerpt : $entry->post_content;
					?>

					<div class="team-item">

						<?php if ( has_post_thumbnail( $id ) ): ?>
							<a href="<?php echo esc_url($link) ?>" class="member-photo">
								<?php
								echo get_the_post_thumbnail( $id, 'cryptex-430x465-center-center' );
								?>
							</a>
						<?php endif; ?>

						<div class="team-desc">
							<div class="member-info">
								<h5 class="member-name"><a href="<?php echo esc_url($link) ?>"><?php echo esc_html($name); ?></a></h5>
								<h6 class="member-position"><?php echo esc_html($position) ?></h6>
							</div>
						</div>

					</div><!--/ .team-item-->

				<?php endforeach; ?>

			<?php elseif ( $style == 'style-2' ): ?>

				<?php foreach ( $this->entries->posts as $entry ): ?>


				<?php endforeach; ?>

			<?php elseif ( $style == 'style-3' ): ?>

				<?php foreach ( $this->entries->posts as $entry ): ?>


				<?php endforeach; ?>

			<?php endif; ?>

		</div><!--/ .team-holder-->

		<?php return ob_get_clean();
	}

}