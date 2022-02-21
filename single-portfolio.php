<?php
/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Cryptex
 */
get_header(); ?>

<?php if ( have_posts() ): ?>

	<?php global $cryptex_settings; ?>

	<?php
	/* Start the Loop */
	while ( have_posts() ) : the_post(); ?>

		<div class="project single-event">

			<div id="post-<?php the_ID(); ?>">

				<?php
				the_content();

				wp_link_pages( array(
					'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'cryptox' ),
					'after'       => '</div>',
					'link_before' => '<span class="page-number">',
					'link_after'  => '</span>',
				) );
				?>

			</div>

			<div class="project-description">

				<div class="content-element3">
					<div class="row">
						<div class="col-md-8 col-sm-12">

							<?php if ( has_excerpt() ): ?>

								<h6 class="event-title"><?php echo esc_html__('Description', 'cryptox') ?></h6>
								<div class="text-black content-element3">
									<?php echo apply_filters( 'the_excerpt', get_the_excerpt() ); ?>
								</div>

							<?php endif; ?>

							<?php if ( function_exists('cryptex_social_share') ): ?>
								<?php echo cryptex_social_share(); ?>
							<?php endif; ?>

						</div>
						<div class="col-md-4 col-sm-12">

							<h6 class="event-title">
								<?php echo esc_html__('Details', 'cryptox') ?>
							</h6>

							<ul class="custom-list">

								<li>
									<span><?php echo esc_html__('Date', 'cryptox') ?>:</span>
									<?php
									echo sprintf( '<time datetime="%1$s">%2$s</time>',
										esc_attr( get_the_date( 'c' ) ),
										esc_attr( get_the_date( 'D j, Y' ) )
									);
									?>
								</li>

								<?php $categories = get_the_term_list( get_the_ID(), 'portfolio_categories', '<li>', ', ','</li>' ); ?>

								<?php if ( $categories ): ?>
									<li>
										<span><?php echo esc_html__('Category', 'cryptox') ?>:</span>
										<?php echo '<ul class="term-list custom-list">' . $categories . '</ul>'; ?>
									</li>
								<?php endif; ?>

								<li>
									<span><?php echo esc_html__('Author', 'cryptox') ?>:</span>
									<a href="<?php echo admin_url( 'profile.php?user_id=' . get_the_author_meta( 'ID' ) ) ?>" class="link-text"><?php echo get_the_author() ?></a>
								</li>

								<?php $tags_list = get_the_tag_list( '', '', '' ); ?>

								<?php if ( $tags_list ): ?>
									<li>
										<span><?php echo esc_html__('Tags', 'cryptox') ?>: &nbsp;</span>
										<?php echo '<div class="tagcloud">' . $tags_list . '</div>'; ?>
									</li>
								<?php endif; ?>

							</ul>

						</div>
					</div>
				</div>

			</div>

		</div><!--/ .project-->

		<?php if ( $cryptex_settings['portfolio-nav'] ): ?>
			<?php get_template_part( 'template-parts/portfolio/post', 'navigation' ); ?>
		<?php endif; ?>

		<?php if ( $cryptex_settings['portfolio-related-posts'] ): ?>
			<?php get_template_part( 'template-parts/portfolio/related-articles' ); ?>
		<?php endif; ?>

	<?php endwhile; ?>

<?php endif; ?>

<?php get_footer(); ?>