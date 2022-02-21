<?php
/**
 * Related Events Template
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$posts = cryptex_tribe_get_related_posts();

if ( is_array( $posts ) && ! empty( $posts ) ) : ?>

	<h3 class="tribe-events-related-events-title">
		<?php printf( __( 'Related %s', 'cryptox' ), tribe_get_event_label_plural() ); ?>
	</h3>

	<ul class="tribe-related-events tribe-clearfix">

		<?php foreach ( $posts as $post ) : ?>

			<li>
				<div class="tribe-related-entry">

					<?php $thumb = ( has_post_thumbnail( $post->ID ) ) ? get_the_post_thumbnail( $post->ID, 'large' ) : '<img src="' . esc_url( trailingslashit( Tribe__Events__Pro__Main::instance()->pluginUrl ) . 'src/resources/images/tribe-related-events-placeholder.png' ) . '" alt="' . esc_attr( get_the_title( $post->ID ) ) . '" />'; ?>

					<div class="tribe-related-events-thumbnail">
						<a href="<?php echo esc_url( tribe_get_event_link( $post ) ); ?>" class="url" rel="bookmark">
							<?php echo sprintf( '%s', $thumb ) ?>
						</a>
					</div>

					<div class="tribe-related-event-info">

						<h5 class="tribe-related-events-title">
							<a href="<?php echo tribe_get_event_link( $post ); ?>" class="tribe-event-url" rel="bookmark">
								<?php echo get_the_title( $post->ID ); ?>
							</a>
						</h5>

						<?php
						if ( $post->post_type == Tribe__Events__Main::POSTTYPE ) {
							echo '<div class="tribe-event-schedule-details tribe-related-event-schedule-details">';
							echo tribe_events_event_schedule_details( $post );
							echo '</div>';
						}
						?>

						<?php echo tribe_events_get_the_excerpt(); ?>

					</div>

				</div><!--/ .entry-->
			</li>

		<?php endforeach; ?>

	</ul>

	<?php
endif;
