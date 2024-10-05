<?php

	$shadows = array(
	    array(
            'type' => 'segmented_button',
            'heading' => esc_html__( 'Shadows', 'solutech' ),
            'param_name' => 'shadow',
            'value' => array(
                'default' => 'no-shadow',
                esc_html__( 'Disable', 'solutech' ) => 'no-shadow',
                esc_html__( 'Show', 'solutech' ) => 'pix-shadow',
                esc_html__( 'On Hover', 'solutech' ) => 'pix-shadow-hover',
            ),
            'group' => esc_html__( 'Shadows', 'solutech' ),
        ),
        array(
            'type' => 'param_group',
            'heading' => esc_html__( 'Values', 'solutech' ),
            'param_name' => 'shadow_values',
            'description' => esc_html__( 'Enter values for graph - title and value.', 'solutech' ),
            'value' => urlencode( json_encode( array(
                array(
                    'horizontal' => '0',
                    'vertical' => '6',
                    'blur' => '18',
                    'spread' => '0',
                    'color' => '#000',
                    'opacity' => '18',
                ),
            ) ) ),
            'params' => array(
                array(
                    'type' => 'range_slider',
                    'heading' => esc_html__( 'Horizontal Position', 'solutech' ),
                    'param_name' => 'horizontal',
                    'value' => array(
                        'default' => '0',
                        'min' => '-100',
                        'max' => '100',
                    ),
                ),
                array(
                    'type' => 'range_slider',
                    'heading' => esc_html__( 'Vertical Position', 'solutech' ),
                    'param_name' => 'vertical',
                    'value' => array(
                        'default' => '0',
                        'min' => '-100',
                        'max' => '100',
                    ),
                ),
                array(
                    'type' => 'range_slider',
                    'heading' => esc_html__( 'Blur', 'solutech' ),
                    'param_name' => 'blur',
                    'value' => array(
                        'default' => '0',
                        'min' => '0',
                        'max' => '100',
                    ),
                ),
                array(
                    'type' => 'range_slider',
                    'heading' => esc_html__( 'Spread', 'solutech' ),
                    'param_name' => 'spread',
                    'value' => array(
                        'default' => '0',
                        'min' => '-100',
                        'max' => '100',
                    ),
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__( 'Color', 'solutech' ),
                    'param_name' => 'color',
                    'value' => '#000',
                    'description' => '',
                ),
                array(
                    'type' => 'range_slider',
                    'heading' => esc_html__( 'Opacity', 'solutech' ),
                    'param_name' => 'opacity',
                    'value' => array(
                        'default' => '24',
                        'min' => '0',
                        'max' => '100',
                        'unit' => '%',
                    ),
                ),
            ),
            'dependency' => array(
                'element' => 'shadow',
                'value' => array('pix-shadow-hover', 'pix-shadow'),
            ),
            'group' => esc_html__( 'Shadows', 'solutech' ),
        ),

        array(
            'type' => 'range_slider',
            'heading' => esc_html__( 'Transition Time', 'solutech' ),
            'param_name' => 'shadow_transition',
            'value' => array(
                'default' => '0.35',
                'min' => '0',
                'max' => '3',
                'step' => '0.05',
            ),
            'dependency' => array(
                'element' => 'shadow',
                'value' => array('pix-shadow-hover'),
            ),
            'group' => esc_html__( 'Shadows', 'solutech' ),
        ),

        array(
            'type' => 'segmented_button',
            'heading' => esc_html__( 'Preset', 'solutech' ),
            'param_name' => 'shadow_effect',
            'value' => array(
                'default' => 'no-effect',
                esc_html__( 'Disable', 'solutech' ) => 'no-effect',
                esc_html__( 'Lifted Corners', 'solutech' ) => 'lifted-corners',
                esc_html__( 'Bottom Curve', 'solutech' ) => 'bottom-curve',
            ),
            'group' => esc_html__( 'Shadows', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-6',
        ),
        
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Item Background Color', 'solutech' ),
            'param_name' => 'shadow_bg_color',
            'value' => '#fff',
            'description' => '',
            'dependency' => array(
                'element' => 'shadow_effect',
                'value' => array('lifted-corners', 'bottom-curve'),
            ),
            'group' => esc_html__( 'Shadows', 'solutech' ),
            'edit_field_class' => 'vc_col-sm-6',
        ),

        
	);

	$buttons_shadow_show = !pixtheme_get_option('buttons_shadow', '0') ? 'no-shadow' : 'pix-shadow-hover';

    $shadows_buttons = $shadows;
    $shadows_buttons[0]['value']['default'] = $buttons_shadow_show;
    $shadows_buttons[1]['value'] = urlencode( json_encode( array(
        array(
            'horizontal' => pixtheme_get_option('buttons_shadow_h', '0'),
            'vertical' => pixtheme_get_option('buttons_shadow_v', '0'),
            'blur' => pixtheme_get_option('buttons_shadow_blur', '0'),
            'spread' => pixtheme_get_option('buttons_shadow_spread', '0'),
            'color' => pixtheme_get_option('buttons_shadow_color', '0'),
            'opacity' => pixtheme_get_option('buttons_shadow_opacity', '100'),
        )
    )));

	vc_add_params( 'vc_row', $shadows );
	vc_add_params( 'common_button', $shadows_buttons);
	vc_add_params( 'common_icon_box', $shadows );
	vc_add_params( 'cars_latest_offers', $shadows );
	vc_add_params( 'common_special_offers', $carousel );
	vc_add_params( 'common_team', $shadows );
	vc_add_params( 'common_reviews', $shadows );
	vc_add_params( 'common_price_table', $shadows );
	vc_add_params( 'common_posts_block', $shadows );
	vc_add_params( 'common_portfolio', $shadows );

	function pixtheme_get_shadow($shadow_arr){
	    if(isset($shadow_arr['shadow']) && $shadow_arr['shadow'] != 'no-shadow') {
            $pix_shadow_class = 'pix_shadow_' . rand();
            $hover = $shadow_arr['shadow'] == 'pix-shadow-hover' ? ':hover' : '';
            $values = (array) vc_param_group_parse_atts( $shadow_arr['shadow_values'] );
            $shadows_data = array();
            $max_blur = 0;
            foreach ( $values as $data ) {
                $h = isset($data['horizontal']) ? $data['horizontal'] : '';
                $v = isset($data['vertical']) ? $data['vertical'] : '';
                $blur = isset($data['blur']) ? $data['blur'] : '';
                $max_blur = $blur > $max_blur ? $blur : $max_blur;
                $spread = isset($data['spread']) ? $data['spread'] : '';
                $color = isset($data['color']) ? $data['color'] : '';
                $opacity = isset($data['opacity']) ? $data['opacity'] : '';

                $shadows_data[] = esc_attr((int)$h).'px '.esc_attr((int)$v).'px '.esc_attr((int)$blur).'px '.esc_attr((int)$spread).'px rgba('.esc_attr(pixtheme_hex2rgb($color)).','.esc_attr((int)$opacity/100).')';
            }
            $transition = isset($shadow_arr['shadow_transition']) ? 'transition:'.$shadow_arr['shadow_transition'].'s;' : '';
            $shadow_effect = isset($shadow_arr['shadow_effect']) ? $shadow_arr['shadow_effect'] : 'no-effect';
            $shadow_bg_color = $shadow_effect != 'no-effect' ? 'background-color:'.$shadow_arr['shadow_bg_color'].';' : '';
            $pix_shadow_style = 'jQuery(function($){';
            $pix_shadow_style .= ' $("head").append("<style> .'.esc_attr($pix_shadow_class).wp_kses_post($hover).', .'.esc_attr($pix_shadow_class).wp_kses_post($hover).'>.vc_column_container>.vc_column-inner{box-shadow:'.implode(',', $shadows_data).';}.'.esc_attr($pix_shadow_class).'{transition:.35s;margin-top:'.esc_attr((int)$max_blur*0.5).'px; height: calc(100% - '.esc_attr((int)$max_blur*0.5).'px); position: relative;'.wp_kses_post($shadow_bg_color).'}</style>");';
            if($shadow_effect == 'lifted-corners')
                $pix_shadow_style .= ' $(".'.esc_attr($pix_shadow_class).'").append(\'<div class="pix-shadow-corner pix-left"></div><div class="pix-shadow-corner pix-right"></div>\');';
            if($shadow_effect == 'bottom-curve')
                $pix_shadow_style .= ' $(".'.esc_attr($pix_shadow_class).'").append(\'<div class="pix-shadow-curve"></div>\');';
            $pix_shadow_style .= '})';
            wp_add_inline_script( 'pixtheme-common', $pix_shadow_style );
            return $pix_shadow_class;
        } else {
	        return '';
        }

    }

?>