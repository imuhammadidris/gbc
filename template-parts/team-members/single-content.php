
<?php
	$position = mad_meta( 'cryptex_tm_position', '' );
	$location = mad_meta( 'cryptex_tm_location', '' );
	$phone = mad_meta( 'cryptex_tm_phone', '' );
	$fax = mad_meta( 'cryptex_tm_fax', '' );
	$email = mad_meta( 'cryptex_tm_email', '' );
	$vcard = mad_meta( 'cryptex_tm_vcard', '' );
	$facebook = mad_meta( 'cryptex_tm_facebook', '' );
	$twitter = mad_meta( 'cryptex_tm_twitter', '' );
	$gplus = mad_meta( 'cryptex_tm_gplus', '' );
	$linkedin = mad_meta( 'cryptex_tm_linkedin', '' );
?>

<div class="team-item team-single">

	<?php if ( '' !== get_the_post_thumbnail() ) : ?>

		<a href="<?php echo get_the_permalink() ?>" class="member-photo">
			<?php the_post_thumbnail( 'cryptex-430x465-center-center' ); ?>
		</a>

	<?php endif; ?>

	<div class="team-desc">

		<div class="member-info">

			<h3 class="member-name">
				<a href="<?php echo esc_url(get_the_permalink()) ?>">
					<?php echo esc_html(get_the_title()) ?>
				</a>
			</h3>

			<?php if ( !empty($position) ): ?>
				<h6 class="member-position"><?php echo esc_html($position) ?></h6>
			<?php endif; ?>

		</div>

		<div class="our-info var2">

			<?php if ( !empty($location) ): ?>
				<div class="info-item">
					<i class="licon-map-marker"></i>
					<div class="info-wrapper">
						<?php echo esc_html($location) ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( !empty($phone) ): ?>

				<div class="info-item">
					<i class="licon-telephone"></i>
					<div class="info-wrapper">
						<span content="telephone=no"><?php echo esc_html($phone) ?></span>
					</div>
				</div>

			<?php endif; ?>

			<?php if ( !empty($fax) ): ?>
				<div class="info-item">
					<i class="licon-printer"></i>
					<div class="info-wrapper">
						<span content="telephone=no"><?php echo esc_html($fax) ?></span>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( !empty($email) ): ?>
				<div class="info-item">
					<i class="licon-at-sign"></i>
					<div class="info-wrapper">
						<a href="mailto:<?php echo antispambot($email, 1) ?>"><?php echo esc_html($email) ?></a>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( !empty($vcard) ): ?>

				<div class="info-item">
					<i class="licon-profile"></i>
					<div class="info-wrapper">
						<a href="<?php echo esc_url($vcard) ?>"><?php esc_html_e('Download vCard', 'cryptox') ?></a>
					</div>
				</div>

			<?php endif; ?>

		</div>

		<?php if ( !empty($facebook) || !empty($twitter) || !empty($gplus) || !empty($linkedin) ): ?>

			<ul class="social-icons style-2 size-2">

				<?php if ( !empty($facebook) ): ?>
					<li class="fb"><a href="<?php echo esc_url($facebook) ?>"><i class="icon-facebook"></i></a></li>
				<?php endif; ?>

				<?php if ( !empty($twitter) ): ?>
					<li class="tw"><a href="<?php echo esc_url($twitter) ?>"><i class="icon-twitter"></i></a></li>
				<?php endif; ?>

				<?php if ( !empty($gplus) ): ?>
					<li class="ins"><a href="<?php echo esc_url($gplus) ?>"><i class="icon-gplus-3"></i></a></li>
				<?php endif; ?>

				<?php if ( !empty($linkedin) ): ?>
					<li class="in"><a href="<?php echo esc_url($linkedin) ?>"><i class="icon-linkedin"></i></a></li>
				<?php endif; ?>

			</ul>

		<?php endif; ?>

	</div>

</div>

<?php $custom_tabs = get_post_meta( get_the_ID(), 'cryptex_custom_tabs', true ); ?>

<div class="tabs tabs-section">

	<ul class="tabs-nav clearfix">

		<li><a class="active" href="#tab-1"><?php esc_html_e('Profile', 'cryptox') ?></a></li>

		<?php
		if ( isset($custom_tabs) && !empty($custom_tabs) && count($custom_tabs) > 0 ) : ?>
			<?php foreach ( $custom_tabs as $id => $tab ): ?>
				<li><a href="#tab-<?php echo esc_attr($id) ?>"><?php echo esc_html($tab['title_custom_tab']); ?></a></li>
			<?php endforeach; ?>
		<?php endif; ?>

	</ul>

	<div class="tabs-content">

		<div id="tab-1" class="tab"><?php the_content(); ?></div>

		<?php
		if ( isset($custom_tabs) && !empty($custom_tabs) && count($custom_tabs) > 0 ) : ?>

			<?php foreach ( $custom_tabs as $id => $tab ) : ?>

				<div id="tab-<?php echo esc_attr($id) ?>" class="tab">
					<?php echo apply_filters('the_content', $tab['content_custom_tab'] ); ?>
				</div>

			<?php endforeach; ?>

		<?php endif; ?>

	</div><!--/ .tabs-content-->

</div><!--/ .tabs-->