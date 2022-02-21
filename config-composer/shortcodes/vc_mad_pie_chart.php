<?php

class WPBakeryShortCode_VC_mad_pie_chart extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';
	public $settings = array();

	protected function content($atts, $content = null) {

		wp_enqueue_script( 'chartist' );

		$this->atts = shortcode_atts( array(
			'title' => '',
			'style' => 'style-1',
			'values' => ''
		), $atts, 'vc_mad_pie_chart' );

		return $this->html();
	}

	public function html() {

		$title = $style = $values = '';

		extract( $this->atts );

		$values = (array) vc_param_group_parse_atts( $values );

		ob_start(); ?>

		<?php if ( !empty($values) ): ?>

			<?php
			echo Cryptex_Vc_Config::getParamTitle(
				array(
					'title' => $title
				)
			);
			?>

			<?php if ( $style == 'style-1' ): ?>

				<?php foreach ( $values as $value ): ?>

					<div class="ct-chart donut-chart" data-series="[<?php echo 100 - absint($value['value']) ?>,<?php echo esc_attr($value['value']) ?>]">
						<div class="chart-progress">
							<h2><?php echo esc_attr($value['value']) ?>%</h2>
							<p><?php echo esc_html($value['label']) ?></p>
						</div>
					</div>

				<?php endforeach; ?>

				<div class="svg-gradient">

					<svg>
						<defs>
							<linearGradient id="MyGradient">
								<stop offset="0%" stop-color="rgba(81,163,255,0.8)" />
								<stop offset="100%" stop-color="rgba(215,32,51,0.8)" />
							</linearGradient>
						</defs>
					</svg>

				</div>

			<?php elseif( $style == 'style-2' ): ?>

				<?php
				$series = $labels = array();
				foreach ( $values as $value ) {
					$labels[] = $value['label'];
				}

				foreach ( $values as $value ) {
					$series[] = $value['value'];
				}
				?>

				<div class="pie-chart-wrap">

					<div class="ct-chart3 pie-chart"
						 data-series="[<?php echo implode( ',', $series ) ?>]"
						 data-labels="[<?php echo implode( ', ', $labels ) ?>]">
					</div>

					<div class="chart-info">

						<?php $i = 1; ?>

						<?php foreach ( $values as $value ): ?>
							<div class="chart-item <?php echo 'chart-item-' . absint($i) ?>"><?php echo esc_html($value['label']) ?>: <?php echo esc_html($value['value']) ?></div>
							<?php $i++; ?>
						<?php endforeach; ?>

					</div>

				</div><!--/ .pie-chart-wrap-->

			<?php endif; ?>

		<?php endif; ?>

		<?php return ob_get_clean() ;
	}

}