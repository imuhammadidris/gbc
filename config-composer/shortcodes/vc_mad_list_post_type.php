<?php

class WPBakeryShortCode_VC_mad_list_post_type extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts( array(
			'post_type' => 'post'
		), $atts, 'vc_mad_list_post_type' );

		return $this->html();
	}

	public function html() {

		extract( $this->atts );

		ob_start(); ?>

		<nav class="services-nav">

			<?php

			$args = array(
				'post_type' => $post_type,
				'numberposts' => -1
			);

			$posts = get_posts( $args );
			$this_id = get_the_ID();
			?>

			<ul>
				<?php foreach ( $posts as $post ): ?>
					<li <?php if ( $post->ID == $this_id ): ?>class="selected" <?php endif; ?>><a href="<?php echo get_the_permalink($post->ID) ?>"><?php echo esc_html($post->post_title) ?></a></li>
				<?php endforeach; ?>
			</ul>

		</nav>

		<?php return ob_get_clean();
	}

}