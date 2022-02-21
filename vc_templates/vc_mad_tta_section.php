<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$title = $tab_id = '';

extract( shortcode_atts( array(
	'title' => '',
	'tab_id' => '',
), $atts ) );

ob_start(); ?>

<div class="accordion-item">
	<h5 class="a-title"><?php echo esc_attr($title) ?></h5>
	<div class="a-content">
		<?php echo wpb_js_remove_wpautop( $content, true ) ?>
	</div>
</div>
<?php echo ob_get_clean();
