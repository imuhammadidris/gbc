<?php
/**
 * Events Navigation Bar Module Template
 * Renders our events navigation bar used across our views
 *
 * $filters and $views variables are loaded in and coming from
 * the show funcion in: lib/Bar.php
 *
 * Override this template in your own theme by creating a file at:
 *
 *     [your-theme]/tribe-events/modules/bar.php
 *
 * @package  TribeEventsCalendar
 * @version  4.3.5
 */
?>

<?php

$filters = tribe_events_get_filters();
$views   = tribe_events_get_views();

$current_url = tribe_events_get_current_filter_url();
?>

<?php do_action( 'tribe_events_bar_before_template' ) ?>
<div id="tribe-events-bar">

	<form id="tribe-bar-form" class="tribe-clearfix" name="tribe-bar-form" method="post" action="<?php echo esc_attr( $current_url ); ?>">

		<!-- Mobile Filters Toggle -->

		<div id="tribe-bar-collapse-toggle" <?php if ( count( $views ) == 1 ) { ?> class="tribe-bar-collapse-toggle-full-width"<?php } ?>>
			<?php printf( '%s %s', esc_html__( 'Find', 'cryptox' ), tribe_get_event_label_plural() ); ?><span class="tribe-bar-toggle-arrow"></span>
		</div>

		<?php if ( ! empty( $filters ) ) { ?>

			<?php
			$geoloc = false;
			foreach ( $filters as $filter) {
				if ( $filter['name'] == 'tribe-bar-geoloc' ) {
					$geoloc = true;
				}
			}
			?>

			<div class="tribe-bar-filters <?php if ( $geoloc ): ?>tribe-has-geoloc-filter<?php endif; ?>">
				<div class="tribe-bar-filters-inner tribe-clearfix">

					<?php foreach ( $filters as $filter ) : ?>
						<div class="<?php echo esc_attr( $filter['name'] ) ?>-filter">
							<label class="label-<?php echo esc_attr( $filter['name'] ) ?>" for="<?php echo esc_attr( $filter['name'] ) ?>"><?php echo esc_html($filter['caption']) ?></label>
							<?php echo sprintf( '%s', $filter['html'] ) ?>
						</div>
					<?php endforeach; ?>
					<div class="tribe-bar-submit">
						<label>&nbsp;</label>
						<button type="submit" class="tribe-events-button tribe-no-param" name="submit-bar"><?php printf( esc_attr__( 'Find %s', 'cryptox' ), tribe_get_event_label_plural() ); ?></button>
					</div>
					<!-- .tribe-bar-submit -->
				</div>
				<!-- .tribe-bar-filters-inner -->
			</div><!-- .tribe-bar-filters -->
		<?php } // if ( !empty( $filters ) ) ?>

		<!-- Views -->
		<?php if ( count( $views ) > 1 ) { ?>
			<div id="tribe-bar-views">
				<div class="tribe-bar-views-inner tribe-clearfix">

					<h3 class="tribe-events-visuallyhidden"><?php esc_html_e( 'Event Views Navigation', 'cryptox' ) ?></h3>

					<label><?php esc_html_e( 'View As', 'cryptox' ); ?></label>

					<div class="cryptex-custom-select kw-over">

						<?php foreach ( $views as $view ) : ?>
							<?php if ( tribe_is_view( $view['displaying']) ): ?>
								<div class="cryptex-selected-option <?php echo esc_attr($view['displaying']) ?>"><?php echo esc_html($view['anchor']); ?></div>
							<?php endif; ?>
						<?php endforeach; ?>

						<ul class="cryptex-options-list">
							<?php foreach ( $views as $view ) : ?>
								<li class="<?php echo esc_attr($view['displaying']) ?>">
									<a <?php if ( tribe_is_view( $view['displaying']) ): ?>class="active"<?php endif; ?> href="<?php echo esc_attr( $view['url'] ); ?>">
										<?php echo esc_html($view['anchor']); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>

					</div><!--/ .kw-custom-select-->

				</div>
				<!-- .tribe-bar-views-inner -->
			</div><!-- .tribe-bar-views -->
		<?php } // if ( count( $views ) > 1 ) ?>


	</form>
	<!-- #tribe-bar-form -->

</div><!-- #tribe-events-bar -->
<?php
do_action( 'tribe_events_bar_after_template' );
