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

		<?php
		$start_date = get_post_meta( get_the_ID(), 'cryptex_ico_start_date', true );
		$end_date = get_post_meta( get_the_ID(), 'cryptex_ico_end_date', true );
		$website = get_post_meta( get_the_ID(), 'cryptex_ico_website', true );
		$whitepaper = get_post_meta( get_the_ID(), 'cryptex_ico_whitepaper', true );
		$facebook = get_post_meta( get_the_ID(), 'cryptex_ico_social_facebook', true );
		$twitter = get_post_meta( get_the_ID(), 'cryptex_ico_social_twitter', true );
		$bit = get_post_meta( get_the_ID(), 'cryptex_ico_bit', true );
		$medium = get_post_meta( get_the_ID(), 'cryptex_ico_medium', true );
		$teams = get_the_terms( get_the_ID(), 'ico_team' );
		$custom_tabs = get_post_meta( get_the_ID(), 'cryptex_custom_tabs', true );
		?>

		<div class="page-nav single">
			<a href="<?php echo get_post_type_archive_link('ico') ?>" class="info-btn prev-btn"><?php esc_html_e('ICO Calendar', 'cryptox') ?></a>
		</div>

		<div class="single-event">

			<div class="content-element2">

				<div class="row">
					<div class="col-lg-4 col-md-12">

						<?php if ( '' !== get_the_post_thumbnail() ) : ?>
							<div class="content-element1">
								<?php the_post_thumbnail( 'cryptex-315x310-center-center' ); ?>
							</div>
						<?php endif; ?>

						<h4 class="event-title"><b><?php the_title() ?></b></h4>

						<ul class="custom-list">

							<?php if ( !empty($start_date) ): ?>
								<li><span><?php echo esc_html__('Start', 'cryptox') ?>:</span> <?php echo cryptex_format_date($start_date) ?></li>
							<?php endif; ?>

							<?php if ( !empty($end_date) ): ?>
								<li><span><?php echo esc_html__('End', 'cryptox') ?>:</span> <?php echo cryptex_format_date($end_date) ?></li>
							<?php endif; ?>

							<?php if ( !empty($website) ): ?>
								<li><span><?php echo esc_html__('Website', 'cryptox') ?>:</span> <a href="<?php echo esc_url($website) ?>" class="link-text"><?php echo esc_html($website) ?></a></li>
							<?php endif; ?>

							<?php if ( !empty($whitepaper) ): ?>
								<li><span><?php echo esc_html__('Whitepaper', 'cryptox') ?>:</span> <a href="<?php echo esc_url($whitepaper) ?>" class="link-text"><?php echo esc_html__('Download PDF', 'cryptox') ?></a></li>
							<?php endif; ?>

							<?php if ( !empty($facebook) || !empty($twitter) || !empty($bit) ): ?>
								<li>
									<span><?php echo esc_html__('ICO links', 'cryptox') ?>:</span> &nbsp;
									<ul class="social-icons style-2">

										<?php if ( !empty($facebook) ): ?>
											<li class="fb"><a href="<?php echo esc_url($facebook) ?>"><i class="icon-facebook"></i></a></li>
										<?php endif; ?>

										<?php if ( !empty($twitter) ): ?>
											<li class="tw"><a href="<?php echo esc_url($twitter) ?>"><i class="icon-twitter"></i></a></li>
										<?php endif; ?>

										<?php if ( !empty($bit) ): ?>
											<li class="bit"><a href="<?php echo esc_url($bit) ?>"><i class="icon-bitcoin-1"></i></a></li>
										<?php endif; ?>

										<?php if ( !empty($medium) ): ?>
											<li class="md"><a href="<?php echo esc_url($medium) ?>"><i class="icon-medium"></i></a></li>
										<?php endif; ?>

									</ul>
								</li>
							<?php endif; ?>

						</ul>

					</div>
					<div class="col-lg-8 col-md-12">

						<div class="content-element2">

							<?php $link = get_post_meta( get_the_ID(), 'cryptex_ico_video_player', true ); ?>

							<?php if ( '' !== $link ): ?>
								<div class="content-element1">
									<div class="responsive-iframe">
										<?php
											global $wp_embed;
											echo sprintf( '%s', $wp_embed->run_shortcode( '[embed]' . $link . '[/embed]' ) );
										?>
									</div>
								</div>
							<?php endif; ?>

							<div class="tabs tabs-section">

								<ul class="tabs-nav clearfix">

									<li><a href="#tab-1"><?php echo esc_html__('Description', 'cryptox') ?></a></li>

									<?php if ( ! is_wp_error( $teams ) && ! empty ( $teams ) ) : ?>
										<li><a href="#tab-2"><?php echo esc_html__('Team', 'cryptox') ?></a></li>
									<?php endif; ?>

									<?php if ( isset($custom_tabs) && !empty($custom_tabs) && count($custom_tabs) > 0 ) : ?>
										<li><a href="#tab-3"><?php echo esc_html__('Details', 'cryptox') ?></a></li>
									<?php endif; ?>

								</ul><!--/ .tabs-nav-->

								<div class="tabs-content">

									<div id="tab-1">
										<?php echo apply_filters( 'the_content', get_the_content() ); ?>
									</div>

									<?php if ( ! is_wp_error( $teams ) && ! empty ( $teams ) ) { ?>

										<div id="tab-2">

											<div class="team-holder small-type">

												<div class="ico-card-team-item">

													<?php foreach ( $teams as $team ) :

														$term_position = cryptex_get_term_meta( 'pix_term_position', $team->term_id );
														$facebook = cryptex_get_term_meta( 'pix_term_team_facebook', $team->term_id );
														$twitter = cryptex_get_term_meta( 'pix_term_team_twitter', $team->term_id );
														$linkedin = cryptex_get_term_meta( 'pix_term_team_linkedin', $team->term_id );
													?>

														<div class="team-item">

															<div class="team-desc">

																<div class="member-info">

																	<h6 class="member-name"><a href="<?php echo esc_url(get_term_link($team)) ?>"><?php echo esc_html($team->name) ?></a></h6>

																	<?php if ( isset($term_position) && !empty($term_position) ): ?>
																		<h6 class="member-position"><?php echo esc_html($term_position) ?></h6>
																	<?php endif; ?>

																</div>

																<ul class="social-icons style-2">

																	<?php if ( isset($facebook) && !empty($facebook) ): ?>
																		<li class="fb"><a href="<?php echo esc_url($facebook) ?>"><i class="icon-facebook"></i></a></li>
																	<?php endif; ?>

																	<?php if ( isset($twitter) && !empty($twitter) ): ?>
																		<li class="tw"><a href="<?php echo esc_url($twitter) ?>"><i class="icon-twitter"></i></a></li>
																	<?php endif; ?>

																	<?php if ( isset($linkedin) && !empty($linkedin) ): ?>
																		<li class="in"><a href="<?php echo esc_url($linkedin) ?>"><i class="icon-linkedin"></i></a></li>
																	<?php endif; ?>

																</ul>

															</div><!--/ .team-desc-->

														</div><!--/ .team-item-->

													<?php endforeach; ?>

												</div><!--/ .ico-card-item-->

											</div><!--/ .team-holder-->

										</div>

									<?php } ?>

									<?php if ( isset($custom_tabs) && !empty($custom_tabs) && count($custom_tabs) > 0 ) : ?>

										<div id="tab-3">

											<div class="tokens">

												<div class="row">

													<?php foreach ( $custom_tabs as $id => $tab ) : ?>

														<div class="col-sm-6">

															<div class="token-item">

																<?php if ( isset($tab['title_custom_tab']) && !empty($tab['title_custom_tab'])):  ?>
																	<h6 class="token-title"><?php echo esc_html($tab['title_custom_tab']) ?></h6>
																<?php endif; ?>

																<?php echo apply_filters('the_content', $tab['content_custom_tab'] ); ?>

															</div>

														</div>

													<?php endforeach; ?>

												</div>

											</div>

										</div>

									<?php endif; ?>

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

			<?php if ( $cryptex_settings['ico-social-share'] ): ?>
				<?php if ( function_exists('cryptex_social_share') ) : ?>
					<?php echo cryptex_social_share() ?>
				<?php endif; ?>
			<?php endif; ?>

		</div><!--/ .single-event-->

		<?php if ( $cryptex_settings['ico-nav'] ): ?>
			<?php get_template_part( 'template-parts/single/ico', 'navigation' ) ?>
		<?php endif; ?>

	<?php endwhile; ?>

<?php endif; ?>

<?php get_footer(); ?>