<?php
/**
 * The template for displaying Testimonials Archive area.
 */

get_header(); ?>

<?php if ( have_posts() ): ?>

	<?php
	global $cryptex_settings;

	$css_classes = array(
		'portfolio-holder',
		'grid-standard',
		'cols-3',
	);

	$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
	$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
	?>

	<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

		<?php while ( have_posts() ) : the_post(); ?>

			<div class="item">

				<div class="project">

					<?php if ( has_post_thumbnail() ): ?>

						<div class="project-image">

							<?php echo get_the_post_thumbnail( get_the_ID(), 'cryptex-660x415-center-center' ); ?>
							<a href="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), '' ) ?>" class="project-link" data-fancybox="group"></a>

						</div><!--/ .project-image-->

					<?php endif; ?>

					<div class="project-description">

						<?php echo get_the_term_list( get_the_ID(), 'portfolio_categories', '<div class="project-cats">', '','</div>' ); ?>

						<h5 class="project-title">
							<a href="<?php echo esc_url(get_the_permalink()) ?>">
								<?php echo esc_html(get_the_title()) ?>
							</a>
						</h5>

					</div><!--/ .project-description-->

				</div><!--/ .project-->

			</div><!--/ .item-->

		<?php endwhile; ?>

	</div>

	<?php wp_reset_postdata(); ?>

<?php else: ?>

	<?php get_template_part( 'template-parts/post/content', 'none' ); ?>

<?php endif; ?>

<?php get_footer(); ?>