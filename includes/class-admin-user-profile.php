<?php
/**
 * User profile social links for wp-admin
 *
 */
if ( !class_exists('cryptex_admin_user_profile') ) {

	class cryptex_admin_user_profile {

		public function __construct() {

			if ( is_admin() ) {

				add_action( 'show_user_profile', array( $this, 'add_meta_fields' ), 20 );
				add_action( 'edit_user_profile', array( $this, 'add_meta_fields' ), 20 );

				add_action( 'personal_options_update', array( $this, 'save_meta_fields' ) );
				add_action( 'edit_user_profile_update', array( $this, 'save_meta_fields' ) );

			}

		}

		function get_store_info( $seller_id ) {
			$info = get_user_meta( $seller_id, 'cryptex_profile_settings', true );
			$info = is_array($info) ? $info : array();
			$info = wp_parse_args( $info, array( 'social' => array() ) );
			return $info;
		}

		function get_social_profile_fields() {
			$fields = array(
				'facebook' => array(
					'icon' => 'icon-facebook',
					'title' => esc_html__('Facebook', 'cryptox'),
				),
				'twitter' => array(
					'icon' => 'icon-twitter',
					'title' => esc_html__('Twitter', 'cryptox'),
				),
				'google' => array(
					'icon' => 'icon-gplus-3',
					'title' => esc_html__('Google Plus', 'cryptox'),
				),
				'instagram' => array(
					'icon' => 'icon-instagram-5',
					'title' => esc_html__('Instagram', 'cryptox'),
				)

			);

			return apply_filters('cryptex_profile_social_fields', $fields);

		}

		/**
		 * Add fields to user profile
		 *
		 * @param WP_User $user
		 *
		 * @return void|false
		 */
		function add_meta_fields($user)
		{
			$store_settings = $this->get_store_info($user->ID);
			$social_fields = $this->get_social_profile_fields();

			?>
			<h3><?php esc_html_e('Social Options', 'cryptox'); ?></h3>

			<table class="form-table">
				<tbody>

				<?php foreach ( $social_fields as $key => $value ) : ?>

					<tr>
						<th><?php echo esc_html($value['title']); ?></th>
						<td>
							<input type="text" name="cryptex_admin_social[social][<?php echo esc_attr($key); ?>]"
								   class="regular-text"
								   value="<?php echo isset($store_settings['social'][$key]) ? esc_url($store_settings['social'][$key]) : ''; ?>">
						</td>
					</tr>

				<?php endforeach; ?>

				<?php do_action('cryptex_seller_meta_fields', $user); ?>

				</tbody>
			</table>
			<?php
		}

		public function output_social_links() {

			$social_fields = $this->get_social_profile_fields();
			$profile_info = $this->get_store_info(get_current_user_id());
			?>

			<ul class="social-icons style-3">

				<?php foreach ( $social_fields as $key => $field ) : ?>
					<?php if ( isset($profile_info['social'][$key]) && !empty($profile_info['social'][$key]) ) : ?>
						<li>
							<a target="_blank"
							   href="<?php echo isset($profile_info['social'][$key]) ? esc_url($profile_info['social'][$key]) : '' ?>">
								<i class="<?php echo isset($field['icon']) ? $field['icon'] : ''; ?>"></i>
							</a>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>

			</ul>

			<?php
		}

		/**
		 * Save user data
		 *
		 * @param int $user_id
		 *
		 * @return void
		 */
		function save_meta_fields($user_id) {

			if ( current_user_can('edit_user',$user_id) )
				update_user_meta($user_id, 'cryptex_profile_settings', $_POST['cryptex_admin_social']);

		}
	}
}

