<?php 
	
	function pixtheme_customize_general_tab($wp_customize, $theme_name){

        $wp_customize->add_panel('pixtheme_general_panel',  array(
                'title' => esc_html__( 'General Settings', 'solutech' ),
                'priority' => 25,
            )
        );


        $wp_customize->add_section( 'pixtheme_general_settings' , array(
            'title'      => esc_html__( 'Logo', 'solutech' ),
            'priority'   => 15,
            'panel' => 'pixtheme_general_panel'
        ) );
		
		
		/* logo image */
		
		$wp_customize->add_setting( 'pixtheme_general_settings_logo' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	            'pixtheme_general_settings_logo',
				array(
				   'label'      => esc_html__( 'Image', 'solutech' ),
				   'section'    => 'pixtheme_general_settings',
				   'settings'   => 'pixtheme_general_settings_logo',
				)
	       )
	    );

		$wp_customize->add_setting(	'pixtheme_general_settings_logo_width', array(
            'default' => get_option('pixtheme_default_logo_width'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_general_settings_logo_width',
                array(
                    'label' => esc_html__( 'Max Width', 'solutech' ),
                    'description'=> esc_html__( 'Retina Logo should be 2x large than max width', 'solutech' ),
                    'section' => 'pixtheme_general_settings',
                    'settings' => 'pixtheme_general_settings_logo_width',
                    'min' => 0,
                    'max' => 300,
                    'unit'=> 'px',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_general_settings_logo_height', array(
            'default' => get_option('pixtheme_default_logo_height'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_general_settings_logo_height',
                array(
                    'label' => esc_html__( 'Min Height', 'solutech' ),
                    'description'=> esc_html__( 'Header Menu height', 'solutech' ),
                    'section' => 'pixtheme_general_settings',
                    'settings' => 'pixtheme_general_settings_logo_height',
                    'min' => 75,
                    'max' => 200,
                    'unit'=> 'px',
                )
            )
        );

		$wp_customize->add_setting( 'pixtheme_general_settings_logo_text' , array(
		    'default'     => '',
		    'transport'   => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
			'pixtheme_general_settings_logo_text',
			array(
				'label'    => esc_html__( 'Logo Text', 'solutech' ),
				'section'  => 'pixtheme_general_settings',
				'settings' => 'pixtheme_general_settings_logo_text',
				'type'     => 'text',
			)
		);

		$wp_customize->add_setting( 'pixtheme_general_settings_logo_mobile' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	            'pixtheme_general_settings_logo_mobile',
				array(
				   'label'      => esc_html__( 'Mobile Logo', 'solutech' ),
				   'section'    => 'pixtheme_general_settings',
				   'settings'   => 'pixtheme_general_settings_logo_mobile',
				)
	       )
	    );

		
		
		
        /// COLOR SETTINGS ///

        $wp_customize->add_section( 'pixtheme_style_settings' , array(
            'title'      => esc_html__( 'Colors', 'solutech' ),
            'priority'   => 20,
            'panel' => 'pixtheme_general_panel'
        ) );


        $wp_customize->add_setting( 'pixtheme_style_settings_main_color', array(
            'default' => get_option('pixtheme_default_main_color'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'pixtheme_style_settings_main_color',
                array(
                    'label' => esc_html__( 'Main', 'solutech' ),
                    'section' => 'pixtheme_style_settings',
                    'settings' => 'pixtheme_style_settings_main_color',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_style_settings_gradient_color', array(
            'default' => get_option('pixtheme_default_gradient_color'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'pixtheme_style_settings_gradient_color',
                array(
                    'label' => esc_html__( 'Gradient', 'solutech' ),
                    'section' => 'pixtheme_style_settings',
                    'settings' => 'pixtheme_style_settings_gradient_color',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_gradient_direction' , array(
            'default'     => get_option('pixtheme_default_gradient_direction'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_gradient_direction',
            array(
                'label'    => esc_html__( 'Gradient Direction', 'solutech' ),
                'section'  => 'pixtheme_style_settings',
                'settings' => 'pixtheme_gradient_direction',
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

        $wp_customize->add_setting( 'pixtheme_style_settings_additional_color', array(
            'default' => get_option('pixtheme_default_additional_color'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'pixtheme_style_settings_additional_color',
                array(
                    'label' => esc_html__( 'Additional', 'solutech' ),
                    'section' => 'pixtheme_style_settings',
                    'settings' => 'pixtheme_style_settings_additional_color',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_style_settings_black_color', array(
            'default' => get_option('pixtheme_default_black_color'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'pixtheme_style_settings_black_color',
                array(
                    'label' => esc_html__( 'Black Tone', 'solutech' ),
                    'section' => 'pixtheme_style_settings',
                    'settings' => 'pixtheme_style_settings_black_color',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_style_theme_tone' , array(
            'default'     => '',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_style_theme_tone',
            array(
                'label'    => esc_html__( 'Theme Tone', 'solutech' ),
                'section'  => 'pixtheme_style_settings',
                'settings' => 'pixtheme_style_theme_tone',
                'type'     => 'select',
                'choices'  => array(
                    '' => esc_html__( 'Light', 'solutech' ),
                    'pix-theme-tone-dark' => esc_html__( 'Dark', 'solutech' ),
                ),
            )
        );








        /// FONT SETTINGS ///

        $wp_customize->add_section( 'pixtheme_style_font_settings' , array(
            'title'      => esc_html__( 'Fonts', 'solutech' ),
            'priority'   => 30,
            'panel' => 'pixtheme_general_panel',
        ) );


        $wp_customize->add_setting( 'pixtheme_fonts_embed' , array(
            'default'     => get_option('pixtheme_default_fonts_embed'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'wp_kses_post'
        ) );
        $wp_customize->add_control(
            new PixTheme_Google_Fonts_Loader_Control(
                $wp_customize,
                'pixtheme_fonts_embed',
                array(
                    'label' => esc_html__( 'Google Fonts Embed', 'solutech' ),
                    'description' => wp_kses_post(__('<a href="https://data.true-emotions.studio/images/google_fonts_embed.png" target="_blank" data-lightbox="embed">Get Fonts Embed String</a>', 'solutech')),
                    'type' => 'text',
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_fonts_embed',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_fonts_use_segment', array(
            'default' => 'text',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Segmented_Control(
                $wp_customize,
                'pixtheme_fonts_use_segment',
                array(
                    'label' => esc_html__( 'Fonts & Titles', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_fonts_use_segment',
                    'choices'  => array(
                        'text' => esc_html__( 'Text', 'solutech' ),
                        'title' => esc_html__( 'H1 H2', 'solutech' ),
                        'subtitle' => esc_html__( 'H3 H4', 'solutech' ),
                        'link' => esc_html__( 'Link', 'solutech' ),
                        'button' => esc_html__( 'Button', 'solutech' ),
                    ),
                    'align' => 'center',
                    'type' => 'tabs',
                    'hide_label' => 'hide',
                )
            )
        );


        // Text
        $wp_customize->add_setting( 'pixtheme_font' , array(
            'default'     => get_option('pixtheme_default_font'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            new PixTheme_Google_Font_Control(
                $wp_customize,
                'pixtheme_font',
                array(
                    'label' => esc_html__( 'Font', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font',
                    'weight_id' => 'pixtheme_font_weight',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_font_weight' , array(
            'default'     => get_option('pixtheme_default_font_weight'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'pixtheme_sanitize_text'
        ) );
        $wp_customize->add_control(
            new PixTheme_Google_Font_Weight_Control(
                $wp_customize,
                'pixtheme_font_weight',
                array(
                    'label' => esc_html__( 'Weight', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_weight',
                    'weight_id' => 'pixtheme_font_weight',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_font_size', array(
            'default' => get_option('pixtheme_default_font_size'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_font_size',
                array(
                    'label' => esc_html__( 'Size', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_size',
                    'min' => 10,
                    'max' => 20,
                    'unit'=> 'px',
                )
            )
        );
        
        $wp_customize->add_setting(	'pixtheme_font_line_height', array(
            'default' => get_option('pixtheme_default_font_line_height'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_font_line_height',
                array(
                    'label' => esc_html__( 'Line height', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_line_height',
                    'min' => 0.1,
                    'max' => 3,
                    'step' => 0.005,
                    'unit'=> '',
                )
            )
        );
        
        $wp_customize->add_setting(	'pixtheme_font_ratio', array(
            'default' => get_option('pixtheme_default_font_ratio'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_font_ratio',
                array(
                    'label' => esc_html__( 'Ratio', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_ratio',
                    'min' => 1,
                    'max' => 2.5,
                    'step' => 0.001,
                    'unit'=> '',
                )
            )
        );

        $wp_customize->add_setting(
            'pixtheme_font_color',
            array(
                'default' => get_option('pixtheme_default_font_color'),
                'transport'   => 'postMessage',
                'sanitize_callback' => 'sanitize_hex_color',
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'pixtheme_font_color',
                array(
                    'label' => esc_html__( 'Color', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_color',
                )
            )
        );
        
        $wp_customize->add_setting(
            'pixtheme_font_color_light',
            array(
                'default' => get_option('pixtheme_default_font_color_light'),
                'transport'   => 'postMessage',
                'sanitize_callback' => 'sanitize_hex_color',
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'pixtheme_font_color_light',
                array(
                    'label' => esc_html__( 'Color Light', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_font_color_light',
                )
            )
        );


        // H1 H2
        $wp_customize->add_setting( 'pixtheme_title_font' , array(
            'default'     => get_option('pixtheme_default_title_font'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'pixtheme_sanitize_text'
        ) );
        $wp_customize->add_control(
            new PixTheme_Google_Font_Control(
                $wp_customize,
                'pixtheme_title_font',
                array(
                    'label' => esc_html__( 'Font', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_title_font',
                    'weight_id' => 'pixtheme_title_font_weight',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_title_font_weight' , array(
            'default'     => get_option('pixtheme_default_title_weight'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'pixtheme_sanitize_text'
        ) );
        $wp_customize->add_control(
            new PixTheme_Google_Font_Weight_Control(
                $wp_customize,
                'pixtheme_title_font_weight',
                array(
                    'label' => esc_html__( 'Weight', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_title_font_weight',
                    'weight_id' => 'pixtheme_title_font_weight',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_title_font_size', array(
            'default' => '28',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_title_font_size',
                array(
                    'label' => esc_html__( 'Size', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_title_font_size',
                    'min' => 10,
                    'max' => 70,
                    'unit'=> 'px',
                )
            )
        );

        $wp_customize->add_setting(
            'pixtheme_title_font_color',
            array(
                'default' => get_option('pixtheme_default_title_color'),
                'transport'   => 'postMessage',
                'sanitize_callback' => 'sanitize_hex_color',
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'pixtheme_title_font_color',
                array(
                    'label' => esc_html__( 'Color', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_title_font_color',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_title_font_style' , array(
            'default'     => 'normal',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_title_font_style',
            array(
                'label'    => esc_html__( 'Title Style', 'solutech' ),
                'section'  => 'pixtheme_style_font_settings',
                'settings' => 'pixtheme_title_font_style',
                'type'     => 'select',
                'choices'  => array(
                    'normal' => esc_html__( 'Normal', 'solutech' ),
                    'italic' => esc_html__( 'Italic', 'solutech' ),
                    'oblique' => esc_html__( 'Oblique', 'solutech' ),
                ),
            )
        );

        $wp_customize->add_setting( 'pixtheme_title_letter_spacing', array(
            'default' => '0',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_title_letter_spacing',
                array(
                    'label' => esc_html__( 'Title Letter Spacing', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_title_letter_spacing',
                    'min' => 0,
                    'max' => 30,
                    'unit'=> 'px',
                    'step'=> '0.25',
                )
            )
        );
        
        
        // H3 H4
        $wp_customize->add_setting( 'pixtheme_subtitle_font' , array(
            'default'     => get_option('pixtheme_default_subtitle_font'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'pixtheme_sanitize_text'
        ) );
        $wp_customize->add_control(
            new PixTheme_Google_Font_Control(
                $wp_customize,
                'pixtheme_subtitle_font',
                array(
                    'label' => esc_html__( 'Font', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_subtitle_font',
                    'weight_id' => 'pixtheme_subtitle_font_weight',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_subtitle_font_weight' , array(
            'default'     => get_option('pixtheme_default_subtitle_weight'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'pixtheme_sanitize_text'
        ) );
        $wp_customize->add_control(
            new PixTheme_Google_Font_Weight_Control(
                $wp_customize,
                'pixtheme_subtitle_font_weight',
                array(
                    'label' => esc_html__( 'Weight', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_subtitle_font_weight',
                    'weight_id' => 'pixtheme_subtitle_font_weight',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_subtitle_font_size', array(
            'default' => '20',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_subtitle_font_size',
                array(
                    'label' => esc_html__( 'Size', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_subtitle_font_size',
                    'min' => 10,
                    'max' => 70,
                    'unit'=> 'px',
                )
            )
        );

        $wp_customize->add_setting(
            'pixtheme_subtitle_font_color',
            array(
                'default' => get_option('pixtheme_default_subtitle_color'),
                'transport'   => 'postMessage',
                'sanitize_callback' => 'sanitize_hex_color',
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'pixtheme_subtitle_font_color',
                array(
                    'label' => esc_html__( 'Color', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_subtitle_font_color',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_subtitle_font_style' , array(
            'default'     => 'normal',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_subtitle_font_style',
            array(
                'label'    => esc_html__( 'Style', 'solutech' ),
                'section'  => 'pixtheme_style_font_settings',
                'settings' => 'pixtheme_subtitle_font_style',
                'type'     => 'select',
                'choices'  => array(
                    'normal' => esc_html__( 'Normal', 'solutech' ),
                    'italic' => esc_html__( 'Italic', 'solutech' ),
                    'oblique' => esc_html__( 'Oblique', 'solutech' ),
                ),
            )
        );

        $wp_customize->add_setting( 'pixtheme_subtitle_letter_spacing', array(
            'default' => '0',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_subtitle_letter_spacing',
                array(
                    'label' => esc_html__( 'Letter Spacing', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_subtitle_letter_spacing',
                    'min' => 0,
                    'max' => 30,
                    'unit'=> 'px',
                    'step'=> '0.25',
                )
            )
        );


        // Link
        $wp_customize->add_setting( 'pixtheme_link_font' , array(
            'default'     => get_option('pixtheme_default_link_font'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'pixtheme_sanitize_text'
        ) );
        $wp_customize->add_control(
            new PixTheme_Google_Font_Control(
                $wp_customize,
                'pixtheme_link_font',
                array(
                    'label' => esc_html__( 'Font', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_link_font',
                    'weight_id' => 'pixtheme_link_font_weight',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_link_font_weight' , array(
            'default'     => get_option('pixtheme_default_link_weight'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'pixtheme_sanitize_text'
        ) );
        $wp_customize->add_control(
            new PixTheme_Google_Font_Weight_Control(
                $wp_customize,
                'pixtheme_link_font_weight',
                array(
                    'label' => esc_html__( 'Weight', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_link_font_weight',
                    'weight_id' => 'pixtheme_link_font_weight',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_link_font_size', array(
            'default' => get_option('pixtheme_default_link_size'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_link_font_size',
                array(
                    'label' => esc_html__( 'Size', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_link_font_size',
                    'min' => 10,
                    'max' => 30,
                    'unit'=> 'px',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_link_font_style' , array(
            'default'     => 'normal',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_link_font_style',
            array(
                'label'    => esc_html__( 'Style', 'solutech' ),
                'section'  => 'pixtheme_style_font_settings',
                'settings' => 'pixtheme_link_font_style',
                'type'     => 'select',
                'choices'  => array(
                    'normal' => esc_html__( 'Normal', 'solutech' ),
                    'italic' => esc_html__( 'Italic', 'solutech' ),
                    'oblique' => esc_html__( 'Oblique', 'solutech' ),
                ),
            )
        );

        $wp_customize->add_setting(
            'pixtheme_link_font_color',
            array(
                'default' => get_option('pixtheme_default_link_color'),
                'transport'   => 'postMessage',
                'sanitize_callback' => 'sanitize_hex_color',
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'pixtheme_link_font_color',
                array(
                    'label' => esc_html__( 'Color', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_link_font_color',
                )
            )
        );


        // Button
        $wp_customize->add_setting( 'pixtheme_buttons_font' , array(
            'default'     => get_option('pixtheme_default_font'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'pixtheme_sanitize_text'
        ) );
        $wp_customize->add_control(
            new PixTheme_Google_Font_Control(
                $wp_customize,
                'pixtheme_buttons_font',
                array(
                    'label' => esc_html__( 'Font', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_buttons_font',
                    'weight_id' => 'pixtheme_buttons_font_weight',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_buttons_font_weight' , array(
            'default'     => get_option('pixtheme_default_button_font_weight'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            new PixTheme_Google_Font_Weight_Control(
                $wp_customize,
                'pixtheme_buttons_font_weight',
                array(
                    'label' => esc_html__( 'Weight', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_buttons_font_weight',
                    'weight_id' => 'pixtheme_buttons_font_weight',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_buttons_font_size', array(
            'default' => get_option('pixtheme_default_button_font_size'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_buttons_font_size',
                array(
                    'label' => esc_html__( 'Size', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_buttons_font_size',
                    'min' => 10,
                    'max' => 30,
                    'unit'=> 'px',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_buttons_font_style' , array(
            'default'     => 'normal',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_buttons_font_style',
            array(
                'label'    => esc_html__( 'Style', 'solutech' ),
                'section'  => 'pixtheme_style_font_settings',
                'settings' => 'pixtheme_buttons_font_style',
                'type'     => 'select',
                'choices'  => array(
                    'normal' => esc_html__( 'Normal', 'solutech' ),
                    'italic' => esc_html__( 'Italic', 'solutech' ),
                    'oblique' => esc_html__( 'Oblique', 'solutech' ),
                ),
            )
        );

        $wp_customize->add_setting( 'pixtheme_buttons_text_transform' , array(
            'default'     => 'none',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_buttons_text_transform',
            array(
                'label'    => esc_html__( 'Text Transform', 'solutech' ),
                'section'  => 'pixtheme_style_font_settings',
                'settings' => 'pixtheme_buttons_text_transform',
                'type'     => 'select',
                'choices'  => array(
                    'none' => esc_html__( 'None', 'solutech' ),
                    'uppercase' => esc_html__( 'UPPERCASE', 'solutech' ),
                    'capitalize' => esc_html__( 'Capitalize', 'solutech' ),
                    'lowercase' => esc_html__( 'lowercase', 'solutech' ),
                ),
            )
        );

        $wp_customize->add_setting( 'pixtheme_buttons_letter_spacing', array(
            'default' => '0',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_buttons_letter_spacing',
                array(
                    'label' => esc_html__( 'Letter Spacing', 'solutech' ),
                    'section' => 'pixtheme_style_font_settings',
                    'settings' => 'pixtheme_buttons_letter_spacing',
                    'min' => 0,
                    'max' => 10,
                    'unit'=> 'px',
                    'step'=> '0.1',
                )
            )
        );








        /// DECOR SETTINGS ///

        $wp_customize->add_section( 'pixtheme_decor_settings' , array(
            'title'      => esc_html__( 'Decor', 'solutech' ),
            'priority'   => 35,
            'panel' => 'pixtheme_general_panel',
        ) );

        $wp_customize->add_setting( 'pixtheme_decor_show' , array(
            'default'     => get_option('pixtheme_default_decor'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_decor_show',
            array(
                'label'    => esc_html__( 'Show Decor', 'solutech' ),
                'section'  => 'pixtheme_decor_settings',
                'settings' => 'pixtheme_decor_show',
                'type'     => 'select',
                'choices'  => array(
                    '1' => esc_html__( 'Yes', 'solutech' ),
                    '0' => esc_html__( 'No', 'solutech' ),
                ),
            )
        );

        $wp_customize->add_setting( 'pixtheme_decor_img' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	            'pixtheme_decor_img',
				array(
				   'label'      => esc_html__( 'Decor', 'solutech' ),
				   'section'    => 'pixtheme_decor_settings',
				   'settings'   => 'pixtheme_decor_img',
				)
	       )
	    );

        $wp_customize->add_setting(	'pixtheme_decor_width', array(
            'default' => '40',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_decor_width',
                array(
                    'label' => esc_html__( 'Width', 'solutech' ),
                    'section' => 'pixtheme_decor_settings',
                    'settings' => 'pixtheme_decor_width',
                    'min' => 0,
                    'max' => 100,
                    'unit'=> 'px',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_decor_height', array(
            'default' => '10',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_decor_height',
                array(
                    'label' => esc_html__( 'Height', 'solutech' ),
                    'section' => 'pixtheme_decor_settings',
                    'settings' => 'pixtheme_decor_height',
                    'min' => 0,
                    'max' => 50,
                    'unit'=> 'px',
                )
            )
        );





        /// BUTTONS SETTINGS ///

        $wp_customize->add_section( 'pixtheme_buttons_settings' , array(
            'title'      => esc_html__( 'Buttons', 'solutech' ),
            'priority'   => 40,
            'panel' => 'pixtheme_general_panel',
        ) );

        $wp_customize->add_setting( 'pixtheme_buttons_shape' , array(
		    'default'     => get_option('pixtheme_default_button_shape'),
		    'transport'   => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
			'pixtheme_buttons_shape',
			array(
				'label'    => esc_html__( 'Shape', 'solutech' ),
				'section'  => 'pixtheme_buttons_settings',
				'settings' => 'pixtheme_buttons_shape',
				'type'     => 'select',
				'choices'  => array(
					'pix-square'  => esc_html__( 'Square', 'solutech' ),
					'pix-rounded' => esc_html__( 'Rounded', 'solutech' ),
					'pix-round' => esc_html__( 'Round', 'solutech' ),
				),
			)
		);
        
        $wp_customize->add_setting( 'pixtheme_buttons_color' , array(
            'default'     => get_option('pixtheme_default_button_color'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            'pixtheme_buttons_color',
            array(
                'label'    => esc_html__( 'Color', 'solutech' ),
                'section'  => 'pixtheme_buttons_settings',
                'settings' => 'pixtheme_buttons_color',
                'type'     => 'select',
                'choices'  => array(
                    'main' => esc_html__( 'Main Color', 'solutech' ),
                    'additional' => esc_html__( 'Additional Color', 'solutech' ),
                    'gradient' => esc_html__( 'Gradient', 'solutech' ),
                    'white' => esc_html__( 'White', 'solutech' ),
                    'black' => esc_html__( 'Black', 'solutech' ),
                ),
            )
        );

		$wp_customize->add_setting(	'pixtheme_buttons_border', array(
            'default' => get_option('pixtheme_default_button_border'),
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_buttons_border',
                array(
                    'label' => esc_html__( 'Border Width', 'solutech' ),
                    'section' => 'pixtheme_buttons_settings',
                    'settings' => 'pixtheme_buttons_border',
                    'min' => 1,
                    'max' => 5,
                    'unit'=> 'px',
                )
            )
        );
        
        $wp_customize->add_setting( 'pixtheme_buttons_shadow' , array(
            'default'     => '0',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'pixtheme_buttons_shadow',
            array(
                'label'    => esc_html__( 'Shadow', 'solutech' ),
                'section'  => 'pixtheme_buttons_settings',
                'settings' => 'pixtheme_buttons_shadow',
                'type'     => 'select',
                'choices'  => array(
                    '1' => esc_html__( 'Yes', 'solutech' ),
                    '0' => esc_html__( 'No', 'solutech' ),
                ),
            )
        );

        $wp_customize->add_setting(	'pixtheme_buttons_shadow_h', array(
            'default' => '0',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_buttons_shadow_h',
                array(
                    'label' => esc_html__( 'Horizontal Position', 'solutech' ),
                    'section' => 'pixtheme_buttons_settings',
                    'settings' => 'pixtheme_buttons_shadow_h',
                    'min' => -100,
                    'max' => 100,
                    'unit'=> 'px',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_buttons_shadow_v', array(
            'default' => '0',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_buttons_shadow_v',
                array(
                    'label' => esc_html__( 'Vertical Position', 'solutech' ),
                    'section' => 'pixtheme_buttons_settings',
                    'settings' => 'pixtheme_buttons_shadow_v',
                    'min' => -100,
                    'max' => 100,
                    'unit'=> 'px',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_buttons_shadow_blur', array(
            'default' => '0',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_buttons_shadow_blur',
                array(
                    'label' => esc_html__( 'Blur', 'solutech' ),
                    'section' => 'pixtheme_buttons_settings',
                    'settings' => 'pixtheme_buttons_shadow_blur',
                    'min' => 0,
                    'max' => 100,
                    'unit'=> 'px',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_buttons_shadow_spread', array(
            'default' => '0',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_buttons_shadow_spread',
                array(
                    'label' => esc_html__( 'Spread', 'solutech' ),
                    'section' => 'pixtheme_buttons_settings',
                    'settings' => 'pixtheme_buttons_shadow_spread',
                    'min' => -100,
                    'max' => 100,
                    'unit'=> 'px',
                )
            )
        );

        $wp_customize->add_setting(	'pixtheme_buttons_shadow_color', array(
            'default' => '#333',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'pixtheme_buttons_shadow_color',
                array(
                    'label' => esc_html__( 'Color', 'solutech' ),
                    'section' => 'pixtheme_buttons_settings',
                    'settings' => 'pixtheme_buttons_shadow_color',
                )
            )
        );

        $wp_customize->add_setting( 'pixtheme_buttons_shadow_opacity' , array(
            'default'     => '100',
            'transport'   => 'postMessage',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            new PixTheme_Slider_Single_Control(
                $wp_customize,
                'pixtheme_buttons_shadow_opacity',
                array(
                    'label' => esc_html__( 'Opacity', 'solutech' ),
                    'section' => 'pixtheme_buttons_settings',
                    'settings' => 'pixtheme_buttons_shadow_opacity',
                    'min' => 0,
                    'max' => 100,
                    'unit'=> '%',
                )
            )
        );






        /// OTHER SETTINGS ///

        $wp_customize->add_section( 'pixtheme_other_settings' , array(
            'title'      => esc_html__( 'Other', 'solutech' ),
            'priority'   => 100,
            'panel' => 'pixtheme_general_panel',
        ) );

        $wp_customize->add_setting( 'pixtheme_theme_boxes_shape' , array(
		    'default'     => 'pix-rounded',
		    'transport'   => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
			'pixtheme_theme_boxes_shape',
			array(
				'label'    => esc_html__( 'Boxes Shape', 'solutech' ),
				'section'  => 'pixtheme_other_settings',
				'settings' => 'pixtheme_theme_boxes_shape',
				'type'     => 'select',
				'choices'  => array(
					'pix-square'  => esc_html__( 'Square', 'solutech' ),
					'pix-rounded' => esc_html__( 'Rounded', 'solutech' ),
					'pix-round' => esc_html__( 'Round', 'solutech' ),
				),
			)
		);

        $wp_customize->add_setting( 'pixtheme_general_settings_loader' , array(
		    'default'     => 'useall',
		    'transport'   => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
			'pixtheme_general_settings_loader',
			array(
				'label'    => esc_html__( 'Page Loader', 'solutech' ),
				'section'  => 'pixtheme_other_settings',
				'settings' => 'pixtheme_general_settings_loader',
				'type'     => 'select',
				'choices'  => array(
					'off'  => esc_html__( 'Off', 'solutech' ),
					'usemain' => esc_html__( 'Use on main', 'solutech' ),
					'useall' => esc_html__( 'Use on all pages', 'solutech' ),
				),
			)
		);

		$wp_customize->add_setting( 'pixtheme_loader_img' , array(
			'default'     => '',
			'transport'   => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	            'pixtheme_loader_img',
				array(
				   'label'      => esc_html__( 'Loader Image', 'solutech' ),
				   'section'    => 'pixtheme_other_settings',
				   'settings'   => 'pixtheme_loader_img',
				)
	       )
	    );

		
		
	}
	
	