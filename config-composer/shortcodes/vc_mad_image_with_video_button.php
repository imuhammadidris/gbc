<?php

class WPBakeryShortCode_VC_mad_image_with_video_button extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
//			'title' => '',
			'image' => '',
			'link' => ''
		), $atts, 'vc_mad_image_with_video_button');

		$html = $this->html();

		return $html;
	}

	public function html() {

		$link = $image = '';
		extract( $this->atts );

		ob_start(); ?>

		<div class="video-holder">

			<?php if ( !empty($link) ): ?>
				<a href="<?php echo esc_url($link) ?>" class="video-btn" data-fancybox="video"></a>
			<?php endif; ?>

			<?php if ( !empty($image) && absint($image) ): ?>
				<?php echo Cryptex_Helper::get_the_thumbnail( $image, '', true, '', array( 'alt' => '' ) ); ?>
			<?php endif; ?>

		</div>

		<?php return ob_get_clean();
	}

}