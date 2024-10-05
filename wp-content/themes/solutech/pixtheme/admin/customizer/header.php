<?php

	function pixtheme_customize_header_tab($wp_customize, $theme_name){

		$wp_customize->add_panel('pixtheme_header_panel',  array(
            'title' => 'Header',
            'priority' => 30,
            )
        );



		$wp_customize->add_section( 'pixtheme_header_settings' , array(
		    'title'      => esc_html__( 'General Settings', 'solutech' ),
		    'priority'   => 5,
			'panel' => 'pixtheme_header_panel'
		) );


		$wp_customize->add_setting( 'pixtheme_header_type' , array(
				'default'     => 'header1',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_type',
            array(
                'label'    => esc_html__( 'Type', 'solutech' ),
                'section'  => 'pixtheme_header_settings',
                'settings' => 'pixtheme_header_type',
                'type'     => 'select',
                'choices'  => array(
                    'header1' => esc_html__( 'Default', 'solutech' ),
                    'header2' => esc_html__( 'Centered Logo', 'solutech' ),
		            'header3' => esc_html__( 'Top Logo (2 levels)', 'solutech' ),
		            'header4' => esc_html__( 'Top Info (2 levels)', 'solutech' ),
                    'header5' => esc_html__( 'Search (2 levels)', 'solutech' ),
//		            'header6' => esc_html__( 'Slideout Sidebar', 'solutech' ),
                ),
            )
        );

		$wp_customize->add_setting( 'pixtheme_header_layout' , array(
			'default'     => 'container',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_layout',
            array(
                'label'    => esc_html__( 'Layout', 'solutech' ),
                'section'  => 'pixtheme_header_settings',
                'settings' => 'pixtheme_header_layout',
                'type'     => 'select',
                'choices'  => array(
                    'container'  => esc_html__( 'Normal', 'solutech' ),
		            'container boxed'  => esc_html__( 'Boxed', 'solutech' ),
		            'container-fluid' => esc_html__( 'Full Width', 'solutech' ),
                ),
            )
        );

		$wp_customize->add_setting( 'pixtheme_header_sticky' , array(
				'default'     => 'sticky',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_sticky',
            array(
                'label'         => esc_html__( 'Sticky', 'solutech' ),
                'section'       => 'pixtheme_header_settings',
                'settings'      => 'pixtheme_header_sticky',
                'type'          => 'select',
                'choices'       => array(
                    '' => esc_html__( 'No', 'solutech' ),
                    'sticky'  => esc_html__( 'Yes', 'solutech' ),
                    'sticky-up'  => esc_html__( 'On Up Scroll', 'solutech' ),
                ),
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_header_sticky_width' , array(
            'default'     => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_header_sticky_width',
            array(
                'label'         => esc_html__( 'Sticky Layout', 'solutech' ),
                'section'       => 'pixtheme_header_settings',
                'settings'      => 'pixtheme_header_sticky_width',
                'type'          => 'select',
                'choices'       => array(
                    'boxed'  => esc_html__( 'Boxed', 'solutech' ),
                    '' => esc_html__( 'Full Width', 'solutech' ),
                ),
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_header_sticky_mobile' , array(
            'default'     => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_header_sticky_mobile',
            array(
                'label'         => esc_html__( 'Sticky Mobile', 'solutech' ),
                'section'       => 'pixtheme_header_settings',
                'settings'      => 'pixtheme_header_sticky_mobile',
                'type'          => 'select',
                'choices'       => array(
                    '' => esc_html__( 'No', 'solutech' ),
                    'sticky'  => esc_html__( 'Yes', 'solutech' ),
                    'sticky-up'  => esc_html__( 'On Up Scroll', 'solutech' ),
                ),
            )
        );
		
		$wp_customize->add_setting( 'pixtheme_header_menu_pos' , array(
				'default'     => '',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_menu_pos',
            array(
                'label'    => esc_html__( 'Menu Position', 'solutech' ),
                'description'   => '',
                'section'  => 'pixtheme_header_settings',
                'settings' => 'pixtheme_header_menu_pos',
                'type'     => 'select',
                'choices'  => array(
                    'pix-text-right' => esc_html__( 'Right', 'solutech' ),
                    'pix-text-left'  => esc_html__( 'Left', 'solutech' ),
                    'pix-text-center'  => esc_html__( 'Center', 'solutech' ),
                ),
            )
        );
		
		$wp_customize->add_setting( 'pixtheme_header_menu_right_info' , array(
				'default'     => '',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_menu_right_info',
            array(
                'label'    => esc_html__( 'Display Info on the Right', 'solutech' ),
                'description'   => '',
                'section'  => 'pixtheme_header_settings',
                'settings' => 'pixtheme_header_menu_right_info',
                'type'     => 'select',
                'choices'  => array(
                    'phone' => esc_html__( 'Phone', 'solutech' ),
                    'email' => esc_html__( 'E-mail', 'solutech' ),
                    'address' => esc_html__( 'Address', 'solutech' ),
                    'button'  => esc_html__( 'Button', 'solutech' ),
                    'custom'  => esc_html__( 'Custom', 'solutech' ),
                    'hide'  => esc_html__( 'Hide', 'solutech' ),
                ),
            )
        );



		/// HEADER COLORS ///

		$wp_customize->add_section( 'pixtheme_header_settings_style' , array(
		    'title'      => esc_html__( 'Colors', 'solutech' ),
		    'priority'   => 10,
			'panel' => 'pixtheme_header_panel'
		) );


		$wp_customize->add_setting( 'pixtheme_top_bar_background' , array(
            'default'     => 'black',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_top_bar_background',
            array(
                'label'    => esc_html__( 'Top Bar Background Color', 'solutech' ),
                'section'  => 'pixtheme_header_settings_style',
                'settings' => 'pixtheme_top_bar_background',
                'type'     => 'select',
                'choices'  => array(
                    'white' => esc_html__( 'White', 'solutech' ),
		            'black' => esc_html__( 'Black', 'solutech' ),
                ),
            )
        );

		$wp_customize->add_setting( 'pixtheme_top_bar_transparent' , array(
			'default'     => '100',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
			new PixTheme_Slider_Single_Control(
				$wp_customize,
				'pixtheme_top_bar_transparent',
				array(
					'label' => esc_html__( 'Top Bar Transparent', 'solutech' ),
					'section' => 'pixtheme_header_settings_style',
					'settings' => 'pixtheme_top_bar_transparent',
					'min' => 0,
					'max' => 100,
					'unit'=> '%',
				)
			)
	    );

		$wp_customize->add_setting( 'pixtheme_header_background' , array(
				'default'     => 'black',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_background',
            array(
                'label'    => esc_html__( 'Background Color', 'solutech' ),
                'section'  => 'pixtheme_header_settings_style',
                'settings' => 'pixtheme_header_background',
                'type'     => 'select',
                'choices'  => array(
                    'white' => esc_html__( 'White', 'solutech' ),
		            'black' => esc_html__( 'Black', 'solutech' ),
                ),
            )
        );

		$wp_customize->add_setting( 'pixtheme_header_transparent' , array(
			'default'     => '0',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
			new PixTheme_Slider_Single_Control(
				$wp_customize,
				'pixtheme_header_transparent',
				array(
					'label' => esc_html__( 'Transparent', 'solutech' ),
					'section' => 'pixtheme_header_settings_style',
					'settings' => 'pixtheme_header_transparent',
					'min' => 0,
					'max' => 100,
					'unit'=> '%',
				)
			)
	    );
        
        $wp_customize->add_setting( 'pixtheme_header_border' , array(
            'default'     => '0',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_header_border',
            array(
                'label'    => esc_html__( 'Borders', 'solutech' ),
                'section'  => 'pixtheme_header_settings_style',
                'settings' => 'pixtheme_header_border',
                'type'     => 'select',
                'choices'  => array(
                    '0' => esc_html__( 'Off', 'solutech' ),
                    'top'  => esc_html__( 'Top', 'solutech' ),
                    'bottom'  => esc_html__( 'Bottom', 'solutech' ),
                    'both'  => esc_html__( 'Both', 'solutech' ),
                ),
            )
        );

		$wp_customize->add_setting( 'pixtheme_header_menu_background' , array(
				'default'     => get_option('pixtheme_default_header_menu_background'),
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_menu_background',
            array(
                'label'    => esc_html__( 'Menu Background Color', 'solutech' ),
                'section'  => 'pixtheme_header_settings_style',
                'settings' => 'pixtheme_header_menu_background',
                'type'     => 'select',
                'choices'  => array(
                    'white' => esc_html__( 'White', 'solutech' ),
		            'black' => esc_html__( 'Black', 'solutech' ),
                    'main-color' => esc_html__( 'Main Color', 'solutech' ),
                    'add-color' => esc_html__( 'Additional Color', 'solutech' ),
                    'gradient' => esc_html__( 'Gradient', 'solutech' ),
                ),
            )
        );

		$wp_customize->add_setting( 'pixtheme_header_menu_transparent' , array(
			'default'     => '100',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
			new PixTheme_Slider_Single_Control(
				$wp_customize,
				'pixtheme_header_menu_transparent',
				array(
					'label' => esc_html__( 'Menu Transparent', 'solutech' ),
					'section' => 'pixtheme_header_settings_style',
					'settings' => 'pixtheme_header_menu_transparent',
					'min' => 0,
					'max' => 100,
					'unit'=> '%',
				)
			)
	    );



        /// HEADER ELEMENTS ///

		$wp_customize->add_section( 'pixtheme_header_settings_elements' , array(
		    'title'      => esc_html__( 'Elements', 'solutech' ),
		    'priority'   => 15,
			'panel' => 'pixtheme_header_panel'
		) );


		$wp_customize->add_setting( 'pixtheme_header_bar' , array(
				'default'     => '0',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
			'pixtheme_header_bar',
			array(
				'label'    => esc_html__( 'Top Bar', 'solutech' ),
				'section'  => 'pixtheme_header_settings_elements',
				'settings' => 'pixtheme_header_bar',
				'type'     => 'select',
				'choices'  => array(
						'1'  => esc_html__( 'On', 'solutech' ),
						'0' => esc_html__( 'Off', 'solutech' ),
				),
			)
		);
		
		$wp_customize->add_setting( 'pixtheme_header_search' , array(
            'default'     => '1',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_header_search',
            array(
                'label'    => esc_html__( 'Search', 'solutech' ),
                'section'  => 'pixtheme_header_settings_elements',
                'settings' => 'pixtheme_header_search',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'solutech' ),
                    '0' => esc_html__( 'Off', 'solutech' ),
                ),
            )
        );

		$wp_customize->add_setting( 'pixtheme_header_minicart' , array(
				'default'     => '1',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_minicart',
            array(
                'label'    => esc_html__( 'Minicart', 'solutech' ),
                'section'  => 'pixtheme_header_settings_elements',
                'settings' => 'pixtheme_header_minicart',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'solutech' ),
                    '0' => esc_html__( 'Off', 'solutech' ),
                ),
            )
        );

		$wp_customize->add_setting( 'pixtheme_header_socials' , array(
				'default'     => '1',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_socials',
            array(
                'label'    => esc_html__( 'Socials', 'solutech' ),
                'section'  => 'pixtheme_header_settings_elements',
                'settings' => 'pixtheme_header_socials',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'solutech' ),
                    '0' => esc_html__( 'Off', 'solutech' ),
                ),
            )
        );

		$wp_customize->add_setting( 'pixtheme_header_button' , array(
            'default'     => '0',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'pixtheme_header_button',
            array(
                'label'    => esc_html__( 'Button', 'solutech' ),
                'section'  => 'pixtheme_header_settings_elements',
                'settings' => 'pixtheme_header_button',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'solutech' ),
                    '0' => esc_html__( 'Off', 'solutech' ),
                ),
            )
		);



        /// HEADER INFO ///

		$wp_customize->add_section( 'pixtheme_header_settings_info' , array(
		    'title'      => esc_html__( 'Info Texts', 'solutech' ),
		    'priority'   => 25,
			'panel' => 'pixtheme_header_panel'
		) );


		$wp_customize->add_setting( 'pixtheme_header_phone' , array(
				'default'     => '',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'wp_kses_post'
		) );
		$wp_customize->add_control(
			'pixtheme_header_phone',
			array(
				'label'    => esc_html__( 'Phone', 'solutech' ),
				'section'  => 'pixtheme_header_settings_info',
				'settings' => 'pixtheme_header_phone',
				'type'     => 'text',
			)
		);
        
		$wp_customize->add_setting( 'pixtheme_header_email' , array(
				'default'     => '',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'wp_kses_post'
		) );
		$wp_customize->add_control(
			'pixtheme_header_email',
			array(
				'label'    => esc_html__( 'E-mail', 'solutech' ),
				'section'  => 'pixtheme_header_settings_info',
				'settings' => 'pixtheme_header_email',
				'type'     => 'text',
			)
		);

		$wp_customize->add_setting( 'pixtheme_header_address' , array(
				'default'     => '',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'wp_kses_post'
		) );
		$wp_customize->add_control(
			'pixtheme_header_address',
			array(
				'label'    => esc_html__( 'Address', 'solutech' ),
				'section'  => 'pixtheme_header_settings_info',
				'settings' => 'pixtheme_header_address',
				'type'     => 'text',
			)
		);
        
		$wp_customize->add_setting( 'pixtheme_header_button_text' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'wp_kses_post'
		) );
		$wp_customize->add_control(
			'pixtheme_header_button_text',
			array(
					'label'    => esc_html__( 'Button Text', 'solutech' ),
					'section'  => 'pixtheme_header_settings_info',
					'settings' => 'pixtheme_header_button_text',
					'type'     => 'text',
			)
		);

		$wp_customize->add_setting( 'pixtheme_header_button_link' , array(
				'default'     => '',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'esc_url'
		) );
		$wp_customize->add_control(
				'pixtheme_header_button_link',
				array(
						'label'    => esc_html__( 'Button Link', 'solutech' ),
						'section'  => 'pixtheme_header_settings_info',
						'settings' => 'pixtheme_header_button_link',
						'type'     => 'text',
				)
		);
		
		$wp_customize->add_setting( 'pixtheme_header_custom_info' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'wp_kses_post'
		) );
		$wp_customize->add_control(
			'pixtheme_header_custom_info',
			array(
					'label'    => esc_html__( 'Custom', 'solutech' ),
					'section'  => 'pixtheme_header_settings_info',
					'settings' => 'pixtheme_header_custom_info',
					'type'     => 'textarea',
			)
		);



		$wp_customize->add_setting( 'pixtheme_header_info_segment', array(
            'default' => 'info_1',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Segmented_Control(
                $wp_customize,
                'pixtheme_header_info_segment',
                array(
                    'label' => esc_html__( 'Info Sections', 'solutech' ),
                    'section' => 'pixtheme_header_settings_info',
                    'settings' => 'pixtheme_header_info_segment',
                    'choices'  => array(
                        'info_1' => esc_html__( 'Info 1', 'solutech' ),
                        'info_2' => esc_html__( 'Info 2', 'solutech' ),
                        'info_3' => esc_html__( 'Info 3', 'solutech' ),
                    ),
                    'align' => 'center',
                    'type' => 'tabs',
                    'hide_label' => 'hide',
                )
            )
        );

		$wp_customize->add_setting( 'pixtheme_header_info_icon_1' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'wp_kses_post'
		) );
		$wp_customize->add_control(
			'pixtheme_header_info_icon_1',
			array(
					'label'    => esc_html__( 'Icon 1', 'solutech' ),
					'section'  => 'pixtheme_header_settings_info',
					'settings' => 'pixtheme_header_info_icon_1',
					'type'     => 'text',
			)
		);
		$wp_customize->add_setting( 'pixtheme_header_info_title_1' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'wp_kses_post'
		) );
		$wp_customize->add_control(
			'pixtheme_header_info_title_1',
			array(
					'label'    => esc_html__( 'Title 1', 'solutech' ),
					'section'  => 'pixtheme_header_settings_info',
					'settings' => 'pixtheme_header_info_title_1',
					'type'     => 'text',
			)
		);
		$wp_customize->add_setting( 'pixtheme_header_info_1' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'wp_kses_post'
		) );
		$wp_customize->add_control(
			'pixtheme_header_info_1',
			array(
					'label'    => esc_html__( 'Info 1', 'solutech' ),
					'section'  => 'pixtheme_header_settings_info',
					'settings' => 'pixtheme_header_info_1',
					'type'     => 'text',
			)
		);

		$wp_customize->add_setting( 'pixtheme_header_info_icon_2' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'wp_kses_post'
		) );
		$wp_customize->add_control(
			'pixtheme_header_info_icon_2',
			array(
					'label'    => esc_html__( 'Icon 2', 'solutech' ),
					'section'  => 'pixtheme_header_settings_info',
					'settings' => 'pixtheme_header_info_icon_2',
					'type'     => 'text',
			)
		);
		$wp_customize->add_setting( 'pixtheme_header_info_title_2' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'wp_kses_post'
		) );
		$wp_customize->add_control(
			'pixtheme_header_info_title_2',
			array(
					'label'    => esc_html__( 'Title 2', 'solutech' ),
					'section'  => 'pixtheme_header_settings_info',
					'settings' => 'pixtheme_header_info_title_2',
					'type'     => 'text',
			)
		);
		$wp_customize->add_setting( 'pixtheme_header_info_2' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'wp_kses_post'
		) );
		$wp_customize->add_control(
			'pixtheme_header_info_2',
			array(
					'label'    => esc_html__( 'Info 2', 'solutech' ),
					'section'  => 'pixtheme_header_settings_info',
					'settings' => 'pixtheme_header_info_2',
					'type'     => 'text',
			)
		);

		$wp_customize->add_setting( 'pixtheme_header_info_icon_3' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'wp_kses_post'
		) );
		$wp_customize->add_control(
			'pixtheme_header_info_icon_3',
			array(
					'label'    => esc_html__( 'Icon 3', 'solutech' ),
					'section'  => 'pixtheme_header_settings_info',
					'settings' => 'pixtheme_header_info_icon_3',
					'type'     => 'text',
			)
		);
		$wp_customize->add_setting( 'pixtheme_header_info_title_3' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'wp_kses_post'
		) );
		$wp_customize->add_control(
			'pixtheme_header_info_title_3',
			array(
					'label'    => esc_html__( 'Title 3', 'solutech' ),
					'section'  => 'pixtheme_header_settings_info',
					'settings' => 'pixtheme_header_info_title_3',
					'type'     => 'text',
			)
		);
		$wp_customize->add_setting( 'pixtheme_header_info_3' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'wp_kses_post'
		) );
		$wp_customize->add_control(
			'pixtheme_header_info_3',
			array(
					'label'    => esc_html__( 'Info 3', 'solutech' ),
					'section'  => 'pixtheme_header_settings_info',
					'settings' => 'pixtheme_header_info_3',
					'type'     => 'text',
			)
		);



        /// HEADER BACKGROUND ///

        $wp_customize->add_section( 'pixtheme_header_settings_bg_image' , array(
            'title'      => esc_html__( 'Background Image', 'solutech' ),
            'priority'   => 30,
            'panel' => 'pixtheme_header_panel'
        ) );


        $wp_customize->add_setting( 'pixtheme_tab_bg_image' , array(
            'default'     => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'pixtheme_tab_bg_image',
                array(
                    'label'      => esc_html__( 'Background Image', 'solutech' ),
                    'section'    => 'pixtheme_header_settings_bg_image',
                    'settings'   => 'pixtheme_tab_bg_image',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_tab_bg_image_size' , array(
            'default'     => 'cover',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_tab_bg_image_size',
            array(
                'label'    => esc_html__( 'Background Size', 'solutech' ),
                'section'  => 'pixtheme_header_settings_bg_image',
                'settings' => 'pixtheme_tab_bg_image_size',
                'type'     => 'select',
                'choices'  => array(
                    'cover'  => esc_html__( 'Cover', 'solutech' ),
                    'contain' => esc_html__( 'Contain', 'solutech' ),
                    'auto' => esc_html__( 'Auto', 'solutech' ),
                ),
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_tab_bg_image_repeat' , array(
            'default'     => 'no-repeat',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_tab_bg_image_repeat',
            array(
                'label'    => esc_html__( 'Background Repeat', 'solutech' ),
                'section'  => 'pixtheme_header_settings_bg_image',
                'settings' => 'pixtheme_tab_bg_image_repeat',
                'type'     => 'select',
                'choices'  => array(
                    'no-repeat'  => esc_html__( 'No Repeat', 'solutech' ),
                    'repeat'  => esc_html__( 'Repeat', 'solutech' ),
                    'repeat-x'  => esc_html__( 'Repeat X', 'solutech' ),
                    'repeat-y'  => esc_html__( 'Repeat Y', 'solutech' ),
                ),
            )
        );

        $wp_customize->add_setting(	'pixtheme_tab_bg_image_horizontal_pos', array(
            'default' => '50',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_tab_bg_image_horizontal_pos',
                array(
                    'label' => esc_html__( 'Horizontal Position', 'solutech' ),
                    'section' => 'pixtheme_header_settings_bg_image',
                    'settings' => 'pixtheme_tab_bg_image_horizontal_pos',
                    'min' => 0,
                    'max' => 100,
                    'unit' => '%',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_tab_bg_image_vertical_pos', array(
            'default' => '50',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_tab_bg_image_vertical_pos',
                array(
                    'label' => esc_html__( 'Vertical Position', 'solutech' ),
                    'section' => 'pixtheme_header_settings_bg_image',
                    'settings' => 'pixtheme_tab_bg_image_vertical_pos',
                    'min' => 0,
                    'max' => 100,
                    'unit' => '%',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_tab_bg_image_fixed' , array(
            'default'     => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_tab_bg_image_fixed',
            array(
                'label'    => esc_html__( 'Fixed Image', 'solutech' ),
                'section'  => 'pixtheme_header_settings_bg_image',
                'settings' => 'pixtheme_tab_bg_image_fixed',
                'type'     => 'select',
                'choices'  => array(
                    '' => esc_html__( 'No', 'solutech' ),
                    'pix-bg-image-fixed' => esc_html__( 'Yes', 'solutech' ),
                ),
            )
        );

        $wp_customize->add_setting( 'pixtheme_tab_bg_color' , array(
            'default'     => get_option('pixtheme_default_tab_bg_color'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'pixtheme_tab_bg_color',
                array(
                    'label'      => esc_html__( 'Overlay Color', 'solutech' ),
                    'section'    => 'pixtheme_header_settings_bg_image',
                    'settings'   => 'pixtheme_tab_bg_color',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_tab_bg_color_gradient' , array(
            'default'     => get_option('pixtheme_default_tab_bg_color_gradient'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'pixtheme_tab_bg_color_gradient',
                array(
                    'label'      => esc_html__( 'Gradient Color', 'solutech' ),
                    'description'    => esc_html__( 'Set this color for gradient overlay', 'solutech'),
                    'section'    => 'pixtheme_header_settings_bg_image',
                    'settings'   => 'pixtheme_tab_bg_color_gradient',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_tab_gradient_direction' , array(
            'default'     => get_option('pixtheme_default_tab_gradient_direction'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_tab_gradient_direction',
            array(
                'label'    => esc_html__( 'Gradient Direction', 'solutech' ),
                'section'  => 'pixtheme_header_settings_bg_image',
                'settings' => 'pixtheme_tab_gradient_direction',
                'type'     => 'select',
                'choices'  => array(
                    'to right' => esc_html__( 'To Right ', 'solutech' ).html_entity_decode('&rarr;'),
                    'to left' => esc_html__( 'To Left ', 'solutech' ).html_entity_decode('&larr;'),
                    'to bottom' => esc_html__( 'To Bottom ', 'solutech' ).html_entity_decode('&darr;'),
                    'to top' => esc_html__( 'To Top ', 'solutech' ).html_entity_decode('&uarr;'),
                    'to bottom right' => esc_html__( 'To Bottom Right ', 'solutech' ).html_entity_decode('&#8600;'),
                    'to bottom left' => esc_html__( 'To Bottom Left ', 'solutech' ).html_entity_decode('&#8601;'),
                    'to top right' => esc_html__( 'To Top Right ', 'solutech' ).html_entity_decode('&#8599;'),
                    'to top left' => esc_html__( 'To Top Left ', 'solutech' ).html_entity_decode('&#8598;'),
                    //'angle' => esc_html__( 'Angle ', 'solutech' ).html_entity_decode('&#10227;'),
                ),
            )
        );

        $wp_customize->add_setting( 'pixtheme_tab_bg_opacity' , array(
            'default'     => get_option('pixtheme_default_tab_bg_opacity'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_tab_bg_opacity',
                array(
                    'label' => esc_html__( 'Overlay Opacity', 'solutech' ),
                    'section' => 'pixtheme_header_settings_bg_image',
                    'settings' => 'pixtheme_tab_bg_opacity',
                    'min' => 0,
                    'max' => 100,
                    'unit' => '%',
                )
            )
        );




        /// TITLE & BREADCRUMBS ///

        $wp_customize->add_section( 'pixtheme_header_settings_tab' , array(
            'title'      => esc_html__( 'Title & Breadcrumbs', 'solutech' ),
            'priority'   => 35,
            'panel' => 'pixtheme_header_panel'
        ) );


        $wp_customize->add_setting( 'pixtheme_tab_tone' , array(
            'default'     => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_tab_tone',
            array(
                'label'    => esc_html__( 'Text Tone', 'solutech' ),
                'section'  => 'pixtheme_header_settings_tab',
                'settings' => 'pixtheme_tab_tone',
                'type'     => 'select',
                'choices'  => array(
                    '' => esc_html__( 'Light', 'solutech' ),
                    'pix-tab-tone-dark' => esc_html__( 'Dark', 'solutech' ),
                ),
            )
        );


        $wp_customize->add_setting( 'pixtheme_tab_position' , array(
            'default'     => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_tab_position',
            array(
                'label'    => esc_html__( 'Title & Breadcrumbs Position', 'solutech' ),
                'section'  => 'pixtheme_header_settings_tab',
                'settings' => 'pixtheme_tab_position',
                'type'     => 'select',
                'choices'  => array(
                    '' => esc_html__( 'Both Center', 'solutech' ),
                    'left' => esc_html__( 'Both Left', 'solutech' ),
                    'right' => esc_html__( 'Both Right', 'solutech' ),
                    'left_right' => esc_html__( 'Title Left Breadcrumbs Right', 'solutech' ),
                    'right_left' => esc_html__( 'Title Right Breadcrumbs Left', 'solutech' ),
                ),
            )
        );

        $wp_customize->add_setting( 'pixtheme_tab_hide' , array(
            'default'     => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_tab_hide',
            array(
                'label'    => esc_html__( 'Title & Breadcrumbs Show', 'solutech' ),
                'section'  => 'pixtheme_header_settings_tab',
                'settings' => 'pixtheme_tab_hide',
                'type'     => 'select',
                'choices'  => array(
                    '' => esc_html__( 'Show Both', 'solutech' ),
                    'hide_title' => esc_html__( 'Hide Title', 'solutech' ),
                    'hide_breadcrumbs' => esc_html__( 'Hide Breadcrumbs', 'solutech' ),
                    'hide' => esc_html__( 'Hide Both', 'solutech' ),
                ),
            )
        );

        $wp_customize->add_setting( 'pixtheme_tab_breadcrumbs_v_position' , array(
            'default'     => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_tab_breadcrumbs_v_position',
            array(
                'label'    => esc_html__( 'Breadcrumbs Vertical Position', 'solutech' ),
                'description' => esc_html__( 'Show breadcrumbs over or under title', 'solutech'),
                'section'  => 'pixtheme_header_settings_tab',
                'settings' => 'pixtheme_tab_breadcrumbs_v_position',
                'type'     => 'select',
                'choices'  => array(
                    '' => esc_html__( 'Under', 'solutech' ),
                    'over' => esc_html__( 'Over', 'solutech' ),
                ),
            )
        );

        $wp_customize->add_setting( 'pixtheme_tab_breadcrumbs_current' , array(
            'default'     => '0',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_tab_breadcrumbs_current',
            array(
                'label'    => esc_html__( 'Breadcrumbs Show Current Page', 'solutech' ),
                'section'  => 'pixtheme_header_settings_tab',
                'settings' => 'pixtheme_tab_breadcrumbs_current',
                'type'     => 'select',
                'choices'  => array(
                    '0' => esc_html__( 'No', 'solutech' ),
                    '1' => esc_html__( 'Yes', 'solutech' ),
                ),
            )
        );

        $wp_customize->add_setting(	'pixtheme_tab_padding_top', array(
            'default' => get_option('pixtheme_default_tab_padding_top'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_tab_padding_top',
                array(
                    'label' => esc_html__( 'Header Padding Top', 'solutech' ),
                    'section' => 'pixtheme_header_settings_tab',
                    'settings' => 'pixtheme_tab_padding_top',
                    'min' => 0,
                    'max' => 500,
                    'unit' => 'px',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_tab_padding_bottom', array(
            'default' => get_option('pixtheme_default_tab_padding_bottom'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_tab_padding_bottom',
                array(
                    'label' => esc_html__( 'Header Padding Bottom', 'solutech' ),
                    'section' => 'pixtheme_header_settings_tab',
                    'settings' => 'pixtheme_tab_padding_bottom',
                    'min' => 0,
                    'max' => 500,
                    'unit' => 'px',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_tab_margin_bottom', array(
            'default' => get_option('pixtheme_default_tab_margin_bottom'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_tab_margin_bottom',
                array(
                    'label' => esc_html__( 'Header Margin Bottom', 'solutech' ),
                    'section' => 'pixtheme_header_settings_tab',
                    'settings' => 'pixtheme_tab_margin_bottom',
                    'min' => 0,
                    'max' => 200,
                    'unit' => 'px',
                )
            )
        );

		
	}
		
?>