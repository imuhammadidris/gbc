
<?php
global $cryptex_settings;
$style_copyright = trim(get_post_meta( get_the_ID(), 'cryptex_style_copyright', true ));

if ( empty($style_copyright) ) {
	$style_copyright = $cryptex_settings['footer-copyright-style'];
}

?>

<?php if ( $cryptex_settings['show-footer-copyright'] ): ?>

	<?php if ( $style_copyright == 'style-1' ): ?>

		<div class="copyright style-1">

			<?php if ( !empty($cryptex_settings['footer-copyright']) ): ?>
				<?php echo wp_kses($cryptex_settings['footer-copyright'],
					array(
						'a' => array(
							'href' => true,
							'title' => true,
						)
					)); ?>
			<?php endif; ?>

		</div>

	<?php elseif ( $style_copyright == 'style-2' ): ?>

		<div class="copyright">

			<div class="container">

				<div class="row">

					<div class="col">

						<?php if ( !empty($cryptex_settings['footer-copyright']) ): ?>
							<?php echo wp_kses($cryptex_settings['footer-copyright'],
								array(
									'a' => array(
										'href' => true,
										'title' => true,
									)
								)); ?>
						<?php endif; ?>

					</div>

					<div class="col align-right">

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

		</div>


	<?php endif; ?>

<?php endif; ?>