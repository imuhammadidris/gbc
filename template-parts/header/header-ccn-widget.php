

<?php
global $cryptex_settings;

if ( !$cryptex_settings['show-crypto-widget'] ) return;

$symbols_settings = $cryptex_settings['crypto-widget-symbols'];
$symbols = 'BTC,XRP,BCH,EOS,LTC,TRX,ADA,XLM,IOT,ABC,NEO,XMR,DASH,XEM,QTUM,BCN,ICX,ZEC,LSK,IOST';

if ( !empty($symbols_settings) ) {
	$symbols = $symbols_settings;
}

$symbols_array = explode( ',', $symbols );

wp_enqueue_script( 'd3' );
wp_enqueue_script( 'moment' );
wp_enqueue_script( 'cryptex-header-widget' );

ob_start(); ?>

<div class="market-info">

	<div class="container">

		<div class="market-items">

			<div class="market-item cs-item">

				<div class="market-inner">

					<div class="toggle-currency custom-select price-check">

						<div class="select-title"><?php echo esc_html($symbols_array[0]) ?>/USD</div>

						<ul id="menu-type" class="select-list">

							<?php foreach ( $symbols_array as $symbol ): ?>
								<li>
									<a data-val="<?php echo esc_attr($symbol) ?>" href="javasript:void(0)"><?php echo esc_html($symbol) ?>/USD</a>
								</li>
							<?php endforeach; ?>

						</ul>

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

	</div>

</div><!--/ .market-info-->

<?php echo ob_get_clean() ;
