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

	<div class="entry-single">

		<?php
		/* Start the Loop */
		while ( have_posts() ) : the_post();
			the_content();
		endwhile; // End of the loop.
		?>

	</div>

<?php endif; ?>

<?php get_footer(); ?>