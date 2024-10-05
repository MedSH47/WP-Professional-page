<?php

	function pixtheme_customize_responsive_tab($wp_customize, $theme_name){
	
		$wp_customize->add_section( 'pixtheme_responsive_settings' , array(
		    'title'      => esc_html__( 'Responsive', 'solutech' ),
		    'priority'   => 35,
		) );

		$wp_customize->add_setting( 'pixtheme_general_settings_responsive' , array(
		    'default'     => '',
		    'transport'   => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		

		$wp_customize->add_control(
			'pixtheme_general_settings_responsive',
			array(
				'label'    => esc_html__( 'Responsive', 'solutech' ),
				'section'  => 'pixtheme_responsive_settings',
				'settings' => 'pixtheme_general_settings_responsive',
				'type'     => 'select',
				'choices'  => array(
					'off'  => esc_html__( 'Off', 'solutech' ),
					'on'   => esc_html__( 'On', 'solutech' ),
				),
				'priority'   => 5
			)
		);
		
	}
		
?>