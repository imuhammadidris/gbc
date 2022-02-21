<?php
/**
 * The template for displaying Testimonials Archive area.
 */

get_header(); ?>

<?php if ( have_posts() ): ?>

	<?php
	global $cryptex_settings;

	$css_classes = array( 'testimonial-holder', 'style-4' );
	$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
	$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
	?>

	<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

		<?php while ( have_posts() ) : the_post(); ?>

			<div class="item-carousel">

				<div class="testimonial">

					<blockquote>
						<p><?php echo get_post_meta( get_the_ID(), 'cryptex_testi_text', true ); ?></p>
						<div class="author"><?php echo get_post_meta( get_the_ID(), 'cryptex_testi_name', true ); ?>, <?php echo get_the_title() ?></div>
					</blockquote>

				</div>

			</div><!--/ .item-carousel-->

		<?php endwhile; ?>

	</div>

	<?php
	the_posts_pagination( array(
		'prev_text' => '<span class="screen-reader-text">' . esc_html__( 'Previous page', 'cryptox' ) . '</span>',
		'next_text' => '<span class="screen-reader-text">' . esc_html__( 'Next page', 'cryptox' ) . '</span>',
		'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'cryptox' ) . ' </span>'
	) );
	?>

	<?php wp_reset_postdata(); ?>

<?php else: ?>

	<?php get_template_part( 'template-parts/post/content', 'none' ); ?>

<?php endif; ?>

<?php get_footer(); ?>