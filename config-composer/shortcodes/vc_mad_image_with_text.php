<?php

class WPBakeryShortCode_VC_mad_image_with_text extends WPBakeryShortCode {

	public $atts = array();
	public $content = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'content' => '',
			'link' => '',
			'image' => '',
			'align_image' => 'left'
		), $atts, 'vc_mad_image_with_text');

		$this->content = $content;
		return $this->html();
	}

	public function html() {

		$atts = $this->atts;

		$title = $link = $image = $align_image = $image_link = $style = '';

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

		if ( !empty($image) ) {
			$image_link = Cryptex_Helper::get_post_attachment_image( $image, 'full' );

			if ( !empty($image_link) ) {
				$bg_img = 'background-image: url('. $image_link .')';
				if ( !empty($bg_img) ) {
					$style = 'style="' . $bg_img . '"';
				}
			}
		}

		ob_start(); ?>


		<div class="iwt-holder <?php echo 'iwt-align-' . sanitize_title($align_image) ?>">

			<div class="iwt-item iwt-item-image">
				<div class="iwt-item-image-inner" <?php echo sprintf( '%s', $style ) ?>></div>
			</div>

			<div class="iwt-item iwt-item-content">

				<div class="iwt-item-part-col-8">

					<div class="iwt-item-inner">

						<?php if ( !empty($title) ): ?>
							<h2 class="iwt-heading"><?php echo esc_html($title) ?></h2>
						<?php endif; ?>

						<?php echo wpb_js_remove_wpautop( $this->content, true ); ?>

						<?php if ( $use_link ): ?>
							<a class="btn btn-medium btn-style-3" href="<?php echo esc_url($a_href) ?>" target="<?php echo esc_attr($a_target) ?>"><?php echo esc_html($a_title) ?></a>
						<?php endif; ?>

					</div>

				</div>

				<div class="iwt-item-part-col-4"></div>

			</div>

		</div>

		<?php return ob_get_clean();
	}

}