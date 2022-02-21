<?php
/**
* The template for displaying pages
*
* This is the template that displays all pages by default.
* Please note that this is the WordPress construct of pages and that
* other "pages" on your WordPress site will use a different template.
*
* @package WordPress
* @since Cryptex 1.0
*/

get_header(); ?>

<!-- - - - - - - - - - - - - Page - - - - - - - - - - - - - - - -->

<?php if ( have_posts() ) : ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<div class="main-content">
			<?php the_content(); ?>
		</div>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'cryptox' ),
			'after'  => '</div>',
		) );
		?>

		<?php
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}

	endwhile; ?>

<?php endif; ?>

<?php wp_reset_postdata(); ?>

<!-- - - - - - - - - - - - -/ Page - - - - - - - - - - - - - - -->

<?php get_footer();

