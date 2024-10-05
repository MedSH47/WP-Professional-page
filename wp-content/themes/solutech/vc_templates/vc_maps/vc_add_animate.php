<?php

    $data_animation = vc_map_add_css_animation();
    $data_animation['dependency'] = array(
        'element' => 'is_animate',
        'value' => 'on',
    );
    $data_animation['group'] = esc_html__( 'Animation', 'solutech' );

	
	$add_animation = array(
		array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'Animation', 'solutech' ),
            'param_name' => 'is_animate',
            'value' => 'off',
            'group' => esc_html__( 'Animation', 'solutech' ),
        ),
		$data_animation,
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Duration', 'solutech' ),
			'param_name' => 'wow_duration',
			'value' => '',
			'description' => esc_html__( 'Change the animation duration in seconds.', 'solutech' ),
			'dependency' => array(
				'element' => 'is_animate',
				'value' => 'on',
			),
            'group' => esc_html__( 'Animation', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-3',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Delay', 'solutech' ),
			'param_name' => 'wow_delay',
			'value' => '',
			'description' => esc_html__( 'Delay before the animation starts in seconds.', 'solutech' ),
			'dependency' => array(
				'element' => 'is_animate',
				'value' => 'on',
			),
            'group' => esc_html__( 'Animation', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-3',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Offset', 'solutech' ),
			'param_name' => 'wow_offset',
			'value' => '',
			'description' => esc_html__( 'Distance to start the animation (related to the browser bottom) in pixels.', 'solutech' ),
			'dependency' => array(
				'element' => 'is_animate',
				'value' => 'on',
			),
            'group' => esc_html__( 'Animation', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-3',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Iteration', 'solutech' ),
			'param_name' => 'wow_iteration',
			'value' => '',
			'description' => esc_html__( 'Number of times the animation is repeated.', 'solutech' ),
			'dependency' => array(
				'element' => 'is_animate',
				'value' => 'on',
			),
            'group' => esc_html__( 'Animation', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-3',
		),
	);

	$add_animation_group = array(
	    array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'Animation', 'solutech' ),
            'param_name' => 'is_animate',
            'value' => 'off',
            'group' => esc_html__( 'Animation', 'solutech' ),
        ),
		$data_animation,
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Items in Group', 'solutech' ),
			'param_name' => 'wow_group',
			'value' => '',
			'description' => esc_html__( 'Items number in animated group.', 'solutech' ),
			'dependency' => array(
				'element' => 'is_animate',
				'value' => 'on',
			),
            'group' => esc_html__( 'Animation', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Group Delay Offset', 'solutech' ),
			'param_name' => 'wow_group_delay',
			'value' => '',
			'description' => esc_html__( 'Offset delay before the next group animation starts in seconds.', 'solutech' ),
			'dependency' => array(
				'element' => 'is_animate',
				'value' => 'on',
			),
            'group' => esc_html__( 'Animation', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Duration', 'solutech' ),
			'param_name' => 'wow_duration',
			'value' => '',
			'description' => esc_html__( 'Change the animation duration in seconds.', 'solutech' ),
			'dependency' => array(
				'element' => 'is_animate',
				'value' => 'on',
			),
            'group' => esc_html__( 'Animation', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-3',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Delay', 'solutech' ),
			'param_name' => 'wow_delay',
			'value' => '',
			'description' => esc_html__( 'Delay before the animation starts in seconds.', 'solutech' ),
			'dependency' => array(
				'element' => 'is_animate',
				'value' => 'on',
			),
            'group' => esc_html__( 'Animation', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-3',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Offset', 'solutech' ),
			'param_name' => 'wow_offset',
			'value' => '',
			'description' => esc_html__( 'Distance to start the animation (related to the browser bottom) in pixels.', 'solutech' ),
			'dependency' => array(
				'element' => 'is_animate',
				'value' => 'on',
			),
            'group' => esc_html__( 'Animation', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-3',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Iteration', 'solutech' ),
			'param_name' => 'wow_iteration',
			'value' => '',
			'description' => esc_html__( 'Number of times the animation is repeated.', 'solutech' ),
			'dependency' => array(
				'element' => 'is_animate',
				'value' => 'on',
			),
            'group' => esc_html__( 'Animation', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-3',
		),
	);
	
    vc_remove_param( 'vc_column', 'css_animation' );
	vc_add_params( 'vc_column', $add_animation );
	
	vc_add_params( 'common_title', $add_animation );
	vc_add_params( 'common_icon_box', $add_animation );
	vc_add_params( 'common_timeline', $add_animation );
	vc_add_params( 'common_timeline_option', $add_animation );

	vc_add_params( 'cars_latest_offers', $add_animation_group );
	vc_add_params( 'common_price_table', $add_animation_group );
    vc_add_params( 'common_reviews', $add_animation_group );
    vc_add_params( 'common_team', $add_animation_group );
    vc_add_params( 'common_special_offers', $add_animation_group );
    vc_add_params( 'common_isotope', $add_animation_group );
    vc_add_params( 'common_slider', $add_animation_group );

?>