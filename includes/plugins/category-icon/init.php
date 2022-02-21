<?php
/*
Plugin Name: Category Icon
Plugin URI:  http://pixelgrade.com
Description: Easily add an icon to a category, tag or any other taxonomy.
Version: 0.6.0
Author: PixelGrade
Author URI: http://pixelgrade.com
Author Email: contact@pixelgrade.com
License:     GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

CryptexPixTaxonomyIconsPlugin::get_instance();

class CryptexPixTaxonomyIconsPlugin {
	protected static $instance;
	protected $plugin_screen_hook_suffix = null;
	protected $version = '0.6.0';
	protected $plugin_slug = 'cryptex-category-icon';
	protected $plugin_key = 'cryptex-category-icon';

	protected $default_settings = array(
		'taxonomies' => array(
			'ico_team' => 'on'
		)
	);

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 * @since     1.0.0
	 */
	protected function __construct() {

		$options = get_option('cryptex-category-icon');

		if ( empty( $options ) ) {
			$options = $this->get_defaults();
			update_option( 'cryptex-category-icon', $options );
		}

		// Load plugin text domain
		add_action( 'init', array( $this, 'plugin_init' ), 9999999999 );
		add_action( 'init', array( $this, 'register_the_termmeta_table' ), 1 );
		add_action('wpmu_new_blog', array($this, 'new_blog'), 10, 6);

//		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		register_activation_hook( __FILE__, array($this, 'activate') );
	}

	/**
	 * This will run when the plugin will turn On
	 *
	 * @param bool|false $network_wide
	 */
	function activate( $network_wide = false ) {
		global $wpdb;

		// if activated on a particular blog, just set it up there.
		if ( !$network_wide ) {
			$this->create_the_termmeta_table();
			return;
		}

		$blogs = $wpdb->get_col( "SELECT blog_id FROM {$wpdb->blogs} WHERE site_id = '{$wpdb->siteid}'" );
		foreach ( $blogs as $blog_id ) {
			$this->create_the_termmeta_table( $blog_id );
		}
		// I feel dirty... this line smells like perl.
		do {} while ( restore_current_blog() );
	}

	function new_blog( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {
		if ( is_plugin_active_for_network(plugin_basename(__FILE__)) )
			$this->create_the_termmeta_table($blog_id);
	}

	/**
	 * Return an instance of this class.
	 * @since     1.0.0
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	function plugin_init() {

		$selected_taxonomies = $this->get_plugin_option('taxonomies');

		if ( ! is_wp_error( $selected_taxonomies ) && ! empty( $selected_taxonomies ) ) {
			foreach ( $selected_taxonomies as $tax_name => $value ) {
				add_action( $tax_name . '_add_form_fields', array( $this, 'taxonomy_add_new_meta_field'), 10, 2 );
				add_action( $tax_name . '_edit_form_fields', array( $this, 'taxonomy_edit_new_meta_field'), 10, 2 );
				add_action( 'edited_' . $tax_name,  array( $this, 'save_taxonomy_custom_meta' ), 10, 2 );
				add_action( 'create_' . $tax_name,  array( $this, 'save_taxonomy_custom_meta' ), 10, 2 );
//				add_filter( "manage_edit-" . $tax_name . "_columns", array( $this, 'add_custom_tax_column' ) );
//				add_filter( "manage_" . $tax_name . "_custom_column", array( $this, 'output_custom_tax_column' ), 10, 3 );
			}
		}
	}

//	function enqueue_admin_scripts () {
//		wp_enqueue_style( $this->plugin_slug . '-admin-style', get_theme_file_uri('includes/plugins/category-icon/assets/css/category-icon.css'), array(  ), $this->version );
//	}

	function taxonomy_add_new_meta_field ( $tax ) { ?>
		<div class="form-field term-position">
			<label for="term_position"><?php echo esc_html__('Position', 'cryptox') ?></label>
			<input type="text" name="term_position" value="" />
			<p class="description"><?php echo esc_html__('Team job position', 'cryptox') ?></p>
		</div>
		<div class="form-field term-team-facebook">
			<label for="term_team_facebook"><?php echo esc_html__('Facebook', 'cryptox') ?></label>
			<input type="text" name="term_team_facebook" value="" />
		</div>
		<div class="form-field term-team-twitter">
			<label for="term_team_twitter"><?php echo esc_html__('Twitter', 'cryptox') ?></label>
			<input type="text" name="term_team_twitter" value="" />
		</div>
		<div class="form-field term-team-linkedin">
			<label for="term_team_linkedin"><?php echo esc_html__('LinkedIn', 'cryptox') ?></label>
			<input type="text" name="term_team_linkedin" value="" />
		</div>
		<?php
	}

	function taxonomy_edit_new_meta_field ( $term ) {
		if ( isset( $term->term_id ) ) {
			$current_position = get_term_meta( $term->term_id, 'pix_term_position', true );
			$current_team_facebook = get_term_meta( $term->term_id, 'pix_term_team_facebook', true );
			$current_team_twitter = get_term_meta( $term->term_id, 'pix_term_team_twitter', true );
			$current_team_linkedin = get_term_meta( $term->term_id, 'pix_term_team_linkedin', true );
		}

		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="term_position"><?php echo esc_html__('Position', 'cryptox') ?></label></th>
			<td>
				<label for="term_position"><?php echo esc_html__('Position', 'cryptox') ?></label>
				<p><input type="text" name="term_position" value="<?php echo esc_attr($current_position) ?>" /></p>
				<p class="description"><?php echo esc_html__('Team job position', 'cryptox') ?></p>
			</td>
		</tr>

		<tr class="form-field">
			<th scope="row" valign="top"><label for="term_team_facebook"><?php echo esc_html__('Facebook', 'cryptox') ?></label></th>
			<td>
				<label for="term_position"><?php echo esc_html__('Facebook', 'cryptox') ?></label>
				<p><input type="text" name="term_team_facebook" value="<?php echo esc_attr($current_team_facebook) ?>" /></p>
			</td>
		</tr>

		<tr class="form-field">
			<th scope="row" valign="top"><label for="term_team_twitter"><?php echo esc_html__('Twitter', 'cryptox') ?></label></th>
			<td>
				<label for="term_position"><?php echo esc_html__('Twitter', 'cryptox') ?></label>
				<p><input type="text" name="term_team_twitter" value="<?php echo esc_attr($current_team_twitter) ?>" /></p>
			</td>
		</tr>

		<tr class="form-field">
			<th scope="row" valign="top"><label for="term_team_linkedin"><?php echo esc_html__('LinkedIn', 'cryptox') ?></label></th>
			<td>
				<label for="term_position"><?php echo esc_html__('LinkedIn', 'cryptox') ?></label>
				<p><input type="text" name="term_team_linkedin" value="<?php echo esc_attr($current_team_linkedin) ?>" /></p>
			</td>
		</tr>
		<?php
	}

	function save_taxonomy_custom_meta ( $term_id ) {

		if ( isset( $_POST['term_position'] ) ) {
			$value = $_POST['term_position'];
			$current_value = get_term_meta( $term_id, 'pix_term_position', true );

			if ( empty( $current_value ) ) {
				update_term_meta( $term_id, 'pix_term_position', $value );
			} else {
				update_term_meta( $term_id, 'pix_term_position', $value, $current_value );
			}
		}

		if ( isset( $_POST['term_team_facebook'] ) ) {
			$value = $_POST['term_team_facebook'];
			$current_value = get_term_meta( $term_id, 'pix_term_team_facebook', true );

			if ( empty( $current_value ) ) {
				update_term_meta( $term_id, 'pix_term_team_facebook', $value );
			} else {
				update_term_meta( $term_id, 'pix_term_team_facebook', $value, $current_value );
			}
		}

		if ( isset( $_POST['term_team_twitter'] ) ) {
			$value = $_POST['term_team_twitter'];
			$current_value = get_term_meta( $term_id, 'pix_term_team_twitter', true );

			if ( empty( $current_value ) ) {
				update_term_meta( $term_id, 'pix_term_team_twitter', $value );
			} else {
				update_term_meta( $term_id, 'pix_term_team_twitter', $value, $current_value );
			}
		}

		if ( isset( $_POST['term_team_linkedin'] ) ) {
			$value = $_POST['term_team_linkedin'];
			$current_value = get_term_meta( $term_id, 'pix_term_team_linkedin', true );

			if ( empty( $current_value ) ) {
				update_term_meta( $term_id, 'pix_term_team_linkedin', $value );
			} else {
				update_term_meta( $term_id, 'pix_term_team_linkedin', $value, $current_value );
			}
		}

		update_termmeta_cache( array( $term_id ) );

	}

	/**
	 * Taxonomy columns
	 */
	function add_custom_tax_column( $current_columns ) {

		$input = array_shift( $current_columns );
		$new_columns = array(
			'cb' => $input,
		);

		$new_columns = $new_columns + $current_columns;
		return $new_columns;
	}

	function output_custom_tax_column(  $value, $name, $id ) {
		$icon_id = get_term_meta( $id, 'pix_term_icon', true );
		if ( is_numeric( $icon_id ) )  {
			$src = wp_get_attachment_image_src( $icon_id, 'thumbnail' );
			if ( isset( $src[0] ) && ! empty( $src[0] ) ) {
				echo '<div class="pix-taxonomy-icon-column_wrap media-icon">';
					echo '<img src="' . $src[0] . '" width="60px" height="60px" />';
				echo '</div>';
			}
		}
	}

	// this should sanitize things around
	function save_setting_values( $input ) {
		return $input;
	}

	function get_plugin_option( $key ) {

		$options = get_option('cryptex-category-icon');

		if ( isset( $options [$key] ) ) {
			return $options[$key];
		}

		return null;
	}

	function get_defaults() {
		return $this->default_settings;
	}

	/** Ensure compat with wp 4.4 */
	function create_the_termmeta_table( $id = false ) {
		global $wpdb;

		if ( $id !== false)
			switch_to_blog( $id );

		$max_index_length = 191;
		$charset_collate = '';

		if ( ! empty($wpdb->charset) )
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty($wpdb->collate) )
			$charset_collate .= " COLLATE $wpdb->collate";

		$blog_tables = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}termmeta (
		meta_id bigint(20) unsigned NOT NULL auto_increment,
		term_id bigint(20) unsigned NOT NULL default '0',
		meta_key varchar(255) default NULL,
		meta_value longtext,
		PRIMARY KEY (meta_id),
		KEY term_id (term_id),
		KEY meta_key (meta_key($max_index_length))
	) $charset_collate; ";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $blog_tables );
	}

	function register_the_termmeta_table() {
		global $wpdb;

		//register the termmeta table with the wpdb object if this is older than 4.4
		if ( ! isset($wpdb->termmeta)) {
			$wpdb->termmeta = $wpdb->prefix . "termmeta";
			//add the shortcut so you can use $wpdb->stats
			$wpdb->tables[] = str_replace($wpdb->prefix, '', $wpdb->prefix . "termmeta");
		}
	}

}

