<?php

class WPBakeryShortCode_VC_mad_message extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'message_box_style' => 'alert-success'
		), $atts, 'vc_mad_message');

		$html = $this->html($content);

		return $html;
	}

	public function html($content) {

		extract( $this->atts);

		$css_classes = array(
			'alert', $message_box_style
		);

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );

		ob_start(); ?>

		<div class="<?php echo esc_attr( trim( $css_class ) ) ?>">

			<button type="button" class="close" data-dismiss="alert"></button>
			<?php echo wpb_js_remove_wpautop( $content, true ); ?>

		</div>

		<?php return ob_get_clean();
	}

}