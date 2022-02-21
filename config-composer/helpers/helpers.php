<?php

if ( ! function_exists('cryptex_vc_manager') ) {
	function cryptex_vc_manager() {
		return Cryptex_Vc_Config::getInstance();
	}
}

if ( ! function_exists('cryptex_vc_asset_url') ) {
	function cryptex_vc_asset_url($file ) {
		return cryptex_vc_manager()->assetUrl( $file );
	}
}