if ( ! function_exists( 'add_term_meta' ) ) {
	function add_term_meta( $term_id, $meta_key, $meta_value, $unique = false ) {
		$added = add_metadata( 'term', $term_id, $meta_key, $meta_value, $unique );

		// Bust term query cache.
		if ( $added ) {
			wp_cache_set( 'last_changed', microtime(), 'terms' );
		}

		return $added;
	}
}

if ( ! function_exists( 'delete_term_meta' ) ) {
	function delete_term_meta( $term_id, $meta_key, $meta_value = '' ) {
		$deleted = delete_metadata( 'term', $term_id, $meta_key, $meta_value );

		// Bust term query cache.
		if ( $deleted ) {
			wp_cache_set( 'last_changed', microtime(), 'terms' );
		}

		return $deleted;
	}
}

if ( ! function_exists( 'get_term_meta' ) ) {
	function get_term_meta( $term_id, $key = '', $single = false ) {
		return get_metadata( 'term', $term_id, $key, $single );
	}
}

if ( ! function_exists( 'update_term_meta' ) ) {
	function update_term_meta( $term_id, $meta_key, $meta_value, $prev_value = '' ) {
		$updated = update_metadata( 'term', $term_id, $meta_key, $meta_value, $prev_value );

		// Bust term query cache.
		if ( $updated ) {
			wp_cache_set( 'last_changed', microtime(), 'terms' );
		}

		return $updated;
	}
}

