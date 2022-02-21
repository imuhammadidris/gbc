<?php

class WPBakeryShortCode_VC_mad_bar_chart extends WPBakeryShortCode {

	public $atts = array();
	public $entries = '';
	public $settings = array();

	protected function content($atts, $content = null) {

		wp_enqueue_script( 'chartist' );

		$this->atts = shortcode_atts( array(
			'title' => '',
			'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
			'style' => 'style-1',
			'symbol' => '',
			'low' => 0,
			'high' => 40,
			'values' => ''
		), $atts, 'vc_mad_bar_chart' );

		return $this->html();
	}

	public function html() {

		$title = $style = $values = $low = $high = '';

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

			<?php if ( $style == 'style-1' ) : ?>

				<?php
				$series = array(); $labs = '';

				foreach ( $values as $value ) {
					$series[] = $value['value'];
				}

				if ( is_array($labels) ) {
					$labs .= '[';
					$i = 0;
					foreach ( $labels as $label ) {
						if ( $i > 0 ) {
							$labs .= ', ';
						}
						$labs .= '"' . $label . '"';
						$i++;
					}
					$labs .= ']';
				} else {
					$labs = $labels;
				}

				?>

				<div class="ct-chart4 bar-chart"
					 data-series="[<?php echo implode( ', ', $series ) ?>]"
					 data-labels="<?php echo esc_attr($labs) ?>"
					 data-symbol="<?php echo esc_attr($symbol) ?>"
					 data-low="<?php echo absint($low) ?>"
					 data-high="<?php echo absint($high) ?>">
				</div>

				<div class="chart-info">

					<?php $i = 1; ?>

					<?php foreach ( $values as $value ): ?>
						<?php if ( !empty($value['label']) ): ?>
							<div class="chart-item <?php echo 'chart-item-' . absint($i) ?>"><?php echo esc_html($value['label']) ?></div>
						<?php endif; ?>
						<?php $i++; ?>
					<?php endforeach; ?>

				</div>

			<?php elseif ( $style == 'style-2' ): ?>

				<?php
				$series = array(); $labs = '';

				foreach ( $values as $value ) {
					$series[] = $value['value'];
				}

				if ( is_array($labels) ) {
					$labs .= '[';
					$i = 0;
					foreach ( $labels as $label ) {
						if ( $i > 0 ) {
							$labs .= ', ';
						}
						$labs .= '"' . $label . '"';
						$i++;
					}
					$labs .= ']';
				} else {
					$labs = $labels;
				}

				?>

				<div class="ct-chart-holder">

					<div class="ct-chart5 line-chart"
						 data-series="[<?php echo implode( ', ', $series ) ?>]"
						 data-labels="<?php echo esc_attr($labs) ?>"
						 data-symbol="<?php echo esc_attr($symbol) ?>"
						 data-low="<?php echo absint($low) ?>"
						 data-high="<?php echo absint($high) ?>">

					</div>

					<div class="chart-info hr-type">

						<?php $i = 1; ?>

						<?php foreach ( $values as $value ): ?>

							<?php if ( !empty($value['label']) ): ; ?>
								<div class="chart-item <?php echo 'chart-item-' . absint($i) ?>"><?php echo esc_html($value['label']) ?></div>
							<?php endif; ?>

							<?php $i++; ?>

						<?php endforeach; ?>

					</div>

				</div>

			<?php endif; ?>

		<?php endif; ?>

		<?php return ob_get_clean() ;
	}

}