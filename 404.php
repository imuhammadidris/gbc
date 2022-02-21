<?php get_header(); ?>

<?php global $cryptex_settings;
$error_content = $cryptex_settings['error-content'];
?>

<div class="page-404-section">

	<div class="container">

		<?php echo html_entity_decode($error_content); ?>

		<?php
		echo sprintf('<p>%1$s <a href="%2$s" class="text-link2">%3$s</a> %4$s:</p>',
			esc_html__('Go', 'cryptox'),
			esc_url( home_url('/') ),
			esc_html__('Home', 'cryptox'),
			esc_html__('or try to search', 'cryptox')
		);

		$search_form_template = locate_template( 'searchform.php' );
		if ( '' != $search_form_template ) {
			ob_start();
			require( $search_form_template );
			echo ob_get_clean();
		}
		?>

	</div>

</div><!--/ .page-404-section-->

<?php get_footer(); ?>