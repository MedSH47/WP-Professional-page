<?php

	$vc_icons_data = pixtheme_init_vc_icons();

	$args = array( 'hide_empty' => false );
	$categories = get_terms( $args );
	$cats = $cats_team = $cats_post = $cats_woo = $cats_serv = $calendars = $calculators = array();
	$calendars[esc_html__('Default Calendar', 'solutech')] = 0;
	$calculators[esc_html__('Default', 'solutech')] = 0;
	foreach($categories as $category){
		if( is_object($category) ){
			if( $category->taxonomy == 'pix-portfolio-cat' ){
				$cats[$category->name] = $category->slug;
			} elseif( $category->taxonomy == 'pix-team-cat' ) {
				$cats_team[$category->name] = $category->slug;
			} elseif( $category->taxonomy == 'category' ) {
				$cats_post[$category->name] = $category->slug;
			} elseif( $category->taxonomy == 'product_cat' ) {
				$cats_woo[$category->name] = $category->slug;
			} elseif( $category->taxonomy == 'pix-service-cat' ) {
				$cats_serv[$category->name] = $category->slug;
			} elseif( $category->taxonomy == 'pix-calculator' ) {
				$calculators[$category->name] = $category->slug;
			} elseif( $category->taxonomy == 'booked_custom_calendars' ) {
				$calendars[$category->name] = $category->term_id;
			}
		}
	}
	
	$args = array( 'post_type' => 'page', 'posts_per_page' => -1);
	$pages_arr = get_posts($args);
	$pages = array();
	if(empty($pages_arr['errors'])){
		foreach($pages_arr as $page){
			$pages[$page->post_title] = $page->ID;
		}
	}

	$args = array( 'post_type' => 'pix-service');
	$services = get_posts($args);
	$serv = array();
	if(empty($services['errors'])){
		foreach($services as $service){
			$serv[$service->post_title] = $service->ID;
		}
	}
	
	$args = array( 'post_type' => 'wpcf7_contact_form');
	$forms = get_posts($args);
	$cform7 = array();
	if(empty($forms['errors'])){
		foreach($forms as $form){		
			$cform7[$form->post_title] = $form->ID;
		}
	}
    
    $post_types_control = array();
	$post_types = array(
	    'default' => 'pix-portfolio',
    );
	if(pixtheme_get_setting('pix-portfolio', 'off') == 'on'){
	    $post_types[esc_html__('Portfolio', 'solutech')] = 'pix-portfolio';
        $post_types_control[] = array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Portfolio Categories', 'solutech' ),
            'param_name' => 'portfolio_cat',
            'value' => $cats,
            'description' => esc_html__( 'Select categories to show', 'solutech' ),
            'dependency' => array(
                'element' => 'post_type',
                'value' => array('pix-portfolio'),
            )
        );
	}
	if(pixtheme_get_setting('pix-service', 'off') == 'on'){
	    $post_types[esc_html__('Services', 'solutech')] = 'pix-service';
        $post_types_control[] = array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Departments', 'solutech' ),
            'param_name' => 'service_cat',
            'value' => $cats_serv,
            'description' => esc_html__( 'Select categories to show', 'solutech' ),
            'dependency' => array(
                'element' => 'post_type',
                'value' => array('pix-service'),
            )
        );
	}
	if(pixtheme_get_setting('pix-team', 'off') == 'on'){
	    $post_types[esc_html__('Team', 'solutech')] = 'pix-team';
        $post_types_control[] = array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Team Categories', 'solutech' ),
            'param_name' => 'team_cat',
            'value' => $cats_team,
            'description' => esc_html__( 'Select categories to show', 'solutech' ),
            'dependency' => array(
                'element' => 'post_type',
                'value' => array('pix-team'),
            )
        );
	}
	if ( class_exists( 'WooCommerce' ) ) {
        $post_types[esc_html__('Products', 'solutech')] = 'product';
        $post_types_control[] = array(
            'type' => 'checkbox',
            'heading' => esc_html__( 'Products Categories', 'solutech' ),
            'param_name' => 'product_cat',
            'value' => $cats_woo,
            'description' => esc_html__( 'Select categories to show', 'solutech' ),
            'dependency' => array(
                'element' => 'post_type',
                'value' => array('product'),
            )
        );
    }
    
    function pix_vc_control($control, $field_class = '', $dep_element = '', $dep_arr = array(), $title = '', $default = ''){
	    
	    $control_arr = array();
	    
	    switch ($control) {
	        case 'radius' :
	            $title = empty($title) ? esc_html__( 'Shape', 'solutech' ) : $title;
	            $default = empty($default) ? 'pix-global' : $default;
	            $control_arr = array(
	                'type' => 'segmented_button',
                    'heading' => $title,
                    'param_name' => 'radius',
                    'value' => array(
                        'default' => $default,
                        esc_html__( 'Global', 'solutech' ) => 'pix-global',
                        esc_html__( 'Square', 'solutech' ) => 'pix-square',
                        esc_html__( 'Rounded', 'solutech' ) => 'pix-rounded',
                        esc_html__( 'Round', 'solutech' ) => 'pix-round',
                    ),
                );
                break;
                
            case 'box_gap' :
	            $title = empty($title) ? esc_html__( 'Boxes Gap', 'solutech' ) : $title;
	            $default = empty($default) ? '0' : $default;
	            $control_arr = array(
                    'type' => 'dropdown',
                    'heading' => $title,
                    'param_name' => 'box_gap',
                    'value' => array(0,1,2,5,10,15,20,30,50),
                );
                break;
        }
        
        if( !empty($dep_element) && !empty($dep_arr) ){
            $control_arr['dependancy'] = array(
                'element' => $dep_element,
                'value' => $dep_arr
            );
        }
        
        if( !empty($field_class) ){
            $control_arr['edit_field_class'] = $field_class;
        }
        
        return $control_arr;
        
    }




	/// common_title
	vc_map(
		array(
			'name' => esc_html__( 'Title', 'solutech' ),
			'base' => 'common_title',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Pixtheme', 'solutech'),
			'params' => array(
				array(
					'type' => 'textarea',
					'holder' => 'div',
					'heading' => esc_html__( 'Title', 'solutech' ),
					'param_name' => 'title',
					'value' => esc_html__( 'I am Title', 'solutech' ),
					'description' => esc_html__( 'Main title.', 'solutech' )
				),
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'No Wrap', 'solutech' ),
                    'param_name' => 'no_wrap',
                    'value' => 'off',
                    'description' => esc_html__( 'If On, the overflowing text will not be moved to a new line', 'solutech' )
                ),
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Size', 'solutech' ),
                    'param_name' => 'size',
                    'value' => array(
                        'default' => 'pix-l',
                        esc_html__( 'Default', 'solutech' ) => 'pix-l',
                        esc_html__( 'Small', 'solutech' ) => 'pix-s',
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'Bottom Padding', 'solutech' ),
                    'param_name' => 'padding',
                    'value' => 'on',
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Position', 'solutech' ),
                    'param_name' => 'position',
                    'value' => array(
                        'default' => 'text-center',
                        esc_html__( 'Left', 'solutech' ) => 'text-left',
                        esc_html__( 'Center', 'solutech' ) => 'text-center',
                        esc_html__( 'Right', 'solutech' ) => 'text-right',
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'Show Decor', 'solutech' ),
                    'param_name' => 'show_decor',
                    'value' => 'on',
                    'edit_field_class' => 'vc_col-sm-6',
                ),
				array(
					'type' => 'textarea',
//                    'holder' => 'div',
					'heading' => esc_html__( 'Pre title', 'solutech' ),
					'param_name' => 'subtitle',
					'value' => '',
					'description' => esc_html__( 'Text before title', 'solutech' )
				),
                array(
                    'type' => 'textarea_html',
//                    'holder' => 'div',
                    'heading' => esc_html__( 'Content', 'solutech' ),
                    'param_name' => 'content',
                    'value' => '',
                    'description' => ''
                ),
				array(
					'type' => 'segmented_button',
					'heading' => esc_html__( 'Text Tone', 'solutech' ),
					'param_name' => 'color',
					'value' => array(
                        'default' => 'default',
						esc_html__( 'Dark', 'solutech' ) => 'default',
						esc_html__( 'Light', 'solutech' ) => 'white-heading',
					),
				),
                array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Class', 'solutech' ),
					'param_name' => 'pix_class',
					'value' => '',
                    'description' => esc_html__( 'Add custom class to title', 'solutech' )
				),
                array(
                    'type' => 'css_editor',
                    'heading' => esc_html__( 'Css', 'solutech' ),
                    'param_name' => 'css',
                    'group' => esc_html__( 'Design options', 'solutech' ),
                ),
			)
		)
	);



	/// common_button
	vc_map(
		array(
			'name' => esc_html__( 'Button', 'solutech' ),
			'base' => 'common_button',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Solutech', 'solutech'),
			'params' => array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'heading' => esc_html__( 'Text', 'solutech' ),
					'param_name' => 'text',
					'value' => esc_html__( 'Go', 'solutech' ),
					'description' => esc_html__( 'Button text.', 'solutech' )
				),
				array(
                    'type' => 'vc_link',
                    'heading' => esc_html__( 'Link', 'solutech' ),
                    'param_name' => 'link',
                    'value' => '',
                    'description' => esc_html__( 'Button link', 'solutech' )
                ),
				array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'As Link', 'solutech' ),
                    'param_name' => 'button_type',
                    'value' => 'off',
                    'description' => esc_html__( 'Use as simple link with hover underline', 'solutech' )
                ),
				array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Shape', 'solutech' ),
                    'param_name' => 'radius',
                    'value' => array(
                        'default' => 'pix-global',
                        esc_html__( 'Global', 'solutech' ) => 'pix-global',
                        esc_html__( 'Square', 'solutech' ) => 'pix-square',
                        esc_html__( 'Rounded', 'solutech' ) => 'pix-rounded',
                        esc_html__( 'Round', 'solutech' ) => 'pix-round',
                    ),
                    'dependency' => array(
                        'element' => 'button_type',
                        'value' => array('off')
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'Transparent', 'solutech' ),
                    'param_name' => 'transparent',
                    'value' => 'off',
                    'dependency' => array(
                        'element' => 'button_type',
                        'value' => array('off')
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Top/Bottom Paddings', 'solutech' ),
                    'param_name' => 'size_v',
                    'value' => array(
                        'default' => 'pix-v-s',
                        esc_html__( 'S', 'solutech' ) => 'pix-v-s',
                        esc_html__( 'M', 'solutech' ) => 'pix-v-m',
                        esc_html__( 'L', 'solutech' ) => 'pix-v-l',
                        esc_html__( 'XL', 'solutech' ) => 'pix-v-xl',
                    ),
                    'dependency' => array(
                        'element' => 'button_type',
                        'value' => array('off')
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
				array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Left/Right Paddings', 'solutech' ),
                    'param_name' => 'size_h',
                    'value' => array(
                        'default' => 'pix-h-l',
                        esc_html__( 'S', 'solutech' ) => 'pix-h-s',
                        esc_html__( 'M', 'solutech' ) => 'pix-h-m',
                        esc_html__( 'L', 'solutech' ) => 'pix-h-l',
                        esc_html__( 'XL', 'solutech' ) => 'pix-h-xl',
                    ),
                    'dependency' => array(
                        'element' => 'button_type',
                        'value' => array('off')
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
				array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Font Size', 'solutech' ),
                    'param_name' => 'font_size',
                    'value' => array(
                        'default' => 'pix-font-m',
                        esc_html__( 'S', 'solutech' ) => 'pix-font-s',
                        esc_html__( 'M', 'solutech' ) => 'pix-font-m',
                        esc_html__( 'L', 'solutech' ) => 'pix-font-l',
                        esc_html__( 'XL', 'solutech' ) => 'pix-font-xl',
                    ),
                ),
				array(
					'type' => 'segmented_button',
					'heading' => esc_html__( 'Color', 'solutech' ),
					'param_name' => 'color',
					'value' => array(
                        'default' => 'pix-colored',
						esc_html__( 'Colored', 'solutech' ) => 'pix-colored',
						esc_html__( 'Dark', 'solutech' ) => 'pix-dark',
						esc_html__( 'Light', 'solutech' ) => 'pix-light',
					),
                    'edit_field_class' => 'vc_col-sm-6',
				),
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Alignment', 'solutech' ),
                    'param_name' => 'position',
                    'value' => array(
                        'default' => 'pix-text-left',
                        esc_html__( 'Left', 'solutech' ) => 'pix-text-left',
                        esc_html__( 'Center', 'solutech' ) => 'pix-text-center',
                        esc_html__( 'Right', 'solutech' ) => 'pix-text-right',
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'css_editor',
                    'heading' => esc_html__( 'Css', 'solutech' ),
                    'param_name' => 'css',
                    'group' => esc_html__( 'Design options', 'solutech' ),
                ),
			)
		)
	);



	/// common_box_icon
	vc_map(
		array(
			'name' => esc_html__( 'Icon Box', 'solutech' ),
			'base' => 'common_icon_box',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Solutech', 'solutech'),
			'params' => array_merge(
				array(
					array(
						'type' => 'radio_images',
						'heading' => esc_html__( 'Style', 'solutech' ),
						'param_name' => 'style',
						'value' => array(
                            'icon_box-side.png' => 'pix-ibox-side',
							'icon_box-title-side.png' => 'pix-ibox-title-side',
							'icon_box-top.png' => 'pix-ibox-top',
                            'services_cat_flip.png' => 'pix-ibox-flip',
						),
						'col' => 4,
						'description' => '',
					),
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__( 'Background Image', 'solutech' ),
                        'param_name' => 'bg_image',
                        'description' => esc_html__( 'Select image.', 'solutech' ),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('pix-ibox-flip')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'switch_button',
                        'heading' => esc_html__( 'Flip Box', 'solutech' ),
                        'param_name' => 'flip',
                        'value' => 'on',
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('pix-ibox-flip'),
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Box Shape', 'solutech' ),
                        'param_name' => 'radius',
                        'value' => array(
                            'default' => 'pix-global',
                            esc_html__( 'Global', 'solutech' ) => 'pix-global',
                            esc_html__( 'Square', 'solutech' ) => 'pix-square',
                            esc_html__( 'Rounded', 'solutech' ) => 'pix-rounded',
                            esc_html__( 'Round', 'solutech' ) => 'pix-round',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Alignment', 'solutech' ),
                        'param_name' => 'position_with_center',
                        'value' => array(
                            'default' => 'pix-text-left',
                            esc_html__( 'Left', 'solutech' ) => 'pix-text-left',
                            esc_html__( 'Center', 'solutech' ) => 'pix-text-center',
                            esc_html__( 'Right', 'solutech' ) => 'pix-text-right',
                        ),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('pix-ibox-top')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Alignment', 'solutech' ),
                        'param_name' => 'position_no_center',
                        'value' => array(
                            'default' => 'pix-text-review-left',
                            esc_html__( 'Left', 'solutech' ) => 'pix-text-review-left',
                            esc_html__( 'Right', 'solutech' ) => 'pix-text-review-right',
                        ),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('pix-ibox-side', 'pix-ibox-title-side')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'switch_button',
                        'heading' => esc_html__( 'Border', 'solutech' ),
                        'param_name' => 'border',
                        'value' => 'off',
                        'description' => esc_html__( 'Show border around the box', 'solutech' ),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('pix-ibox-top')
                        ),
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
                    array(
                        'type' => 'switch_button',
                        'heading' => esc_html__( 'Fill on Hover', 'solutech' ),
                        'param_name' => 'filled',
                        'value' => 'off',
                        'description' => esc_html__( 'Fill the background with the main color on hover', 'solutech' ),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('pix-ibox-top')
                        ),
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
                    array(
                        'type' => 'switch_button',
                        'heading' => esc_html__( 'No Padding', 'solutech' ),
                        'param_name' => 'no_padding',
                        'value' => 'off',
                        'description' => esc_html__( 'Set default padding to 0', 'solutech' ),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('pix-ibox-top')
                        ),
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Icon Type', 'solutech' ),
                        'param_name' => 'icon_type',
                        'value' => array(
                            'default' => 'image',
                            esc_html__( 'Image/SVG', 'solutech' ) => 'image',
                            esc_html__( 'Font', 'solutech' ) => 'font',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Fill Color', 'solutech' ),
                        'param_name' => 'fill_color',
                        'value' => array(
                            'default' => 'pix-main-color',
                            esc_html__( 'Main', 'solutech' ) => 'pix-main-color',
                            esc_html__( 'Additional', 'solutech' ) => 'pix-additional-color',
                            esc_html__( 'Gradient', 'solutech' ) => 'pix-gradient-color',
                            esc_html__( 'Black', 'solutech' ) => 'pix-black-color',
                        ),
                        'dependency' => array(
                            'element' => 'filled',
                            'value' => array('on')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
					array(
						'type' => 'attach_image',
						'heading' => esc_html__( 'Image/SVG', 'solutech' ),
						'param_name' => 'image',
						'description' => esc_html__( 'Select image.', 'solutech' ),
                        'dependency' => array(
                            'element' => 'icon_type',
                            'value' => array('image')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
					),
					
				),
				pixtheme_get_vc_icons($vc_icons_data, 'icon_type', 'font'),
				array(
				    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Icon Size', 'solutech' ),
                        'param_name' => 'icon_size',
                        'value' => array(
                            'default' => 'pix-icon-l',
                            esc_html__( 'S', 'solutech' ) => 'pix-icon-s',
                            esc_html__( 'M', 'solutech' ) => 'pix-icon-m',
                            esc_html__( 'L', 'solutech' ) => 'pix-icon-l',
                            esc_html__( 'XL', 'solutech' ) => 'pix-icon-xl',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Icon Background', 'solutech' ),
                        'param_name' => 'icon_shape',
                        'value' => array(
                            'default' => 'transparent',
                            esc_html__( 'Transparent', 'solutech' ) => 'transparent',
                            esc_html__( 'Round', 'solutech' ) => 'round',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
				    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Icon Color', 'solutech' ),
                        'param_name' => 'icon_color',
                        'value' => array(
                            'default' => 'pix-icon-color',
                            esc_html__( 'Color', 'solutech' ) => 'pix-icon-color',
                            esc_html__( 'Gradient', 'solutech' ) => 'pix-icon-gradient',
                            esc_html__( 'Monochrome', 'solutech' ) => 'pix-icon-default',
                        ),
                        'dependency' => array(
                            'element' => 'icon_type',
                            'value' => array('font')
                        ),
                    ),
				    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Background Color', 'solutech' ),
                        'param_name' => 'icon_bg_color',
                        'value' => array(
                            'default' => 'pix-icon-bg-main-color',
                            esc_html__( 'Main', 'solutech' ) => 'pix-icon-bg-main-color',
                            esc_html__( 'Additional', 'solutech' ) => 'pix-icon-bg-additional-color',
                            esc_html__( 'Gradient', 'solutech' ) => 'pix-icon-bg-gradient-color',
                            esc_html__( 'Black', 'solutech' ) => 'pix-icon-bg-black-color',
                            esc_html__( 'White', 'solutech' ) => 'pix-icon-bg-white-color',
                        ),
                        'dependency' => array(
                            'element' => 'icon_shape',
                            'value' => array('round')
                        ),
                    ),
				    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Title', 'solutech' ),
                        'param_name' => 'title',
                        'description' => esc_html__( 'Enter text used as title of icon.', 'solutech' ),
                        'admin_label' => true,
                    ),
					array(
						'type' => 'vc_link',
						'heading' => esc_html__( 'Link', 'solutech' ),
						'param_name' => 'link',
						'value' => '',
						'description' => esc_html__( 'Button link', 'solutech' )
					),
					array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Link Type', 'solutech' ),
                        'param_name' => 'link_type',
                        'value' => array(
                            'default' => 'overlay',
                            esc_html__( 'Overlay', 'solutech' ) => 'overlay',
                            esc_html__( 'Button', 'solutech' ) => 'button',
                            esc_html__( 'Text Link', 'solutech' ) => 'href',
                        ),
                        'description' => esc_html__( 'If Overlay the whole box is a link. Don\'t use links in content', 'solutech' ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Button/Link Text', 'solutech' ),
						'param_name' => 'btn_link_txt',
                        'dependency' => array(
                            'element' => 'link_type',
                            'value' => array('button', 'href')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
					),
					array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Content Position', 'solutech' ),
                        'param_name' => 'content_position',
                        'value' => array(
                            'default' => 'pix-top',
                            esc_html__( 'Top', 'solutech' ) => 'pix-top',
                            esc_html__( 'Middle', 'solutech' ) => 'pix-middle',
                            esc_html__( 'Bottom', 'solutech' ) => 'pix-bottom',
                        ),
                        'dependency' => array(
                            'element' => 'style',
                            'value' => array('pix-ibox-side')
                        ),
                    ),
					array(
						'type' => 'textarea_html',
						'holder' => 'div',
						'heading' => esc_html__( 'Content', 'solutech' ),
						'param_name' => 'content',
						'value' => '',
						'description' => esc_html__( 'Enter information.', 'solutech' )
					),
                    array(
                        'type' => 'css_editor',
                        'heading' => esc_html__( 'Css', 'solutech' ),
                        'param_name' => 'css',
                        'group' => esc_html__( 'Design options', 'solutech' ),
                    ),
				)
			),
		)
	);




	/// common_amount_box
	vc_map(
		array(
			'name' => esc_html__( 'Amount Box', 'solutech' ),
			'base' => 'common_amount_box',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Solutech', 'solutech'),
			'params' => array_merge(
			    array(
			        array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Icon Type', 'solutech' ),
                        'param_name' => 'icon_type',
                        'value' => array(
                            'default' => 'image',
                            esc_html__( 'Image/SVG', 'solutech' ) => 'image',
                            esc_html__( 'Font', 'solutech' ) => 'font',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
					array(
						'type' => 'attach_image',
						'heading' => esc_html__( 'Image/SVG', 'solutech' ),
						'param_name' => 'image',
						'description' => esc_html__( 'Select image.', 'solutech' ),
                        'dependency' => array(
                            'element' => 'icon_type',
                            'value' => array('image')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
					),
                ),
                pixtheme_get_vc_icons($vc_icons_data, 'icon_type', 'font'),
                array(
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Icon Size', 'solutech' ),
                        'param_name' => 'icon_size',
                        'value' => array(
                            'default' => 'pix-icon-l',
                            esc_html__( 'S', 'solutech' ) => 'pix-icon-s',
                            esc_html__( 'M', 'solutech' ) => 'pix-icon-m',
                            esc_html__( 'L', 'solutech' ) => 'pix-icon-l',
                            esc_html__( 'XL', 'solutech' ) => 'pix-icon-xl',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Icon Position', 'solutech' ),
                        'param_name' => 'position',
                        'value' => array(
                            'default' => 'pix-text-center',
                            esc_html__( 'Left', 'solutech' ) => 'pix-text-left',
                            esc_html__( 'Top', 'solutech' ) => 'pix-text-center',
                            esc_html__( 'Right', 'solutech' ) => 'pix-text-right',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Icon Color', 'solutech' ),
                        'param_name' => 'icon_color',
                        'value' => array(
                            'default' => 'pix-icon-color',
                            esc_html__( 'Color', 'solutech' ) => 'pix-icon-color',
                            esc_html__( 'Monochrome', 'solutech' ) => 'pix-icon-default',
                        ),
                        'dependency' => array(
                            'element' => 'icon_type',
                            'value' => array('font')
                        ),
                    ),
                    array(
                        'type' => 'switch_button',
                        'heading' => esc_html__( 'Fill on Hover', 'solutech' ),
                        'param_name' => 'border',
                        'value' => 'off',
                        'description' => esc_html__( 'Fill the background with the main color on hover', 'solutech' ),
                    ),
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__( 'Title', 'solutech' ),
                        'param_name' => 'title',
                        'value' => '',
                        'description' => esc_html__( 'Title.', 'solutech' )
                    ),
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__( 'Amount', 'solutech' ),
                        'param_name' => 'amount',
                        'value' => '',
                        'description' => esc_html__( 'Amount.', 'solutech' )
                    ),
                    array(
						'type' => 'textarea_html',
						'holder' => 'div',
						'heading' => esc_html__( 'Content', 'solutech' ),
						'param_name' => 'content',
						'value' => '',
						'description' => esc_html__( 'Enter information.', 'solutech' )
					),
                    array(
                        'type' => 'css_editor',
                        'heading' => esc_html__( 'Css', 'solutech' ),
                        'param_name' => 'css',
                        'group' => esc_html__( 'Design options', 'solutech' ),
                    ),
			    ),
                $add_animation
            )
		)
	);

	/// common_mailchimp
	vc_map(
		array(
			'name' => esc_html__( 'Mailchimp Box', 'solutech' ),
			'base' => 'common_mailchimp',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Solutech', 'solutech'),
			'show_settings_on_create' => false,
			'content_element' => true,
			'params' => array(),
		)
	);
	//////////////////////////////////////////////////////////////////////


    /// common_cform7
    vc_map(
        array(
            'name' => esc_html__( 'Contact Form 7', 'solutech' ),
            'base' => 'common_cform7',
            'class' => 'pix-theme-icon-common',
            'category' => esc_html__( 'Solutech', 'solutech'),
            'params' => array(

                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__( 'Contact Form', 'solutech' ),
                    'param_name' => 'form_id',
                    'value' => $cform7,
                    'description' => esc_html__( 'Select contact form to show', 'solutech' )
                ),
                pix_vc_control('radius', 'vc_col-sm-8'),
                pix_vc_control('box_gap', 'vc_col-sm-4'),
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Send Button Position', 'solutech' ),
                    'param_name' => 'btn_position',
                    'value' => array(
                        'default' => 'pix-text-left',
                        esc_html__( 'Left', 'solutech' ) => 'pix-text-left',
                        esc_html__( 'Center', 'solutech' ) => 'pix-text-center',
                        esc_html__( 'Right', 'solutech' ) => 'pix-text-right',
                        esc_html__( 'Full Width', 'solutech' ) => 'pix-text-full-width',
                    ),
                ),
            )
        )
    );
    
    
    /// pix_calculator
    if(pixtheme_get_setting('pix-calculator', 'on') == 'on'){
        $cf7_calculator = array();
        $cf7_calculator = array_merge(array(esc_html__('Without Contact Form', 'solutech') => 0), $cform7);
        vc_map(
            array(
                'name' => esc_html__( 'Calculator', 'solutech' ),
                'base' => 'pix_calculator',
                'class' => 'pix-theme-icon-common',
                'category' => esc_html__( 'Solutech', 'solutech'),
                'params' => array(
                    array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Calculator', 'solutech' ),
						'param_name' => 'calc_id',
						'value' => $calculators,
						'description' => esc_html__( 'Select calculator to show', 'solutech' ),
                        'edit_field_class' => 'vc_col-sm-6',
					),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Contact Form', 'solutech' ),
                        'param_name' => 'form_id',
                        'value' => $cf7_calculator,
                        'description' => esc_html__( 'Select contact form to show', 'solutech' ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__( 'Title', 'solutech' ),
                        'param_name' => 'calc_title',
                        'value' => '',
                        'description' => esc_html__( 'Calculator title', 'solutech' ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Currency', 'solutech' ),
                        'param_name' => 'currency',
                        'value' => '',
                        'std' => '$',
                        'edit_field_class' => 'vc_col-sm-2',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Position', 'solutech' ),
                        'param_name' => 'position',
                        'value' => array(
                            esc_html__( 'Left', 'solutech' ) => 'left',
                            esc_html__( 'Right', 'solutech' ) => 'right',
                        ),
                        'std' => 'left',
                        'edit_field_class' => 'vc_col-sm-2',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Decimals', 'solutech' ),
                        'param_name' => 'decimals',
                        'value' => array(0,1,2,3),
                        'std' => '0',
                        'edit_field_class' => 'vc_col-sm-2',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Tone', 'solutech' ),
                        'param_name' => 'tone',
                        'value' => array(
                            'default' => 'text-default',
                            esc_html__( 'Dark', 'solutech' ) => 'text-default',
                            esc_html__( 'Light', 'solutech' ) => 'text-white',
                        ),
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
                    array(
                        'type' => 'switch_button',
                        'heading' => esc_html__( 'Shadow', 'solutech' ),
                        'param_name' => 'shadow',
                        'value' => 'on',
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
                    array(
                        'type' => 'switch_button',
                        'heading' => esc_html__( 'Show Field Titles', 'solutech' ),
                        'param_name' => 'titles',
                        'value' => 'on',
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Text', 'solutech' ),
                        'param_name' => 'btntext',
                        'value' => esc_html__( 'order service', 'solutech' ),
                        'description' => esc_html__( 'Button text.', 'solutech' ),
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => esc_html__( 'Link', 'solutech' ),
                        'param_name' => 'link',
                        'value' => '',
                        'description' => esc_html__( 'Button link', 'solutech' ),
                        'edit_field_class' => 'vc_col-sm-8',
                        'dependency' => array(
                            'element' => 'form_id',
                            'value' => array('0'),
                        )
                    ),
                )
            )
        );
    }




    /// common_special_offers
    vc_map( array(
        'name' => esc_html__( 'Special Offers', 'solutech' ),
        'base' => 'common_special_offers',
        'class' => 'pix-theme-icon-common',
        'category' => esc_html__( 'Solutech', 'solutech'),
        'params' => array(
            array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Boxes Shape', 'solutech' ),
                'param_name' => 'radius',
                'value' => array(
                    'default' => 'pix-global',
                    esc_html__( 'Global', 'solutech' ) => 'pix-global',
                    esc_html__( 'Square', 'solutech' ) => 'pix-square',
                    esc_html__( 'Rounded', 'solutech' ) => 'pix-rounded',
                    esc_html__( 'Round', 'solutech' ) => 'pix-round',
                ),
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__( 'Offers', 'solutech' ),
                'param_name' => 'offers',
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__( 'Image', 'solutech' ),
                        'param_name' => 'image',
                        'description' => esc_html__( 'Select image.', 'solutech' )
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Title', 'solutech' ),
                        'param_name' => 'title',
                        'description' => '',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Subtitle', 'solutech' ),
                        'param_name' => 'subtitle',
                        'description' => '',
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__( 'Text', 'solutech' ),
                        'param_name' => 'content_d',
                        'value' => wp_kses_post(__( 'I am test text block. Click edit button to change this text.', 'solutech' )),
                        'description' => esc_html__( 'Enter text.', 'solutech' )
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => esc_html__( 'Link', 'solutech' ),
                        'param_name' => 'link',
                    ),
                ),
            ),
        ),


    ) );



    /// common_tab_acc
    $tabs_acc_content = 'Metus quam cras vehicula ante, potenti eget. Vel est integer, vivamus proin torquent, sodales aliquam tincidunt laoreet est, at in sollicitudin laoreet etiam sit suspendisse, ligula ut vestibulum dapibus et neque. Nibh et risus ipsum amet pede, eros arcu non, velit ridiculus elit, mauris cursus et. Vel cursus sagittis sem nullam odio pede.';
    vc_map(
        array(
            'name' => esc_html__( 'Tabs/Accordion', 'solutech' ),
            'base' => 'common_tab_acc',
            'class' => 'pix-theme-icon-common',
            'category' => esc_html__( 'Solutech', 'solutech'),
            'params' => array(
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Toggle Type', 'solutech' ),
                    'param_name' => 'toggle_type',
                    'value' => array(
                        'default' => 'tabs',
                        esc_html__( 'Tabs', 'solutech' ) => 'tabs',
                        esc_html__( 'Accordion', 'solutech' ) => 'accordion',
                    ),
                ),
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'Collapse', 'solutech' ),
                    'param_name' => 'collapse',
                    'value' => 'off',
                    'dependency' => array(
                        'element' => 'toggle_type',
                        'value' => array('accordion')
                    ),
                ),
                array(
                    'type' => 'param_group',
                    'heading' => esc_html__( 'Tabs', 'solutech' ),
                    'param_name' => 'tabs',
                    'description' => esc_html__( 'Enter values for graph - title and value.', 'solutech' ),
                    'value' => urlencode( json_encode( array(
                        array(
                            'label' => esc_html__( 'Concept', 'solutech' ),
                            'content_t' => $tabs_acc_content,
                            'link' => '/',
                            'tab_id' => rand(),
                        ),
                        array(
                            'label' => esc_html__( 'Design', 'solutech' ),
                            'content_t' => $tabs_acc_content,
                            'link' => '/',
                            'tab_id' => rand(),
                        ),
                        array(
                            'label' => esc_html__( 'Deployment', 'solutech' ),
                            'content_t' => $tabs_acc_content,
                            'link' => '/',
                            'tab_id' => rand(),
                        ),
                        array(
                            'label' => esc_html__( 'Support', 'solutech' ),
                            'content_t' => $tabs_acc_content,
                            'link' => '/',
                            'tab_id' => rand(),
                        ),
                    ) ) ),
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Label', 'solutech' ),
                            'param_name' => 'label',
                            'description' => esc_html__( 'Enter text used as title of bar.', 'solutech' ),
                            'admin_label' => true,
                        ),
                        array(
                            'type' => 'textarea',
                            'heading' => esc_html__( 'Content', 'solutech' ),
                            'param_name' => 'content_t',
                            'value' => wp_kses_post(__( 'I am test text block. Click edit button to change this text.', 'solutech' )),
                            'description' => esc_html__( 'Enter text.', 'solutech' )
                        ),
                        array(
                            'type' => 'vc_link',
                            'heading' => esc_html__( 'Link', 'solutech' ),
                            'param_name' => 'link',
                            'value' => '',
                            'description' => esc_html__( 'Button link', 'solutech' )
                        ),
                        array(
                            'type' => 'tab_id_text',
                            'heading' => esc_html__( 'ID', 'solutech' ),
                            'param_name' => 'tab_id',
                        ),

                    ),
                    'dependency' => array(
                        'element' => 'toggle_type',
                        'value' => array('tabs')
                    ),
                ),
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Link Type', 'solutech' ),
                    'param_name' => 'link_type',
                    'value' => array(
                        'default' => 'button',
                        esc_html__( 'Button', 'solutech' ) => 'button',
                        esc_html__( 'Text Link', 'solutech' ) => 'href',
                    ),
                    'dependency' => array(
                        'element' => 'toggle_type',
                        'value' => array('tabs')
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Button/Link Text', 'solutech' ),
                    'param_name' => 'btn_link_txt',
                    'dependency' => array(
                        'element' => 'toggle_type',
                        'value' => array('tabs')
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'param_group',
                    'heading' => esc_html__( 'Accordion', 'solutech' ),
                    'param_name' => 'accordion',
                    'description' => esc_html__( 'Enter values for graph - title and value.', 'solutech' ),
                    'value' => urlencode( json_encode( array(
                        array(
                            'label_a' => esc_html__( 'Mus imperdiet, consectetuer adipiscing?', 'solutech' ),
                            'content_a' => $tabs_acc_content,
                            'tab_id_a' => rand(),
                        ),
                        array(
                            'label_a' => esc_html__( 'Dictum interdum aenean magna vestibulum lectus?', 'solutech' ),
                            'content_a' => $tabs_acc_content,
                            'tab_id_a' => rand(),
                        ),
                        array(
                            'label_a' => esc_html__( 'Urna auctor, turpis eu, curabitur maecenas vitae?', 'solutech' ),
                            'content_a' => $tabs_acc_content,
                            'tab_id_a' => rand(),
                        ),
                        array(
                            'label_a' => esc_html__( 'Vel cursus sagittis sem nullam odio pede?', 'solutech' ),
                            'content_a' => $tabs_acc_content,
                            'tab_id_a' => rand(),
                        ),
                    ) ) ),
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Label', 'solutech' ),
                            'param_name' => 'label_a',
                            'description' => esc_html__( 'Enter text used as title of bar.', 'solutech' ),
                            'admin_label' => true,
                        ),
                        array(
                            'type' => 'textarea',
                            'heading' => esc_html__( 'Content', 'solutech' ),
                            'param_name' => 'content_a',
                            'value' => wp_kses_post(__( 'I am test text block. Click edit button to change this text.', 'solutech' )),
                            'description' => esc_html__( 'Enter text.', 'solutech' )
                        ),
                        array(
                            'type' => 'tab_id_text',
                            'heading' => esc_html__( 'ID', 'solutech' ),
                            'param_name' => 'tab_id_a',
                        ),
                    ),
                    'dependency' => array(
                        'element' => 'toggle_type',
                        'value' => array('accordion')
                    ),
                ),
            ),
        )
    );
    
    
    
    /// common_tabs_content
    vc_map(
        array(
            'name' => esc_html__( 'Tabs Content', 'solutech' ),
            'base' => 'common_tabs_content',
            'class' => 'wpb_vc_tta_tabs pix-theme-icon-common',
			'as_parent' => array('only' => 'common_tab_content'),
			'content_element' => true,
			'show_settings_on_create' => false,
			'is_container' => true,
			'category' => esc_html__( 'Solutech', 'solutech' ),
			'params' => array(),
            'admin_enqueue_js' => get_template_directory_uri().'/vc_templates/js/custom-vc-admin.js',
		    'js_view' => 'VcPixContainerView',
        )
    );
    
    /// common_tab_content
    vc_map(
        array(
            'name' => esc_html__( 'Tab Content', 'solutech' ),
            'base' => 'common_tab_content',
            'class' => 'pix-theme-icon-common',
			'as_child' => array('only' => 'common_tabs_content'),
			'content_element' => true,
			'show_settings_on_create' => true,
			'is_container' => true,
			'category' => esc_html__( 'Solutech', 'solutech' ),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Label', 'solutech' ),
                    'param_name' => 'label',
                    'description' => esc_html__( 'Enter text used as title of bar.', 'solutech' ),
                    'admin_label' => true,
                ),
                array(
                    'type' => 'tab_id_text',
                    'heading' => esc_html__( 'ID', 'solutech' ),
                    'param_name' => 'tab_id',
                ),
            ),
            'js_view' => 'VcColumnView',
        )
    );



    /// common_progress
    vc_map(
        array(
            'name' => esc_html__( 'Progress Bar', 'solutech' ),
            'base' => 'common_progress',
            'class' => 'pix-theme-icon-common',
            'category' => esc_html__( 'Solutech', 'solutech'),
            'params' => array(
                array(
                    'type' => 'param_group',
                    'heading' => esc_html__( 'Values', 'solutech' ),
                    'param_name' => 'values',
                    'description' => esc_html__( 'Enter values for graph - title and value.', 'solutech' ),
                    'value' => urlencode( json_encode( array(
                        array(
                            'label' => esc_html__( 'Hosting providers', 'solutech' ),
                            'value' => '70',
                        ),
                        array(
                            'label' => esc_html__( 'Security companies', 'solutech' ),
                            'value' => '50',
                        ),
                        array(
                            'label' => esc_html__( 'Private companies and clients', 'solutech' ),
                            'value' => '60',
                        ),
                        array(
                            'label' => esc_html__( 'Software development companies', 'solutech' ),
                            'value' => '90',
                        ),
                    ) ) ),
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Label', 'solutech' ),
                            'param_name' => 'label',
                            'description' => esc_html__( 'Enter text used as title of bar.', 'solutech' ),
                            'admin_label' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Value', 'solutech' ),
                            'param_name' => 'value',
                            'description' => esc_html__( 'Enter value of bar.', 'solutech' ),
                            'admin_label' => true,
                        ),
                    ),
                ),
            ),
        )
    );



	/// common_posts_block
	vc_map(
		array(
			'name' => esc_html__( 'Posts Block', 'solutech' ),
			'base' => 'common_posts_block',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Solutech', 'solutech'),
			'params' => array(
			    array(
                    'type' => 'radio_images',
                    'heading' => esc_html__( 'Style', 'solutech' ),
                    'param_name' => 'style',
                    'value' => array(
                        'posts_block-news.png' => 'pix-news-slider',
                        'posts_block-long.png' => 'news-card-long',
                        'posts_block-centered.png' => 'news-card-centered',
                        'posts_block-gradient.png' => 'news-card-gradient',
                        'posts_block-high.png' => 'pix-news-high',
                    ),
                    'col' => 3,
                    'description' => '',
                ),
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Boxes Shape', 'solutech' ),
                    'param_name' => 'radius',
                    'value' => array(
                        'default' => 'pix-global-shape',
                        esc_html__( 'Global', 'solutech' ) => 'pix-global-shape',
                        esc_html__( 'Square', 'solutech' ) => 'pix-square',
                        esc_html__( 'Rounded', 'solutech' ) => 'pix-rounded',
                        esc_html__( 'Round', 'solutech' ) => 'pix-round',
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'Greyscale Images', 'solutech' ),
                    'param_name' => 'greyscale',
                    'value' => 'off',
                    'description' => esc_html__( 'Show greyscale image with colored hover', 'solutech' ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Categories', 'solutech' ),
					'param_name' => 'cats',
					'value' => $cats_post,
					'description' => esc_html__( 'Select categories to show. If empty, display last posts.', 'solutech' )
				),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Items Count', 'solutech' ),
                    'param_name' => 'count',
                    'description' => esc_html__( 'Select number posts to show. Default 3.', 'solutech' ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__( 'Hover Icon', 'solutech' ),
                    'param_name' => 'hover_icon',
                    'value' => array(
                        esc_html__( 'No', 'solutech' ) => '',
                        esc_html__( 'Plus', 'solutech' ) => 'plus',
                        esc_html__( 'Eye', 'solutech' ) => 'eye',
                        esc_html__( 'Search', 'solutech' ) => 'search',
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Image Proportions', 'solutech' ),
                    'param_name' => 'img_proportions',
                    'value' => array(
                        'default' => 'pixtheme-square',
                        esc_html__( 'Original', 'solutech' ) => 'pixtheme-original',
                        esc_html__( 'Landscape', 'solutech' ) => 'pixtheme-landscape',
                        esc_html__( 'Portrait', 'solutech' ) => 'pixtheme-portrait',
                        esc_html__( 'Square', 'solutech' ) => 'pixtheme-square',
                    ),
                ),
                array(
                    'type' => 'css_editor',
                    'heading' => esc_html__( 'Css', 'solutech' ),
                    'param_name' => 'css',
                    'group' => esc_html__( 'Design options', 'solutech' ),
                ),

			)
		)
	);


	/// common_team
    vc_map( array(
        'name' => esc_html__( 'Team', 'solutech' ),
        'base' => 'common_team',
        'class' => 'pix-theme-icon-common',
        'category' => esc_html__( 'Solutech', 'solutech'),
        'params' => array(
            array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Boxes Shape', 'solutech' ),
                'param_name' => 'radius',
                'value' => array(
                    'default' => 'pix-global-shape',
                    esc_html__( 'Global', 'solutech' ) => 'pix-global-shape',
                    esc_html__( 'Square', 'solutech' ) => 'pix-square',
                    esc_html__( 'Rounded', 'solutech' ) => 'pix-rounded',
                    esc_html__( 'Round', 'solutech' ) => 'pix-round',
                ),
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__( 'Members', 'solutech' ),
                'param_name' => 'members',
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__( 'Image', 'solutech' ),
                        'param_name' => 'image',
                        'description' => esc_html__( 'Select image.', 'solutech' )
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Name', 'solutech' ),
                        'param_name' => 'name',
                        'description' => '',
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Position', 'solutech' ),
                        'param_name' => 'position',
                        'description' => '',
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Skype', 'solutech' ),
                        'param_name' => 'skype',
                        'edit_field_class' => 'vc_col-sm-3',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Facebook', 'solutech' ),
                        'param_name' => 'facebook',
                        'edit_field_class' => 'vc_col-sm-3',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Twitter', 'solutech' ),
                        'param_name' => 'twitter',
                        'edit_field_class' => 'vc_col-sm-3',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Instagram', 'solutech' ),
                        'param_name' => 'instagram',
                        'edit_field_class' => 'vc_col-sm-3',
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => esc_html__( 'Link', 'solutech' ),
                        'param_name' => 'link',
                        'description' => esc_html__( 'to profile page', 'solutech' )
                    ),
                ),
            ),
        ),


    ) );


    /// common_reviews
    vc_map( array(
        'name' => esc_html__( 'Reviews', 'solutech' ),
        'base' => 'common_reviews',
        'class' => 'pix-theme-icon-common',
        'category' => esc_html__( 'Solutech', 'solutech'),
        'params' => array(
            array(
                'type' => 'radio_images',
                'heading' => esc_html__( 'Style', 'solutech' ),
                'param_name' => 'style',
                'value' => array(
                    'reviews_testimonials.png' => 'pix-testimonials',
                    'reviews_people.png' => 'news-card-people',
                    'reviews_feedback.png' => 'news-card-feedback',
                    'reviews_message.png' => 'news-card-message',
                    'reviews_profile.png' => 'news-card-profile',
                    'reviews_people_2.png' => 'pix-testimonials-people',
                ),
                'col' => 3,
                'description' => '',
            ),
            array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Boxes Shape', 'solutech' ),
                'param_name' => 'radius',
                'value' => array(
                    'default' => 'pix-global-shape',
                    esc_html__( 'Global', 'solutech' ) => 'pix-global-shape',
                    esc_html__( 'Square', 'solutech' ) => 'pix-square',
                    esc_html__( 'Rounded', 'solutech' ) => 'pix-rounded',
                    esc_html__( 'Round', 'solutech' ) => 'pix-round',
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Hover Color', 'solutech' ),
                'param_name' => 'color',
                'value' => array(
                    'default' => 'pix-main-color',
                    esc_html__( 'Main', 'solutech' ) => 'pix-main-color',
                    esc_html__( 'Additional', 'solutech' ) => 'pix-additional-color',
                    esc_html__( 'Gradient', 'solutech' ) => 'pix-gradient-color',
                    esc_html__( 'Black', 'solutech' ) => 'pix-black-color',
                ),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('news-card-people', 'news-card-profile'),
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Hover Effect', 'solutech' ),
                'param_name' => 'hover',
                'value' => array(
                    'default' => 'pix-change-color',
                    esc_html__( 'Change Color', 'solutech' ) => 'pix-change-color',
                    esc_html__( 'Transform', 'solutech' ) => 'pix-transform',
                ),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('pix-testimonials'),
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__( 'Reviews', 'solutech' ),
                'param_name' => 'reviews',
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__( 'Image', 'solutech' ),
                        'param_name' => 'image',
                        'description' => esc_html__( 'Select image.', 'solutech' )
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Name', 'solutech' ),
                        'param_name' => 'name',
                        'description' => '',
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Position', 'solutech' ),
                        'param_name' => 'position',
                        'description' => '',
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Facebook', 'solutech' ),
                        'param_name' => 'facebook',
                        'description' => esc_html__( 'Profile link', 'solutech' ),
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Twitter', 'solutech' ),
                        'param_name' => 'twitter',
                        'description' => esc_html__( 'Profile link', 'solutech' ),
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Instagram', 'solutech' ),
                        'param_name' => 'instagram',
                        'description' => esc_html__( 'Profile link', 'solutech' ),
                        'edit_field_class' => 'vc_col-sm-4',
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__( 'Review Text', 'solutech' ),
                        'param_name' => 'content_d',
                        'value' => wp_kses_post(__( 'I am test text block. Click edit button to change this text.', 'solutech' )),
                        'description' => esc_html__( 'Enter text.', 'solutech' )
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => esc_html__( 'Link', 'solutech' ),
                        'param_name' => 'link',
                        'description' => esc_html__( 'Author link', 'solutech' )
                    ),
                ),
            ),
        ),
    
    
    ) );

    
    
    /// common_video
    vc_map(
		array(
			'name' => esc_html__( 'Video', 'solutech' ),
			'base' => 'common_video',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Solutech', 'solutech' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'YouTube or Vimeo Link', 'solutech' ),
					'param_name' => 'url',
					'value' => 'https://www.youtube.com/watch?v=tpBI7RhVHNI',
				),
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Display Type', 'solutech' ),
                    'param_name' => 'display',
                    'value' => array(
                        'default' => 'popup',
                        esc_html__( 'Popup Window', 'solutech' ) => 'popup',
                        esc_html__( 'Embedded Video', 'solutech' ) => 'embed',
                        esc_html__( 'Button with Popup', 'solutech' ) => 'button',
                    ),
                ),
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Alignment', 'solutech' ),
                    'param_name' => 'position',
                    'value' => array(
                        'default' => 'pix-text-left',
                        esc_html__( 'Left', 'solutech' ) => 'pix-text-left',
                        esc_html__( 'Center', 'solutech' ) => 'pix-text-center',
                        esc_html__( 'Right', 'solutech' ) => 'pix-text-right',
                    ),
                    'dependency' => array(
                        'element' => 'display',
                        'value' => array('button'),
                    ),
                ),
				array(
                    'type' => 'attach_image',
                    'heading' => esc_html__( 'Image', 'solutech' ),
                    'param_name' => 'image',
                    'description' => esc_html__( 'Select image.', 'solutech' ),
                    'dependency' => array(
                        'element' => 'display',
                        'value' => array('popup', 'embed'),
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
				array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Boxes Shape', 'solutech' ),
                    'param_name' => 'radius',
                    'value' => array(
                        'default' => 'pix-global-shape',
                        esc_html__( 'Global', 'solutech' ) => 'pix-global-shape',
                        esc_html__( 'Square', 'solutech' ) => 'pix-square',
                        esc_html__( 'Rounded', 'solutech' ) => 'pix-rounded',
                        esc_html__( 'Round', 'solutech' ) => 'pix-round',
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'heading' => esc_html__( 'Height', 'solutech' ),
					'param_name' => 'height',
                    'description' => esc_html__( 'Default 500px', 'solutech' ),
                    'dependency' => array(
                        'element' => 'display',
                        'value' => array('popup', 'embed'),
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
				),
				array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__( 'Overlay Color', 'solutech' ),
                    'param_name' => 'color',
                    'value' => '#000',
                    'dependency' => array(
                        'element' => 'display',
                        'value' => array('popup', 'embed'),
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Title', 'solutech' ),
                    'param_name' => 'title',
                    'dependency' => array(
                        'element' => 'display',
                        'value' => array('popup', 'embed'),
                    ),
                ),
				array(
					'type' => 'textarea_html',
					'holder' => 'div',
					'heading' => esc_html__( 'Content', 'solutech' ),
					'param_name' => 'content',
                    'value' => '',
                    'dependency' => array(
                        'element' => 'display',
                        'value' => array('popup', 'embed'),
                    ),
				),
			)
		)
	);


    

    /// common_google_map
    vc_map(
        array(
            'name' => esc_html__( 'Google Map', 'solutech' ),
            'base' => 'common_google_map',
            'class' => 'pix-theme-icon-common',
            'category' => esc_html__( 'Solutech', 'solutech'),
            'params' => array(
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__( 'Map Type', 'solutech' ),
                    'param_name' => 'map_type',
                    'value' => array(
                        'default' => 'google',
                        esc_html__( 'Google Map', 'solutech' ) => 'google',
                        esc_html__( 'Image with Link', 'solutech' ) => 'img',
                    ),
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => esc_html__( 'Map Image', 'solutech' ),
                    'param_name' => 'map_image',
                    'value' => '',
                    'description' => esc_html__( 'Select image from media library.', 'solutech' ),
                    'dependency' => array(
                        'element' => 'map_type',
                        'value' => 'img',
                    )
                ),array(
                    'type' => 'vc_link',
                    'heading' => esc_html__( 'Link', 'solutech' ),
                    'param_name' => 'map_link',
                    'value' => '',
                    'dependency' => array(
                        'element' => 'map_type',
                        'value' => 'img',
                    )
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => esc_html__( 'Marker Image', 'solutech' ),
                    'param_name' => 'image',
                    'value' => '',
                    'description' => esc_html__( 'Select image from media library.', 'solutech' ),
                    'dependency' => array(
                        'element' => 'map_type',
                        'value' => 'google',
                    )
                ),
                array(
                    'type' => 'param_group',
                    'heading' => esc_html__( 'Locations', 'solutech' ),
                    'param_name' => 'locations',
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'holder' => 'div',
                            'heading' => esc_html__( 'LatLng', 'solutech' ),
                            'param_name' => 'latlng',
                            'value' => '40.6700,-73.9400',
                            'description' => esc_html__( 'Latitude, Longtitude (Example: 40.6700,-73.9400)', 'solutech' )
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Description', 'solutech' ),
                            'param_name' => 'description',
                            'value' => '',
                            'description' => '',
                        ),
                    ),
                    'dependency' => array(
                        'element' => 'map_type',
                        'value' => 'google',
                    )
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'heading' => esc_html__( 'Map Width', 'solutech' ),
                    'param_name' => 'width',
                    'value' => '',
                    'description' => esc_html__( 'Default 100%', 'solutech' ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'heading' => esc_html__( 'Map Height', 'solutech' ),
                    'param_name' => 'height',
                    'value' => '',
                    'description' => esc_html__( 'Default 500px', 'solutech' ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'heading' => esc_html__( 'Zoom', 'solutech' ),
                    'param_name' => 'zoom',
                    'value' => '',
                    'description' => esc_html__( 'Zoom 0-20. Default 9.', 'solutech' ),
                    'edit_field_class' => 'vc_col-sm-6',
                    'dependency' => array(
                        'element' => 'map_type',
                        'value' => 'google',
                    )
                ),
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'Scroll Wheel', 'solutech' ),
                    'param_name' => 'scrollwheel',
                    'value' => 'off',
                    'description' => esc_html__( 'Zoom map with scroll', 'solutech' ),
                    'edit_field_class' => 'vc_col-sm-6',
                    'dependency' => array(
                        'element' => 'map_type',
                        'value' => 'google',
                    )
                ),
            )
        )
    );






    /// common_points
	vc_map( array(
		'name' => esc_html__( 'Image Points', 'solutech' ),
		'base' => 'common_points',
		'class' => 'pix-theme-icon-common',
		'category' => esc_html__( 'Solutech', 'solutech'),
		'params' => array(
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'solutech' ),
				'param_name' => 'image',
				'description' => esc_html__( 'Select image.', 'solutech' ),
			),
			array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Boxes Shape', 'solutech' ),
                'param_name' => 'radius',
                'value' => array(
                    'default' => 'pix-global',
                    esc_html__( 'Global', 'solutech' ) => 'pix-global',
                    esc_html__( 'Square', 'solutech' ) => 'pix-square',
                    esc_html__( 'Rounded', 'solutech' ) => 'pix-rounded',
                    esc_html__( 'Round', 'solutech' ) => 'pix-round',
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
			array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Point Unit', 'solutech' ),
                'param_name' => 'unit',
                'value' => array(
                    'default' => '%',
                    esc_html__( 'Percent', 'solutech' ) => '%',
                    esc_html__( 'Pixels', 'solutech' ) => 'px',

                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__( 'Points', 'solutech' ),
                'param_name' => 'points',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Top Position', 'solutech' ),
                        'param_name' => 'top_pos',
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Left Position', 'solutech' ),
                        'param_name' => 'left_pos',
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__( 'Popup Text', 'solutech' ),
                        'param_name' => 'content_d',
                        'value' => wp_kses_post(__( 'I am test text block. Click edit button to change this text.', 'solutech' )),
                    ),
                )
            ),
		),

	) );


    vc_map(
		array(
			'name' => esc_html__( 'Slider', 'solutech' ),
			'base' => 'common_slider',
			'class' => 'wpb_vc_tta_tabs pix-theme-icon-common',
			'as_parent' => array('only' => 'common_icon_box'),
			'content_element' => true,
			'show_settings_on_create' => true,
			'is_container' => true,
			'category' => esc_html__( 'Solutech', 'solutech' ),
			'params' => array(),
            'admin_enqueue_js' => get_template_directory_uri().'/vc_templates/js/custom-vc-admin.js',
		    'js_view' => 'VcPixContainerView',
		)
	);
    
    vc_map(
		array(
			'name' => esc_html__( 'Wrapper', 'solutech' ),
			'base' => 'common_wrapper',
			'class' => 'wpb_vc_tta_tabs pix-theme-icon-common',
			'as_parent' => array('only' => 'vc_icon'),
			'content_element' => true,
			'show_settings_on_create' => false,
			'is_container' => false,
			'category' => esc_html__( 'Solutech', 'solutech' ),
			'params' => array(),
            'admin_enqueue_js' => get_template_directory_uri().'/vc_templates/js/custom-vc-admin.js',
		    'js_view' => 'VcPixContainerView',
		)
	);
    

