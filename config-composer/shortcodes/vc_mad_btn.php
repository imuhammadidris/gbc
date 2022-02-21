<?php

class WPBakeryShortCode_VC_mad_btn extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'link' => '',
			'style' => 'btn-style-1',
			'size' => 'btn-medium',
			'icon' => '',
			'align' => 'align-inline'
		), $atts, 'vc_mad_btn');

		return $this->html();
	}

	public function html() {

		$title = $link = $size = $style = $icon = $align = $href = $style_text = '';
		$atts = $this->atts;
		$attributes = array();

		extract($atts);

		$link = ( '||' === $link ) ? '' : $link;
		$link = vc_build_link( $link );
		$use_link = false;
		if ( strlen( $link['url'] ) > 0 ) {
			$use_link = true;
			$a_href = $link['url'];
			$a_title = $link['title'];
			$a_target = $link['target'];
			$a_rel = $link['rel'];
		}

		$css_classes = array(
			'button-container', $align
		);

		$button_classes = array(
			'btn', $size, $style
		);

		$button_classes = esc_attr( implode( ' ', array_filter( $button_classes ) ) );
		$attributes[] = 'class="' . trim( $button_classes ) . '"';

		$button_text = $title;

		$wrapper_attributes = array();
		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		if ( $use_link ) {
			$attributes[] = 'href="' . trim( $a_href ) . '"';
			$attributes[] = 'title="' . esc_attr( trim( $a_title ) ) . '"';
			if ( ! empty( $a_target ) ) {
				$attributes[] = 'target="' . esc_attr( trim( $a_target ) ) . '"';
			}
			if ( ! empty( $a_rel ) ) {
				$attributes[] = 'rel="' . esc_attr( trim( $a_rel ) ) . '"';
			}
		}

		$icon = trim($icon);

		if ( $icon !== '' ) {
			$icon = '<i class="' . $icon . '"></i>';
		}

		$attributes = implode( ' ', $attributes );

		ob_start(); ?>

		<div <?php echo implode( ' ', $wrapper_attributes ) ?>>
			<?php if ( $use_link ) {
				echo '<a ' . $attributes . '>' . $icon . $button_text . '</a>';
			} else {
				echo '<button ' . $attributes . '>' . $icon . $button_text . '</button>';
			} ?>
		</div>

		<?php return ob_get_clean();
	}

}