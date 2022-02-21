
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

<!-- top-header -->

<div class="top-header">

	<div class="container">

		<div class="row justify-content-between align-items-center">

			<div class="col">

				<div class="logo-wrap">
					<?php echo cryptex_logo(); ?>
				</div>

			</div>

			<div class="col-xl-6 col-lg-8 col">

				<!-- - - - - - - - - - - - / Mobile Menu - - - - - - - - - - - - - -->

				<!--main menu-->

				<div class="menu-holder">

					<div class="container">

						<div class="menu-wrap">

							<div class="nav-item">

								<nav id="main-navigation" class="main-navigation">
									<?php echo cryptex_main_navigation() ?>
								</nav>

							</div>

						</div>

					</div>

				</div>

			</div>

			<div class="col align-right">

				<div class="head-action">

					<?php if ( $cryptex_settings['header-style-2-search'] ): ?>
						<div class="search-holder">
							<button type="button" class="search-button"></button>
						</div>
					<?php endif; ?>

					<?php if ( $cryptex_settings['header-style-2-button'] ): ?>
						<a href="<?php echo esc_url($cryptex_settings['header-style-2-button-link']) ?>" class="btn btn-style-3 btn-big"><?php echo esc_html($cryptex_settings['header-style-2-button-text']) ?></a>
					<?php endif; ?>

					<?php if ( defined('ICL_LANGUAGE_CODE') ): ?>
						<?php if ( $cryptex_settings['header-style-2-show-language'] ): ?>
							<?php echo Cryptex_WC_WPML_Config::wpml_header_languages_list_with_flag(); ?>
						<?php endif; ?>
					<?php endif; ?>

				</div>

			</div>

		</div>

	</div>

</div>