if ( ! function_exists( 'update_termmeta_cache' ) ) {
	function update_termmeta_cache( $term_ids ) {
		return update_meta_cache( 'term', $term_ids );
	}
}

if ( ! function_exists( 'wp_lazyload_term_meta' ) ) {
	function wp_lazyload_term_meta( $check, $term_id ) {
		global $wp_query;

		if ( $wp_query instanceof WP_Query && ! empty( $wp_query->posts ) && $wp_query->get( 'update_post_term_cache' ) ) {
			// We can only lazyload if the entire post object is present.
			$posts = array();
			foreach ( $wp_query->posts as $post ) {
				if ( $post instanceof WP_Post ) {
					$posts[] = $post;
				}
			}

			if ( empty( $posts ) ) {
				return;
			}

			// Fetch cached term_ids for each post. Keyed by term_id for faster lookup.
			$term_ids = array();
			foreach ( $posts as $post ) {
				$taxonomies = get_object_taxonomies( $post->post_type );
				foreach ( $taxonomies as $taxonomy ) {
					// No extra queries. Term cache should already be primed by 'update_post_term_cache'.
					$terms = get_object_term_cache( $post->ID, $taxonomy );
					if ( false !== $terms ) {
						foreach ( $terms as $term ) {
							if ( ! isset( $term_ids[ $term->term_id ] ) ) {
								$term_ids[ $term->term_id ] = 1;
							}
						}
					}
				}
			}

			if ( $term_ids ) {
				update_termmeta_cache( array_keys( $term_ids ) );
			}
		}

		return $check;
	}
	add_filter( 'get_term_metadata',        'wp_lazyload_term_meta',        10, 2 );
}
