<?php

class WPBakeryShortCode_VC_mad_counter extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'title' => '',
//			'subtitle' => '',
			'title_color' => '',
//			'subtitle_color' => '',
			'align_title' => '',
			'style' => 'style-1',
			'columns' => 4,
			'values' => '',
		), $atts, 'vc_mad_counter');

		$html = $this->html();

		return $html;
	}

	public function html() {

		$values = $title = $style = '';
		$atts = $this->atts;

		extract( $atts );
		$values = (array) vc_param_group_parse_atts( $values );

		$css_classes = array(
			'counter-wrap', $style
		);

		$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );

		ob_start(); ?>

		<!-- - - - - - - - - - - - - - Counter - - - - - - - - - - - - - - - - -->

		<?php if ( !empty($values) ): ?>

			<?php
			echo Cryptex_Vc_Config::getParamTitle(
				array(
					'title' => $title,
				)
			);
			?>

			<div class="<?php echo esc_attr(trim($css_class)) ?>">

				<div class="row">

					<?php foreach ( $values as $value ): ?>

						<div class="col-lg-3 col-md-6 col-sm-6">

							<div class="counter">

								<div class="count-item">

									<?php if ( isset($value['icon']) ): ?>

										<?php $icon = trim($value['icon']); ?>

										<?php if ( !empty($icon) && $icon !== 'none' ): ?>
											<span class="<?php echo trim($icon) ?>"></span>
										<?php endif; ?>

									<?php endif; ?>

									<h3 class="timer count-number" data-to="<?php echo esc_attr($value['value']) ?>" data-speed="1500">0</h3>

								</div>

								<p><?php echo esc_html($value['label']) ?></p>

							</div>

						</div>

					<?php endforeach; ?>

				</div>

			</div>

		<?php endif; ?>

		<!-- - - - - - - - - - - - - - End of Counter - - - - - - - - - - - - - - - - -->

		<?php return ob_get_clean();
	}

}