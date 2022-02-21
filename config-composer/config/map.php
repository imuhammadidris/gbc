<?php

$target_arr = array(
	esc_html__( 'Same window', 'cryptox' ) => '_self',
	esc_html__( 'New window', 'cryptox' ) => '_blank',
);

/* Default Custom Shortcodes
/* --------------------------------------------------------------------- */

/* Custom Heading element
----------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Custom Heading', 'cryptox' ),
	'base' => 'vc_custom_heading',
	'icon' => 'icon-wpb-ui-custom_heading',
	'show_settings_on_create' => true,
	'category' => esc_html__( 'Content', 'cryptox' ),
	'description' => esc_html__( 'Text with Google fonts', 'cryptox' ),
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Text source', 'cryptox' ),
			'param_name' => 'source',
			'value' => array(
				esc_html__( 'Custom text', 'cryptox' ) => '',
				esc_html__( 'Post or Page Title', 'cryptox' ) => 'post_title',
			),
			'std' => '',
			'description' => esc_html__( 'Select text source.', 'cryptox' ),
		),
		array(
			'type' => 'textarea',
			'heading' => esc_html__( 'Text', 'cryptox' ),
			'param_name' => 'text',
			'admin_label' => true,
			'value' => esc_html__( 'This is custom heading element', 'cryptox' ),
			'description' => esc_html__( 'Note: If you are using non-latin characters be sure to activate them under Settings/Visual Composer/General Settings.', 'cryptox' ),
			'dependency' => array(
				'element' => 'source',
				'is_empty' => true,
			),
		),
		array(
			'type' => 'vc_link',
			'heading' => esc_html__( 'URL (Link)', 'cryptox' ),
			'param_name' => 'link',
			'description' => esc_html__( 'Add link to custom heading.', 'cryptox' ),
		),
		array(
			'type' => 'font_container',
			'param_name' => 'font_container',
			'value' => 'tag:h2|text_align:left',
			'settings' => array(
				'fields' => array(
					'tag' => 'h2',
					'text_align',
					'font_size',
					'line_height',
					'color',
					'tag_description' => esc_html__( 'Select element tag.', 'cryptox' ),
					'text_align_description' => esc_html__( 'Select text alignment.', 'cryptox' ),
					'font_size_description' => esc_html__( 'Enter font size.', 'cryptox' ),
					'line_height_description' => esc_html__( 'Enter line height.', 'cryptox' ),
					'color_description' => esc_html__( 'Select heading color.', 'cryptox' ),
				),
			),
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Use theme default font family?', 'cryptox' ),
			'param_name' => 'use_theme_fonts',
			'value' => array( esc_html__( 'Yes', 'cryptox' ) => 'yes' ),
			'description' => esc_html__( 'Use font family from the theme.', 'cryptox' ),
			'std' => 'yes'
		),
		array(
			'type' => 'google_fonts',
			'param_name' => 'google_fonts',
			'value' => 'font_family:Source Sans Pro:200,200italic,300,300italic,regular',
			'settings' => array(
				'fields' => array(
					'font_family_description' => esc_html__( 'Select font family.', 'cryptox' ),
					'font_style_description' => esc_html__( 'Select font styling.', 'cryptox' ),
				),
			),
			'dependency' => array(
				'element' => 'use_theme_fonts',
				'value_not_equal_to' => 'yes',
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Extra class name', 'cryptox' ),
			'param_name' => 'el_class',
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'cryptox' ),
		),
		array(
			'type' => 'css_editor',
			'heading' => esc_html__( 'CSS box', 'cryptox' ),
			'param_name' => 'css',
			'group' => esc_html__( 'Design Options', 'cryptox' ),
		),
	),
) );

/* Theme Shortcodes
/* ---------------------------------------------------------------- */

/* Contact Information
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Contact Information', 'cryptox' ),
	'base' => 'vc_mad_contact_info',
	'icon' => 'icon-wpb-map-contact',
	'category' => esc_html__( 'Cryptex', 'cryptox' ),
	'description' => esc_html__( 'Contact Information', 'cryptox' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'cryptox' ),
			'param_name' => 'title',
			'admin_label' => true,
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Tag', 'cryptox' ),
			'param_name' => 'heading',
			'value' => array(
				'h3' => 'h3',
				'h4' => 'h4'
			),
			'std' => 'h3',
			'description' => esc_html__( 'Choose tag for heading', 'cryptox' ),
			'param_holder_class' => ''
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Location', 'cryptox' ),
			'param_name' => 'info_location',
			'admin_label' => true,
			'description' => esc_html__( 'Enter address.', 'cryptox' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Phone', 'cryptox' ),
			'param_name' => 'info_phone',
			'admin_label' => true,
			'description' => esc_html__( 'Enter phone.', 'cryptox' )
		),
		array(
			"type" => "textfield",
			"param_name" => "info_email",
			"heading" => esc_html__( 'Email', 'cryptox' ),
			'admin_label' => true,
			'description' => esc_html__( 'Email', 'cryptox' )
		),
		array(
			"type" => "textfield",
			"param_name" => "info_open_hours",
			"heading" => esc_html__( 'Open Hours', 'cryptox' ),
			'admin_label' => true,
			'description' => esc_html__( 'Open hours.', 'cryptox' )
		),

	)
) );

/* Blockquotes
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Blockquotes', 'cryptox' ),
	'base' => 'vc_mad_blockquotes',
	'icon' => 'icon-wpb-mad-blockquotes',
	'category' => esc_html__( 'Cryptex', 'cryptox' ),
	'description' => esc_html__( 'Blockquotes', 'cryptox' ),
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Style', 'cryptox' ),
			'param_name' => 'style',
			'value' => array(
				esc_html__('Style 1', 'cryptox') => 'style-1',
				esc_html__('Style 2', 'cryptox') => 'style-2'
			),
			'std' => 'style-1',
			'description' => esc_html__('Choose layout style.', 'cryptox')
		),
		array(
			'type' => 'textarea_html',
			'holder' => 'div',
			'heading' => esc_html__( 'Text', 'cryptox' ),
			'param_name' => 'content',
			'value' => esc_html__( '<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'cryptox' ),
		)

	)
));

/* Button
---------------------------------------------------------- */

vc_map(array(
	'name' => esc_html__( 'Button', 'cryptox' ),
	'base' => 'vc_mad_btn',
	'icon' => 'icon-wpb-mad-button',
	'category' => array( esc_html__( 'Cryptex', 'cryptox' ) ),
	'description' => esc_html__( 'Eye catching button', 'cryptox' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Text', 'cryptox' ),
			'param_name' => 'title',
			'value' => esc_html__( 'Text on the button', 'cryptox' ),
		),
		array(
			'type' => 'vc_link',
			'heading' => esc_html__( 'URL (Link)', 'cryptox' ),
			'param_name' => 'link',
			'description' => esc_html__( 'Add link to button.', 'cryptox' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Style', 'cryptox' ),
			'param_name' => 'style',
			'description' => esc_html__( 'Select button display style.', 'cryptox' ),
			'value' => array(
				esc_html__( 'Grey', 'cryptox' ) => 'btn-style-1',
				esc_html__( 'Blue', 'cryptox' ) => 'btn-style-2',
				esc_html__( 'Sky', 'cryptox' ) => 'btn-style-3',
				esc_html__( 'Red', 'cryptox' ) => 'btn-style-4',
				esc_html__( 'Black', 'cryptox' ) => 'btn-style-5',
				esc_html__( 'Gradient', 'cryptox' ) => 'btn-style-6'
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Size', 'cryptox' ),
			'param_name' => 'size',
			'description' => esc_html__( 'Select button display size.', 'cryptox' ),
			'std' => 'small',
			'value' => array(
				esc_html__('Small', 'cryptox') => 'btn-small',
				esc_html__('Medium', 'cryptox') => 'btn-medium',
				esc_html__('Big', 'cryptox') => 'btn-big',
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Alignment', 'cryptox' ),
			'param_name' => 'align',
			'description' => esc_html__( 'Select button alignment.', 'cryptox' ),
			'value' => array(
				esc_html__( 'Inline', 'cryptox' ) => 'align-inline',
				esc_html__( 'Left', 'cryptox' ) => 'align-left',
				esc_html__( 'Right', 'cryptox' ) => 'align-right',
				esc_html__( 'Center', 'cryptox' ) => 'align-center',
			),
		),
		array(
			"type" => "choose_icons",
			"heading" => esc_html__("Icon", 'cryptox'),
			"param_name" => "icon",
			"value" => 'none',
			"description" => esc_html__('Select icon from library.', 'cryptox')
		),
	),
));

/* Message
---------------------------------------------------------- */

vc_map(array(
	'name' => esc_html__( 'List of the post type', 'cryptox' ),
	'base' => 'vc_mad_list_post_type',
	'category' => esc_html__( 'Cryptex', 'cryptox' ),
	'description' => esc_html__( 'List of the post type', 'cryptox' ),
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Post Type', 'cryptox' ),
			'param_name' => 'post_type',
			'value' => array(
				esc_html__('Post', 'cryptox') => 'post',
				esc_html__('Page', 'cryptox') => 'page',
				esc_html__('Testimonials', 'cryptox') => 'testimonials',
				esc_html__('Team Members', 'cryptox') => 'team-members',
				esc_html__('Services', 'cryptox') => 'services',
				esc_html__('Portfolio', 'cryptox') => 'portfolio',
			),
			'description' => esc_html__( 'Choose post type', 'cryptox' ),
		),
	),
));

