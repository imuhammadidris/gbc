<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.3
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();
$event_id = get_the_ID();
?>

<div id="tribe-events-content" class="tribe-events-single">

	<div class="tribe-events-page-nav">

		<div class="tribe-events-back">
			<a href="<?php echo esc_url( tribe_get_events_link() ); ?>">
				<?php printf( esc_html_x( 'All %s', '%s Events plural label', 'cryptox' ), $events_label_plural ); ?>
			</a>
		</div>

		<?php
		$tribe_events_ical = new Tribe__Events__iCal();
		echo sprintf( '%s', $tribe_events_ical->single_event_links() );
		?>

	</div>

	<!-- Notices -->
	<?php tribe_the_notices() ?>

	<?php while ( have_posts() ) :  the_post(); ?>

		<div class="single-event">

			<div class="row">

				<div class="col-lg-8 col-md-12">

					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<!-- Event featured image, but exclude link -->

						<?php echo tribe_event_featured_image( $event_id, 'full', false ); ?>

						<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>

						<?php do_action( 'tribe_events_single_event_after_the_content' ) ?>

						<div class="content-element2">

							<div class="row">

								<div class="col-md-6 col-sm-12">

									<?php
									// Always include the main event details in this first section
									tribe_get_template_part( 'modules/meta/details' );
									?>

								</div>

								<div class="col-md-6 col-sm-12">

									<?php
									// Include organizer meta if appropriate
									if ( tribe_has_organizer() ) {
										tribe_get_template_part( 'modules/meta/organizer' );
									}
									?>

								</div>

							</div>

						</div>

						<div class="content-element3">
							<div class="tribe-events-single-event-description tribe-events-content">
								<?php the_content(); ?>

								<?php if ( function_exists('cryptex_social_share') ): ?>
									<?php echo cryptex_social_share(); ?>
								<?php endif; ?>

							</div>
						</div>

					</div>

					<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>

				</div>

				<div class="col-lg-4 col-md-12">

					<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>

					<?php tribe_get_template_part( 'modules/meta' ); ?>

					<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>

				</div>

			</div>

		</div>

	<?php endwhile; ?>

	<div id="tribe-events-footer">

		<h3 class="tribe-events-visuallyhidden"><?php printf( '%s %s', $events_label_singular, esc_html__( 'Navigation', 'cryptox' ) ); ?></h3>

		<ul class="tribe-events-sub-nav">
			<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
			<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
		</ul>

	</div>

	<?php echo cryptex_tribe_single_related_events(); ?>

</div><!-- #tribe-events-content -->
