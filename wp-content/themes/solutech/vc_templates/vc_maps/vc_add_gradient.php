<?php

    $padding_attr = array(
        array(
            'type' => 'segmented_button',
            'holder' => 'div',
            'class' => 'pix-padding-vc-row pix-top',
            'heading' => esc_html__( 'Padding Top', 'solutech' ),
            'param_name' => 'pix_padding_top',
            'value' => array(
                'default' => 'padding L',
                esc_html__( 'No Padding', 'solutech' ) => 'padding No',
                esc_html__( 'S', 'solutech' ) => 'padding S',
                esc_html__( 'M', 'solutech' ) => 'padding M',
                esc_html__( 'L', 'solutech' ) => 'padding L',
                esc_html__( 'XL', 'solutech' ) => 'padding XL',
            ),
            'group' => esc_html__( 'PixSettings', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-6',
        ),
        array(
            'type' => 'segmented_button',
            'holder' => 'div',
            'class' => 'pix-padding-vc-row pix-bottom',
            'heading' => esc_html__( 'Padding Bottom', 'solutech' ),
            'param_name' => 'pix_padding_bottom',
            'value' => array(
                'default' => 'padding L',
                esc_html__( 'No Padding', 'solutech' ) => 'padding No',
                esc_html__( 'S', 'solutech' ) => 'padding S',
                esc_html__( 'M', 'solutech' ) => 'padding M',
                esc_html__( 'L', 'solutech' ) => 'padding L',
                esc_html__( 'XL', 'solutech' ) => 'padding XL',
            ),
            'group' => esc_html__( 'PixSettings', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-6',
        ),
    );

    $padding_no_attr = array(
        array(
            'type' => 'segmented_button',
            'class' => 'pix-padding-vc-row pix-top',
            'heading' => esc_html__( 'Padding Top', 'solutech' ),
            'param_name' => 'pix_padding_top',
            'value' => array(
                'default' => 'padding No',
                esc_html__( 'No Padding', 'solutech' ) => 'padding No',
                esc_html__( 'S', 'solutech' ) => 'padding S',
                esc_html__( 'M', 'solutech' ) => 'padding M',
                esc_html__( 'L', 'solutech' ) => 'padding L',
                esc_html__( 'XL', 'solutech' ) => 'padding XL',
            ),
            'group' => esc_html__( 'PixSettings', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-6',
        ),
        array(
            'type' => 'segmented_button',
            'class' => 'pix-padding-vc-row pix-bottom',
            'heading' => esc_html__( 'Padding Bottom', 'solutech' ),
            'param_name' => 'pix_padding_bottom',
            'value' => array(
                'default' => 'padding No',
                esc_html__( 'No Padding', 'solutech' ) => 'padding No',
                esc_html__( 'S', 'solutech' ) => 'padding S',
                esc_html__( 'M', 'solutech' ) => 'padding M',
                esc_html__( 'L', 'solutech' ) => 'padding L',
                esc_html__( 'XL', 'solutech' ) => 'padding XL',
            ),
            'group' => esc_html__( 'PixSettings', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-6',
        ),
    );

	$row_attr = array(
        array(
            'type' => 'segmented_button',
            'heading' => esc_html__( 'Container Shape', 'solutech' ),
            'param_name' => 'radius',
            'value' => array(
                'default' => 'default',
                esc_html__( 'Square', 'solutech' ) => 'default',
                esc_html__( 'Rounded', 'solutech' ) => 'pix-rounded',
                esc_html__( 'Round', 'solutech' ) => 'pix-round',
            ),
            'group' => esc_html__( 'PixSettings', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-6',
        ),
        array(
            'type' => 'segmented_button',
            'heading' => esc_html__( 'Text Color', 'solutech' ),
            'param_name' => 'ptextcolor',
            'value' => array(
                'default' => 'Default',
                esc_html__( 'Default', 'solutech' ) => 'Default',
                esc_html__( 'Light', 'solutech' ) => 'White',
                esc_html__( 'Dark', 'solutech' ) => 'Black',
            ),
            'group' => esc_html__( 'PixSettings', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-6',
        ),
		array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'Overflow Visible', 'solutech' ),
            'param_name' => 'overflow',
            'value' => 'off',
            'group' => esc_html__( 'PixSettings', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-6',
        ),
        array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Top offset', 'solutech' ),
			'param_name' => 'top_offset',
			'value' => '',
			'description' => esc_html__( 'The value can be negative (example: -50px)', 'solutech' ),
			'dependency' => array(
				'element' => 'overflow',
				'value' => 'on',
			),
			'group' => esc_html__( 'PixSettings', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-6',
		),

    );

	$stretch_attr = array(
	    array(
            'type' => 'segmented_button',
            'heading' => esc_html__( 'Not Stretch Content Alignment', 'solutech' ),
            'param_name' => 'pix_not_stretch_content',
            'value' => array(
                'default' => 'off',
                esc_html__( 'Off', 'solutech' ) => 'off',
                esc_html__( 'Left', 'solutech' ) => 'pix-col-content-left',
                esc_html__( 'Center', 'solutech' ) => 'pix-col-content-center',
                esc_html__( 'Right', 'solutech' ) => 'pix-col-content-right',
            ),
            'description' => esc_html__( 'If you don\'t want to stretch content in column with row setting \'Stretch row and content\'.', 'solutech' ),
            'group' => esc_html__( 'PixSettings', 'solutech' ),
        ),
    );
    $column_attr = array(
        array(
            'type' => 'segmented_button',
            'heading' => esc_html__( 'Text Color', 'solutech' ),
            'param_name' => 'ptextcolor',
            'value' => array(
                'default' => 'Default',
                esc_html__( 'Default', 'solutech' ) => 'Default',
                esc_html__( 'Light', 'solutech' ) => 'White',
                esc_html__( 'Dark', 'solutech' ) => 'Black',
            ),
            'group' => esc_html__( 'PixSettings', 'solutech' ),
        ),
    );


    $gradient_attr = array(
		// Gradient
        array(
            'type' => 'param_group',
            'value' => '',
            'heading' => esc_html__( 'Gradient', 'solutech' ),
            'param_name' => 'gradient_colors',
            // Note params is mapped inside param-group:
            'params' => array(
                array(
                    'type' => 'colorpicker',
                    'value' => '',
                    'heading' => esc_html__( 'Color For Gradient', 'solutech' ),
                    'param_name' => 'gradient_color',
                )
            ),
		    'group' => esc_html__( 'Gradient', 'solutech' ),
        ),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Direction', 'solutech' ),
			'param_name' => 'gradient_direction',
			'value' => array(
				esc_html__( 'To Right ', 'solutech' ).html_entity_decode('&rarr;') => 'to right',
				esc_html__( 'To Left ', 'solutech' ).html_entity_decode('&larr;') => 'to left',
				esc_html__( 'To Bottom ', 'solutech' ).html_entity_decode('&darr;') => 'to bottom',
				esc_html__( 'To Top ', 'solutech' ).html_entity_decode('&uarr;') => 'to top',
				esc_html__( 'To Bottom Right ', 'solutech' ).html_entity_decode('&#8600;') => 'to bottom right',
				esc_html__( 'To Bottom Left ', 'solutech' ).html_entity_decode('&#8601;') => 'to bottom left',
				esc_html__( 'To Top Right ', 'solutech' ).html_entity_decode('&#8599;') => 'to top right',
				esc_html__( 'To Top Left ', 'solutech' ).html_entity_decode('&#8598;') => 'to top left',
				esc_html__( 'Angle ', 'solutech' ).html_entity_decode('&#10227;') => 'angle',
			),
			'description' => '',
			'group' => esc_html__( 'Gradient', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-4',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Angle Direction', 'solutech' ),
			'param_name' => 'gradient_angle',
			'value' => '90',
			'description' => esc_html__( 'Values -360 - 360', 'solutech' ),
			'dependency' => array(
				'element' => 'gradient_direction',
				'value' => 'angle',
			),
			'group' => esc_html__( 'Gradient', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-4',
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Opacity', 'solutech' ),
			'param_name' => 'gradient_opacity',
			'value' => '1',
			'description' => esc_html__( 'Values 0.01 - 0.99', 'solutech' ),
			'group' => esc_html__( 'Gradient', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-4',
		),
        
	);


	$decor_attr = array(
        
        // Decors
        // Top Decor
        array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'Show Top Decor', 'solutech' ),
            'param_name' => 'pdecor',
            'value' => 'off',
            'description' => esc_html__( 'Show decor at the top of the section.', 'solutech' ),
            'group' => esc_html__( 'Decor', 'solutech' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Height', 'solutech' ),
            'param_name' => 'decor_height',
            'value' => '150',
            'description' => esc_html__( 'Values 0 - 300', 'solutech' ),
            'dependency' => array(
                'element' => 'pdecor',
                'value' => 'on',
            ),
            'group' => esc_html__( 'Decor', 'solutech' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Top Decor Opacity', 'solutech' ),
            'param_name' => 'decor_opacity',
            'value' => '',
            'description' => esc_html__( 'Values 0.01 - 0.99', 'solutech' ),
            'dependency' => array(
                'element' => 'pdecor',
                'value' => 'on',
            ),
            'group' => esc_html__( 'Decor', 'solutech' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Top Decor Points', 'solutech' ),
            'param_name' => 'decor_points_top',
            'value' => '',
            'description' => esc_html__( 'Example: 0,100 50,50 100,100', 'solutech' ),
            'dependency' => array(
                'element' => 'pdecor',
                'value' => 'on',
            ),
            'group' => esc_html__( 'Decor', 'solutech' ),
        ),

        // Bottom Decor
        array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'Show Bottom Decor', 'solutech' ),
            'param_name' => 'pdecor_bottom',
            'value' => 'off',
            'description' => esc_html__( "Show decor at the bottom of the section.", 'solutech' ),
            'group' => esc_html__( 'Decor', 'solutech' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Height', 'solutech' ),
            'param_name' => 'decor_bottom_height',
            'value' => '150',
            'description' => esc_html__( 'Values 0 - 300', 'solutech' ),
            'dependency' => array(
                'element' => 'pdecor_bottom',
                'value' => 'on',
            ),
            'group' => esc_html__( 'Decor', 'solutech' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Bottom Decor Opacity', 'solutech' ),
            'param_name' => 'decor_bottom_opacity',
            'value' => '',
            'description' => esc_html__( 'Values 0.01 - 0.99', 'solutech' ),
            'dependency' => array(
                'element' => 'pdecor_bottom',
                'value' => 'on',
            ),
            'group' => esc_html__( 'Decor', 'solutech' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Bottom Decor Points', 'solutech' ),
            'param_name' => 'decor_points_bottom',
            'value' => '',
            'description' => esc_html__( 'Example: 0,100 50,50 100,100', 'solutech' ),
            'dependency' => array(
                'element' => 'pdecor_bottom',
                'value' => 'on',
            ),
            'group' => esc_html__( 'Decor', 'solutech' ),
        ),

        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Overlay', 'solutech' ),
            'param_name' => 'poverlay',
            'value' => array(
                esc_html__( "Use", 'solutech' ) => 'pix-row-overlay',
                esc_html__( "None", 'solutech' ) => 'no-overlay',
            ),
            'description' => '',
            'group' => esc_html__( 'Decor', 'solutech' ),
        ),
	);

	vc_add_params( 'vc_row', array_merge($padding_attr, $row_attr, $gradient_attr) );
	vc_add_params( 'vc_row_inner', array_merge($padding_no_attr, $row_attr, $gradient_attr) );
	vc_add_params( 'vc_column', array_merge($padding_no_attr, $stretch_attr, $column_attr, $gradient_attr) );

	vc_add_params( 'common_title', $stretch_attr );

?>