/* Message
---------------------------------------------------------- */

vc_map(array(
	'name' => esc_html__( 'Message Box', 'cryptox' ),
	'base' => 'vc_mad_message',
	'icon' => 'icon-wpb-mad-message-box',
	'category' => esc_html__( 'Cryptex', 'cryptox' ),
	'description' => esc_html__( 'Notification boxes', 'cryptox' ),
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Style', 'cryptox' ),
			'param_name' => 'message_box_style',
			'value' => array(
				esc_html__('Success', 'cryptox') => 'alert-success',
				esc_html__('Warning', 'cryptox') => 'alert-warning',
				esc_html__('Info', 'cryptox') => 'alert-info',
				esc_html__('Error', 'cryptox') => 'alert-error',
			),
			'description' => esc_html__( 'Select message box style.', 'cryptox' ),
		),
		array(
			'type' => 'textarea_html',
			'holder' => 'div',
			'class' => 'messagebox_text',
			'heading' => esc_html__( 'Message text', 'cryptox' ),
			'param_name' => 'content',
			'value' => esc_html__( 'I am message box. Click edit button to change this text', 'cryptox' ),
		)
	),
));

/* List Styles
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'List Styles', 'cryptox' ),
	'base' => 'vc_mad_list_styles',
	'icon' => 'icon-wpb-mad-list-styles',
	'category' => esc_html__( 'Cryptex', 'cryptox' ),
	'description' => esc_html__( 'List styles', 'cryptox' ),
	'params' => array(
		array(
			'type' => 'param_group',
			'heading' => esc_html__( 'Values', 'cryptox' ),
			'param_name' => 'values',
			'description' => esc_html__( 'Enter values - value and title.', 'cryptox' ),
			'value' => urlencode( json_encode( array(
				array(
					'label' => esc_html__( 'Sed laoreet aliquam leo', 'cryptox' ),
					'icon'  => 'licon-map-marker-check'
				),
				array(
					'label' => esc_html__( 'Ut tellus dolor dapibus', 'cryptox' ),
					'icon'  => 'licon-map-marker-check'
				),
				array(
					'label' => esc_html__( 'Eget elementum vel', 'cryptox' ),
					'icon'  => 'licon-map-marker-check'
				)
			) ) ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Label', 'cryptox' ),
					'param_name' => 'label',
					'description' => esc_html__( 'Enter text used as title.', 'cryptox' ),
					'admin_label' => true,
				),
				array(
					"type" => "choose_icons",
					"heading" => esc_html__("Icon", 'cryptox'),
					"param_name" => "icon",
					"value" => 'none',
					"description" => esc_html__( 'Select icon from library.', 'cryptox')
				)
			)
		),
	)
) );

/* Call to Action
---------------------------------------------------------- */

$wysija_forms = array();

if ( defined('WYSIJA') ) {
	$model_forms = WYSIJA::get( 'forms', 'model' );
	$model_forms->reset();
	$forms = $model_forms->getRows( array( 'form_id', 'name' ) );
	if ( $forms ) {
		foreach( $forms as $form ) {
			if ( isset($form) )
				$wysija_forms[$form['name']] = $form['form_id'];
		}
	}
}

