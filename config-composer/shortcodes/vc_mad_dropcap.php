<?php

class WPBakeryShortCode_VC_mad_dropcap extends WPBakeryShortCode {

	public $atts = array();
	public $content = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'letter' => '',
			'type' => 'type-1',
			'image' => '',
			'dropcap_color' => '',
		), $atts, 'vc_mad_dropcap' );

		$this->content = $content;
		$html = $this->html();

		return $html;
	}

	public function html() {

		$style = $letter = $output = $type = $dropcap = $color = $dropcap_color = "";

		extract( $this->atts );

		if ( '' !== $letter ) {

			if ( !empty($dropcap_color) ) {
				$color = vc_get_css_color( 'color', $dropcap_color );
				if ( !empty($color) ) {
					$style = 'style="' . $color . '"';
				}
			}

			$output .= '<div class="dropcap-holder '. $type .'">';
				$dropcap .= '<span '. $style .' class="letter-dropcap">'. esc_html($letter) .'</span>';
				$output .= $dropcap;
				$output .= wpb_js_remove_wpautop( $this->content, true );
			$output .= '</div>';

		}

		return $output;
	}

}