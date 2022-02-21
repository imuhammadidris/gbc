<?php
// reset all previous queries
wp_reset_postdata();

global $cryptex_settings, $cryptex_config;
$sidebar = $cryptex_settings['sidebar'];
$page_sidebar = trim( get_post_meta( cryptex_post_id(), 'cryptex_page_sidebar', true ) );

if ( isset($cryptex_config['sidebar_position'])) {
	if ( $cryptex_config['sidebar_position'] == 'no-sidebar' ) {
		return;
	}
}

if ( isset($cryptex_config['sidebar']) ) {
	if ( !is_active_sidebar($cryptex_config['sidebar']) ) {
		return;
	}
}

if ( is_singular( array('page', 'post') ) && !empty($page_sidebar) ) {
	$sidebar = $page_sidebar;
}

if ( is_singular('practice') ) {
	$sidebar = $cryptex_settings['practice-sidebar'];
} elseif ( is_singular('team-members') ) {
	$sidebar = $cryptex_settings['team-members-sidebar'];
} elseif ( cryptex_is_realy_woocommerce_page() ) {
	$sidebar = $cryptex_settings['product-sidebar'];
} elseif ( is_singular('ico') ) {
	$sidebar = $cryptex_settings['ico-sidebar'];
}

?>

<?php if ( !empty($sidebar) ): ?>

	<aside id="sidebar" class="sidebar">

		<?php
		if ( is_active_sidebar($sidebar) ) {
			dynamic_sidebar($sidebar);
		}
		?>

	</aside>

<?php endif; ?>