vc_map( array(
	'name' => esc_html__( 'Call to Action', 'cryptox' ),
	'base' => 'vc_mad_cta',
	'icon' => 'icon-wpb-mad-cta',
	'category' => array( esc_html__( 'Cryptex', 'cryptox' ) ),
	'description' => esc_html__( 'Catch visitors attention with CTA block', 'cryptox' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Heading', 'cryptox' ),
			'admin_label' => true,
			'param_name' => 'h2',
			'value' => '',
			'description' => esc_html__( 'Enter text for heading line. \n = LF (Line Feed) - Used as a new line character', 'cryptox' ),
			'edit_field_class' => 'vc_col-sm-9',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Subheading', 'cryptox' ),
			'param_name' => 'p',
			'value' => '',
			'description' => esc_html__( 'Enter text for subheading line.', 'cryptox' ),
			'edit_field_class' => 'vc_col-sm-9',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Add button or form?', 'cryptox' ),
			'param_name' => 'add',
			'value' => array(
				esc_html__( 'Button', 'cryptox' ) => 'button',
				esc_html__( 'Subscribe Form', 'cryptox' ) => 'form',
			),
			'description' => esc_html__( 'Add button or form for call to action.', 'cryptox' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Select a form', 'cryptox' ),
			'param_name' => 'select_form',
			'value' => $wysija_forms,
			'group' => esc_html__( 'Form', 'cryptox' ),
			'description' => esc_html__( 'Select a form.', 'cryptox' ),
			'dependency' => array(
				'element' => 'add',
				'value' => array( 'form' )
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Alignment', 'cryptox' ),
			'param_name' => 'align',
			'description' => esc_html__( 'Select alignment.', 'cryptox' ),
			'value' => array(
				esc_html__( 'Left', 'cryptox' ) => 'align-left',
				esc_html__( 'Right', 'cryptox' ) => 'align-right',
				esc_html__( 'Center', 'cryptox' ) => 'align-center'
			),
			'dependency' => array(
				'element' => 'add',
				'value' => array( 'button' )
			)
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color', 'cryptox' ),
			'param_name' => 'color',
			'group' => esc_html__( 'Styling', 'cryptox' ),
			'description' => esc_html__( 'Select custom text color.', 'cryptox' ),
		),
		array(
			'type' => 'vc_link',
			'heading' => esc_html__( 'URL (Link)', 'cryptox' ),
			'param_name' => 'link',
			'description' => esc_html__( 'Add link to button.', 'cryptox' ),
			'group' => esc_html__( 'Button', 'cryptox' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Style button', 'cryptox' ),
			'param_name' => 'button_style',
			'description' => esc_html__( 'Select style button.', 'cryptox' ),
			'value' => array(
				esc_html__( 'Red', 'cryptox' ) => 'btn-style-4',
				esc_html__( 'Blue', 'cryptox' ) => 'btn-style-3'
			),
			'group' => esc_html__( 'Button', 'cryptox' ),
		),
	),
	'js_view' => 'VcCallToActionView3',
));

/* MailPoet
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'MailPoet Subscription Form', 'cryptox' ),
	'base' => 'vc_mad_mailpoet',
	'category' => array( esc_html__( 'Cryptex', 'cryptox' ) ),
	'description' => esc_html__( 'Subscription form for your newsletters.', 'cryptox' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Subheading', 'cryptox' ),
			'param_name' => 'subheading',
			'value' => '',
			'description' => esc_html__( 'Enter text for subheading line.', 'cryptox' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Select a form', 'cryptox' ),
			'param_name' => 'select_form',
			'value' => $wysija_forms,
			'description' => esc_html__( 'Select a form.', 'cryptox' ),
		),
	)
));

/* Icos Posts
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'ICO', 'cryptox' ),
	'base' => 'vc_mad_ico',
	'icon' => 'icon-wpb-mad-ico',
	'category' => esc_html__( 'Cryptex', 'cryptox' ),
	'description' => esc_html__( 'ICO posts', 'cryptox' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'cryptox' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'cryptox' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order By', 'cryptox' ),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__( 'Date', 'cryptox' ) => 'date',
				esc_html__( 'ID', 'cryptox' ) => 'ID',
				esc_html__( 'Author', 'cryptox' ) => 'author',
				esc_html__( 'Title', 'cryptox' ) => 'title',
				esc_html__( 'Modified', 'cryptox' ) => 'modified',
				esc_html__( 'Random', 'cryptox' ) => 'rand',
				esc_html__( 'Comment count', 'cryptox' ) => 'comment_count',
				esc_html__( 'Menu order', 'cryptox' ) => 'menu_order'
			),
			'std' => 'date',
			'description' => esc_html__( 'Sort retrieved posts by parameter', 'cryptox' ),
			'group' => esc_html__( 'Data Settings', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order', 'cryptox' ),
			'param_name' => 'order',
			'value' => array(
				esc_html__( 'DESC', 'cryptox' ) => 'DESC',
				esc_html__( 'ASC', 'cryptox' ) => 'ASC'
			),
			'description' => esc_html__( 'In what direction order?', 'cryptox' ),
			'group' => esc_html__( 'Data Settings', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Posts Count', 'cryptox' ),
			'param_name' => 'items',
			'value' => Cryptex_Vc_Config::array_number(1, 50, 1, array('-1' => 'All')),
			'std' => 10,
			'description' => esc_html__( 'How many items should be displayed per page?', 'cryptox' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Pagination', 'cryptox' ),
			'param_name' => 'paginate',
			'value' => array(
				esc_html__( 'Display Pagination', 'cryptox' ) => 'pagination',
				esc_html__( 'No option to view additional entries', 'cryptox' ) => 'none'
			),
			'std' => 'none',
			'description' => esc_html__( 'Should a pagination be displayed?', 'cryptox' )
		),
	)
) );

/* Carousel Blog Posts
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Carousel Blog Posts', 'cryptox' ),
	'base' => 'vc_mad_carousel_blog_posts',
	'icon' => 'icon-wpb-mad-car-posts',
	'category' => esc_html__( 'Cryptex', 'cryptox' ),
	'description' => esc_html__( 'Blog posts', 'cryptox' ),
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Posts Count', 'cryptox' ),
			'param_name' => 'items',
			'value' => Cryptex_Vc_Config::array_number(1, 50, 1, array('-1' => 'All')),
			'std' => 3,
			'description' => esc_html__( 'How many items should be displayed per page?', 'cryptox' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Autoplay', 'cryptox' ),
			'param_name' => 'autoplay',
			'description' => esc_html__( 'Enables autoplay mode.', 'cryptox' ),
			'value' => array( esc_html__( 'Yes, please', 'cryptox' ) => 'yes' ),
		),
		array(
			'type' => 'number',
			'heading' => esc_html__( 'Autoplay timeout', 'cryptox' ),
			'param_name' => 'autoplaytimeout',
			'description' => esc_html__( 'Autoplay interval timeout', 'cryptox' ),
			'value' => 5000,
			'dependency' => array(
				'element' => 'autoplay',
				'value' => array( 'yes' )
			)
		),
		array(
			"type" => 'get_terms',
			"term" => 'category',
			'heading' => esc_html__( 'Which categories should be used for the blog?', 'cryptox' ),
			"param_name" => 'categories',
			"holder" => "div",
			'description' => esc_html__('The Page will then show entries from only those categories.', 'cryptox'),
			'group' => esc_html__( 'Data Settings', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order By', 'cryptox' ),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__( 'Date', 'cryptox' ) => 'date',
				esc_html__( 'ID', 'cryptox' ) => 'ID',
				esc_html__( 'Author', 'cryptox' ) => 'author',
				esc_html__( 'Title', 'cryptox' ) => 'title',
				esc_html__( 'Modified', 'cryptox' ) => 'modified',
				esc_html__( 'Random', 'cryptox' ) => 'rand',
				esc_html__( 'Comment count', 'cryptox' ) => 'comment_count',
				esc_html__( 'Menu order', 'cryptox' ) => 'menu_order'
			),
			'std' => 'date',
			'description' => esc_html__( 'Sort retrieved posts by parameter', 'cryptox' ),
			'group' => esc_html__( 'Data Settings', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order', 'cryptox' ),
			'param_name' => 'order',
			'value' => array(
				esc_html__( 'DESC', 'cryptox' ) => 'DESC',
				esc_html__( 'ASC', 'cryptox' ) => 'ASC'
			),
			'description' => esc_html__( 'In what direction order?', 'cryptox' ),
			'group' => esc_html__( 'Data Settings', 'cryptox' )
		),
	)
) );

/* Blog Posts
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Blog Posts', 'cryptox' ),
	'base' => 'vc_mad_blog_posts',
	'icon' => 'icon-wpb-mad-blog-posts',
	'category' => esc_html__( 'Cryptex', 'cryptox' ),
	'description' => esc_html__( 'Blog posts', 'cryptox' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'cryptox' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'cryptox' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Tag', 'cryptox'),
			'param_name' => 'heading',
			'value' => array(
				'h2' => 'h2',
				'h3' => 'h3',
				'h4' => 'h4'
			),
			'std' => 'h3',
			'description' => esc_html__('Choose tag for heading', 'cryptox'),
			'param_holder_class' => ''
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Title Alignment', 'cryptox'),
			'param_name' => 'align_title',
			'description' => esc_html__('Select title alignment.', 'cryptox'),
			'value' => array(
				esc_html__('Left', 'cryptox') => 'align-left',
				esc_html__('Right', 'cryptox') => 'align-right',
				esc_html__('Center', 'cryptox') => 'align-center'
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Blog Layout', 'cryptox' ),
			'param_name' => 'layout',
			'value' => array(
				esc_html__( 'Classic', 'cryptox' ) => 'entry-small',
				esc_html__( 'Grid', 'cryptox' ) => 'entry-grid',
				esc_html__( 'Masonry', 'cryptox' ) => 'entry-masonry'
			),
			'std' => 'entry-small',
			'description' => esc_html__( 'Choose the default blog layout here.', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns', 'cryptox' ),
			'param_name' => 'columns',
			'value' => array(
				esc_html__( '1 Column', 'cryptox' ) => 1,
				esc_html__( '2 Columns', 'cryptox' ) => 2,
				esc_html__( '3 Columns', 'cryptox' ) => 3,
				esc_html__( '4 Columns', 'cryptox' ) => 4
			),
			'description' => esc_html__( 'How many columns should be displayed?', 'cryptox' ),
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'entry-small', 'entry-grid', 'entry-masonry' )
			),
			'std' => 3
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Remove border in items', 'cryptox' ),
			'param_name' => 'remove_border',
			'description' => esc_html__( 'Enable sorting', 'cryptox' ),
			'value' => array( esc_html__( 'Yes', 'cryptox' ) => true ),
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'entry-grid' )
			),
			'std' => false
		),
		array(
			"type" => "get_terms",
			"term" => "category",
			'heading' => esc_html__( 'Which categories should be used for the blog?', 'cryptox' ),
			"param_name" => "categories",
			"holder" => "div",
			'description' => esc_html__('The Page will then show entries from only those categories.', 'cryptox'),
			'group' => esc_html__( 'Data Settings', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order By', 'cryptox' ),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__( 'Date', 'cryptox' ) => 'date',
				esc_html__( 'ID', 'cryptox' ) => 'ID',
				esc_html__( 'Author', 'cryptox' ) => 'author',
				esc_html__( 'Title', 'cryptox' ) => 'title',
				esc_html__( 'Modified', 'cryptox' ) => 'modified',
				esc_html__( 'Random', 'cryptox' ) => 'rand',
				esc_html__( 'Comment count', 'cryptox' ) => 'comment_count',
				esc_html__( 'Menu order', 'cryptox' ) => 'menu_order'
			),
			'std' => 'date',
			'description' => esc_html__( 'Sort retrieved posts by parameter', 'cryptox' ),
			'group' => esc_html__( 'Data Settings', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order', 'cryptox' ),
			'param_name' => 'order',
			'value' => array(
				esc_html__( 'DESC', 'cryptox' ) => 'DESC',
				esc_html__( 'ASC', 'cryptox' ) => 'ASC'
			),
			'description' => esc_html__( 'In what direction order?', 'cryptox' ),
			'group' => esc_html__( 'Data Settings', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Posts Count', 'cryptox' ),
			'param_name' => 'items',
			'value' => Cryptex_Vc_Config::array_number(1, 50, 1, array('-1' => 'All')),
			'std' => 10,
			'description' => esc_html__( 'How many items should be displayed per page?', 'cryptox' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Pagination', 'cryptox' ),
			'param_name' => 'paginate',
			'value' => array(
				esc_html__( 'Display Pagination', 'cryptox' ) => 'pagination',
				esc_html__( 'No option to view additional entries', 'cryptox' ) => 'none'
			),
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'entry-small', 'entry-masonry' )
			),
			'std' => 'none',
			'description' => esc_html__( 'Should a pagination be displayed?', 'cryptox' )
		),
		array(
			"type" => "vc_link",
			"heading" => esc_html__( 'Add URL button to the blog (optional)', 'cryptox' ),
			"param_name" => "link"
		)
	)
) );

/* Countdown
---------------------------------------------------------- */

vc_map( array(
	"name" => esc_html__( "Countdown", 'cryptox' ),
	"base" => "vc_mad_countdown",
	"icon" => "icon-wpb-mad-countdown",
	'category' => esc_html__( 'Cryptex', 'cryptox' ),
	'description' => esc_html__( 'Countdown', 'cryptox' ),
	"params" => array(
		array(
			"type" => "datetimepicker",
			"class" => "",
			"heading" => esc_html__("Target Time For Countdown", 'cryptox'),
			"param_name" => "datetime",
			"value" => "",
			"description" => esc_html__("Date and time format (yyyy/mm/dd hh:mm:ss).", 'cryptox'),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Extra class name', 'cryptox' ),
			'param_name' => 'el_class',
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'cryptox' )
		)
	)
) );

/* Brands Logo
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Brands', 'cryptox' ),
	'base' => 'vc_mad_partners',
	'icon' => 'icon-wpb-mad-brands-logo',
	'category' => esc_html__( 'Cryptex', 'cryptox' ),
	'description' => esc_html__( 'Our partners logo', 'cryptox' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'cryptox' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'cryptox' ),
		),
		array(
			'type' => 'attach_images',
			'heading' => esc_html__( 'Images', 'cryptox' ),
			'param_name' => 'images',
			'value' => '',
			'description' => esc_html__( 'Select images from media library.', 'cryptox' )
		),
		array(
			"type" => "textarea",
			"heading" => esc_html__( 'Links', 'cryptox' ),
			"param_name" => "links",
			"holder" => "span",
			"description" => esc_html__( 'Input links values. Divide values with linebreaks (|). Example: http://partner.com | http://partner2.com', 'cryptox' )
		),
	)
) );

/* Services
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Services', 'cryptox' ),
	'base' => 'vc_mad_services',
	'icon' => 'icon-wpb-mad-services',
	'category' => esc_html__( 'Cryptex', 'cryptox' ),
	'description' => esc_html__( 'Displayed for services items', 'cryptox' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'cryptox' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'cryptox' ),
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__( 'Select type', 'cryptox' ),
			"param_name" => 'style',
			"value" => array(
				esc_html__('Style 1', 'cryptox') => 'style-1',
				esc_html__('Style 2', 'cryptox') => 'style-2',
				esc_html__('Style 3', 'cryptox') => 'style-3',
				esc_html__('Style 4', 'cryptox') => 'style-4'
			),
			"std" => 'style-1',
			"description" => esc_html__( 'Choose type design for services.', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns', 'cryptox' ),
			'param_name' => 'columns',
			'value' => array(
				esc_html__( '2 Columns', 'cryptox' ) => 2,
				esc_html__( '3 Columns', 'cryptox' ) => 3,
				esc_html__( '4 Columns', 'cryptox' ) => 4,
			),
			'std' => 3,
			'description' => esc_html__( 'How many columns should be displayed?', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order By', 'cryptox' ),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__( 'Date', 'cryptox' ) => 'date',
				esc_html__( 'ID', 'cryptox' ) => 'ID',
				esc_html__( 'Author', 'cryptox' ) => 'author',
				esc_html__( 'Title', 'cryptox' ) => 'title',
				esc_html__( 'Modified', 'cryptox' ) => 'modified',
				esc_html__( 'Random', 'cryptox' ) => 'rand',
				esc_html__( 'Comment count', 'cryptox' ) => 'comment_count',
				esc_html__( 'Menu order', 'cryptox' ) => 'menu_order'
			),
			'description' => esc_html__( 'Sort retrieved items by parameter', 'cryptox' ),
			'group' => esc_html__( 'Data Settings', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order', 'cryptox' ),
			'param_name' => 'order',
			'value' => array(
				esc_html__( 'DESC', 'cryptox' ) => 'DESC',
				esc_html__( 'ASC', 'cryptox' ) => 'ASC',
			),
			'description' => esc_html__( 'Direction Order', 'cryptox' ),
			'group' => esc_html__( 'Data Settings', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Count Items', 'cryptox' ),
			'param_name' => 'items',
			'value' => Cryptex_Vc_Config::array_number( 1, 51, 1, array( esc_html__('All', 'cryptox') => '-1') ),
			'std' => -1,
			'group' => esc_html__( 'Data Settings', 'cryptox' ),
			'description' => esc_html__( 'How many items should be displayed per page?', 'cryptox' )
		)
	)
) );


/* Portfolio
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Portfolio', 'cryptox' ),
	'base' => 'vc_mad_portfolio',
	'icon' => 'icon-wpb-mad-portfolio',
	'category' => esc_html__( 'Cryptex', 'cryptox' ),
	'description' => esc_html__( 'Displayed for portfolio items', 'cryptox' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'cryptox' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'cryptox' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Layout', 'cryptox' ),
			'param_name' => 'layout',
			'value' => array(
				esc_html__( 'Standard Grid', 'cryptox' ) => 'grid-standard',
				esc_html__( 'Grid Classic', 'cryptox' ) => 'grid-classic'
			),
			'description' => esc_html__( 'Layout be displayed?', 'cryptox' )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Hide details', 'cryptox' ),
			'param_name' => 'hide_details',
			'description' => esc_html__( 'Hide details', 'cryptox' ),
			'dependency' => array(
				'element' => 'layout',
				'value' => array( 'grid-classic' )
			),
			'value' => array( esc_html__( 'Yes', 'cryptox' ) => true ),
		),
		array(
			'type' => 'get_terms',
			'term' => 'portfolio_categories',
			'heading' => esc_html__( 'Which categories should be used for the portfolio?', 'cryptox' ),
			'param_name' => 'categories',
			'description' => esc_html__('The Page will then show portfolio from only those categories.', 'cryptox'),
			'group' => esc_html__( 'Data Settings', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order By', 'cryptox' ),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__( 'Date', 'cryptox' ) => 'date',
				esc_html__( 'ID', 'cryptox' ) => 'ID',
				esc_html__( 'Author', 'cryptox' ) => 'author',
				esc_html__( 'Title', 'cryptox' ) => 'title',
				esc_html__( 'Modified', 'cryptox' ) => 'modified',
				esc_html__( 'Random', 'cryptox' ) => 'rand',
				esc_html__( 'Comment count', 'cryptox' ) => 'comment_count',
				esc_html__( 'Menu order', 'cryptox' ) => 'menu_order'
			),
			'description' => esc_html__( 'Sort retrieved items by parameter', 'cryptox' ),
			'group' => esc_html__( 'Data Settings', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order', 'cryptox' ),
			'param_name' => 'order',
			'value' => array(
				esc_html__( 'DESC', 'cryptox' ) => 'DESC',
				esc_html__( 'ASC', 'cryptox' ) => 'ASC',
			),
			'description' => esc_html__( 'Direction Order', 'cryptox' ),
			'group' => esc_html__( 'Data Settings', 'cryptox' )
		),
		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Sorting', 'cryptox' ),
			'param_name' => 'sort',
			'description' => esc_html__( 'Enable sorting', 'cryptox' ),
			'value' => array( esc_html__( 'Yes', 'cryptox' ) => true )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns', 'cryptox' ),
			'param_name' => 'columns',
			'value' => array(
				esc_html__( '2 Columns', 'cryptox' ) => 2,
				esc_html__( '3 Columns', 'cryptox' ) => 3,
				esc_html__( '4 Columns', 'cryptox' ) => 4,
			),
			'std' => 3,
			'description' => esc_html__( 'How many columns should be displayed?', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Count Items', 'cryptox' ),
			'param_name' => 'items',
			'value' => Cryptex_Vc_Config::array_number( 1, 51, 1, array( esc_html__('All', 'cryptox') => '-1') ),
			'std' => -1,
			'group' => esc_html__( 'Data Settings', 'cryptox' ),
			'description' => esc_html__( 'How many items should be displayed per page?', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Pagination', 'cryptox' ),
			'param_name' => 'paginate',
			'value' => array(
				esc_html__( 'Display Pagination', 'cryptox' ) => 'pagination',
				esc_html__( 'No option to view additional entries', 'cryptox' ) => 'none'
			),
			'std' => 'none',
			'description' => esc_html__( 'Should a pagination be displayed?', 'cryptox' )
		),
	)
) );

/* Pie and Round Chart
---------------------------------------------------------- */

vc_map(array(
	'name' => esc_html__( 'Pie and Round Chart', 'cryptox' ),
	'base' => 'vc_mad_pie_chart',
	'icon' => 'icon-wpb-mad-chart-pie',
	'category' => esc_html__( 'Cryptex', 'cryptox' ),
	'description' => esc_html__( 'Animated pie and round chart', 'cryptox' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'cryptox' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'cryptox' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Style', 'cryptox' ),
			'param_name' => 'style',
			'value' => array(
				esc_html__('Pie Chart', 'cryptox') => 'style-1',
				esc_html__('Round Chart', 'cryptox') => 'style-2'
			),
			'std' => 'style-1',
			'description' => esc_html__('Choose chart style.', 'cryptox')
		),
		array(
			'type' => 'param_group',
			'heading' => esc_html__( 'Values', 'cryptox' ),
			'param_name' => 'values',
			'description' => esc_html__( 'Enter values for graph - value, title and color.', 'cryptox' ),
			'value' => urlencode( json_encode( array(
				array(
					'label' => esc_html__( 'Years of Experience', 'cryptox' ),
					'value' => '75'
				),
				array(
					'label' => esc_html__( 'Satisfied Clients', 'cryptox' ),
					'value' => '45',
				),
			) ) ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Label', 'cryptox' ),
					'param_name' => 'label',
					'description' => esc_html__( 'Enter text used as title of bar.', 'cryptox' ),
					'admin_label' => true,
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Value', 'cryptox' ),
					'param_name' => 'value',
					'description' => esc_html__( 'Enter value of pie chart.', 'cryptox' ),
					'admin_label' => true,
				),
			)
		)
	)
) );

