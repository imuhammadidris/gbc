<?php
/**
 * The template for displaying Archive pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Cryptex
 */

get_header(); ?>

<?php if ( have_posts() ) : ?>

	<?php
	$wrapper_attributes = $data_attributes = array();
	$css_classes = array( 'table-type-1', 'ico-calendar', 'entry-box' );
	$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
	$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
	$wrapper_attributes[] = implode( ' ', $data_attributes );
	?>

	<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

		<table>

			<tr>
				<th><?php echo esc_html__('Name', 'cryptox') ?></th>
				<th><?php echo esc_html__('Start', 'cryptox') ?></th>
				<th><?php echo esc_html__('End', 'cryptox') ?></th>
			</tr>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				$description = get_post_meta(get_the_ID(), 'cryptex_ico_description', true);
				$start_date = get_post_meta(get_the_ID(), 'cryptex_ico_start_date', true);
				$end_date = get_post_meta(get_the_ID(), 'cryptex_ico_end_date', true);
				?>

				<tr>
					<td>

						<div class="entry entry-ico">

							<?php if ('' !== get_the_post_thumbnail()) : ?>
								<div class="thumbnail-attachment">
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail('thumbnail'); ?>
									</a>
								</div>
							<?php endif; ?>

							<div class="entry-body">

								<h5 class="entry-title">
									<a href="<?php the_permalink() ?>"><?php the_title() ?></a>
								</h5>

								<?php if (!empty($description)): ?>
									<?php echo apply_filters('the_content', $description) ?>
								<?php endif; ?>

							</div>

						</div><!--/ .entry-->

					</td>

					<td>
						<?php if (!empty($start_date)): ?>
							<?php echo cryptex_format_date($start_date) ?>
						<?php endif; ?>
					</td>

					<td>
						<?php if (!empty($end_date)): ?>
							<?php echo cryptex_format_date($end_date) ?>
						<?php endif; ?>
					</td>

				</tr>

			<?php endwhile; ?>

		</table>

	</div>

	<?php the_posts_pagination( array(
		'prev_text' => '<span class="screen-reader-text">' . esc_html__( 'Previous page', 'cryptox' ) . '</span>',
		'next_text' => '<span class="screen-reader-text">' . esc_html__( 'Next page', 'cryptox' ) . '</span>',
		'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'cryptox' ) . ' </span>'
	) );
	?>

<?php else : ?>

	<?php get_template_part( 'template-parts/post/content', 'none' ); ?>

<?php endif; ?>

<?php get_footer(); ?>