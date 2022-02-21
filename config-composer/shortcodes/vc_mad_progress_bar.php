<?php

class WPBakeryShortCode_VC_mad_progress_bar extends WPBakeryShortCode {

	public $atts = array();
	public $content = '';

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts( array(
			'title' => '',
			'values' => '',
			'style' => 'style-1',
			'units' => '%',
		), $atts, 'vc_mad_progress_bar' );

		$html = $this->html();
		return $html;
	}

	public function html() {

		$title = $values = $style = $units = '';

		extract( $this->atts );

		$values = (array) vc_param_group_parse_atts( $values );
		$max_value = 0.0;
		$graph_lines_data = array();

		foreach ( $values as $data ) {
			$new_line = $data;
			$new_line['value'] = isset( $data['value'] ) ? $data['value'] : 0;
			$new_line['label'] = isset( $data['label'] ) ? $data['label'] : '';
			$new_line['color'] = isset( $data['color'] ) ? $data['color'] : '';

			if ( $max_value < (float) $new_line['value'] ) {
				$max_value = $new_line['value'];
			}
			$graph_lines_data[] = $new_line;
		}

		$wrapper_attributes = array();

		$css_classes = array(
			'pbar-holder', $style
		);

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
		$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

		ob_start(); ?>

		<?php if ( !empty($values) ): ?>

			<?php
			echo Cryptex_Vc_Config::getParamTitle(
				array(
					'title' => $title,
				)
			);
			?>

			<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

				<?php foreach ( $graph_lines_data as $line ): ?>

					<?php $unit = ( '' !== $units ) ? $units : ''; ?>

					<div class="pbar-wrap">
						<div class="pbar-title"><?php echo esc_html($line['label']) ?> <span><?php echo esc_attr( $line['value'] ) ?><?php echo esc_attr($unit) ?></span></div>
						<div class="pbar">
							<div class="pbar-inner" style="width: <?php echo esc_attr( $line['value'] ) ?>%"></div>
						</div>
					</div>

				<?php endforeach; ?>

			</div>

		<?php endif; ?>

		<?php return ob_get_clean();
	}

}