/* Bar and Line Chart
---------------------------------------------------------- */

vc_map(array(
	'name' => esc_html__( 'Bar and Line Chart', 'cryptox' ),
	'base' => 'vc_mad_bar_chart',
	'icon' => 'icon-wpb-mad-chart-pie',
	'category' => esc_html__( 'Cryptex', 'cryptox' ),
	'description' => esc_html__( 'Animated bar and line chart', 'cryptox' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'cryptox' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'cryptox' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Style', 'cryptox' ),
			'param_name' => 'style',
			'value' => array(
				esc_html__('Bar Chart', 'cryptox') => 'style-1',
				esc_html__('Line Chart', 'cryptox') => 'style-2'
			),
			'std' => 'style-1',
			'description' => esc_html__('Choose chart style.', 'cryptox')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Labels', 'cryptox' ),
			'value' => array(
				'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'
			),
			'param_name' => 'labels',
			'description' => esc_html__('A labels array that can contain any sort of values. Example: [\'Jan\', \'Feb\', \'Mar\', \'Apr\', \'May\', \'Jun\', \'Jul\', \'Aug\']', 'cryptox')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Symbol', 'cryptox' ),
			'value' => '',
			'param_name' => 'symbol',
			'description' => esc_html__('Example: $', 'cryptox')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Low', 'cryptox' ),
			'value' => 0,
			'param_name' => 'low',
			'description' => esc_html__('If low is specified then the axis will display values explicitly down to this value and the computed minimum from the data is ignored', 'cryptox')
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'High', 'cryptox' ),
			'value' => 40,
			'param_name' => 'high',
			'description' => esc_html__('If high is specified then the axis will display values explicitly up to this value and the computed maximum from the data is ignored', 'cryptox')
		),
		array(
			'type' => 'param_group',
			'heading' => esc_html__( 'Values', 'cryptox' ),
			'param_name' => 'values',
			'description' => esc_html__( 'Enter values for graph - value, title and color.', 'cryptox' ),
			'value' => urlencode( json_encode( array(
				array(
					'label' => esc_html__( 'Completed Projects', 'cryptox' ),
					'value' => '[10, 15, 20, 25, 27, 25, 18, 25]'
				),
				array(
					'label' => esc_html__( 'Satisfied Clients', 'cryptox' ),
					'value' => '[25, 18, 16, 18, 20, 25, 30, 35]',
				),
			) ) ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Label', 'cryptox' ),
					'param_name' => 'label',
					'description' => esc_html__( 'Enter text used as title of bar.', 'cryptox' ),
					'admin_label' => true,
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Value', 'cryptox' ),
					'param_name' => 'value',
					'description' => esc_html__( 'Enter value of pie chart.', 'cryptox' ),
					'admin_label' => true,
				),
			)
		)
	)
) );

