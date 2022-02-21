<?php

// add custom menu fields to menu
add_filter( 'wp_setup_nav_menu_item', 'cryptex_add_custom_nav_fields' );

function cryptex_add_custom_nav_fields($menu_item ) {
	$menu_item->nolink = get_post_meta( $menu_item->ID, '_menu_item_nolink', true );
	$menu_item->hide = get_post_meta( $menu_item->ID, '_menu_item_hide', true );
	$menu_item->submenu_type = get_post_meta( $menu_item->ID, '_menu_item_submenu_type', true );
	return $menu_item;
}

// save menu custom fields
add_action( 'wp_update_nav_menu_item', 'cryptex_update_custom_nav_fields', 10, 3 );

function cryptex_update_custom_nav_fields($menu_id, $menu_item_db_id, $args ) {
	$check = array( 'hide', 'nolink', 'submenu_type' );

	foreach ( $check as $key ) {

		if ( !isset($_POST['menu-item-' . $key][$menu_item_db_id]) ) {
			if ( !isset($args['menu-item-' . $key]) ) {
				$value = "";
			} else {
				$value = $args['menu-item-' . $key];
			}
		} else {
			$value = $_POST['menu-item-' . $key][$menu_item_db_id];
		}

		if ( $value ) {
			update_post_meta( $menu_item_db_id, '_menu_item_' . $key, $value );
		} else {
			delete_post_meta( $menu_item_db_id, '_menu_item_' . $key );
		}

	}
}

// edit menu walker
add_filter( 'wp_edit_nav_menu_walker', 'cryptex_menu_edit_walker', 10, 2 );

function cryptex_menu_edit_walker($walker = '', $menu_id = '') {
	return 'Cryptex_Walker_Nav_Menu_Edit';
}

// Create HTML list of nav menu input items.
// Extend from Walker_Nav_Menu class
class Cryptex_Walker_Nav_Menu_Edit extends Walker_Nav_Menu {
	/**
	 * @see Walker_Nav_Menu::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 */
	function start_lvl(&$output, $depth = 0, $args = array())
	{
	}

