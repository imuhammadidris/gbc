<?php

if ( !class_exists('Cryptex_WC_WPML_Config') ) {

	class Cryptex_WC_WPML_Config {

		public static function wpml_header_languages_list() {

			global $sitepress;
			$languages = $sitepress->get_ls_languages();

			if ( 1 < count($languages) ) { ?>

				<div class="col align-right">

					<div class="lang-button">

						<?php foreach ( $languages as $l ): ?>

							<?php if ( $l['active'] ): ?>
								<a href="javascript:void(0)"><?php echo esc_html($l['native_name']); ?></a>
							<?php endif; ?>

						<?php endforeach; ?>

						<ul class="dropdown-list">

							<?php foreach ( $languages as $l ): ?>
								<li>
									<a <?php if ( $l['active'] ): ?> class="current" <?php endif; ?> href="<?php echo esc_url($l['url']) ?>">
										<?php echo esc_html($l['native_name']); ?>
									</a>
								</li>
							<?php endforeach; ?>

						</ul>

					</div>

				</div>

			<?php
			}
		}

		public static function wpml_header_languages_list_with_flag() {

			global $sitepress;
			$languages = $sitepress->get_ls_languages();

			if ( 1 < count($languages) ) { ?>

				<div class="lang-button">

					<?php foreach ( $languages as $l ): ?>

						<?php if ( $l['active'] ): ?>
							<a href="javascript:void(0)">
								<img src="<?php echo esc_url($l['country_flag_url']); ?>" alt="<?php echo esc_attr($l['native_name']); ?>">
							</a>
						<?php endif; ?>

					<?php endforeach; ?>

					<ul class="dropdown-list">

						<?php foreach ( $languages as $l ): ?>
							<li>
								<a <?php if ( $l['active'] ): ?> class="current" <?php endif; ?> href="<?php echo esc_url($l['url']) ?>">
									<?php echo esc_html($l['native_name']); ?>
								</a>
							</li>
						<?php endforeach; ?>

					</ul>

				</div>

				<?php
			}
		}

	}

}