if ( defined('VCW_VERSION') ) {

	$vcw_rates = array();
	$ids = array();
	$rates = VCW_Data::rates(array());

	foreach ( $rates as $code => $info ) {
		$vcw_rates[$info['name']] = $code;
	}

	foreach (VCW_Data::coinList() as $coin) {
		$ids[$coin['name']] = $coin['id'];
	}

	vc_map(
		array(
			'name' => esc_html__( 'Virtual Coin Table', 'cryptox' ),
			'base' => 'vc_mad_vcw_table',
			'icon' => 'icon-wpb-mad-virtual-coin',
			'category' => esc_html__( 'Cryptex', 'cryptox' ),
			'description' => esc_html__( 'Show virtual coin table', 'cryptox' ),
			'params' => array(
				array(
					"type" => "dropdown_multi",
					"heading" => esc_html__("Ids", 'cryptox'),
					'param_name'  => 'ids',
					"value" => $ids,
					'description'   => esc_html__("Cryptocurrency's id", 'cryptox'),
					'std'  => ''
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Price Currency', 'cryptox' ),
					'param_name' => 'currency',
					'value' => $vcw_rates,
					'std' => 'USD',
					'description' => esc_html__('Currency used for price quote', 'cryptox')
				),
			)
		)
	);

}


if ( class_exists('WooCommerce') ) {

	$order_by_values = array(
		'',
		esc_html__( 'Date', 'cryptox' ) => 'date',
		esc_html__( 'ID', 'cryptox' ) => 'ID',
		esc_html__( 'Author', 'cryptox' ) => 'author',
		esc_html__( 'Title', 'cryptox' ) => 'title',
		esc_html__( 'Modified', 'cryptox' ) => 'modified',
		esc_html__( 'Random', 'cryptox' ) => 'rand',
		esc_html__( 'Comment count', 'cryptox' ) => 'comment_count',
		esc_html__( 'Menu order', 'cryptox' ) => 'menu_order',
	);

	$order_way_values = array(
		'',
		esc_html__( 'Descending', 'cryptox' ) => 'DESC',
		esc_html__( 'Ascending', 'cryptox' ) => 'ASC',
	);

	vc_map(
		array(
			'name' => esc_html__( 'Products Carousel', 'cryptox' ),
			'base' => 'vc_mad_products',
			'icon' => 'icon-wpb-mad-woocommerce',
			'category' => esc_html__( 'Cryptex', 'cryptox' ),
			'description' => esc_html__( 'Show products carousel', 'cryptox' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'cryptox' ),
					'param_name' => 'title',
					'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'cryptox' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Per page', 'cryptox' ),
					'value' => 12,
					'save_always' => true,
					'param_name' => 'per_page',
					'description' => esc_html__( 'The "per_page" shortcode determines how many products to show on the page', 'cryptox' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Columns', 'cryptox' ),
					'value' => 4,
					'param_name' => 'columns',
					'save_always' => true,
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'cryptox' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'std' => 'title',
					'save_always' => true,
					'description' => sprintf( __( 'Select how to sort retrieved products. More at %s. Default by Title', 'cryptox' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Sort order', 'cryptox' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'save_always' => true,
					'description' => sprintf( __( 'Designates the ascending or descending order. More at %s. Default by ASC', 'cryptox' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
				),
				array(
					"type" => "get_terms",
					"term" => "product_cat",
					'heading' => esc_html__( 'Which categories should be used for the products?', 'cryptox' ),
					"param_name" => "category",
					'description' => esc_html__('The Page will then show products from only those categories.', 'cryptox'),
					'group' => esc_html__( 'Data Settings', 'cryptox' )
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Add button \'View All Products\'', 'cryptox' ),
					'param_name' => 'view_all_button',
					'description' => esc_html__( 'Show button.', 'cryptox' ),
					'value' => array( esc_html__( 'Yes, please', 'cryptox' ) => true )
				),
			)
		)
	);

}

/* Progress Bar
---------------------------------------------------------- */

vc_map(array(
	'name' => esc_html__( 'Progress Bar', 'cryptox' ),
	'base' => 'vc_mad_progress_bar',
	'icon' => 'icon-wpb-mad-progress-bar',
	'category' => esc_html__( 'Cryptex', 'cryptox' ),
	'description' => esc_html__( 'Animated progress bar', 'cryptox' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'cryptox' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'cryptox' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Style', 'cryptox' ),
			'param_name' => 'style',
			'value' => array(
				esc_html__('Style 1', 'cryptox') => 'style-1',
				esc_html__('Style 2', 'cryptox') => 'style-2'
			),
			'std' => 'style-1',
			'description' => esc_html__('Choose layout style.', 'cryptox')
		),
		array(
			'type' => 'param_group',
			'heading' => esc_html__( 'Values', 'cryptox' ),
			'param_name' => 'values',
			'description' => esc_html__( 'Enter values for graph - value, title and color.', 'cryptox' ),
			'value' => urlencode( json_encode( array(
				array(
					'label' => esc_html__( 'Intensive Format', 'cryptox' ),
					'value' => '75',
				),
				array(
					'label' => esc_html__( 'Experienced Staff', 'cryptox' ),
					'value' => '35',
				),
				array(
					'label' => esc_html__( 'World Class Venues', 'cryptox' ),
					'value' => '90',
				),
				array(
					'label' => esc_html__( 'Sutisfied Clients', 'cryptox' ),
					'value' => '60',
				),
			) ) ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Label', 'cryptox' ),
					'param_name' => 'label',
					'description' => esc_html__( 'Enter text used as title of bar.', 'cryptox' ),
					'admin_label' => true,
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Value', 'cryptox' ),
					'param_name' => 'value',
					'description' => esc_html__( 'Enter value of bar.', 'cryptox' ),
					'admin_label' => true,
				),
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Units', 'cryptox' ),
			'param_name' => 'units',
			'description' => esc_html__( 'Enter measurement units (Example: %, px, points, etc. Note: graph value and units will be appended to graph title).', 'cryptox' ),
		),
	),
));