	/**
	 * @see Walker_Nav_Menu::end_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {
	}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param object $args
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
	{
		global $_wp_nav_menu_max_depth;
		$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

		ob_start();
		$item_id = esc_attr( $item->ID );
		$removed_args = array(
			'action',
			'customlink-tab',
			'edit-menu-item',
			'menu-item',
			'page-tab',
			'_wpnonce',
		);

		$original_title = false;
		if ( 'taxonomy' == $item->type ) {
			$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
			if ( is_wp_error( $original_title ) )
				$original_title = false;
		} elseif ( 'post_type' == $item->type ) {
			$original_object = get_post( $item->object_id );
			$original_title = get_the_title( $original_object->ID );
		} elseif ( 'post_type_archive' == $item->type ) {
			$original_object = get_post_type_object( $item->object );
			if ( $original_object ) {
				$original_title = $original_object->labels->archives;
			}
		}

		$classes = array(
			'menu-item menu-item-depth-' . $depth,
			'menu-item-' . esc_attr( $item->object ),
			'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
		);

		$title = $item->title;

		if ( ! empty( $item->_invalid ) ) {
			$classes[] = 'menu-item-invalid';
			/* translators: %s: title of menu item which is invalid */
			$title = sprintf( __( '%s (Invalid)', 'cryptox'), $item->title );
		} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
			$classes[] = 'pending';
			/* translators: %s: title of menu item in draft status */
			$title = sprintf( __('%s (Pending)', 'cryptox'), $item->title );
		}

		$title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

		$submenu_text = '';
		if ( 0 == $depth )
			$submenu_text = 'style="display: none;"';

		?>
	<li id="menu-item-<?php echo esc_attr($item_id); ?>" class="<?php echo implode(' ', $classes ); ?>">
		<div class="menu-item-bar">
			<div class="menu-item-handle">
				<span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo sprintf('%s', $submenu_text); ?>><?php esc_html_e( 'sub item', 'cryptox' ); ?></span></span>
					<span class="item-controls">
						<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
						<span class="item-order hide-if-js">
							<a href="<?php
							echo wp_nonce_url(
								add_query_arg(
									array(
										'action' => 'move-up-menu-item',
										'menu-item' => $item_id,
									),
									remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
								),
								'move-menu_item'
							);
							?>" class="item-move-up" aria-label="<?php esc_attr_e( 'Move up', 'cryptox' ) ?>">&#8593;</a>
							|
							<a href="<?php
							echo wp_nonce_url(
								add_query_arg(
									array(
										'action' => 'move-down-menu-item',
										'menu-item' => $item_id,
									),
									remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
								),
								'move-menu_item'
							);
							?>" class="item-move-down" aria-label="<?php esc_attr_e( 'Move down', 'cryptox' ) ?>">&#8595;</a>
						</span>
						<a class="item-edit" id="edit-<?php echo esc_attr($item_id); ?>" href="<?php
						echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
						?>" aria-label="<?php esc_attr_e( 'Edit menu item', 'cryptox' ); ?>"><?php esc_html_e( 'Edit', 'cryptox' ); ?></a>
					</span>
			</div>
		</div>

		<div class="menu-item-settings wp-clearfix" id="menu-item-settings-<?php echo esc_attr($item_id); ?>">
			<?php if ( 'custom' == $item->type ) : ?>
				<p class="field-url description description-wide">
					<label for="edit-menu-item-url-<?php echo esc_attr($item_id); ?>">
						<?php echo esc_html__( 'URL', 'cryptox' ); ?><br />
						<input type="text" id="edit-menu-item-url-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
					</label>
				</p>
			<?php endif; ?>
			<p class="description description-wide">
				<label for="edit-menu-item-title-<?php echo esc_attr($item_id); ?>">
					<?php echo esc_html__('Navigation Label', 'cryptox') ?><br />
					<input type="text" id="edit-menu-item-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
				</label>
			</p>

			<p class="description">
				<label for="edit-menu-item-nolink-<?php echo esc_attr($item_id); ?>">
					<input type="checkbox" id="edit-menu-item-nolink-<?php echo esc_attr($item_id); ?>" value="nolink" name="menu-item-nolink[<?php echo esc_attr($item_id); ?>]" <?php checked( $item->nolink, 'nolink' ); ?> />
					<?php echo esc_html__('Don\'t link', 'cryptox') ?>
				</label>
			</p>

			<p class="description">
				<label for="edit-menu-item-hide-<?php echo esc_attr($item_id); ?>">
					<input type="checkbox" id="edit-menu-item-hide-<?php echo esc_attr($item_id); ?>" class="code edit-menu-item-custom" value="hide" name="menu-item-hide[<?php echo esc_attr($item_id); ?>]" <?php checked( $item->hide, 'hide' ); ?> />
					<?php echo esc_html__('Don\'t show a link', 'cryptox') ?>
				</label>
			</p>

			<?php if ( $depth == 0 ): ?>

				<p class="description description-wide">
					<label for="edit-menu-item-submenu_type-<?php echo esc_attr($item_id); ?>">
						<?php echo esc_html__('Submenu Type', 'cryptox') ?><br/>
						<select id="edit-menu-item-submenu_type-<?php echo esc_attr($item_id); ?>" name="menu-item-submenu_type[<?php echo esc_attr($item_id); ?>]" >
							<option value="default-dropdown" <?php selected( $item->submenu_type, 'default-dropdown' ); ?>><?php echo esc_html__('Standard Submenu', 'cryptox') ?></option>
							<option value="multicolumn" <?php selected( $item->submenu_type, 'multicolumn' ); ?>><?php echo esc_html__('Multicolumn Submenu', 'cryptox') ?></option>
						</select>
					</label>
				</p>

			<?php endif; ?>

			<div class="menu-item-actions description-wide submitbox">
				<?php if ( 'custom' != $item->type && $original_title !== false ) : ?>
					<p class="link-to-original">
						<?php printf( __('Original: %s', 'cryptox'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
					</p>
				<?php endif; ?>
				<a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr($item_id); ?>" href="<?php
				echo wp_nonce_url(
					add_query_arg(
						array(
							'action' => 'delete-menu-item',
							'menu-item' => $item_id,
						),
						admin_url( 'nav-menus.php' )
					),
					'delete-menu_item_' . $item_id
				); ?>"><?php esc_html_e( 'Remove', 'cryptox' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo esc_attr($item_id); ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
				?>#menu-item-settings-<?php echo esc_attr($item_id); ?>"><?php esc_html_e('Cancel', 'cryptox'); ?></a>
			</div>

			<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item_id); ?>" />
			<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
			<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
			<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
			<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
			<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
		</div><!-- .menu-item-settings-->
		<ul class="menu-item-transport"></ul>
		<?php
		$output .= ob_get_clean();
	}

}


