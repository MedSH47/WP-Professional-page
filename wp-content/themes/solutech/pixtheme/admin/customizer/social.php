<?php
    function pixtheme_customize_social_tab($wp_customize, $theme_name){

        $wp_customize->add_section( 'pixtheme_social_settings' , array(
            'title'      => esc_html__( 'Social', 'solutech' ),
            'priority'   => 70,
        ) );

        $wp_customize->add_setting( 'pixtheme_social_facebook' , array(
		    'default'     => '',
		    'transport'   => 'postMessage',
			'sanitize_callback' => 'esc_url'
		) );

		$wp_customize->add_setting( 'pixtheme_social_twitter' , array(
		    'default'     => '',
		    'transport'   => 'postMessage',
			'sanitize_callback' => 'esc_url'
		) );

		$wp_customize->add_setting( 'pixtheme_social_instagram' , array(
		    'default'     => '',
		    'transport'   => 'postMessage',
			'sanitize_callback' => 'esc_url'
		) );

		$wp_customize->add_setting( 'pixtheme_social_youtube' , array(
		    'default'     => '',
		    'transport'   => 'postMessage',
			'sanitize_callback' => 'esc_url'
		) );

		$wp_customize->add_setting( 'pixtheme_social_pinterest' , array(
		    'default'     => '',
		    'transport'   => 'postMessage',
			'sanitize_callback' => 'esc_url'
		) );

		$wp_customize->add_setting( 'pixtheme_social_custom_icon_1' , array(
		    'default'     => '',
		    'transport'   => 'postMessage',
			'sanitize_callback' => 'esc_attr'
		) );

		$wp_customize->add_setting( 'pixtheme_social_custom_url_1' , array(
		    'default'     => '',
		    'transport'   => 'postMessage',
			'sanitize_callback' => 'esc_url'
		) );

		$wp_customize->add_setting( 'pixtheme_social_custom_icon_2' , array(
		    'default'     => '',
		    'transport'   => 'postMessage',
			'sanitize_callback' => 'esc_attr'
		) );

		$wp_customize->add_setting( 'pixtheme_social_custom_url_2' , array(
		    'default'     => '',
		    'transport'   => 'postMessage',
			'sanitize_callback' => 'esc_url'
		) );

		$wp_customize->add_setting( 'pixtheme_social_custom_icon_3' , array(
		    'default'     => '',
		    'transport'   => 'postMessage',
			'sanitize_callback' => 'esc_attr'
		) );

		$wp_customize->add_setting( 'pixtheme_social_custom_url_3' , array(
		    'default'     => '',
		    'transport'   => 'postMessage',
			'sanitize_callback' => 'esc_url'
		) );


        $wp_customize->add_control(
			'pixtheme_social_facebook',
			array(
				'label'    => esc_html__( 'Facebook URL', 'solutech' ),
				'section'  => 'pixtheme_social_settings',
				'settings' => 'pixtheme_social_facebook',
				'type'     => 'url',
			)
		);

		$wp_customize->add_control(
			'pixtheme_social_twitter',
			array(
				'label'    => esc_html__( 'Twitter URL', 'solutech' ),
				'section'  => 'pixtheme_social_settings',
				'settings' => 'pixtheme_social_twitter',
				'type'     => 'url',
			)
		);

		$wp_customize->add_control(
			'pixtheme_social_instagram',
			array(
				'label'    => esc_html__( 'Instagram URL', 'solutech' ),
				'section'  => 'pixtheme_social_settings',
				'settings' => 'pixtheme_social_instagram',
				'type'     => 'url',
			)
		);

		$wp_customize->add_control(
			'pixtheme_social_youtube',
			array(
				'label'    => esc_html__( 'YouTube URL', 'solutech' ),
				'section'  => 'pixtheme_social_settings',
				'settings' => 'pixtheme_social_youtube',
				'type'     => 'url',
			)
		);

        $wp_customize->add_control(
			'pixtheme_social_pinterest',
			array(
				'label'    => esc_html__( 'Pinterest URL', 'solutech' ),
				'section'  => 'pixtheme_social_settings',
				'settings' => 'pixtheme_social_pinterest',
				'type'     => 'url',
			)
		);

		$wp_customize->add_control(
			'pixtheme_social_custom_icon_1',
			array(
				'label'    => esc_html__( 'Custom Icon 1', 'solutech' ),
				'section'  => 'pixtheme_social_settings',
				'settings' => 'pixtheme_social_custom_icon_1',
				'type'     => 'text',
			)
		);

		$wp_customize->add_control(
			'pixtheme_social_custom_url_1',
			array(
				'label'    => esc_html__( 'Custom URL 1', 'solutech' ),
				'section'  => 'pixtheme_social_settings',
				'settings' => 'pixtheme_social_custom_url_1',
				'type'     => 'url',
			)
		);

		$wp_customize->add_control(
			'pixtheme_social_custom_icon_2',
			array(
				'label'    => esc_html__( 'Custom Icon 2', 'solutech' ),
				'section'  => 'pixtheme_social_settings',
				'settings' => 'pixtheme_social_custom_icon_2',
				'type'     => 'text',
			)
		);

		$wp_customize->add_control(
			'pixtheme_social_custom_url_2',
			array(
				'label'    => esc_html__( 'Custom URL 2', 'solutech' ),
				'section'  => 'pixtheme_social_settings',
				'settings' => 'pixtheme_social_custom_url_2',
				'type'     => 'url',
			)
		);

		$wp_customize->add_control(
			'pixtheme_social_custom_icon_3',
			array(
				'label'    => esc_html__( 'Custom Icon 3', 'solutech' ),
				'section'  => 'pixtheme_social_settings',
				'settings' => 'pixtheme_social_custom_icon_3',
				'type'     => 'text',
			)
		);

		$wp_customize->add_control(
			'pixtheme_social_custom_url_3',
			array(
				'label'    => esc_html__( 'Custom URL 3', 'solutech' ),
				'section'  => 'pixtheme_social_settings',
				'settings' => 'pixtheme_social_custom_url_3',
				'type'     => 'url',
			)
		);


    }
?>