/* Counter Bar
---------------------------------------------------------- */

vc_map( array(
	"name" => esc_html__("Counter", 'cryptox' ),
	"base"=> 'vc_mad_counter',
	"icon" => 'icon-wpb-mad-counter',
	'category' => esc_html__( 'Cryptex', 'cryptox' ),
	"description" => esc_html__( 'Counter', 'cryptox' ),
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'cryptox' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'cryptox' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Style', 'cryptox' ),
			'param_name' => 'style',
			'value' => array(
				esc_html__('Style 1', 'cryptox') => 'style-1',
				esc_html__('Style 2', 'cryptox') => 'style-2'
			),
			'std' => 'style-1',
			'description' => esc_html__('Choose layout style.', 'cryptox')
		),
		array(
			'type' => 'param_group',
			'heading' => esc_html__( 'Values', 'cryptox' ),
			'param_name' => 'values',
			'description' => esc_html__( 'Enter values - value and title.', 'cryptox' ),
			'value' => urlencode( json_encode( array(
				array(
					'label' => esc_html__( 'Years of Experience', 'cryptox' ),
					'value' => '18',
					'icon'  => 'licon-briefcase'
				),
				array(
					'label' => esc_html__( 'Satisfied Clients', 'cryptox' ),
					'value' => '389',
					'icon'  => 'licon-thumbs-up'
				),
				array(
					'label' => esc_html__( 'Experts in Our Team', 'cryptox' ),
					'value' => '15',
					'icon'  => 'licon-tie'
				),
				array(
					'label' => esc_html__( 'Completed Projects', 'cryptox' ),
					'value' => '74',
					'icon'  => 'licon-check'
				),
			) ) ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Label', 'cryptox' ),
					'param_name' => 'label',
					'description' => esc_html__( 'Enter text used as title.', 'cryptox' ),
					'admin_label' => true,
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Value', 'cryptox' ),
					'param_name' => 'value',
					'description' => esc_html__( 'Enter value.', 'cryptox' ),
					'admin_label' => true,
				),
				array(
					"type" => "choose_icons",
					"heading" => esc_html__("Icon", 'cryptox'),
					"param_name" => "icon",
					"value" => 'none',
					"description" => esc_html__( 'Select icon from library.', 'cryptox')
				)
			)
		),
	)
));

/* Image with Text
---------------------------------------------------------- */

vc_map( array(
	"name" => esc_html__("Image with Text", 'cryptox' ),
	"base"=> 'vc_mad_image_with_text',
	"icon" => '',
	'category' => esc_html__( 'Cryptex', 'cryptox' ),
	"description" => esc_html__( 'Image with Text', 'cryptox' ),
	"params" => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'cryptox' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'cryptox' ),
		),
		array(
			'type' => 'textarea_html',
			'holder' => 'div',
			'heading' => esc_html__( 'Text', 'cryptox' ),
			'param_name' => 'content',
			'value' => ''
		),
		array(
			'type' => 'vc_link',
			'heading' => esc_html__( 'URL (Link)', 'cryptox' ),
			'param_name' => 'link',
			'description' => esc_html__( 'Add link to custom heading.', 'cryptox' ),
		),
		array(
			'type' => 'attach_image',
			'heading' => esc_html__( 'Image', 'cryptox' ),
			'param_name' => 'image',
			'value' => '',
			'description' => esc_html__( 'Select image from media library.', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Align image', 'cryptox' ),
			'param_name' => 'align_image',
			'value' => array(
				esc_html__('Left', 'cryptox') => 'left',
				esc_html__('Right', 'cryptox') => 'right'
			),
			'std' => 'left',
			'description' => esc_html__('Choose align image.', 'cryptox')
		),
	)
));


/* Image with Video Button
---------------------------------------------------------- */

vc_map( array(
	"name" => esc_html__("Image with Video Button", 'cryptox' ),
	"base"=> 'vc_mad_image_with_video_button',
	"icon" => 'icon-wpb-mad-video-button',
	'category' => esc_html__( 'Cryptex', 'cryptox' ),
	"description" => esc_html__( 'Image with Video Button', 'cryptox' ),
	"params" => array(
		array(
			'type' => 'attach_image',
			'heading' => esc_html__( 'Image', 'cryptox' ),
			'param_name' => 'image',
			'value' => '',
			'description' => esc_html__( 'Select image from media library.', 'cryptox' )
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Video link', 'cryptox' ),
			'param_name' => 'link',
			'value' => 'https://vimeo.com/51589652',
			'admin_label' => true,
			'description' => sprintf( __( 'Enter link to video (Note: read more about available formats at WordPress <a href="%s" target="_blank">codex page</a>).', 'cryptox' ), 'http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F' ),
		),
	)
));