/* Mobile Navigation Menu */
if ( !class_exists('cryptex_mobile_navwalker') ) {

	class cryptex_mobile_navwalker extends Walker_Nav_Menu
	{

		function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
			$id_field = $this->db_fields['id'];
			if ( is_object( $args[0] ) ) {
				$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
			}
			return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}

		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<span class=\"arrow\"></span><ul class=\"sub-menu\">\n";
		}

		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "$indent</ul>\n";
		}

		// add main/sub classes to li's and links
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			global $wp_query;

			$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' );

			$active = "";

			// passed classes
			$classes = empty( $item->classes ) ? array() : (array)$item->classes;

			$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

			$output .= $indent . '<li id="mobile-menu-item-'. $item->ID . '" class="' . $class_names . ' ' . $active . '">';

			// link attributes
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

			$item_output = $args->before;
			if ( $item->hide == "" ) {

				$item_output .= '<a'. $attributes .'>';

				$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID );

				$item_output .= '</a>';
			}

			$item_output .= $args->after;

			// build html
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

	}

}

/* Primary Navigation Menu */
if ( !class_exists('cryptex_primary_navwalker') ) {

	class cryptex_primary_navwalker extends Walker_Nav_Menu {

		// add classes to ul sub menus
		function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
			$id_field = $this->db_fields['id'];
			if (is_object($args[0])) {
				$args[0]->has_children = !empty($children_elements[$element->$id_field]);
			}
			return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
		}

		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);

			if ( $depth == 0 ) {
				$out_div = '<div class="sub-menu-wrap">';
			} else {
				$out_div = '';
			}
			$output .= "\n$indent$out_div<ul class=\"sub-menu\">\n";
		}

		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			if ( $depth == 0 ) {
				$out_div = '</div>';
			} else {
				$out_div = '';
			}
			$output .= "$indent</ul>$out_div\n";
		}

		// add main/sub classes to li's and links
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			global $wp_query;

			$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' );

			$sub = $bg_style = $active = "";

			// passed classes
			$classes = empty( $item->classes ) ? array() : (array)$item->classes;

			$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

			$submenu_type = $submenu_pos = '';

			if ( $depth == 0 ) {
				$submenu_type = " " . $item->submenu_type;
			}

			if ( $depth == 1 ) {
				$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $class_names . ' ' . $active . $sub . '">';
			} else {
				$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $class_names . ' ' . $active . $sub . $submenu_type . '">';
			}

			// link attributes
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

			$item_output = $args->before;
			if ( $item->hide == "" ) {

				if ( $item->nolink == "" ) {
					$item_output .= '<a'. $attributes .'>';
				} else{
					$item_output .= '<a>';
				}

				$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID );
				$item_output .= $args->link_after;

				$item_output .= '</a>';
			}

			$item_output .= $args->after;

			// build html
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

	}
}
