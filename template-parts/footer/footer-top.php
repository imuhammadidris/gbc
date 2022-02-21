
<?php

global $cryptex_settings;

$hide_top_footer = (bool) get_post_meta( get_the_ID(), 'cryptex_top_footer', true ); ?>

<?php if ( $hide_top_footer ) return; ?>

<?php if ( !$cryptex_settings['show-top-footer'] || $hide_top_footer ) return; ?>

<div class="top-footer">

	<div class="container">

		<div class="row align-items-center">

			<div class="col-lg-3 col-md-12">
				<?php echo cryptex_logo(); ?>
			</div>

			<div class="col-lg-6 col-md-12 align-center">
				<?php echo cryptex_main_navigation( 'secondary', 'footer-list' ) ?>
			</div>

			<div class="col-lg-3 col-md-12 align-right">

				<?php if ( $cryptex_settings['show-footer-social-links']): ?>

					<ul class="social-icons">

						<?php if ( $cryptex_settings['footer-social-facebook']): ?>
							<li><a title="<?php echo esc_html__('Facebook', 'cryptox') ?>" href="<?php echo esc_url($cryptex_settings['footer-social-facebook']) ?>"><i class="icon-facebook"></i></a></li>
						<?php endif; ?>

						<?php if ( $cryptex_settings['footer-social-twitter']): ?>
							<li><a title="<?php echo esc_html__('Twitter', 'cryptox') ?>" href="<?php echo esc_url($cryptex_settings['footer-social-twitter']) ?>"><i class="icon-twitter"></i></a></li>
						<?php endif; ?>

						<?php if ( $cryptex_settings['footer-social-googleplus']): ?>
							<li><a title="<?php echo esc_html__('Tumblr', 'cryptox') ?>" href="<?php echo esc_url($cryptex_settings['footer-social-googleplus']) ?>"><i class="icon-gplus-3"></i></a></li>
						<?php endif; ?>

						<?php if ( $cryptex_settings['footer-social-linkedin']): ?>
							<li><a title="<?php echo esc_html__('LinkedIn', 'cryptox') ?>" href="<?php echo esc_url($cryptex_settings['footer-social-linkedin']) ?>"><i class="icon-linkedin-3"></i></a></li>
						<?php endif; ?>

					</ul>

				<?php endif; ?>

			</div>

		</div>

	</div>

</div><!--/ .top-footer-->