/* Team Members
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Team Members', 'cryptox' ),
	'base' => 'vc_mad_team_members',
	'icon' => 'icon-wpb-mad-team-members',
	'category' => esc_html__( 'Cryptex', 'cryptox' ),
	'description' => esc_html__( 'Team Members post type', 'cryptox' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'cryptox' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'cryptox' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Description', 'cryptox' ),
			'param_name' => 'description',
			'description' => esc_html__( 'Enter text which will be used as description. Leave blank if no description is needed.', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Style', 'cryptox' ),
			'param_name' => 'style',
			'description' => esc_html__( 'Select style.', 'cryptox' ),
			'value' => array(
				esc_html__( 'Style 1', 'cryptox' ) => 'style-1',
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Columns', 'cryptox' ),
			'param_name' => 'columns',
			'value' => array(
				esc_html__( '3 Columns', 'cryptox' ) => 3,
				esc_html__( '4 Columns', 'cryptox' ) => 4
			),
			'description' => esc_html__( 'How many columns should be displayed?', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Count Items', 'cryptox' ),
			'param_name' => 'items',
			'value' => Cryptex_Vc_Config::array_number(1, 51, 1, array('All' => '-1')),
			'std' => -1,
			'description' => esc_html__( 'How many items should be displayed per page?', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order By', 'cryptox' ),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__( 'Date', 'cryptox' ) => 'date',
				esc_html__( 'ID', 'cryptox' ) => 'ID',
				esc_html__( 'Author', 'cryptox' ) => 'author',
				esc_html__( 'Title', 'cryptox' ) => 'title',
				esc_html__( 'Modified', 'cryptox' ) => 'modified',
				esc_html__( 'Random', 'cryptox' ) => 'rand',
				esc_html__( 'Comment count', 'cryptox' ) => 'comment_count',
				esc_html__( 'Menu order', 'cryptox' ) => 'menu_order'
			),
			'description' => ''
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order', 'cryptox' ),
			'param_name' => 'order',
			'value' => array(
				esc_html__( 'DESC', 'cryptox' ) => 'DESC',
				esc_html__( 'ASC', 'cryptox' ) => 'ASC',
			),
			'description' => esc_html__( 'Direction Order', 'cryptox' )
		)
	)
) );

/* Testimonials
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__( 'Testimonials', 'cryptox' ),
	'base' => 'vc_mad_testimonials',
	'icon' => 'icon-wpb-mad-testimonials',
	'category' => esc_html__( 'Cryptex', 'cryptox' ),
	'description' => esc_html__( 'Testimonials post type', 'cryptox' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Title', 'cryptox' ),
			'param_name' => 'title',
			'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'cryptox' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Testimonial Style', 'cryptox' ),
			'param_name' => 'style',
			'value' => array(
				esc_html__( 'Carousel Style 1', 'cryptox' ) => 'style-1',
				esc_html__( 'Carousel Style 2', 'cryptox' ) => 'style-2',
				esc_html__( 'List', 'cryptox' ) => 'style-3'
			),
			'description' => esc_html__( 'Here you can select how to display the testimonials.', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Count Items', 'cryptox' ),
			'param_name' => 'items',
			'value' => Cryptex_Vc_Config::array_number(1, 51, 1, array( esc_html__('All', 'cryptox') => '-1') ),
			'std' => -1,
			'description' => esc_html__( 'How many items should be displayed per page?', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order By', 'cryptox' ),
			'param_name' => 'orderby',
			'value' => array(
				esc_html__( 'Date', 'cryptox' ) => 'date',
				esc_html__( 'ID', 'cryptox' ) => 'ID',
				esc_html__( 'Author', 'cryptox' ) => 'author',
				esc_html__( 'Title', 'cryptox' ) => 'title',
				esc_html__( 'Modified', 'cryptox' ) => 'modified',
				esc_html__( 'Random', 'cryptox' ) => 'rand',
				esc_html__( 'Comment count', 'cryptox' ) => 'comment_count',
				esc_html__( 'Menu order', 'cryptox' ) => 'menu_order'
			),
			'description' => esc_html__( 'Sort retrieved items by parameter', 'cryptox' ),
			'edit_field_class' => 'vc_col-sm-6',
			'group' => esc_html__( 'Data Settings', 'cryptox' )
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Order', 'cryptox' ),
			'param_name' => 'order',
			'value' => array(
				esc_html__( 'DESC', 'cryptox' ) => 'DESC',
				esc_html__( 'ASC', 'cryptox' ) => 'ASC',
			),
			'description' => esc_html__( 'Direction Order', 'cryptox' ),
			'edit_field_class' => 'vc_col-sm-6',
			'group' => esc_html__( 'Data Settings', 'cryptox' )
		),
	)
) );

/* Tooltip
---------------------------------------------------------- */

vc_map( array(
	'name' => esc_html__('Tooltip', 'cryptox'),
	'base' => 'vc_mad_tooltip',
	'category' => esc_html__('Cryptex', 'cryptox'),
	'icon' => 'icon-wpb-mad-tooltip',
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Text', 'cryptox'),
			'param_name' => 'text',
			'admin_label' => true,
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Link", 'cryptox'),
			"param_name" => "link",
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Link target', 'cryptox' ),
			'param_name' => 'target_link',
			'description' => esc_html__( 'Select where to open link.', 'cryptox' ),
			'value' => $target_arr,
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__('Tooltip Text', 'cryptox'),
			'param_name' => 'tooltip_text',
			'admin_label' => true,
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Tooltip Position', 'cryptox' ),
			'param_name' => 'tooltip_position',
			'value' => array(
				esc_html__('Top', 'cryptox')     => 'top',
				esc_html__('Right', 'cryptox')   => 'right',
				esc_html__('Bottom', 'cryptox')  => 'bottom',
				esc_html__('Left', 'cryptox')    => 'left'
			)
		)
	)
) );

/* Dropcap
---------------------------------------------------------- */
vc_map( array(
	'name' => esc_html__( 'Dropcap', 'cryptox' ),
	'base' => 'vc_mad_dropcap',
	'icon' => 'icon-wpb-mad-dropcap',
	'category' => esc_html__( 'Cryptex', 'cryptox' ),
	'description' => esc_html__( 'Dropcap', 'cryptox' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Letter', 'cryptox' ),
			'param_name' => 'letter',
			'admin_label' => true,
			'description' => ''
		),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Color for dropcap', 'cryptox' ),
			'param_name' => 'dropcap_color',
			'description' => esc_html__( 'Select custom color for dropcap.', 'cryptox' ),
			'dependency' => array(
				'element' => 'style',
				'value' => array('type-1'),
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Style', 'cryptox' ),
			'param_name' => 'type',
			'value' => array(
				esc_html__('Style 1', 'cryptox') => 'type-1',
				esc_html__('Style 2', 'cryptox') => 'type-2'
			),
			'std' => 'type-1',
			'description' => esc_html__('Choose style type.', 'cryptox')
		),
		array(
			'type' => 'textarea_html',
			'holder' => 'div',
			'heading' => esc_html__( 'Text', 'cryptox' ),
			'param_name' => 'content',
			'value' => ''
		),
	)
));


/*** Visual Composer Content elements refresh ***/
class CryptexVcSharedLibrary {
	// Here we will store plugin wise (shared) settings. Colors, Locations, Sizes, etc...
	/**
	 * @var array
	 */
	private static $colors = array(
		'Blue' => 'blue',
		'Turquoise' => 'turquoise',
		'Pink' => 'pink',
		'Violet' => 'violet',
		'Peacoc' => 'peacoc',
		'Chino' => 'chino',
		'Mulled Wine' => 'mulled_wine',
		'Vista Blue' => 'vista_blue',
		'Black' => 'black',
		'Grey' => 'grey',
		'Orange' => 'orange',
		'Sky' => 'sky',
		'Green' => 'green',
		'Juicy pink' => 'juicy_pink',
		'Sandy brown' => 'sandy_brown',
		'Purple' => 'purple',
		'White' => 'white'
	);

	/**
	 * @var array
	 */
	public static $icons = array(
		'Glass' => 'glass',
		'Music' => 'music',
		'Search' => 'search'
	);

