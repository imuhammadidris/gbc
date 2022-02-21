<?php

class WPBakeryShortCode_vc_mad_vcw_table extends WPBakeryShortCode {

	public $atts = array();
	protected $currency      = 'USD';
	protected $currencies    = array();
	protected $main_class    = '';

	protected $ids = array();

	protected function content( $atts, $content = null ) {

		if ( !defined('VCW_VERSION') ) return;

		$this->atts = shortcode_atts( array(
			'ids' => '',
			'currency'  => 'USD',
			'count'     => 16
		), $atts, 'vc_mad_vcw_table' );

		$atts = $this->atts;
		extract( $atts );

		$this->setCurrency($currency);

		return $this->build();
	}

	public function setCurrency( $currency )
	{
		if ( is_string($currency) ) {
			$this->currency = $currency;
		}
	}

	protected function quotation($info, $show_unit = true, $currency = null)
	{
		if( !is_array($info) ) {
			return '---';
		}

		$currency       = $currency ?: $this->currency;
		$rate           = VCW_Data::rate($currency);
		$lower_code     = strtolower($currency);
		$price_value    = empty($info['price'][$lower_code]) ? '?' : VCW_Helpers::price_format($info['price'][$lower_code]);
		$id             = $info['id'];

		return $show_unit ?
			"{$rate['unit']} <price-output data-currency=\"$currency\" data-id=\"$id\">$price_value</price-output>" :
			"<price-output data-currency=\"$currency\" data-id=\"$id\">$price_value</price-output>";
	}

	public function build() {

		if ( !empty($this->atts['ids']) ) {

			$this->ids = explode(',', $this->atts['ids']);

			if ( is_array($this->ids) ) {

				$output = '';

				foreach ( $this->ids as $id ) {

					$info = VCW_Data::coin($id);

					if ( !$info ) continue;

					$change_1h  = $info['change_1h'];
					$volume_24h  = $info['change_24h'];

					$output .= '<div class="cr-item">';
					$output .= '<div class="cr-currency">'. $info['name'] .'<span class="change-icon '. $this->changeIcon($change_1h) .'">'. VCW_Helpers::changeString($change_1h) .'</span></div>';
					$output .= '<div class="cr-price"><span>'. $this->quotation($info, false, $this->currency) .'</span> '. $this->currency .'</div>';
					$output .= '<div class="vol"> '. esc_html__('Volume', 'cryptox') . ': <span>'. VCW_Helpers::changeString($volume_24h, true) .'</span></div>';
					$output .= '</div>';

				}

				return (string) '<div class="str crypto-section">'. $output .'</div>';
			}

		}

		return '';

	}

	protected function changeIcon($change)
	{
		if(is_null($change)) {
			$classes = '';
		} else if($change > 0) {
			$classes = 'plus';
		} else if($change < 0) {
			$classes = '';
		} else {
			$classes = '';
		}

		return $classes;
	}

}