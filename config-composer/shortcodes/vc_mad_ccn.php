<?php

class WPBakeryShortCode_VC_mad_ccn extends WPBakeryShortCode {

	public $symbols = '';

	protected function content($atts, $content = null) {

		wp_enqueue_script( 'd3' );
		wp_enqueue_script( 'moment' );
		wp_enqueue_script( 'cryptex-header-widget' );

		$this->atts = shortcode_atts( array(
			'symbols' => 'BTC,XRP,BCH,EOS,LTC,TRX,ADA,XLM,IOT,ABC,NEO,XMR,DASH,XEM,QTUM,BCN,ICX,ZEC,LSK,IOST',
		), $atts, 'vc_mad_ccn' );

		$symbols_array = explode( ',', $this->atts['symbols'] );
		$this->setSymbols($symbols_array);

		return $this->html();
	}

	public function setSymbols( $symbols ) {
		if ( is_array($symbols) ) {
			$this->symbols = $symbols;
		}
	}

	public function html() {

		extract( $this->atts ); ob_start(); ?>

		<div class="market-info">

			<div class="market-items">

				<div class="market-item cs-item">

					<div class="market-inner">
						<div class="toggle-currency price-check">

							<?php if ( isset($this->symbols) && !empty($this->symbols) ): ?>

								<select class="custom-select">

									<?php $i = 1; ?>

									<?php foreach ( $this->symbols as $symbol ): ?>
										<option <?php if ( $i == 1 ): ?>selected="selected"<?php endif; ?> value="<?php echo esc_attr($symbol) ?>"><?php echo esc_html($symbol) ?>/USD</option>
										<?php $i++; ?>
									<?php endforeach; ?>

								</select>

							<?php endif; ?>

						</div>
					</div>

				</div>

				<div class="market-item graph-item">

					<div class="market-inner">
						<div class="graph">
							<div id="ccnSummaryGraph"></div>
						</div>
					</div>

				</div>

				<div class="market-item">

					<div class="market-inner">
						<div class="current-price">
							<time id="ccnSummaryCurrentTime" class="small" datetime=""></time>
							<span id="ccnSummaryPriceCurrent" class="font-weight-bold" data-raw=""></span>
						</div>
					</div>

				</div>

				<div class="market-item">

					<div class="market-inner">
						<div class="summary-low">
							<span class="small"><?php esc_html_e('Low', 'cryptox') ?></span>
							<span id="ccnSummaryLow" class="font-weight-bold"></span>
						</div>
					</div>

				</div>

				<div class="market-item">

					<div class="market-inner">
						<div class="summary-high">
							<span class="small"><?php esc_html_e('High', 'cryptox') ?></span>
							<span id="ccnSummaryHigh" class="font-weight-bold"></span>
						</div>
					</div>

				</div>

				<div class="market-item">

					<div class="market-inner">
						<div class="summary-marketcap">
							<span class="small"><?php esc_html_e('Marketcap', 'cryptox') ?></span>
							<span id="ccnSummaryMarketCap" class="font-weight-bold"></span>
						</div>
					</div>

				</div>

			</div><!--/ .market-items-->

		</div><!--/ .market-info-->

		<?php return ob_get_clean() ;
	}

}