	/**
	 * @var array
	 */
	public static $sizes = array(
		'Mini' => 'xs',
		'Small' => 'sm',
		'Normal' => 'md',
		'Large' => 'lg'
	);

	/**
	 * @var array
	 */
	public static $button_styles = array(
		'Rounded' => 'rounded',
		'Square' => 'square',
		'Round' => 'round',
		'Outlined' => 'outlined',
		'3D' => '3d',
		'Square Outlined' => 'square_outlined'
	);

	/**
	 * @var array
	 */
	public static $message_box_styles = array(
		'Standard' => 'standard',
		'Solid' => 'solid',
		'Solid icon' => 'solid-icon',
		'Outline' => 'outline',
		'3D' => '3d',
	);

	/**
	 * Toggle styles
	 * @var array
	 */
	public static $toggle_styles = array(
		'Default' => 'default',
		'Simple' => 'simple',
		'Round' => 'round',
		'Round Outline' => 'round_outline',
		'Rounded' => 'rounded',
		'Rounded Outline' => 'rounded_outline',
		'Square' => 'square',
		'Square Outline' => 'square_outline',
		'Arrow' => 'arrow',
		'Text Only' => 'text_only',
	);

	/**
	 * Animation styles
	 * @var array
	 */
	public static $animation_styles = array(
		'Bounce' => 'easeOutBounce',
		'Elastic' => 'easeOutElastic',
		'Back' => 'easeOutBack',
		'Cubic' => 'easeinOutCubic',
		'Quint' => 'easeinOutQuint',
		'Quart' => 'easeOutQuart',
		'Quad' => 'easeinQuad',
		'Sine' => 'easeOutSine'
	);

	/**
	 * @var array
	 */
	public static $cta_styles = array(
		'Rounded' => 'rounded',
		'Square' => 'square',
		'Round' => 'round',
		'Outlined' => 'outlined',
		'Square Outlined' => 'square_outlined'
	);

	/**
	 * @var array
	 */
	public static $txt_align = array(
		'Left' => 'left',
		'Right' => 'right',
		'Center' => 'center',
		'Justify' => 'justify'
	);

	/**
	 * @var array
	 */
	public static $el_widths = array(
		'100%' => '',
		'90%' => '90',
		'80%' => '80',
		'70%' => '70',
		'60%' => '60',
		'50%' => '50'
	);

	/**
	 * @var array
	 */
	public static $sep_widths = array(
		'1px' => '',
		'2px' => '2',
		'3px' => '3',
		'4px' => '4',
		'5px' => '5',
		'6px' => '6',
		'7px' => '7',
		'8px' => '8',
		'9px' => '9',
		'10px' => '10'
	);

	/**
	 * @var array
	 */
	public static $sep_styles = array(
		'Border' => '',
		'Dashed' => 'dashed',
		'Dotted' => 'dotted',
		'Double' => 'double'
	);

	/**
	 * @var array
	 */
	public static $box_styles = array(
		'Default' => '',
		'Rounded' => 'vc_box_rounded',
		'Border' => 'vc_box_border',
		'Outline' => 'vc_box_outline',
		'Shadow' => 'vc_box_shadow',
		'Bordered shadow' => 'vc_box_shadow_border',
		'3D Shadow' => 'vc_box_shadow_3d',
		'Round' => 'vc_box_circle', //new
		'Round Border' => 'vc_box_border_circle', //new
		'Round Outline' => 'vc_box_outline_circle', //new
		'Round Shadow' => 'vc_box_shadow_circle', //new
		'Round Border Shadow' => 'vc_box_shadow_border_circle', //new
		'Circle' => 'vc_box_circle_2', //new
		'Circle Border' => 'vc_box_border_circle_2', //new
		'Circle Outline' => 'vc_box_outline_circle_2', //new
		'Circle Shadow' => 'vc_box_shadow_circle_2', //new
		'Circle Border Shadow' => 'vc_box_shadow_border_circle_2' //new
	);

	/**
	 * @return array
	 */
	public static function getColors() {
		return self::$colors;
	}

	/**
	 * @return array
	 */
	public static function getIcons() {
		return self::$icons;
	}

	/**
	 * @return array
	 */
	public static function getSizes() {
		return self::$sizes;
	}

	/**
	 * @return array
	 */
	public static function getButtonStyles() {
		return self::$button_styles;
	}

	/**
	 * @return array
	 */
	public static function getMessageBoxStyles() {
		return self::$message_box_styles;
	}

	/**
	 * @return array
	 */
	public static function getToggleStyles() {
		return self::$toggle_styles;
	}

	/**
	 * @return array
	 */
	public static function getAnimationStyles() {
		return self::$animation_styles;
	}

	/**
	 * @return array
	 */
	public static function getCtaStyles() {
		return self::$cta_styles;
	}

	/**
	 * @return array
	 */
	public static function getTextAlign() {
		return self::$txt_align;
	}

	/**
	 * @return array
	 */
	public static function getBorderWidths() {
		return self::$sep_widths;
	}

	/**
	 * @return array
	 */
	public static function getElementWidths() {
		return self::$el_widths;
	}

	/**
	 * @return array
	 */
	public static function getSeparatorStyles() {
		return self::$sep_styles;
	}

	/**
	 * @return array
	 */
	public static function getBoxStyles() {
		return self::$box_styles;
	}

	public static function getColorsDashed() {
		$colors = array(
			esc_html__( 'Blue', 'cryptox' ) => 'blue',
			esc_html__( 'Turquoise', 'cryptox' ) => 'turquoise',
			esc_html__( 'Pink', 'cryptox' ) => 'pink',
			esc_html__( 'Violet', 'cryptox' ) => 'violet',
			esc_html__( 'Peacoc', 'cryptox' ) => 'peacoc',
			esc_html__( 'Chino', 'cryptox' ) => 'chino',
			esc_html__( 'Mulled Wine', 'cryptox' ) => 'mulled-wine',
			esc_html__( 'Vista Blue', 'cryptox' ) => 'vista-blue',
			esc_html__( 'Black', 'cryptox' ) => 'black',
			esc_html__( 'Grey', 'cryptox' ) => 'grey',
			esc_html__( 'Orange', 'cryptox' ) => 'orange',
			esc_html__( 'Sky', 'cryptox' ) => 'sky',
			esc_html__( 'Green', 'cryptox' ) => 'green',
			esc_html__( 'Juicy pink', 'cryptox' ) => 'juicy-pink',
			esc_html__( 'Sandy brown', 'cryptox' ) => 'sandy-brown',
			esc_html__( 'Purple', 'cryptox' ) => 'purple',
			esc_html__( 'White', 'cryptox' ) => 'white'
		);

		return $colors;
	}
}

/**
 * @param string $asset
 *
 * @return array
 */
function hhgetVcShared( $asset = '' ) {
	switch ( $asset ) {
		case 'colors':
			return CryptexVcSharedLibrary::getColors();
			break;

		case 'colors-dashed':
			return CryptexVcSharedLibrary::getColorsDashed();
			break;

		case 'icons':
			return CryptexVcSharedLibrary::getIcons();
			break;

		case 'sizes':
			return CryptexVcSharedLibrary::getSizes();
			break;

		case 'button styles':
		case 'alert styles':
			return CryptexVcSharedLibrary::getButtonStyles();
			break;
		case 'message_box_styles':
			return CryptexVcSharedLibrary::getMessageBoxStyles();
			break;
		case 'cta styles':
			return CryptexVcSharedLibrary::getCtaStyles();
			break;

		case 'text align':
			return CryptexVcSharedLibrary::getTextAlign();
			break;

		case 'cta widths':
		case 'separator widths':
			return CryptexVcSharedLibrary::getElementWidths();
			break;

		case 'separator styles':
			return CryptexVcSharedLibrary::getSeparatorStyles();
			break;

		case 'separator border widths':
			return CryptexVcSharedLibrary::getBorderWidths();
			break;

		case 'single image styles':
			return CryptexVcSharedLibrary::getBoxStyles();
			break;

		case 'toggle styles':
			return CryptexVcSharedLibrary::getToggleStyles();
			break;

		case 'animation styles':
			return CryptexVcSharedLibrary::getAnimationStyles();
			break;

		default:
			# code...
			break;
	}

	return '';
}