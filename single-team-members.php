<?php
/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Cryptex
 */
get_header(); ?>

<?php if ( have_posts() ): ?>

	<?php
	/* Start the Loop */
	while ( have_posts() ) : the_post(); ?>

		<div class="profile-page">
			<?php get_template_part( 'template-parts/team-members/single', 'content' ); ?>
		</div><!--/ .profile-page-->

	<?php endwhile; ?>

<?php endif; ?>

<?php get_footer(); ?>