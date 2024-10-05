<?php
function pixtheme_customize_services_tab($wp_customize, $theme_name) {

	$wp_customize->add_section( 'pixtheme_services_settings' , array(
        'title'      => esc_html__( 'Services', 'solutech' ),
        'priority'   => 60,
    ) );

	$wp_customize->add_setting( 'pixtheme_services_settings_page', array(
		'default'           => '0',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_setting( 'pixtheme_services_settings_related', array(
			'default'           => 1,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_attr'
	) );

	$wp_customize->add_setting( 'pixtheme_services_settings_share', array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_attr'
	) );


	$wp_customize->add_control( 'pixtheme_services_settings_page', array(
		'label'    => esc_html__( 'Select Page For All Services', 'solutech' ),
		'section'  => 'pixtheme_services_settings',
		'type'     => 'dropdown-pages'
	) );

	$wp_customize->add_control( 'pixtheme_services_settings_related', array(
        'label'    => esc_html__( 'Display Related Services', 'solutech' ),
        'section'  => 'pixtheme_services_settings',
        'settings' => 'pixtheme_services_settings_related',
        'type'     => 'select',
        'choices'  => array(
            '1' => esc_html__( 'On', 'solutech' ),
            '0'  => esc_html__( 'Off', 'solutech' ),
        ),
        'priority'   => 20
	) );

    $wp_customize->add_control( 'pixtheme_services_settings_share', array(
            'label'    => esc_html__( 'Display Share on Services', 'solutech' ),
            'section'  => 'pixtheme_services_settings',
            'settings' => 'pixtheme_services_settings_share',
            'type'     => 'select',
            'choices'  => array(
                '1' => esc_html__( 'On', 'solutech' ),
                '0'  => esc_html__( 'Off', 'solutech' ),
            ),
            'priority'   => 30
    ) );

}