if(1==2) {
    vc_map(array(
        'name' => esc_html__('Grid', 'solutech'),
        'base' => 'common_section_grid',
        'class' => 'pix-theme-icon-common',
        'category' => esc_html__('Solutech', 'solutech'),
        'params' => array_merge(
            array(
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__('Posts Type', 'solutech'),
                    'param_name' => 'post_type',
                    'value' => $post_types,
                    'description' => esc_html__('Select posts type to show', 'solutech')
                ),
            ),
            $post_types_control,
            array(
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__('Greyscale Images', 'solutech'),
                    'param_name' => 'greyscale',
                    'value' => 'off',
                    'description' => esc_html__('Show greyscale image with colored hover', 'solutech'),
                ),
                array(
                    'type' => 'param_group',
                    'heading' => esc_html__('Rows', 'solutech'),
                    'param_name' => 'rows',
                    'params' => array(
                        array(
                            'type' => 'radio_images',
                            'heading' => esc_html__('Style', 'solutech'),
                            'param_name' => 'style',
                            'value' => array(
                                'reviews_people.png' => 'grid-fives',
                                'reviews_feedback.png' => 'grid-three',
                                'reviews_message.png' => 'grid-four',
                                'reviews_profile.png' => 'grid-eight',
                            ),
                            'description' => '',
                        ),
                        array(
                            'type' => 'segmented_button',
                            'heading' => esc_html__('Large Image Position', 'solutech'),
                            'param_name' => 'position',
                            'value' => array(
                                'default' => 'right',
                                esc_html__('Left', 'solutech') => 'left',
                                esc_html__('Center', 'solutech') => 'center',
                                esc_html__('Right', 'solutech') => 'right',
                            ),
                            'dependency' => array(
                                'element' => 'style',
                                'value' => array('grid-fives'),
                            )
                        ),
                    )
                ),
                
                array(
                    'type' => 'segmented_button',
                    'heading' => esc_html__('Order', 'solutech'),
                    'param_name' => 'order',
                    'value' => array(
                        'default' => 'default',
                        esc_html__('First posts', 'solutech') => 'default',
                        esc_html__('Custom IDs', 'solutech') => 'ids',
                    ),
                    'description' => esc_html__('Select first posts or custom', 'solutech')
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Custom IDs', 'solutech'),
                    'param_name' => 'items',
                    'description' => esc_html__('Input items IDs. First id is large image. (example: 307,304,302,301,300)', 'solutech'),
                    'dependency' => array(
                        'element' => 'order',
                        'value' => array('ids'),
                    )
                ),
            )
        )
    
    ));
}

	//////////////////////////////////////////////////////////////////////


    /// common_isotope
	vc_map(
		array(
			'name' => esc_html__( 'Isotope', 'solutech' ),
			'base' => 'common_isotope',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Solutech', 'solutech' ),
			'params' => array_merge(
                array(
                    array(
                        'type' => 'radio_images',
                        'heading' => esc_html__( 'Box Style', 'solutech' ),
                        'param_name' => 'style',
                        'value' => array(
                            'isotop_hover-info.png;Hover Info' => 'hover-info',
                            'isotop_bottom-info.png;Bottom Info' => 'bottom-info',
                            'isotop_bottom-desc.png;Bottom Description' => 'bottom-desc',
                        ),
                        'col' => 3,
                        'description' => '',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Filter Alignment', 'solutech' ),
                        'param_name' => 'filter',
                        'value' => array(
                            'default' => 'pix-text-right',
                            esc_html__('Left', 'solutech') => 'pix-text-left',
                            esc_html__('Center', 'solutech') => 'pix-text-center',
                            esc_html__('Right', 'solutech') => 'pix-text-right',
                            esc_html__('Hide', 'solutech') => 'pix-hide',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Filter Style', 'solutech' ),
                        'param_name' => 'filter_style',
                        'value' => array(
                            'default' => 'top-filter',
                            esc_html__('Top', 'solutech') => 'top-filter',
                            esc_html__('Sidebar', 'solutech') => 'sidebar-filter',
                            esc_html__('Sidebar Out', 'solutech') => 'sidebar-out-filter',
                        ),
                        'description' => '',
                        'dependency' => array(
                            'element' => 'filter',
                            'value'   => array('pix-text-left', 'pix-text-center', 'pix-text-right')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'All Text', 'solutech' ),
                        'param_name' => 'filter_all',
                        'value' => esc_html__( 'All', 'solutech'),
                        'description' => esc_html__( 'Replace All with your text', 'solutech'),
                        'dependency' => array(
                            'element' => 'filter',
                            'value'   => array('pix-text-left', 'pix-text-center', 'pix-text-right')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Filter Title', 'solutech' ),
                        'param_name' => 'filter_title',
                        'description' => '',
                        'dependency' => array(
                            'element' => 'filter_style',
                            'value'   => array('sidebar-filter', 'sidebar-out-filter')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Posts Type', 'solutech' ),
                        'param_name' => 'post_type',
                        'value' => $post_types,
                        'description' => esc_html__( 'Select posts type to show', 'solutech' ),
                        //'edit_field_class' => 'vc_col-sm-6',
                    ),
                    
                ),
                $post_types_control,
                array(
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Columns', 'solutech' ),
                        'param_name' => 'col',
                        'value' => array(
                            'default' => 4,
                            esc_html__( '2', 'solutech' ) => 2,
                            esc_html__( '3', 'solutech' ) => 3,
                            esc_html__( '4', 'solutech' ) => 4,
                            esc_html__( '5', 'solutech' ) => 5,
                            esc_html__( '6', 'solutech' ) => 6,
                            esc_html__( '8', 'solutech' ) => 8,
                        ),
                        'description' => esc_html__( 'Select items number per row', 'solutech' ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Items Count', 'solutech' ),
                        'param_name' => 'count',
                        'description' => esc_html__( 'Items number to show. Leave empty to show all items.', 'solutech' ),
                        'edit_field_class' => 'vc_col-sm-3',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Boxes Gap', 'solutech' ),
                        'param_name' => 'box_gap',
                        'value' => array(0,1,2,5,10,15,20,30,50),
                        'edit_field_class' => 'vc_col-sm-3',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Boxes Shape', 'solutech' ),
                        'param_name' => 'radius',
                        'value' => array(
                            'default' => 'pix-global',
                            esc_html__( 'Global', 'solutech' ) => 'pix-global',
                            esc_html__( 'Square', 'solutech' ) => 'pix-square',
                            esc_html__( 'Rounded', 'solutech' ) => 'pix-rounded',
                            esc_html__( 'Round', 'solutech' ) => 'pix-round',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'switch_button',
                        'heading' => esc_html__( 'Greyscale Images', 'solutech' ),
                        'param_name' => 'greyscale',
                        'value' => 'off',
                        'description' => esc_html__( 'Show greyscale picture with colored hover.', 'solutech' ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Image Proportions', 'solutech' ),
                        'param_name' => 'img_proportions',
                        'value' => array(
                            'default' => 'pixtheme-square',
                            esc_html__( 'Original', 'solutech' ) => 'pixtheme-original',
                            esc_html__( 'Landscape', 'solutech' ) => 'pixtheme-landscape',
                            esc_html__( 'Portrait', 'solutech' ) => 'pixtheme-portrait',
                            esc_html__( 'Square', 'solutech' ) => 'pixtheme-square',
                        ),
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => esc_html__( 'Css', 'solutech' ),
                        'param_name' => 'css',
                        'group' => esc_html__( 'Design options', 'solutech' ),
                    ),
                )
            )
		)
	);
 

 


	vc_map(
		array(
			'name' => esc_html__( 'Carousel', 'solutech' ),
			'base' => 'common_carousel',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Solutech', 'solutech' ),
			'params' => array_merge(
                array(
                    array(
                        'type' => 'radio_images',
                        'heading' => esc_html__( 'Box Style', 'solutech' ),
                        'param_name' => 'style',
                        'value' => array(
                            'isotop_hover-info.png;Hover Info' => 'hover-info',
                            'isotop_bottom-info.png;Bottom Info' => 'bottom-info',
                            'isotop_bottom-info.png;Bottom Boxed' => 'bottom-info boxed',
                            'isotop_bottom-desc.png;Bottom Description' => 'bottom-desc',
                        ),
                        'col' => 4,
                        'description' => '',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Posts Type', 'solutech' ),
                        'param_name' => 'post_type',
                        'value' => $post_types,
                        'description' => esc_html__( 'Select posts type to show', 'solutech' )
                    ),
                ),
                $post_types_control,
                array(
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Navigation', 'solutech' ),
                        'param_name' => 'navigation',
                        'value' => array(
							esc_html__( 'Navigation Arrows', 'solutech' ) => 'nav',
                            esc_html__( 'Pagination Dots', 'solutech' ) => 'dots',
                            esc_html__( 'Hide', 'solutech' ) => 'no',
						),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'textfield',
                        'holder' => 'div',
                        'heading' => esc_html__( 'Title', 'solutech' ),
                        'param_name' => 'title',
                        'value' => '',
                        'dependency' => array(
                            'element' => 'navigation',
                            'value'   => array('nav')
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Columns', 'solutech' ),
                        'param_name' => 'col',
                        'value' => array(
                            'default' => 3,
                            esc_html__( '1', 'solutech' ) => 1,
                            esc_html__( '2', 'solutech' ) => 2,
                            esc_html__( '3', 'solutech' ) => 3,
                            esc_html__( '4', 'solutech' ) => 4,
                            esc_html__( '5', 'solutech' ) => 5,
                            esc_html__( '6', 'solutech' ) => 6,
                            esc_html__( '7', 'solutech' ) => 7,
                            esc_html__( '8', 'solutech' ) => 8,
                        ),
                        'description' => esc_html__( 'Select items number per screen', 'solutech' ),
                        'edit_field_class' => 'vc_col-sm-7',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Gap', 'solutech' ),
                        'param_name' => 'box_gap',
                        'value' => array(0,1,2,5,10,15,20,30,50),
                        'edit_field_class' => 'vc_col-sm-2',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Items Count', 'solutech' ),
                        'param_name' => 'count',
                        'description' => esc_html__( 'Items number to show. Leave empty to show all items.', 'solutech' ),
                        'edit_field_class' => 'vc_col-sm-3',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Boxes Shape', 'solutech' ),
                        'param_name' => 'radius',
                        'value' => array(
                            'default' => 'pix-global',
                            esc_html__( 'Global', 'solutech' ) => 'pix-global',
                            esc_html__( 'Square', 'solutech' ) => 'pix-square',
                            esc_html__( 'Rounded', 'solutech' ) => 'pix-rounded',
                            esc_html__( 'Round', 'solutech' ) => 'pix-round',
                        ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'switch_button',
                        'heading' => esc_html__( 'Greyscale Images', 'solutech' ),
                        'param_name' => 'greyscale',
                        'value' => 'off',
                        'description' => esc_html__( 'Show greyscale picture with colored hover', 'solutech' ),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Hover Icon', 'solutech' ),
                        'param_name' => 'hover_icon',
                        'value' => array(
							esc_html__( 'No', 'solutech' ) => '',
                            esc_html__( 'Plus', 'solutech' ) => 'plus',
                            esc_html__( 'Eye', 'solutech' ) => 'eye',
                            esc_html__( 'Search', 'solutech' ) => 'search',
						),
                        'edit_field_class' => 'vc_col-sm-6',
                    ),
                    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Image Proportions', 'solutech' ),
                        'param_name' => 'img_proportions',
                        'value' => array(
                            'default' => 'pixtheme-square',
                            esc_html__( 'Original', 'solutech' ) => 'pixtheme-original',
                            esc_html__( 'Landscape', 'solutech' ) => 'pixtheme-landscape',
                            esc_html__( 'Portrait', 'solutech' ) => 'pixtheme-portrait',
                            esc_html__( 'Square', 'solutech' ) => 'pixtheme-square',
                        ),
                    ),
                )
            )
		)
	);



	if ( class_exists( 'booked_plugin' ) ) {
		/// common_appointment
		vc_map(
			array(
				'name' => esc_html__( 'Book An Appointment', 'solutech' ),
				'base' => 'common_appointment',
				'class' => 'pix-theme-icon-common',
				'category' => esc_html__( 'Solutech', 'solutech'),
				'params' => array(
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Calendar Type', 'solutech' ),
						'param_name' => 'calendar_type',
						'value' => array(
							esc_html__( 'With Departments Select', 'solutech' ) => 'switcher',
							esc_html__( 'Single', 'solutech' ) => 'single',
						),
						'description' => esc_html__( 'Select appointment calendar to show', 'solutech' )
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Calendar', 'solutech' ),
						'param_name' => 'calendar_id',
						'value' => $calendars,
						'description' => esc_html__( 'Select appointment calendar to show', 'solutech' ),
						'dependency' => array(
							'element' => 'calendar_type',
							'value' => 'single',
						),
					),
				)
			)
		);
	}


	
	/// common_brands
	vc_map(
		array(
			'name' => esc_html__( 'Brands', 'solutech' ),
			'base' => 'common_brands',
			'class' => 'pix-theme-icon-common',
			'category' => esc_html__( 'Solutech', 'solutech'),
			'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Brands per page', 'solutech' ),
                    'param_name' => 'brands_per_page',
                    'description' => esc_html__( 'Select number of columns. Default 5.', 'solutech' ),
                ),
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'Popup Images', 'solutech' ),
                    'param_name' => 'popup',
                    'value' => 'off',
                    'description' => esc_html__( 'Show popup with large image on click. The link doesn\'t work', 'solutech' ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'switch_button',
                    'heading' => esc_html__( 'Greyscale Images', 'solutech' ),
                    'param_name' => 'greyscale',
                    'value' => 'off',
                    'description' => esc_html__( 'Show greyscale image with colored hover', 'solutech' ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    'type' => 'param_group',
                    'heading' => esc_html__( 'Brands', 'solutech' ),
                    'param_name' => 'brands',
                    'params' => array(
                        array(
                            'type' => 'attach_image',
                            'heading' => esc_html__( 'Image', 'solutech' ),
                            'param_name' => 'image',
                            'value' => '',
                            'description' => esc_html__( 'Select image from media library.', 'solutech' )
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Brand Title', 'solutech' ),
                            'param_name' => 'title',
                            'value' => '',
                        ),
                        array(
                            'type' => 'vc_link',
                            'heading' => esc_html__( 'Link', 'solutech' ),
                            'param_name' => 'link',
                            'value' => '#',
                        ),
                    )
                ),
            ),
		)

	);
	////////////////////////



	/// common_section_pricetable
	//////// Price Table ////////
	vc_map( array(
		'name' => esc_html__( 'Price Table', 'solutech' ),
		'base' => 'common_price_table',
		'class' => 'pix-theme-icon-common',
		'category' => esc_html__( 'Solutech', 'solutech'),
		'params' => array(
            array(
                'type' => 'radio_images',
                'heading' => esc_html__( 'Style', 'solutech' ),
                'param_name' => 'style',
                'value' => array(
                    'price_table_default.png' => 'pix-price-box',
                    'price_table_compare.png' => 'pix-price-table',
                    'price_table_long.png' => 'pix-price-long',
                ),
                'col' => 3,
                'description' => '',
            ),
            array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Boxes Type', 'solutech' ),
                'param_name' => 'type_table',
                'value' => array(
                    'default' => 'single',
                    esc_html__( 'Single', 'solutech' ) => 'single',
                    esc_html__( 'Double', 'solutech' ) => 'double',
                ),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('pix-price-box', 'pix-price-long'),
                ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'First Selector', 'solutech' ),
                'param_name' => 'first_text',
                'value' => 'Monthly',
                'description' => esc_html__( 'First tab button text', 'solutech' ),
                'dependency' => array(
                    'element' => 'type_table',
                    'value' => array('double'),
                ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Second Selector', 'solutech' ),
                'param_name' => 'second_text',
                'value' => 'Yearly',
                'description' => esc_html__( 'Second tab button text', 'solutech' ),
                'dependency' => array(
                    'element' => 'type_table',
                    'value' => array('double'),
                ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Boxes Shape', 'solutech' ),
                'param_name' => 'gap',
                'value' => array(
                    'default' => 'pix-global',
                    esc_html__( 'Global', 'solutech' ) => 'pix-global',
                    esc_html__( 'Square', 'solutech' ) => 'pix-square',
                    esc_html__( 'Rounded', 'solutech' ) => 'pix-rounded',
                    esc_html__( 'Round', 'solutech' ) => 'pix-round',
                ),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('pix-price-box', 'pix-price-long')
                ),
            ),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Currency', 'solutech' ),
				'param_name' => 'currency',
				'value' => '$',
				'description' => esc_html__( 'Change currency', 'solutech' ),
                'edit_field_class' => 'vc_col-sm-4',
			),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Button Text', 'solutech' ),
                'param_name' => 'btntext',
                'description' => esc_html__( 'Button text', 'solutech' ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'segmented_button',
                'heading' => esc_html__( 'Button Position', 'solutech' ),
                'param_name' => 'btn_position',
                'value' => array(
                    'default' => 'pix-footer',
                    esc_html__( 'Header', 'solutech' ) => 'pix-header',
                    esc_html__( 'Footer', 'solutech' ) => 'pix-footer',
                ),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('pix-price-table'),
                ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Boxes Gap', 'solutech' ),
                'param_name' => 'box_gap',
                'value' => array(0,1,2,5,10,15,20,30,50),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('pix-price-box', 'pix-price-long')
                ),
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Features Title', 'solutech' ),
                'param_name' => 'features_title',
                'value' => 'Features',
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('pix-price-table'),
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Features Subtitle', 'solutech' ),
                'param_name' => 'features_subtitle',
                'value' => '',
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('pix-price-table'),
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                'type' => 'textarea',
                'holder' => 'div',
                'heading' => esc_html__( 'Features for Comparison', 'solutech' ),
                'param_name' => 'compare_features',
                'value' => '',
                'description' => esc_html__( 'This Features is compared with every box options and set enable/disable', 'solutech' ),
                
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__( 'Price Boxes', 'solutech' ),
                'param_name' => 'prices',
                'params' => array_merge(
                    array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Title', 'solutech' ),
                            'param_name' => 'title',
                            'description' => esc_html__( 'Column title', 'solutech' ),
                            'edit_field_class' => 'vc_col-sm-4',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Subtitle', 'solutech' ),
                            'param_name' => 'subtitle',
                            'description' => esc_html__( 'Subtitle text', 'solutech' ),
                            'edit_field_class' => 'vc_col-sm-4',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Button Text', 'solutech' ),
                            'param_name' => 'btntext_box',
                            'description' => esc_html__( 'Change Global button text', 'solutech' ),
                            'edit_field_class' => 'vc_col-sm-4',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'First Price', 'solutech' ),
                            'param_name' => 'first_price',
                            'description' => '',
                            'edit_field_class' => 'vc_col-sm-3',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Second Price', 'solutech' ),
                            'param_name' => 'second_price',
                            'description' => '',
                            'edit_field_class' => 'vc_col-sm-3',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Price Subtext', 'solutech' ),
                            'param_name' => 'price_text',
                            'description' => esc_html__( 'Text after price', 'solutech' ),
                            'edit_field_class' => 'vc_col-sm-3',
                        ),
                        array(
                            'type' => 'switch_button',
                            'heading' => esc_html__( 'Popular', 'solutech' ),
                            'param_name' => 'is_popular',
                            'value' => 'off',
                            'edit_field_class' => 'vc_col-sm-3',
                        ),
                        array(
                            'type' => 'segmented_button',
                            'heading' => esc_html__( 'Icon Type', 'solutech' ),
                            'param_name' => 'icon_type',
                            'value' => array(
                                'default' => 'svg',
                                esc_html__( 'SVG/Image', 'solutech' ) => 'image',
                                esc_html__( 'Font', 'solutech' ) => 'font',
                            ),
                            'edit_field_class' => 'vc_col-sm-7',
                        ),
                        array(
                            'type' => 'attach_image',
                            'heading' => esc_html__( 'Image/SVG', 'solutech' ),
                            'param_name' => 'image',
                            'description' => esc_html__( 'Select image.', 'solutech' ),
                            'dependency' => array(
                                'element' => 'icon_type',
                                'value' => array('image')
                            ),
                            'edit_field_class' => 'vc_col-sm-5',
                        ),
                    ),
                    pixtheme_get_vc_icons($vc_icons_data, 'icon_type', 'font'),
                    array(
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'heading' => esc_html__( 'Features', 'solutech' ),
                            'param_name' => 'price_features',
                            'value' => '',
                            'description' => esc_html__( 'The list of Features', 'solutech' ),
                            'edit_field_class' => 'vc_col-sm-6',
                        ),
                        array(
                            'type' => 'textarea',
                            'holder' => 'div',
                            'heading' => esc_html__( 'Additional Information', 'solutech' ),
                            'param_name' => 'price_content',
                            'value' => '',
                            'description' => esc_html__( 'Enter information', 'solutech' ),
                            'edit_field_class' => 'vc_col-sm-6',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Product ID', 'solutech' ),
                            'param_name' => 'id_product',
                            'description' => esc_html__( 'Redirect to checkout', 'solutech' ),
                            'edit_field_class' => 'vc_col-sm-3',
                        ),
                        array(
                            'type' => 'vc_link',
                            'heading' => esc_html__( 'Link', 'solutech' ),
                            'param_name' => 'link',
                            'description' => esc_html__( 'Item link', 'solutech' ),
                            'edit_field_class' => 'vc_col-sm-9',
                        ),
                    )
                ),
            ),
		),

	) );


    //////// Timeline ////////

	vc_map( array(
		'name' => esc_html__( 'Timeline', 'solutech' ),
		'base' => 'common_timeline',
		'class' => 'pix-theme-icon-common',
		'as_parent' => array('only' => 'common_timeline_option'),
		'content_element' => true,
		'show_settings_on_create' => true,
		'category' => esc_html__( 'Solutech', 'solutech' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Timeline block per page', 'solutech' ),
				'param_name' => 'count',
				'value' => '3',
				'description' => esc_html__( 'If empty, display all blocks', 'solutech' ),
			),
		),
		'js_view' => 'VcColumnView',

	) );


	vc_map( array(
		'name' => esc_html__( 'Timeline option', 'solutech' ),
		'base' => 'common_timeline_option',
		'class' => 'pix-theme-icon-common',
		'as_child' => array('only' => 'common_timeline'),
		'content_element' => true,
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Position On Timeline', 'solutech' ),
				'param_name' => 'type',
				'value' => array(
					esc_html__('Left', 'solutech') => 'left',
					esc_html__('Right', 'solutech') => 'right',
				),
				'description' => esc_html__( 'Left/right position on timeline', 'solutech' )
			),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'solutech' ),
				'param_name' => 'image',
				'description' => esc_html__( 'Select image.', 'solutech' )
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Date', 'solutech' ),
				'param_name' => 'date',
				'description' => esc_html__( 'Option date', 'solutech' )
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'solutech' ),
				'param_name' => 'title',
				'description' => esc_html__( 'Option title', 'solutech' )
			),
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( 'Content', 'solutech' ),
				"param_name" => "content",
				"value" => wp_kses_post( __( '<p>I am test text block. Click edit button to change this text.</p>', 'solutech' ) ),
				"description" => esc_html__( 'Enter text.', 'solutech' )
			),
		)
	) );
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_Common_Timeline extends WPBakeryShortCodesContainer {
		}
	}
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_Common_Timeline_Option extends WPBakeryShortCode {
		}
	}

	/////////////////////////////////



	////////////////////////

	if ( class_exists( 'WooCommerce' ) ) {
		/// common_woocommerce
		//////// Woocommerce Products ////////
		vc_map(
			array(
				'name' => esc_html__( 'Woocommerce Products', 'solutech' ),
				'base' => 'common_woocommerce',
				'class' => 'pix-theme-icon-common',
				'category' => esc_html__( 'Solutech', 'solutech'),
				'params' => array(
				    array(
                        'type' => 'segmented_button',
                        'heading' => esc_html__( 'Products by', 'solutech' ),
                        'param_name' => 'select_type',
                        'value' => array(
                            'default' => 'default',
                            esc_html__('Category', 'solutech') => 'default',
                            esc_html__('IDs', 'solutech') => 'ids',
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'IDs', 'solutech' ),
                        'param_name' => 'items',
                        'description' => esc_html__( 'Input products ID.  (example: 307,304,302,301,300)', 'solutech' ),
                        'dependency' => array(
                            'element' => 'select_type',
                            'value' => array('ids'),
                        )
                    ),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Categories', 'solutech' ),
						'param_name' => 'cats',
						'value' => $cats_woo,
						'description' => esc_html__( 'Select categories to show', 'solutech' ),
                        'dependency' => array(
                            'element' => 'select_type',
                            'value' => array('default'),
                        )
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Items Count', 'solutech' ),
						'param_name' => 'count',
						'description' => esc_html__( 'Select number products.', 'solutech' ),
                        'dependency' => array(
                            'element' => 'select_type',
                            'value' => array('default'),
                        )
					),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Products per page', 'solutech' ),
                        'param_name' => 'per_page',
                        'description' => esc_html__( 'Default 3.', 'solutech' ),
                        'dependency' => array(
                            'element' => 'carousel',
                            'value' => 'on',
                        ),
                    ),
				)
			)
		);
	}


	if ( class_exists( 'WPBakeryShortCode' ) && class_exists( 'WPBakeryShortCodesContainer' ) ) {

		class WPBakeryShortCode_Box_Container extends WPBakeryShortCodesContainer {
			protected $controls_css_settings = 'out-tc vc_controls-content-widget';
			protected $controls_list = array( 'add', 'edit', 'clone', 'delete' );

			public function __construct( $settings ) {
				parent::__construct( $settings );
			}

			public function contentAdmin( $atts, $content = null ) {

				$elem = $this->getElementHolder( '' );
				$elem = str_ireplace( 'wpb_content_element', '', $elem );
				$elem = str_ireplace( '%wpb_element_content%', '<div class="wpb_column_container vc_container_for_children vc_clearfix vc_empty-container ui-sortable ui-droppable"></div>', $elem );
				$output = $elem;

				return $output;
			}
		}

        class WPBakeryShortCode_Progress extends WPBakeryShortCode {
            public static function convertAttributesToNewProgressBar( $atts ) {
                if ( isset( $atts['values'] ) && strlen( $atts['values'] ) > 0 ) {
                    $values = vc_param_group_parse_atts( $atts['values'] );
                    if ( ! is_array( $values ) ) {
                        $temp = explode( ',', $atts['values'] );
                        $paramValues = array();
                        foreach ( $temp as $value ) {
                            $data = explode( '|', $value );
                            $colorIndex = 2;
                            $newLine = array();
                            $newLine['value'] = isset( $data[0] ) ? $data[0] : 0;
                            $newLine['label'] = isset( $data[1] ) ? $data[1] : '';
                            if ( isset( $data[1] ) && preg_match( '/^\d{1,3}\%$/', $data[1] ) ) {
                                $colorIndex += 1;
                                $newLine['value'] = (float) str_replace( '%', '', $data[1] );
                                $newLine['label'] = isset( $data[2] ) ? $data[2] : '';
                            }
                            if ( isset( $data[ $colorIndex ] ) ) {
                                $newLine['customcolor'] = $data[ $colorIndex ];
                            }
                            $paramValues[] = $newLine;
                        }
                        $atts['values'] = urlencode( json_encode( $paramValues ) );
                    }
                }

                return $atts;
            }
        }


        class WPBakeryShortCode_Common_Title extends WPBakeryShortCode {}
        class WPBakeryShortCode_Common_Button extends WPBakeryShortCode {}
		class WPBakeryShortCode_Common_Icon_Box extends WPBakeryShortCode {}
		class WPBakeryShortCode_Common_Tab_Acc extends WPBakeryShortCode {}
        class WPBakeryShortCode_Common_Posts_Block extends WPBakeryShortCode {}
        class WPBakeryShortCode_Common_Special_Offers extends WPBakeryShortCode {}
        class WPBakeryShortCode_Common_Team extends WPBakeryShortCode {}
        class WPBakeryShortCode_Common_Reviews extends WPBakeryShortCode {}
        class WPBakeryShortCode_Common_Video extends WPBakeryShortCode {}
        class WPBakeryShortCode_Common_Google_Map extends WPBakeryShortCode {}
		class WPBakeryShortCode_Common_Price_Table extends WPBakeryShortCode {}
		class WPBakeryShortCode_Common_Points extends WPBakeryShortCode {}
		class WPBakeryShortCode_Common_Amount_Box extends WPBakeryShortCode {}
		class WPBakeryShortCode_Common_Progress extends WPBakeryShortCode_Progress {}
		class WPBakeryShortCode_Common_Brands extends WPBakeryShortCode {}
		class WPBakeryShortCode_Common_Mailchimp extends WPBakeryShortCode {}
		class WPBakeryShortCode_Common_Cform7 extends WPBakeryShortCode {}
		class WPBakeryShortCode_Common_Slider extends WPBakeryShortCode_Box_Container {}
		class WPBakeryShortCode_Common_Wrapper extends WPBakeryShortCode_Box_Container {}
		class WPBakeryShortCode_Common_Tabs_Content extends WPBakeryShortCode_Box_Container {}
		class WPBakeryShortCode_Common_Tab_Content extends WPBakeryShortCodesContainer {}
        //class WPBakeryShortCode_Common_Section_Grid extends WPBakeryShortCode {}
        class WPBakeryShortCode_Common_Isotope extends WPBakeryShortCode {}
        class WPBakeryShortCode_Common_Carousel extends WPBakeryShortCode {}
        class WPBakeryShortCode_Pix_Calculator extends WPBakeryShortCode {}
        if ( class_exists( 'booked_plugin' ) ) {
		    class WPBakeryShortCode_Common_Appointment extends WPBakeryShortCode {}
        }
		class WPBakeryShortCode_Common_Woocommerce extends WPBakeryShortCode {}

	}
?>