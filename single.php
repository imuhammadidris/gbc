<?php
/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Cryptex
 */
get_header(); ?>

<?php if ( have_posts() ): ?>

	<?php global $cryptex_settings; $id = cryptex_post_id(); ?>

	<?php
	/* Start the Loop */
	while ( have_posts() ) : the_post(); ?>

		<div class="content-element">

			<div class="entry-single">

				<div class="row">

					<div class="sidebar col-sm-4">

						<div class="sidebar-widget">

							<div class="entry-box">

								<div class="entry entry-small">

									<?php if ( in_array('categories', $cryptex_settings['single-post-metas']) ): ?>

										<div class="thumbnail-attachment">
											<?php
											$categories = get_the_category_list(' ', '');
											if ( $categories ) {
												echo '<div class="entry-cats">' . $categories . '</div>';
											}
											?>
										</div>

									<?php endif; ?>

									<div class="entry-body">
										<?php echo cryptex_blog_post_meta(); ?>
									</div>

								</div>

							</div>

						</div>

						<div class="sidebar-widget">

							<?php if ( function_exists('cryptex_social_share') ): ?>
								<?php echo cryptex_social_share( array(
									'classes' => array( 'v-type' )
								) ); ?>
							<?php endif; ?>

						</div>

						<?php
						$ads = $cryptex_settings['post-ads']['url'];
						$link_to_ads = $cryptex_settings['post-link-ads'];

						if ( !empty($ads) ): ?>
							<div class="sidebar-widget">
								<div class="banner-wrap">
									<div class="banner-title"><?php echo esc_html__('Advertisement', 'cryptox') ?></div>
									<a href="<?php echo esc_url($link_to_ads) ?>"><img src="<?php echo esc_attr($ads) ?>" alt="<?php echo esc_attr_e('Advertisement', 'cryptox') ?>"></a>
								</div>
							</div>
						<?php endif; ?>

					</div><!--/ .sidebar-->

					<div class="main col-sm-8">

						<h2 class="title">
							<?php if ( is_sticky() ): ?>
								<span class="sticky-label"><?php esc_html_e('Featured', 'cryptox') ?></span>
							<?php endif; ?>

							<b><?php echo get_the_title() ?></b>
						</h2>

						<div class="single-holder">
							<?php get_template_part( 'template-parts/post/content', get_post_format() ); ?>
						</div>

						<?php if ( $cryptex_settings['post-tag'] ): ?>
							<?php
							$tags_list = get_the_tag_list( '', '' );
							if ( $tags_list ) {
								echo '<div class="tagcloud">' . $tags_list . '</div>';
							}
							?>
						<?php endif; ?>

					</div><!--/ .main-->

				</div><!--/ .row-->

			</div><!--/ .entry-single-->

			<?php if ( $cryptex_settings['post-nav'] ): ?>
				<?php get_template_part( 'template-parts/single/post', 'navigation' ) ?>
			<?php endif; ?>

		</div>

	<?php endwhile; // End of the loop .?>

	<?php if ( $cryptex_settings['post-related-posts'] ): ?>
		<div class="content-element">
			<?php get_template_part( 'template-parts/single/post', 'related-articles' ); ?>
		</div>
	<?php endif; ?>

	<?php if ( $cryptex_settings['post-comments'] ): ?>
		<div class="content-element">
			<?php if ( comments_open() || get_comments_number() ): ?>
				<?php comments_template(); ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php endif; ?>

<?php get_footer(); ?>