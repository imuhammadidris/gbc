
<?php global $cryptex_settings; ?>

<div class="searchform-wrap">
	<div class="vc-child h-inherit">

		<form class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<button type="submit" class="search-button"></button>
			<div class="wrapper">
				<input type="text" autocomplete="off" id="s" name="s" placeholder="<?php esc_attr_e( 'Start typing...', 'cryptox' ) ?>" value="<?php echo get_search_query(); ?>">
			</div>
		</form>

		<button class="close-search-form"></button>

	</div>
</div>

<div class="pre-header">

	<div class="container">

		<div class="row justify-content-between">

			<div class="col">
				<div class="date">
					<?php echo current_time( 'l, F d, Y'); ?>
				</div>
			</div>

			<?php if ( defined('ICL_LANGUAGE_CODE') ): ?>
				<?php if ( $cryptex_settings['header-style-1-show-language'] ): ?>
					<?php echo Cryptex_WC_WPML_Config::wpml_header_languages_list(); ?>
				<?php endif; ?>
			<?php endif; ?>

		</div>

	</div>

</div><!--/ .pre-header-->

<div class="top-header">

	<div class="container">

		<div class="row justify-content-between align-items-center">

			<div class="col">

				<?php if ( $cryptex_settings['show-header-social-links']): ?>

					<ul class="social-icons">

						<?php if ( $cryptex_settings['header-social-facebook']): ?>
							<li><a title="<?php echo esc_attr__('Facebook', 'cryptox') ?>" href="<?php echo esc_url($cryptex_settings['header-social-facebook']) ?>"><i class="icon-facebook"></i></a></li>
						<?php endif; ?>

						<?php if ( $cryptex_settings['header-social-twitter']): ?>
							<li><a title="<?php echo esc_attr__('Twitter', 'cryptox') ?>" href="<?php echo esc_url($cryptex_settings['header-social-twitter']) ?>"><i class="icon-twitter"></i></a></li>
						<?php endif; ?>

						<?php if ( $cryptex_settings['header-social-googleplus']): ?>
							<li><a title="<?php echo esc_attr__('Tumblr', 'cryptox') ?>" href="<?php echo esc_url($cryptex_settings['header-social-googleplus']) ?>"><i class="icon-gplus-3"></i></a></li>
						<?php endif; ?>

						<?php if ( $cryptex_settings['header-social-linkedin']): ?>
							<li><a title="<?php echo esc_attr__('LinkedIn', 'cryptox') ?>" href="<?php echo esc_url($cryptex_settings['header-social-linkedin']) ?>"><i class="icon-linkedin-3"></i></a></li>
						<?php endif; ?>

					</ul>

				<?php endif; ?>

			</div>

			<div class="col">

				<div class="logo-wrap">
					<?php echo cryptex_logo(); ?>
				</div>

			</div>

			<div class="col align-right">
				<?php if ( $cryptex_settings['header-style-1-button'] ): ?>
					<a href="<?php echo esc_url($cryptex_settings['header-style-1-button-link']) ?>" class="btn btn-style-4 btn-big"><i class="licon-mailbox-full"></i><?php echo esc_html($cryptex_settings['header-style-1-button-text']) ?></a>
				<?php endif; ?>
			</div>

		</div>

	</div>

</div><!--/ .top-header-->

<div class="menu-holder">

	<div class="container">

		<div class="menu-wrap">

			<div class="nav-item">

				<nav id="main-navigation" class="main-navigation">
					<?php echo cryptex_main_navigation() ?>
				</nav>

			</div>

			<div class="search-holder">

				<?php if ( $cryptex_settings['header-style-1-search'] ): ?>
					<button type="button" class="search-button"></button>
				<?php endif; ?>

				<?php if ( $cryptex_settings['header-style-1-cart'] ): ?>
					<?php if ( defined('Cryptex_Woo_Config') ): ?>

						<div class="shop-cart">

							<button class="sc-cart-btn dropdown-invoker"><span class="licon-cart"></span></button>

							<div class="shopping-cart dropdown-window">
								<div class="widget_shopping_cart_content"></div>
							</div>

						</div>

					<?php endif; ?>
				<?php endif; ?>

			</div>

		</div>

	</div>

</div><!--/ .menu-holder-->